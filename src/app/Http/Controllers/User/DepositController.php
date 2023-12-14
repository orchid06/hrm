<?php

namespace App\Http\Controllers\User;

use App\Enums\DepositStatus;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Http\Services\UserService;
use App\Models\Admin\PaymentMethod;
use App\Models\PaymentLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
class DepositController extends Controller
{
    
    protected $userService ,$user;

    public function __construct(){
        
        $this->userService = new UserService();

        $this->middleware(function ($request, $next) {
            $this->user = auth_user('web');
            return $next($request);
        });
    }


    /**
     * Process deposit request
     *
     * @param DepositRequest $request
     * @return array
     */
    public function process(DepositRequest $request) : View | RedirectResponse {


        $method           = PaymentMethod::with(['currency'])->find($request->input("payment_id"));
        $responseStatus   = response_status(translate('Deposit amount should be less than ').num_format(number :$method->maximum_amount ,calC:true). " and greter than ".num_format(number :$method->minimum_amount ,calC:true),'error');

        try {
            $amount    = (double) $request->input('amount');

            if($amount  >= $method->minimum_amount || $amount <= $method->maximum_amount ){

                $request->merge([
                    'remarks' => 'Deposit Via '.$method->name,
                ]);
                $depositResponse =  $this->userService->createDepositLog($request,$this->user,$method,DepositStatus::value('INITIATE',true));
                $depositLog      = Arr::get($depositResponse ,"log");

                return $this->depositConfirm($depositLog);
                
            }
    
        } catch (\Exception $ex) {
            $message = strip_tags( $ex->getMessage());
        }
    

        return back()->with($responseStatus);
      
        
    }


    
    /**
     *  Deposit request confirmation
     *
     * @param PaymentLog $depositLog
     * @return mixed
     */
    public function depositConfirm(PaymentLog $depositLog) :mixed {

        $metaData = [
            'title' => 'Pay With '.$depositLog->method->name
        ];

        if($depositLog->method->type == StatusEnum::false->status()){

            session()->put('trx_code',$depositLog->trx_code);
            
            $metaData = [
                'title' => translate("Payment Confirm")
            ];

            return view('user.payment.manual',[
                'log'        => $depositLog,
                'meta_data'  => $this->metaData($metaData),
            ]);
        }

        try {
            $gatewayService  = 'App\\Http\\Services\\Gateway\\'.$depositLog->method->code.'\\Payment';
            $data            = $gatewayService::paymentData($depositLog);
            $data            = json_decode($data);

        } catch (\Exception $exception) {
            return back()->with(response_status($exception->getMessage(),'error'));
        }


        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        if (isset($data->error)) {
            return back()->with(response_status($data->message,'error'));
        }
       

        return view($data->view,[
            'log'       => $depositLog,
            'data'      => $data,
            'meta_data' => $this->metaData($metaData),
        ]);
    }



    /**
     * payment ipn route
     *
     * @param Request $request
     * @param string $code
     * @param string $trx
     * @param string $type
     * @return mixed
     */
    public function callbackIpn(Request $request , ? string $trxCode = null , ? string $type = null ) :RedirectResponse  {
        

        $responseStatus = response_status("Invalid deposit request",'error');

        try {
      
            $trxCode    = $trxCode?? session()->get("trx_code");
            $depositLog = PaymentLog::with(['user','method','currency'])
                            ->where('trx_code', $trxCode)
                            ->initiate()
                            ->first();


            $gatewayService = 'App\\Http\\Services\\Gateway\\'.$depositLog->method->code.'\\Payment';
            $data           = $gatewayService::ipn($request, @$depositLog, @$type);
            if (isset($data['redirect'])) {
                return   Redirect::to($data['redirect'])->with($data['status'],$data['message']);
            }

        } catch (\Exception $ex) {
            $responseStatus = response_status(strip_tags($ex->getMessage()),'error');
        }

        return redirect()->route('user.home')->with($responseStatus);


    }

    /**
     * Manual payment 
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function manualPay(Request  $request) :RedirectResponse
    {

        $depositLog = PaymentLog::with(['user','method','currency'])
                        ->where('trx_code', session()->get('trx_code'))
                        ->initiate()
                        ->firstOrfail();

        
        $depositLog->status = DepositStatus::value('PENDING',true);
        $depositLog->save();

        $rules = $this->userService->paramValidationRules($depositLog->method->parameters);

        $this->validate($request, $rules);

        $this->userService->saveCustomInfo($request , $depositLog , $depositLog->method->parameters,'custom_data');

        session()->forget('trx_code');

        return redirect()->route('user.home')->with(response_status('Your deposit request is pending,Please Wait For Confirmation'));
    }




    public function success(Request $request) :RedirectResponse{
        return redirect()->route('user.home')->with(response_status('Payment Request Successfully Processed'));
     }
     public function failed(Request $request) :RedirectResponse{
         return redirect()->route('user.home')->with(response_status('Invalid Payment Requrest !','error'));
     }






}