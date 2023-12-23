<?php

namespace App\Http\Controllers\User;

use App\Enums\StatusEnum;
use App\Enums\WithdrawStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\KycRequest;
use App\Http\Services\UserService;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Admin\Withdraw;
use App\Models\Core\File;
use App\Models\KycLog;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Enums\WithdrawStatus as KycStatus;
use App\Http\Utility\SendNotification;
use App\Jobs\SendMailJob;
use App\Models\Admin;
use Carbon\Carbon;

class UserController extends Controller
{
    
    protected $userService ,$user;

    public function __construct(){
        
        $this->userService      = new UserService();

        $this->middleware(function ($request, $next) {
            $this->user = auth_user('web');
            return $next($request);
        });
    }


    /**
     * Purchase a  Plan
     *
     * @return View
     */
    public function planPurchase(string $slug) :RedirectResponse{


        $package   = Package::where("slug",$slug)->firstOrfail();
        $response  = $this->userService->createSubscription($this->user,$package);
        $status    = isset($response['status']) 
                         ? 'success' 
                         : 'error';
        
        return back()->with(response_status(Arr::get($response,"message",trans("default.something_went_wrong")),$status));
    }



    /**
     * Withdraw request view 
     *
     * @param Request $request
     * @return View
     */
    public function withdrawCreate(Request $request) :View{


        
        return view('user.withdraw_request',[

            'meta_data'  => $this->metaData(['title'=> translate("Withdraw Request")]),
            'methods'    => Withdraw::with(['file'])->active()->get(),
  
        ]);


    }




    /**
     * Process withdraw request
     *
     * @return RedirectResponse
     */
    public function withdrawRequest(Request $request) :RedirectResponse{

        $amount = session()->get("withdraw_amount");
        $gwId   = session()->get("gw_id");

        $balance = (int)$this->user->balance;
        

        $rules = [
            "amount" => ['numeric','gt:0',"max:".$balance],
        ];

        $gateway           = Withdraw::with(['file'])->findOrfail($gwId);

        $customRules       = $this->userService->paramValidationRules($gateway->parameters);
        $mergedRules       = array_merge($rules, $customRules);

        $request->validate($mergedRules);

        $response         = response_status(translate("Invalid amount and gateway"),'error');

        if((int)$request->input('amount') == $amount){
            $response = $this->userService
                             ->createWithdrawLog($request,$this->user,$gateway,WithdrawStatus::value('PENDING',true));
        }

        session()->forget("withdraw_amount");
        session()->forget("gw_id");

        return redirect()
                ->route('user.withdraw.report.list')->with($response);
    }



    /**
     * Withdraw preview
     *
     * @return View
     */
    public function withdrawPreview(Request $request) :View | RedirectResponse{

        $balance = (int)$this->user->balance;
        $request->validate([
            "id"     => ['required','exists:withdraws,id'],
            "amount" => ['numeric','gt:0',"max:".$balance],
        ]);

        $method           = Withdraw::with(['file'])->find($request->input("id"));
        $amount           = (int) $request->input('amount');

        $error            = $this->validateWithdrawRequest($method, $amount);

        if($error !== null){
            return back()->with("error",$error);
        }

        session()->put("withdraw_amount",$amount);
        session()->put("gw_id",$method->id);

        return view('user.withdraw.preview',[

            'meta_data' => $this->metaData(['title'=> translate("Withdraw preview")]),
            'method'    => $method,
            'amount'    => $amount,
        ]);

    }
    


    /**
     * Validate withdraw request
     *
     * @param Withdraw $method
     * @param integer $amount
     * @return string|null
     */
    public function validateWithdrawRequest(Withdraw $method , int $amount ) :?string {

        $maxRequestLimit = (int) site_settings("max_pending_withdraw",100);
        $pendingRequest  = (int) $this->user?->pendingWithdraws->count();

        if($amount  < $method->minimum_amount || $amount > $method->maximum_amount ){
            return translate('Withdraw amount should be less than ').num_format(number :$method->maximum_amount ,calC:true). " and greter than ".num_format(number :$method->minimum_amount ,calC:true);
        }

        if($maxRequestLimit == $pendingRequest ){
            return translate('Oops! It looks like your withdrawal request has gone over the limit. Please review and try again.');
        }

        return null;
    }



    public function kycForm() :View {

        return view('user.kyc_form',[
            'meta_data' => $this->metaData(['title'=> translate("Kyc Verification")]),
        ]);

    }




    /**
     * Kyc application request
     *
     * @param KycRequest $request
     * @return RedirectResponse
     */
    public function kycApplication(KycRequest $request) :RedirectResponse {


        DB::transaction(function() use ($request ) {

            $kycLog                  = new KycLog();
            $kycLog->user_id         = $this->user->id;
            $kycLog->status          = KycStatus::PENDING;
            $kycLog->kyc_data        = (Arr::except($request['kyc_data'],['attachment']));
            $kycLog->save();

            if(isset($request["kyc_data"] ['attachment'][0])){
                foreach($request["kyc_data"] ['attachment'] as $file){
                    $response = $this->storeFile(
                        file        : $file, 
                        location    : config("settings")['file_path']['kyc']['path'],
                    );
                    if(isset($response['status'])){
                        $file = new File([
                            'name'      => Arr::get($response, 'name', '#'),
                            'disk'      => Arr::get($response, 'disk', 'local'),
                            'type'      => 'ticket_file',
                            'size'      => Arr::get($response, 'size', ''),
                            'extension' => Arr::get($response, 'extension', ''),
                        ]);

                        $kycLog->file()->save($file);
                    }
                }
            }

            $route          =  route("admin.kyc.report.details",$kycLog->id);

            $admin          = get_admin();

            $code           = [
                "name"          =>  $this->user->name,
                "time"          =>  Carbon::now(),
            ];

            $notifications = [

                'database_notifications' => [
                    'action' => [SendNotification::class, 'database_notifications'],
                    'params' => [
                        [ $admin, 'KYC_APPLIED', $code, $route ],
              
                    ],
                ],

                'slack_notifications' => [
                    'action' => [SendNotification::class, 'slack_notifications'],
                    'params' => [
                        [
                            $admin, 'KYC_APPLIED', $code, $route
                        ]
                    ],
                ],

                'email_notifications' => [
                    'action' => [SendMailJob::class, 'dispatch'],
                    'params' => [
                        [$admin,'KYC_APPLIED',$code],
                      
                    ],
                ],
                'sms_notifications' => [
                    'action' => [SendMailJob::class, 'dispatch'],
                    'params' => [
                        [$admin,'NEW_TICKET',$code],
                       
                    ],
                ],
               
            ];

            $this->notify($notifications);

            return $kycLog ;
        });


        return back()->with(response_status('KYC application submitted! Verification in progress. We will notify you upon completion. Thank you for your patience'));
    }




 
}
