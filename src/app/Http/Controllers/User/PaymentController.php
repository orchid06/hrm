<?php

namespace App\Http\Controllers\User;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Services\PaymentService;
use App\Models\Admin\PaymentMethod;
use App\Models\Package;
use App\Models\PaymentLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
class PaymentController extends Controller
{
    
    protected $paymentService ;

    public function __construct(){
        $this->paymentService = new PaymentService();
    }

    public function process(Request $request) : array{

        $request->validate([
            'package_id'=> 'required|exists:packages,id',
            'method_id'=> 'required|exists:payment_methods,id',
        ]);
        return $this->paymentService->createPaymentLog($request);
        
    }


    /**
     *payment confirmation
     *
     * @param Request $request
     * @return mixed
     */
    public function confirm(Request $request) :mixed
    {

        $trx = session()->get('trx_number');
        $log = PaymentLog::where('transaction', $trx)->orderBy('id', 'DESC')->with(['method','user','package'])->first();

        $meta_data = [
            'title' => 'Pay With '.$log->method->name
        ];

        if (is_null($log) || $log->status !=  StatusEnum::false->status()) {
            return redirect()->route('user.home')->with(response_status('Invalid Transaction','error'));
        }

        if($log->method->type == StatusEnum::false->status()){

            $meta_data = [
                'title' => 'Payment Confirm'
            ];
            return view('user.payment.manual',[
                'log' => $log,
                'meta_data'=> $this->metaData($meta_data),
            ]);
        }

        try {

            $gatewayService = 'App\\Http\\Services\\Gateway\\'.$log->method->code.'\\Payment';
            $data = $gatewayService::paymentData($log);
            $data = json_decode($data);

        } catch (\Exception $exception) {
            return back()->with(response_status($exception->getMessage(),'error'));
        }


        if (isset($data->error)) {
            return back()->with(response_status($data->message,'error'));
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        return view($data->view,[
            'log' => $log,
            'data'=> $data,
            'meta_data'=> $this->metaData($meta_data),
        ]);
    }


    public function manualPay(Request  $request)
    {
        $trx = session()->get('trx_number');
        $log = PaymentLog::where('transaction', $trx)->orderBy('id', 'DESC')->with(['method','user','package'])->first();
        if (is_null($log) || $log->status !=  StatusEnum::false->status()) {
            return redirect()->route('user.home')->with(response_status('Invalid Transaction','error'));
        }
        $rules = $this->paymentService->manualPaymentValidation($log);
        $this->validate($request, $rules);
        $this->paymentService->saveManualPayment($request,$log);
        
        session()->forget('trx_number');
        return redirect()->route('user.home')->with(response_status('Your Subscription Request Is Pending Now!! Please Wait For Confirmation'));
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
    public function callbackIpn(Request $request , string $code = null , string $trx = null , string $type = null )  {
        

        if(isset($request->m_orderid)){
            $trx  = $request->m_orderid;
        }

        try {
            $gateway = PaymentMethod::where('code', $code)->first();
            
            if (!$gateway) throw new \Exception('Invalid Payment Gateway.');
            if (isset($trx)) {
                $paymentLog = PaymentLog::where('transaction', $trx)->with(['method','user','package'])->first();
                if (!$paymentLog) throw new \Exception('Invalid Payment Request.');
            }
            $gatewayService = 'App\\Http\\Services\\Gateway\\'.$paymentLog->method->code.'\\Payment';
            $data = $gatewayService::ipn($request, $gateway, @$paymentLog, @$trx, @$type);
      
            if (isset($data['redirect'])) {
                
                return   Redirect::to($data['redirect'])->with($data['status'], $data['msg']);
            }
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }


    }

    public function success(Request $request) :RedirectResponse{
       return redirect()->route('user.home')->with(response_status('Payment Request Successfully Processed'));

    }
    public function failed(Request $request) :RedirectResponse{
        return redirect()->route('user.home')->with(response_status('Invalid Payment Requrest !','error'));
    }




}
