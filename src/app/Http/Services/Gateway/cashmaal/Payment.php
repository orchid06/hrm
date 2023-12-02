<?php

namespace App\Http\Services\Gateway\cashmaal;

use App\Http\Services\CurlService;
use App\Http\Services\PaymentService;
use App\Models\Admin\PaymentMethod;
use App\Models\PaymentLog;
class Payment
{
    public static function paymentData(PaymentLog $log)
    {

        $gateway = ($log->method->parameters);

        $val['pay_method'] = " ";
        $val['amount'] = round($log->final_amount, 2);
        $val['currency'] = $log->method->currency;
        $val['succes_url'] = route('success');
        $val['cancel_url'] = route('failed');
        $val['client_email'] = optional($log->user)->email;
        $val['web_id'] = $gateway->web_id;
        $val['order_id'] = $log->transaction;
        $val['addi_info'] = "Payment";

        $send['url'] = 'https://www.cashmaal.com/Pay/';
        $send['method'] = 'post';
        $send['view'] = 'user.payment.redirect';
        $send['val'] = $val;

        return json_encode($send);
    }

    public static function ipn(mixed $request, PaymentMethod $gateway, PaymentLog $log = null,mixed $trx = null, mixed $type = null)
    {
        $log = PaymentLog::with('method')->where('transaction', $request->order_id)->orderBy('id', 'DESC')->first();
        if ($log) {
            if ($request->currency == $log->method->currency && ($request->Amount == round($log->final_amount, 2)) && $log->status == '0') {
                PaymentService::make_payment($log);
            }
        }
    }
}
