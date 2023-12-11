<?php

namespace App\Http\Services\Gateway\payumoney;


use App\Http\Services\CurlService;
use App\Http\Services\PaymentService;
use App\Models\Admin\PaymentMethod;
use App\Models\PaymentLog;
use Illuminate\Support\Arr;

class Payment
{
    public static function paymentData(PaymentLog $log)
    {
        $siteName = site_settings('site_name');
        $gateway = ($log->method->parameters);
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';
        $send['val'] = [
            'key' => $gateway->merchant_key ?? '',
            'txnid' => $log->trx_code,
            'amount' => round($log->final_amount,2),
            'firstname' => optional($log->user)->username ?? 'SMM Panel',
            'email' => optional($log->user)->email ?? '',
            'productinfo' => $log->trx_code ?? 'Order',
            'surl' => route('ipn', [$log->method->code, $log->trx_code]),
            'furl' => route('failed'),
            'service_provider' =>$siteName ?? 'SMM Panel',
        ];
        foreach ($hashVarsSeq as $hash_var) {
            $hash_string .= $send['val'][$hash_var] ?? '';
            $hash_string .= '|';
        }
        $hash_string .= $gateway->parameters->salt ?? '';

        $send['val']['hash'] = strtolower(hash('sha512', $hash_string));
        $send['view'] = 'user.payment.redirect';
        $send['method'] = 'post';
        //$send['url'] = 'https://test.payu.in/_payment'; //test 
        $send['url'] = 'https://secure.payu.in/_payment';
        return json_encode($send);
    }

    public static function ipn(mixed $request, PaymentMethod $gateway, PaymentLog $log = null,mixed $trx = null, mixed $type = null)
    {
        if (isset($request->status) && $request->status == 'success') {
            if (($gateway->parameters->merchant_key ?? '') == $request->key) {
                if ($log->trx_code == $request->txnid) {
                    if (round($log->final_amount,2) <= $request->amount) {
                        PaymentService::make_payment($log);

                        $data['status'] = 'success';
                        $data['msg'] = trans('default.trx_success');                        
                        $data['redirect'] = route('success');
                    } else {
                        $data['status'] = 'error';
                        $data['msg'] = translate('invalid amount.');
                        $data['redirect'] = route('failed');
                    }
                } else {
                    $data['status'] = 'error';
                    $data['msg'] = translate('invalid trx id.');
                    $data['redirect'] = route('failed');
                }
            } else {
                $data['status'] = 'error';
                $data['msg'] = translate('invalid account.');
                $data['redirect'] = route('failed');
            }
        } else {
            $data['status'] = 'error';
            $data['msg'] = trans('default.trx_failed');
            $data['redirect'] = route('failed');
        }
        return $data;
    }
}
