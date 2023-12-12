<?php

namespace App\Http\Services\Gateway\razorpay;

use App\Http\Services\CurlService;
use App\Http\Services\PaymentService;
use App\Models\Admin\PaymentMethod;
use App\Models\PaymentLog;
use Illuminate\Support\Arr;
use Razorpay\Api\Api;

require_once('razorpay-php/Razorpay.php');

class Payment
{
    public static function paymentData(PaymentLog $log)
    {
        $siteName = site_settings('site_name');
        $gateway = ($log->method->parameters);
        $api_key = $gateway->key_id ?? '';
        $api_secret = $gateway->key_secret ?? '';
        $razorPayApi = new Api($api_key, $api_secret);
        $finalAmount = round($log->final_amount * 100, 2);
        $gatewayCurrency =  $log->method->currency;
        $trx = $log->trx_code;
        $razorOrder = $razorPayApi->order->create(
            array(
                'receipt' => $trx,
                'amount' => $finalAmount,
                'currency' => $gatewayCurrency,
                'payment_capture' => '0'
            )
        );

        $val['key'] = $api_key;
        $val['amount'] = $finalAmount;
        $val['currency'] = $gatewayCurrency;
        $val['order_id'] = $razorOrder['id'];
        $val['buttontext'] = "Pay via Razorpay";
        $val['name'] = optional($log->user)->username;
        $val['description'] = "Payment By Razorpay";
        $val['image'] = asset('assets/uploads/logo/logo.png');
        $val['prefill.name'] = optional($log->user)->username;
        $val['prefill.email'] = optional($log->user)->email;
        $val['prefill.contact'] = optional($log->user)->phone;
        $val['theme.color'] = "#2ecc71";
        $send['val'] = $val;

        $send['method'] = 'POST';
        $send['url'] = route('ipn',[$log->method->code, $log->trx_code]);
        $send['custom'] = $trx;
        $send['checkout_js'] = "https://checkout.razorpay.com/v1/checkout.js";
        $send['view'] = 'user.payment.razorpay';
        return json_encode($send);
    }

    public static function ipn(mixed $request, PaymentMethod $gateway, PaymentLog $log = null,mixed $trx = null, mixed $type = null)
    {

        $params = ($gateway->parameters);
        $api_secret = $params->key_secret ?? '';
        $signature = hash_hmac('sha256', $request->razorpay_order_id . "|" . $request->razorpay_payment_id, $api_secret);

        if ($signature == $request->razorpay_signature) {
            PaymentService::make_payment($log);

            $data['status'] = 'success';
            $data['msg'] = trans('default.trx_success');
            $data['redirect'] = route('success');
        } else {
            $data['status'] = 'error';
            $data['msg'] = trans('default.trx_failed');
            $data['redirect'] = route('failed');
        }

        return $data;
    }
}
