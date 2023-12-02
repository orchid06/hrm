<?php

namespace App\Http\Services\Gateway\bkash;

use App\Http\Services\CurlService;
use App\Http\Services\PaymentService;
use App\Models\Admin\PaymentMethod;
use App\Models\PaymentLog;
use Config;
use Illuminate\Support\Arr;
use Karim007\LaravelBkashTokenize\Facade\BkashPaymentTokenize;
class Payment
{

    public static function paymentData(PaymentLog $log)
    {
        $gateway = ($log->method->parameters);
        
          
        if ($gateway->sandbox == '1') {
            $sandbox = true;
        } else {
            $sandbox = false;
        }
        $config = [
            'sandbox'=>   $sandbox ,
            'bkash_app_key'=> $gateway->api_key ,
            'bkash_app_secret'=>  $gateway->api_secret ,
            'bkash_username'=>  $gateway->username ,
            'bkash_password'=>  $gateway->password ,
            'callbackURL'=>   route('ipn', [$log->method->code, $log->transaction]) ,
            "timezone" => "Asia/Dhaka"
        ];
        Config::set('bkash',  $config );

        $request = [];
        $inv = uniqid();
        $request['intent'] = 'sale';
        $request['mode'] = '0011'; 
        $request['payerReference'] = $inv;
        $request['currency'] = 'BDT';
        $request['amount'] = round($log->final_amount);
        $request['merchantInvoiceNumber'] = $log->transaction;
        $request['callbackURL'] = config("bkash.callbackURL");;

        $request_data_json = json_encode($request);

        $response =  BkashPaymentTokenize::cPayment($request_data_json);

        
        if (isset($response['bkashURL'])) {
            $send['redirect'] = true;
            $send['redirect_url'] = $response['bkashURL'];
        }
        else {
            $send['error'] = true;
            $send['message'] = "Invalid Request";
        }

        return json_encode($send);
    }
    public static function ipn(mixed $request, PaymentMethod $gateway, PaymentLog $log = null,mixed $trx = null, mixed $type = null)
    {
        $gateway = ($log->method->parameter);
        if ($gateway->sandbox == '1') {
            $sandbox = true;
        } else {
            $sandbox = false;
        }
        $config = [
            'sandbox'=>   $sandbox ,
            'bkash_app_key'=> $gateway->api_key ,
            'bkash_app_secret'=>  $gateway->api_secret ,
            'bkash_username'=>  $gateway->user_name ,
            'bkash_password'=>  $gateway->password ,
            'callbackURL'=>   route('ipn', [$log->method->code, $log->transaction]) ,
            "timezone" => "Asia/Dhaka"
        ];
        Config::set('bkash',  $config );
        if ($request->status == 'success'){
            $response = BkashPaymentTokenize::executePayment($request->paymentID); 

            if (isset($response['statusCode']) && $response['statusCode'] == "0000" && $response['transactionStatus'] == "Completed") {
                PaymentService::make_payment($log);
                $data['status'] = 'success';
                $data['msg'] = trans('default.trx_success');  

                $data['redirect'] = route('success');
                return $data;
          
            }
            $data['status'] = 'error';
            $data['msg'] = translate('invalid amount.');
            $data['redirect'] = route('failed');;
  
        }else if ($request->status == 'cancel'){
          
            $data['status'] = 'error';
            $data['msg'] = translate('Payment Cancel.');
            $data['redirect'] = route('failed');
        }else{
            $data['status'] = 'error';
                    $data['msg'] = translate('invalid amount.');
                    $data['redirect'] = route('failed');
        }

  
        return $data;
    }

}