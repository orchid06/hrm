<?php
namespace App\Http\Services;

use App\Enums\DepositStatus;
use App\Enums\PlanDuration;
use App\Enums\StatusEnum;
use App\Enums\SubscriptionStatus;
use App\Enums\WithdrawStatus;
use App\Http\Services\Gateway\bkash\Payment;
use App\Http\Utility\SendMail;
use App\Http\Utility\SendNotification;
use App\Jobs\SendMailJob;
use App\Jobs\SendSmsJob;
use App\Models\Admin;
use App\Models\Admin\PaymentMethod;
use App\Models\Admin\Withdraw;
use App\Models\AffiliateLog;
use App\Models\User;
use App\Models\Core\File;
use App\Models\CreditLog;
use App\Models\Package;
use App\Models\PaymentLog;
use App\Models\SocialAccount;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Rules\General\FileExtentionCheckRule;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Traits\Fileable;
use Twilio\Rest\Events\V1\SubscriptionPage;
use App\Traits\Notifyable;
class UserService
{


    use Fileable , Notifyable;

    public  $paymentService;

    public function __construct()
    {
       $this->paymentService  = new PaymentService();
    }

    use Fileable;
   
    public function save(Request $request) :User{

        $user = 
            DB::transaction(function() use ($request) {
 
                $user                       =  User::with('file')->firstOrNew(['id' => $request->input("id")]);
                $user->name                 =  $request->input('name');
                $user->username             =  $request->input('username');
                $user->phone                =  $request->input('phone');
                $user->email                =  $request->input('email');
                $user->address              =  $request->input('address',[]);
                $user->password             =  $request->input('password');
                $user->country_id           =  $request->input('country_id');
                $user->email_verified_at    =  $request->input('email_verified') ?  Carbon::now() : null ;
                $user->auto_subscription    =  $request->input('auto_subscription')?? StatusEnum::false->status();
                $user->is_kyc_verified      =  $request->input('is_kyc_verified')?? StatusEnum::false->status();
                $user->save();

                if($request->hasFile('image')){

                    $oldFile = $user->file()->where('type','profile')->first();
                    $response = $this->storeFile(
                        file        : $request->file('image'), 
                        location    : config("settings")['file_path']['profile']['user']['path'],
                        removeFile  : $oldFile
                    );
                    
                    if(isset($response['status'])){
                        $image = new File([
                            'name'      => Arr::get($response, 'name', '#'),
                            'disk'      => Arr::get($response, 'disk', 'local'),
                            'type'      => 'profile',
                            'size'      => Arr::get($response, 'size', ''),
                            'extension' => Arr::get($response, 'extension', ''),
                        ]);

                        $user->file()->save($image);
                    }
                }
                
                return $user;
        
            });
        

       return $user;

    }




    /**
     * Withdraw request handle
     *
     * @param Request $request
     * @param User $user
     * @param Withdraw $method
     * @param mixed $status
     * @return array
     */
    public function createWithdrawLog(Request $request , User $user , Withdraw $method ,mixed $status = null) :array{


        $params['currency_id']     = session()->get("currency") ? session()->get("currency")->id : base_currency()->id;
        $amount                    = (float)$request->input("amount");
        $charge                    = round_amount((float)$method->fixed_charge + ($amount  * (float)$method->percent_charge / 100));
        $total                     = $amount + $charge;
        $baseAmount                = convert_to_base($total);
        $response                  = response_status("Insufficient funds in user account. Withdrawal request cannot be processed due to insufficient balance. ",'error');

        if($baseAmount  < $user->balance){

            $status              =  $status ?  $status : WithdrawStatus::value("APPROVED",true);

            $params  = [

                'currency_id'         =>  session()->get("currency") ? session()->get("currency")->id : base_currency()->id ,
                "amount"              =>  $amount,
                "base_amount"         =>  $baseAmount,
                "charge"              =>  $charge,
                "final_amount"        =>  $amount + $charge,
                "base_final_amount"   =>  convert_to_base($amount + $charge),
                "status"              =>  $status,
                "notes"               =>  $request->input("remarks"),
                "trx_code"            =>  trx_number()
            ];


            DB::transaction(function() use ($request,$params,$user,$method ,$baseAmount ) {
                
                $log = $this->paymentService->withdrawLog($user , $method ,$params);

                    if(request()->routeIs('user.*')){
                        $this->saveCustomInfo($request ,$log, $method->parameters ,"custom_data");
                    }

                    if($log->status == WithdrawStatus::value("APPROVED")){

                        $params ['trx_type']   = Transaction::$MINUS;
                        $params ['trx_code']   = $log->trx_code;
                        $params ['remarks']    = 'withdraw';
                        $params ['details']    = $params['amount']." ".session("currency")?->code.' Withdraw Via ' .$method->name;
                    
                        $transaction           =  PaymentService::makeTransaction($user,$params);

                        $user->balance -= $baseAmount;
                        $user->save();

                    }
                    
                    $code = [
                        "name"      => $user->name,
                        "trx_code"  => $log->trx_code,
                        "amount"    => num_format($log->amount,$log->currency),
                        "method"    => $method->name,
                        "time"      => Carbon::now(),
                    ];
    
                    $route          =  route("admin.withdraw.report.list");
                    $userRoute      =  route("user.withdraw.report.list");
                    $admin          = get_admin();

                    $notifications = [
                        'database_notifications' => [
                            'action' => [SendNotification::class, 'database_notifications'],
                            'params' => [
                                [ $admin, 'WITHDRAWAL_REQUEST_SUBMIT', $code, $route ],
                                ($log->status == WithdrawStatus::value("APPROVED")) ? [$user, 'WITHDRAWAL_REQUEST_ACCEPTED', $code ,$userRoute] : null,
                            ],
                        ],
                        'slack_notifications' => [
                            'action' => [SendNotification::class, 'slack_notifications'],
                            'params' => [
                                [
                                    $admin, 'WITHDRAWAL_REQUEST_SUBMIT', $code, $route
                                ]
                            ],
                        ],
                        'email_notifications' => [
                            'action' => [SendMailJob::class, 'dispatch'],
                            'params' => [
                                [$admin, 'WITHDRAWAL_REQUEST_SUBMIT', $code],
                                [$user, 'WITHDRAWAL_REQUEST_RECEIVED', $code],
                                ($log->status == WithdrawStatus::value("APPROVED")) ? [$user, 'WITHDRAWAL_REQUEST_ACCEPTED', $code] : null,
                            ],
                        ],
                        'sms_notifications' => [
                            'action' => [SendSmsJob::class, 'dispatch'],
                            'params' => [
                                [$admin, 'WITHDRAWAL_REQUEST_SUBMIT', $code],
                                [$user, 'WITHDRAWAL_REQUEST_RECEIVED', $code],
                                ($log->status == WithdrawStatus::value("APPROVED")) ? [$user, 'WITHDRAWAL_REQUEST_ACCEPTED', $code] : null,
                            ],
                        ],
                    ];
                    
                    $this->notify($notifications);


            
            });


            $message = translate("Your withdrawal request has been processed successfully");
            if(request()->routeIs('user.*')){
                $message = translate("Your withdrawal Request is submitted !! Please wait for confirmation");
            }
            return $response                  = response_status($message);

        }

        return $response;


    }


    /**
     * create  a new subscription for user
     *
     * @param User $user
     * @param Package $package
     * @return array
     */
    public function createSubscription(User $user , Package $package ,string | null $remarks =  null) :array {

        try {

            $price           = round($package->discount_price) > 0 ?  $package->discount_price :  $package->price;
        
            $oldSubscription = $user->subscriptions?->first();
    
            if($user->balance <   $price){
    
                return [
                    "status"    => false,
                    "message"   => translate("User doesnot have enough balance to purchase this package !!")
                ];
            }
    
            if($package->is_free == StatusEnum::true->status() && Subscription::where("user_id",$user->id)->where('package_id',$package->id)->count() > 0){
                
                return [
                    "status"    => false,
                    "message"   => translate("User cannot be  subscribed in  free package twice !!")
                ];
                
            }
    
            $params =  [
                "user_id"         =>  $user->id,
                "package_id"      =>  $package->id,
                "old_package_id"  =>  $oldSubscription?->package_id,
                "payment_amount"  =>  $price,
                "payment_status"  =>  DepositStatus::value('PAID',true) ,
                "status"          =>  SubscriptionStatus::value('Running',true),
            ];
    
    
            $expireDate = null;
            if($package->duration != PlanDuration::value('UNLIMITED',true)){
                $expireDate  = date('Y-m-d', strtotime(date('Y-m-d') . $package->duration == PlanDuration::value('YEARLY',true) ? ' + 1 years' : ' + 1 months'));
            }
    
            $params['expired_at']                 = $expireDate ;
    
            $params['remarks']                    = $remarks ? $remarks :  $package->title . " Plan Purchased" ;
    
            $wordLimit                            = (int) @$package->ai_configuration->word_limit;
            $postLimit                            = (int) @$package->social_access->post;
            $profileLimit                         = (int) @$package->social_access->profile;
    
            $params['word_balance']               = $wordLimit;
            $params['remaining_word_balance']     = $wordLimit;
            $params['total_profile']              = $profileLimit ;
            $params['post_balance']               = $postLimit;
            $params['remaining_post_balance']     = $postLimit;
           
    
            if(site_settings('subscription_carry_forword') == StatusEnum::true->status() && $oldSubscription && $oldSubscription->package_id == $package->id){
    
                if($wordLimit   !=  PlanDuration::value('UNLIMITED')){
    
                    $carriedWords                          = (int)$oldSubscription->remaining_word_balance;
                    $params['word_balance']               += $carriedWords;
                    $params['remaining_word_balance']     += $carriedWords;
                    $params['carried_word_balance']        = $carriedWords;
                }
    
                $carriedProfile                            = (int)$oldSubscription->total_profile;
                $params['total_profile']                  += $carriedProfile;
                $params['carried_profile']                 = $carriedProfile;
    
                if($wordLimit   != PlanDuration::value('UNLIMITED')){
    
                    $carriedPost                           = (int)$oldSubscription->remaining_post_balance; 
                    $params['post_balance']               += $carriedPost ;
                    $params['remaining_post_balance']     += $carriedPost ;
                    $params['carried_post_balance']        = $carriedPost ;
    
                }
    
            }
    

            DB::transaction(function() use ($params,$oldSubscription,$user,$package) {
    


                $params['trx_code']               = trx_number() ; 
    
              
                $this->invalidatePreviousSubscriptions($user);
         
    
                $subscription   = Subscription::create($params);
    
                $user->balance -= $subscription->payment_amount;
                $user->save();
                
    
                $package->total_subscription_income +=$subscription->payment_amount;
                $package->save();
    
                $transactionParams = [

                    "currency_id"    => base_currency()->id,
                    "amount"         => $subscription->payment_amount,
                    "final_amount"   => $subscription->payment_amount,
                    "trx_type"       => Transaction::$MINUS,
                    "remarks"        => "subscription",
                    "details"        => $package->title . " Plan Purchased",
                    "trx_code"       => $subscription->trx_code
                ];
    
                $transaction         =  PaymentService::makeTransaction($user,$transactionParams);
    
          
                $balance             = PlanDuration::value('UNLIMITED');
                $socialBalance       = PlanDuration::value('UNLIMITED');
    
                if((int)$subscription->word_balance != PlanDuration::value('UNLIMITED')){
                    $balance         = (int) $subscription->word_balance;
                }
                if((int)$subscription->word_balance != PlanDuration::value('UNLIMITED')){
                    $socialBalance   = (int) $subscription->post_balance;
                }
    


                $crditLogs =  [
    
                    "word_credit"        => [
                        'balance'        =>  $balance,
                        'post_balance'   => (int) @$oldSubscription->remaining_word_balance
                    ],
    
                    "profile_credit"     => [
                        'balance'        => (int) $subscription->total_profile,
                        'post_balance'   => (int) @$oldSubscription->total_profile
                    ],
    
                    "social_post_credit" => [
                        'balance'        => $socialBalance,
                        'post_balance'   => (int) @$oldSubscription->remaining_post_balance
                    ],
    
                ];
    
                foreach( $crditLogs as $key => $log){

                    $log['user_id']          = $user->id;
                    $log['subscription_id']  = $subscription->id;
                    $log['trx_code']         = trx_number();
                    $log['remark']           = k2t($key);
                    $log['details']          = $transaction->details;
                    $log['type']             = Transaction::$PLUS;

                    CreditLog::create($log);
                }


                $continuousCommission  = site_settings("continuous_commission");
                $affiliateBonus        =  $continuousCommission == StatusEnum::true->status() || Subscription::where('user_id', $user->id)->count() < 1;

                if(site_settings("affiliate_system") == StatusEnum::true->status() && $user->referral && $affiliateBonus && $subscription->package->affiliate_commission > 0  ){

                    $this->affiliateBonus($user, $subscription);
                }

                $route             =  route("admin.subscription.report.list");
                $userRoute         =  route("user.subscription.report.list");
                $admin             = get_admin();
                $code =  [
                    'name'         => $user->name,
                    'start_date'   => date('Y-m-d'),
                    'end_date'     => $subscription->expired_at,
                    'package_name' => $package->title,
                ];

                $notifications = [

                    'database_notifications' => [
                        'action' => [SendNotification::class, 'database_notifications'],
                        'params' => [
                            [ $admin, 'SUBSCRIPTION_CREATED', $code, $route ],
                            [ $user, 'SUBSCRIPTION_CREATED', $code, $userRoute ],
                        ],
                    ],
                    'slack_notifications' => [
                        'action' => [SendNotification::class, 'slack_notifications'],
                        'params' => [
                            [
                                $admin, 'SUBSCRIPTION_CREATED', $code, $route
                            ]
                        ],
                    ],
                    'email_notifications' => [
                        'action' => [SendMailJob::class, 'dispatch'],
                        'params' => [
                            [$admin,'SUBSCRIPTION_CREATED',$code],
                            [$user, 'SUBSCRIPTION_CREATED', $code],
                        ],
                    ],
                    'sms_notifications' => [
                        'action' => [SendSmsJob::class, 'dispatch'],
                        'params' => [
                            [$admin,'SUBSCRIPTION_CREATED',$code],
                            [$user, 'SUBSCRIPTION_CREATED', $code],
                        ],
                    ],
                ];

                $this->notify($notifications);
              
          
            });
    

            return [
                "status"    => true,
                "message"   => translate("New subscription created")
            ];
    
    
        } catch (\Exception $ex) {
            
            return [
                "status"    => false,
                "message"   => strip_tags($ex->getMessage())
            ];
        }

 
    }



    /**
     * Affiliate Bonus calculations
     *
     * @param User $user
     * @param Subscription $subscription
     * @return void
     */
    public function affiliateBonus(User $user , Subscription $subscription) :void {

        DB::transaction(function() use ($user,$subscription) {

            $commission  =  ((float) $subscription->package->affiliate_commission / 100 ) * (float) $subscription->payment_amount;
            $params ['commission_rate']             = $subscription->package->affiliate_commission ; 
            $params ['subscription_id']             = $subscription->id; 
            $params ['user_id']                     = $user->referral->id;
            $params ['referred_to']                 = $user->id;
            $params ['commission_amount']           = $commission;
            $params ['trx_code']                    = trx_number();
            $params ['note']                        = $user->name . " Purchased ".$subscription->package->title . " Plan";

            $log = AffiliateLog::create($params);

            $user->referral->balance += $log->commission_amount;
            $user->referral->save();

            $transactionParams = [
                "currency_id"    => base_currency()->id,
                "amount"         => $log->commission_amount,
                "final_amount"   => $log->commission_amount,
                "trx_type"       => Transaction::$PLUS,
                "remarks"        => "affiliate",
                "details"        => $log->commission_amount." ".base_currency()?->code.' Added Via Affiliate Bonus ',
                "trx_code"       => $log->trx_code
            ];

            $transaction         =  PaymentService::makeTransaction($user,$transactionParams);
        });
        
    }


    /**
     * Create deposit request
     *
     * @param Request $request
     * @param User $user
     * @param PaymentMethod $method
     * @param mixed $status
     * @return array
     */
    public function createDepositLog(Request $request , User $user ,PaymentMethod $method , mixed $status = null) :array{

        $params['currency_id']     = session()->get("currency") ? session()->get("currency")->id : base_currency()->id;
        $amount                    = (float)$request->input("amount");
        $charge                    = round_amount( (float)$method->fixed_charge + ($amount  * (float)$method->percentage_charge / 100));
        $total                     = $amount + $charge;
        $status                    = $status ?  $status : DepositStatus::value("PAID",true);
        $finalBase                 = convert_to_base($total);
        $finalAmount               = round_amount($finalBase*$method->currency->exchange_rate,2);

        $params                    = [

            'currency_id'          =>  session()->get("currency") ? session()->get("currency")->id : base_currency()->id ,
            "amount"               =>  $amount,
            "base_amount"          =>  convert_to_base($amount),
            "charge"               =>  $charge,
            "final_base"           =>  $finalBase,
            "final_amount"         =>  $finalAmount,
            "base_final_amount"    =>  convert_to_base($amount + $charge),
            "status"               =>  $status,
            "notes"                =>  $request->input("remarks"),
            "trx_code"             =>  trx_number(),
            "rate"                 =>  exchange_rate($method->currency,5)
 
        ];

      

        $log = DB::transaction(function() use ($request,$params,$user,$method) {

            $log = $this->paymentService->paymentLog($user,$method ,$params);

         
            $params ['trx_type']        = Transaction::$PLUS;
            $params ['trx_code']        = $log->trx_code;
            $params ['remarks']         = 'deposit';
            $params ['final_amount']    = $log->amount + $log->charge;
            $params ['details']         = $log->amount." ".session("currency")?->code.' Deposited Via ' .$method->name;

            $code = [
                "name"            => $user->name,
                "trx_code"        => $log->trx_code,
                "amount"          => num_format($log->amount,$log->currency),
                "time"            => Carbon::now(),
                "payment_method"  => $log->method->name
            ];

            $route          =  route("admin.deposit.report.list");
            $userRoute      =  route("user.deposit.report.list");
            $admin          = get_admin();


            if($log->status  == DepositStatus::value("PAID",true)){

                $params ['trx_code']       =  $log->trx_code;
                $transaction               =  PaymentService::makeTransaction($user,$params);
                $user->balance +=$log->base_amount;
                $user->save();
            }

            $notifications = [

                'database_notifications' => [
                    'action' => [SendNotification::class, 'database_notifications'],
                    'params' => [
                        [ $admin, 'NEW_DEPOSIT', $code, $route ],
                        $log->status  == DepositStatus::value("PAID",true) ?  [ $user, 'DEPOSIT_REQUEST_ACCEPTED', $code, $userRoute ] : [ $user, 'DEPOSIT_REQUEST', $code, $userRoute ],
                    ],
                ],
                'slack_notifications' => [
                    'action' => [SendNotification::class, 'slack_notifications'],
                    'params' => [
                        [
                            $admin, 'NEW_DEPOSIT', $code, $route
                        ]
                    ],
                ],
                'email_notifications' => [
                    'action' => [SendMailJob::class, 'dispatch'],
                    'params' => [
                        [$admin,'NEW_DEPOSIT',$code],
                        $log->status  == DepositStatus::value("PAID",true) ?   [$user, 'DEPOSIT_REQUEST_ACCEPTED', $code] : [$user, 'DEPOSIT_REQUEST', $code],
                    ],
                ],
                'sms_notifications' => [
                    'action' => [SendSmsJob::class, 'dispatch'],
                    'params' => [
                        [$admin,'NEW_DEPOSIT',$code],
                        $log->status  == DepositStatus::value("PAID",true) ? [$user, 'DEPOSIT_REQUEST_ACCEPTED', $code] : [$user, 'DEPOSIT_REQUEST', $code],
                    ],
                ],
            ];

            $this->notify($notifications);

            return $log;

        });

        $message = translate("Your deposit request has been processed successfully");
     
        $response    = response_status($message);

        return [
            "response" => $response,
            "log"      => $log,
        ];

        
    }


    /**
     *Save custom field
     *
     * @param Request $request
     * @param mixed $log
     * @param object $params
     * @param string $key
     * @return void
     */
    public function saveCustomInfo(Request $request , mixed $log , object $params , string $key ) :void{

          
        $collection    = collect($request);
        $customData    = [];
        if ($params != null) {

            foreach ($collection as $k => $v) {

                foreach ($params as $inKey => $inVal) {

                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {

                                try {
             
                                    $response = $this->storeFile(

                                        file        : $request->file($inKey), 
                                        location    :  config("settings")['file_path']['withdraw']['path'],
                                    );
                                    
                                    if(isset($response['status'])){

                                        $file = new File([

                                            'name'      => Arr::get($response, 'name', '#'),
                                            'disk'      => Arr::get($response, 'disk', 'local'),
                                            'type'      => $inKey ,
                                            'size'      => Arr::get($response, 'size', ''),
                                            'extension' => Arr::get($response, 'extension', ''),
                                        ]);
                
                                        $log->file()->save($file);
                                    }

                                    $customData[$inKey] = [

                                        'field_name' => Arr::get( $response ,'name',"#"),
                                        'type'       => $inVal->type,
                                    ];

                                } catch (\Exception $exp) {

                                }
                            }
                        } else {
                            $customData[$inKey] = $v;
                            $customData[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }

            $log->{$key} = $customData;
            $log->save();
        }
    }



    /**
     * manual  input validation rules
     *
     * @param mixed $params
     * @return array
     */
    public function paramValidationRules(mixed $params) :array {

        $rules           = [];
        $verifyImages    = [];
        if ($params != null) {
            foreach ($params as $key => $cus) {
                $rules[$key] = [$cus->validation];

                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true)));
                    array_push($verifyImages, $key);
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
            }
        }

        return $rules;

    }


    /**
     * Update deposit log
     *
     * @param PaymentLog $log
     * @param mixed $status
     * @param array $responseData
     * @return void
     */
    public static function updateDepositLog(PaymentLog $log , mixed $status ,array $responseData) :void{

        $log->status            =   $status;
        $log->gateway_response  =   $responseData;
        $log->save();

        if($log->status  == DepositStatus::value("PAID",true)){

            $params  = [
                'trx_code'     => $log->trx_code,
                'currency_id'  => $log->currency_id,
                'amount'       => $log->amount,
                'charge'       => $log->charge,
                'final_amount' => $log->amount + $log->charge,
                'trx_type'     => Transaction::$PLUS,
                'remarks'      => "Deposit",
                'details'      => $log->amount." ".$log->currency?->code.' Deposited Via ' .$log->method->name
            ];

            $transaction  =  PaymentService::makeTransaction($log->user,$params);
            $log->user->balance +=$log->base_amount;
            $log->user->save();
        }

    }
    
    


    /**
     * Inactive social account
     *
     * @param Subscription $subscription
     * @param string $details
     * @return void
     */
    public function inactiveSocialAccounts(Subscription $subscription, string $details = "Subscription Expired") :void{

        SocialAccount::where('user_id',$subscription->user->id)->where('id',$subscription->id)->update([
            'status'  => StatusEnum::false->status(),
            'details' => $details,
        ]);
    }



    /**
     * Invalid subscriptions
     *
     * @param User $user
     * @return void
     */
    public function invalidatePreviousSubscriptions(User $user) :void{

        $subscriptions  = Subscription::with('user')
                            ->running()
                            ->where('user_id',$user->id)
                            ->get();

        foreach($subscriptions as $subscription){   
            
            $subscription->expired_at =  date('Y-m-d');
            $subscription->status     =  SubscriptionStatus::value('Expired',true);
            $subscription->save();
            $this->inactiveSocialAccounts($subscription);
        }

    }
    

    public function deductSubscriptionCredit(Subscription $subscription , string $key , int $value = 1) :Subscription{
        $subscription->decrement($key,$value);

        return $subscription;
        
    }
  
}
