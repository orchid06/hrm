<?php

namespace App\Http\Services\Gateway\coinbase;

use App\Enums\DepositStatus;
use App\Http\Services\UserService;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use CoinGate\CoinGate;
use CoinGate\Merchant\Order;

class Payment
{
    public static function paymentData(PaymentLog $log) :string {

        $gateway    = ($log->method->parameters);

        try {
            CoinGate::config(array(
                'environment' => 'live', // sandbox OR live
                'auth_token'  => $gateway->api_key
            ));
        } catch (\Exception $e) {

            $send['error']   = true;
            $send['message'] = $e->getMessage();
            return json_encode($send);
        }

        $siteName   = site_settings('site_name');

        $post_params = array(
            'order_id'         => $log->trx_code,
            'price_amount'     => round($log->final_amount,2),
            'price_currency'   => $log->method->currency->code,
            'receive_currency' => $log->method->currency->code,
            'callback_url'     => route('ipn',[$log->trx_code]),
            'cancel_url'       => route('cancel'),
            'success_url'      => route('success'),
            'title'            => 'Deposit to ' . $siteName,
            'token'            => $log->trx_code
        );

        try {
            $order = Order::create($post_params);
        } catch (\Exception $e) {
            $send['error']    = true;
            $send['message']  = $e->getMessage();
            return json_encode($send);
        }
        if ($order) {
            $send['redirect']     = true;
            $send['redirect_url'] = $order->payment_url;
        } else {
            $send['error']   = true;
            $send['message'] = translate('Unexpected Error! Please Try Again');
        }
        return json_encode($send);
       
    }

    public static function ipn(Request $request, PaymentLog $depositLog) :array {

        $data['status']      = 'error';
        $data['message']     = translate('Unable to Process.');
        $data['redirect']    = route('user.home');
        $data['gw_response'] = $request->all();
        $status              = DepositStatus::value('FAILED',true);

        $postdata    = file_get_contents("php://input");
        $res         = json_decode($postdata);
        $gateway     = ($depositLog->method->parameters);
        $headers     = apache_request_headers();
        $headers     = json_decode(json_encode($headers),true);
        $sentSign    = $headers['X-Cc-Webhook-Signature'];
        
        $sig         = hash_hmac('sha256', $postdata, $gateway->webhook_secret);

        if ($sentSign == $sig && $res->event->type == 'charge:confirmed') {

            $data['status']   = 'success';
            $data['message']  = trans('default.deposit_success');
            $status           = DepositStatus::value('PAID',true);
            
        }

        UserService::updateDepositLog($depositLog,$status,$data);


        return $data;
    
       
    }
}
