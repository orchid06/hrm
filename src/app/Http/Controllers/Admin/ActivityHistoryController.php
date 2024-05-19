<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DepositStatus;
use App\Enums\StatusEnum;
use App\Enums\SubscriptionStatus;
use App\Enums\WithdrawStatus;
use App\Http\Controllers\Controller;
use App\Http\Services\PaymentService;
use App\Http\Utility\SendNotification;
use App\Jobs\SendMailJob;
use App\Jobs\SendSmsJob;
use App\Models\Admin\PaymentMethod;
use App\Models\PaymentLog;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Models\Admin\Template;
use App\Models\Admin\Withdraw;
use App\Models\AffiliateLog;
use App\Models\AiTemplate;
use App\Models\CreditLog;
use App\Models\KycLog;
use App\Models\Package;
use App\Models\PostWebhookLog;
use App\Models\TemplateUsage;
use App\Models\WithdrawLog;
use App\Traits\ModelAction;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use App\Traits\Notifyable;
use Illuminate\Support\Facades\Redirect;

class ActivityHistoryController extends Controller
{


    use ModelAction ,Notifyable;

    public function __construct()
    {


        $this->middleware(['permissions:view_report'])
            ->only([
                    "templateReport",
                    'creditReport',
                    'transactionReport',
                    'subscriptionReport',
                    'updateSubscription',
                    "depositReport",
                    "updateDeposit",
                    "depositDetails",
                    'withdrawReport',
                    'withdrawUpdate',
                    'withdrawDetails',
                    'kycReport',
                    'kycDetails',
                    'kycUpdate',
                    'webhookReport'
                ]);

        $this->middleware(['permissions:delete_report'])
             ->only([
                    "templateReportdestroy",
                    'creditReportDestory',
                    'creditReportBulk',
                    'destroyTransaction',
                    'transactionBulk',
                    'depostiBulk',
                    'destroyDeposit',
                    'destroyWebhook'
                ]);
    }



    /**
     * ai template templates report
     *
     * @return View
     */
    public function templateReport() :View{


        return view('admin.report.word_report',[

            'breadcrumbs'     =>  ['Home'=>'admin.home','Templates Reports'=> null],
            'title'           => 'Templates Reports',
            "genarated_words" => TemplateUsage::filter(['template:slug',"user:username"])
                                  ->date()
                                  ->sum("total_words"),

            "reports"         => TemplateUsage::with(['template','admin','user'])
                                        ->filter(['template:slug',"user:username"])
                                        ->date()               
                                        ->latest()
                                        ->paginate(paginateNumber())
                                        ->appends(request()->all()),
                                    
            "templates"      => AiTemplate::whereHas("templateUsages")->get(),
           
         
        ]);

    }


    /**
     * Template report delete
     * 
     * @param string | int $id
     */
    public function templateReportdestroy(string | int $id) :RedirectResponse{

        $report  = TemplateUsage::custom()->where('id',$id)->firstOrfail();
        $report->delete();
        return  back()->with(response_status('Item deleted succesfully'));
    }


    /**
     * Credit report
     *
     * @return View
     */
    public function creditReport() :View{


        return view('admin.report.credit_report',[

            'breadcrumbs'     =>  ['Home'=>'admin.home','Credit Reports'=> null],
            'title'           => 'Credit Reports',
            "reports"         => CreditLog::with(['user'])
                                    ->search(['remark','trx_code'])
                                    ->filter(["user:username",'type'])
                                    ->date()               
                                    ->latest()
                                    ->paginate(paginateNumber())
                                    ->appends(request()->all()),


         
        ]);

    }
    

    /**
     * Credit report destory
     * 
     */
    public function creditReportdestroy(int | string $id) :RedirectResponse{

        $report = CreditLog::findOrfail($id);
        $report->delete();
        return  back()->with(response_status('Deleted Successfully'));
    }


    /**
     * Credit report bulk destroy
     * 
     */
    public function creditReportBulk(Request $request) :RedirectResponse{

        try {
            $response =  $this->bulkAction($request,[
                "model"        => new CreditLog(),
            ]);
    
        } catch (\Exception $exception) {
            $response  = \response_status($exception->getMessage(),'error');
        }
        return  back()->with($response);
    }





    /**
     * transaction Log
     *
     * @return View
     */
    public function transactionReport() :View{


        return view('admin.report.transaction_report',[

            'breadcrumbs'     =>  ['Home'=>'admin.home','Transaction Reports'=> null],
            'title'           => 'Transaction Reports',
            "reports"         => Transaction::with(['user','admin','currency'])
                                    ->search(['remarks','trx_code'])
                                    ->filter(["user:username",'trx_type'])
                                    ->date()               
                                    ->latest()
                                    ->paginate(paginateNumber())
                                    ->appends(request()->all()),

        ]);

    
    }


    /**
     * Detroty a transaction
     * 
     */
    public function destroyTransaction(int | string $id) :RedirectResponse{

        $report = Transaction::findOrfail($id);
        $report->delete();
        return  back()->with(response_status('Deleted Successfully'));
        
    }

    /**
     * Destory bulk transaction
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function transactionBulk(Request $request) :RedirectResponse{

        
        try {
            $response =  $this->bulkAction($request,[
                "model"        => new Transaction(),
            ]);
    
        } catch (\Exception $exception) {
            $response  = \response_status($exception->getMessage(),'error');
        }
        return  back()->with($response);

        
    }



    /**
     * subscription Log
     *
     * @return View
     */
    public function subscriptionReport() :View{


        return view('admin.report.subscription_report',[

            'breadcrumbs'     =>  ['Home'=>'admin.home','Subscription Reports'=> null],
            'title'           => 'Subscription Reports',
            "reports"         => Subscription::with(['user','package','oldPackage'])
                                    ->search(['trx_code'])
                                    ->filter(["user:username",'package:slug'])
                                    ->date()               
                                    ->latest()
                                    ->paginate(paginateNumber())
                                    ->appends(request()->all()),


            "packages"       => Package::all(),
         
        ]);

    
    }


    /**
     * Update  subscription
     * 
     */
    public function updateSubscription(Request $request) :RedirectResponse{

        $request->validate([
            'id'         => ["required","exists:subscriptions,id"],
            "status"     => ["required",Rule::in(SubscriptionStatus::toArray())],
            "expired_at" => ["required",'date'],
        ]);

        $subscription             = Subscription::with(['user','package'])
                                      ->where('id',$request->input('id'))
                                      ->firstOrFail();
        $subscription->status     = $request->input("status");
        $subscription->remarks    = $request->input("remarks");
        $subscription->expired_at = $request->input("expired_at");
        $subscription->save();
        $code = [
            "link"          => route("user.subscription.report.list"), 
            "plan_name"     => $subscription->package->title,
            "time"          => Carbon::now(),
            "status"        => Arr::get(array_flip(SubscriptionStatus::toArray()),$subscription->status ,"Expired")
        ];

        $notifications = [

            'database_notifications' => [
                'action' => [SendNotification::class, 'database_notifications'],
                'params' => [
                    [ $subscription->user, 'SUBSCRIPTION_STATUS', $code, Arr::get( $code , "link", null) ],
                ],
            ],
            'email_notifications' => [
                'action' => [SendMailJob::class, 'dispatch'],
                'params' => [

                    [ $subscription->user, 'SUBSCRIPTION_STATUS', $code],
                ],
            ],
            'sms_notifications' => [
                'action' => [SendSmsJob::class, 'dispatch'],
                'params' => [

                    [ $subscription->user, 'SUBSCRIPTION_STATUS', $code],
                ],
            ],
            
        ];
        $this->notify( $notifications);

        return  back()->with(response_status('Subscription updated'));
        
    }




    /**
     * deposit report
     *
     * @return View
     */
    public function depositReport() :View{


        return view('admin.report.deposit_report',[

            'breadcrumbs'     =>  ['Home'=>'admin.home','Deposit Reports'=> null],
            'title'           => 'Deposit Reports',
            "reports"         =>  PaymentLog::with(['user','method','method.currency','currency'])
                                        ->search(['trx_code'])
                                        ->filter(["user:username",'method_id','status'])
                                        ->date()               
                                        ->latest()
                                        ->paginate(paginateNumber())
                                        ->appends(request()->all()),
                                        
            'methods'         => PaymentMethod::active()->get()
            

         
        ]);

    
    }


    
    /**
     * deposit details
     *
     * @return View
     */
    public function depositDetails(int | string $id) :View{


        return view('admin.report.deposit_details',[

            'breadcrumbs'     =>  ['Home'=>'admin.home',"Deposits"=> "admin.deposit.report.list",'Deposit Details'=> null],
            'title'           => 'Deposit Details',
            "report"          =>  PaymentLog::with(['user','method','method.currency','currency','file'])
                                    ->findOrfail($id)
                                        
        ]);
    }


    /**
     * deposit details
     *
     * @return View
     */
    public function updateDeposit(Request $request) :RedirectResponse{

        $request->validate([
            "id"        => ['required',"exists:payment_logs,id"],
            "status"    => ['required',Rule::in([DepositStatus::value('REJECTED'),DepositStatus::value('PAID')])],
            "feedback"  => ['required',"string",'max:255'],
        ]);

        $deposit  = PaymentLog::with(['user','method',"currency"])->where('id',$request->input("id"))
                    ->pending()
                    ->firstOrfail();
        $response =  (new PaymentService())->handleDepositRequest( $deposit ,$request->except(['id','token']));

        return back()->with(response_status(Arr::get($response,"message",translate('Fail to update')) ,$response['status']? "success":"error" ));
    }
  



    /**
     * withdraw report
     *
     * @return View
     */
    public function withdrawReport() :View{


        return view('admin.report.withdraw_report',[

            'breadcrumbs'     =>  ['Home'=>'admin.home','Withdraw Report'=> null],
            'title'           => 'Withdraw Reports',
            "reports"         =>  WithdrawLog::with(['user','method','currency'])
                                    ->search(['trx_code'])
                                    ->filter(["user:username",'status'])
                                    ->date()               
                                    ->latest()
                                    ->paginate(paginateNumber())
                                    ->appends(request()->all()),

        ]);

    
    }


    
    /**
     * withdraw details
     *
     * @return View
     */
    public function withdrawDetails(int | string $id) :View{


        return view('admin.report.withdraw_details',[

            'breadcrumbs'     =>  ['Home'=>'admin.home',"Withdraws"=> "admin.withdraw.report.list",'Withdraw Details'=> null],
            'title'           => 'Withdraw details',
            "report"          =>  WithdrawLog::with(['user','method','method','currency',"file"])
                                    ->findOrfail($id)
                                        
        ]);

    
    }


    /**
     * withdraw update
     *
     * @return View
     */
    public function withdrawUpdate(Request $request) :RedirectResponse{


        $request->validate([
            "id"        => ['required',"exists:withdraw_logs,id"],
            "status"    => ['required',Rule::in([WithdrawStatus::value('APPROVED'),WithdrawStatus::value('REJECTED')])],
            "notes"     => ['required',"string",'max:255'],
        ]);

        $log           = WithdrawLog::with(['user','method',"currency"])->where('id',$request->input("id"))
                            ->pending()
                            ->firstOrfail();
        
        $response      =  response_status("Insufficient funds in user account. Withdrawal request cannot be processed due to insufficient balance. ",'error');

        if($log->user &&  $log->user->balance > $log->base_final_amount){

            $response =  (new PaymentService())->handleWithdrawRequest($log ,$request->except(['id','token']));
            $response =  response_status(Arr::get($response,"message",translate('Fail to update')) ,$response['status']? "success":"error" );
        }               


        return back()->with($response);
    }



    /**
     * affiliate report
     *
     * @return View
     */
    public function affiliateReport() :View{


        return view('admin.report.affiliate_report',[

            'breadcrumbs'     =>  ['Home'=>'admin.home','Affiliate Reports'=> null],
            'title'           => 'Affiliate Reports',
            "reports"         =>  AffiliateLog::with(['user','subscription','subscription.package','referral'])
                                    ->search(['trx_code'])
                                    ->filter(["user:username"])
                                    ->date()               
                                    ->latest()
                                    ->paginate(paginateNumber())
                                    ->appends(request()->all()),

         
        ]);

    
    }




    /**
     * kyc report
     *
     * @return View
     */

    public function kycReport() :View{


        return view('admin.report.kyc_report',[

            'breadcrumbs'     =>  ['Home'=>'admin.home','Kycs Reports'=> null],
            'title'           => 'Kyc Reports',
            "reports"         =>  KycLog::with(['user'])
                                    ->search(['notes'])
                                    ->filter(["user:username","status"])
                                    ->date()               
                                    ->latest()
                                    ->paginate(paginateNumber())
                                    ->appends(request()->all()),

         
        ]);

    
    }



    /**
     * kyc report details
     *
     * @return View
     */
    
     public function kycDetails(int | string $id) :View{


        return view('admin.report.kyc_details',[

            'breadcrumbs'     => ['Home'=>'admin.home','Kycs'=> "admin.kyc.report.list" ,'Details' => null],
            'title'           => 'Kyc Details',
            "report"         =>  KycLog::with(['user','file']) 
                                    ->where('id',$id)          
                                    ->latest()
                                    ->firstOrfail()
    

         
        ]);

    
    }



    /**
     * kyc report update
     *
     * @return View
     */
    
     public function kycUpdate(Request $request) :RedirectResponse{

        $request->validate([
            "id"        => ['required',"exists:kyc_logs,id"],
            "status"    => ['required',Rule::in([WithdrawStatus::value('APPROVED'),WithdrawStatus::value('REJECTED')])],
            "notes"     => ['required',"string",'max:255'],
        ]);

        $report  = KycLog::with(['user','file']) 
                    ->pending()    
                    ->where('id',$request->input("id"))     
                    ->latest()
                    ->firstOrfail();


        
        $report->status  = $request->input('status');
        $report->notes   = $request->input('notes');
        $report->save();

        if($report->status == WithdrawStatus::value('APPROVED',true)) {

            $report->user->is_kyc_verified  = StatusEnum::true->status();
            $report->user->save();
        }



        $code = [
            "name"            => $report->user->name,
            "status"          => Arr::get(array_flip(WithdrawStatus::toArray()),$report->status ,"Pending")
        ];

        $route      =  route("user.kyc.report.list");

        $notifications = [

            'database_notifications' => [
                
                'action' => [SendNotification::class, 'database_notifications'],
                'params' => [
                   [ $report->user, 'KYC_UPDATE', $code, $route ]
                ],
            ],
          
            'email_notifications' => [

                'action' => [SendMailJob::class, 'dispatch'],
                'params' => [
                   [$report->user, 'KYC_UPDATE', $code],
                ],
            ],
            'sms_notifications' => [

                'action' => [SendSmsJob::class, 'dispatch'],
                'params' => [
                    [$report->user, 'KYC_UPDATE', $code],
                ],
            ],
        ];

        $this->notify($notifications);

        return back()->with(response_status("Updated successfully"));

    
    }


    /**
     * webhook report
     *
     * @return View
     */

     public function webhookReport() :View{


        return view('admin.report.webhook_report',[

            'breadcrumbs'     =>  ['Home'=>'admin.home','Webhook Reports'=> null],
            'title'           => 'Webhook Reports',
            "reports"         => PostWebhookLog::whereNull('user_id')
                                    ->date()               
                                    ->latest()
                                    ->paginate(paginateNumber())
                                    ->appends(request()->all()),
         
        ]);

    
    }


    /**
     * webhook report Delete
     *
     * @return RedirectResponse
     */

     public function destroyWebhook(int | string $id) :RedirectResponse{


        $report  = PostWebhookLog::whereNull('user_id')->where('id',$id)->firstOrfail();
        $report->delete();
        return  back()->with(response_status('Deleted Successfully'));

    
    }




}
