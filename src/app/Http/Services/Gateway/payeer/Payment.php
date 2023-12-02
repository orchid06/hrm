<?php

namespace App\Http\Services\Gateway\payeer;

use App\Enums\StatusEnum;
use App\Models\PaymentLog;

use App\Http\Services\PaymentService;
use App\Models\Admin\PaymentMethod;
use Illuminate\Support\Arr;

class Payment
{
    public static function paymentData(PaymentLog $log)
    {
        $siteName = site_settings('site_name');
        $gateway = ($log->method->parameters);
        $m_amount = number_format($log->amount, 2, '.', "");
        $arHash = [
            trim($gateway->merchant_id),
            $log->transaction,
            $m_amount,
            $log->method->currency,
            base64_encode("Pay To $siteName"),
            trim($gateway->secret_key)
        ];

        $val['m_shop'] = trim($gateway->merchant_id);
        $val['m_orderid'] = $log->transaction;
        $val['m_amount'] = $m_amount;
        $val['m_curr'] =  $log->method->currency;
        $val['m_desc'] = base64_encode("Pay To $siteName");
        $val['m_sign'] = strtoupper(hash('sha256', implode(":", $arHash)));
        $val['lang'] = 'en';

        $send['val'] = $val;
        $send['view'] = 'user.payment.redirect';
        $send['method'] = 'get';
        $send['url'] = 'https://payeer.com/merchant';
        
       

        return json_encode($send);
    }


    public static function ipn(mixed $request, PaymentMethod $gateway, PaymentLog $log = null,mixed $trx = null, mixed $type = null)
    {


        $params = ($gateway->parameters);
        if (isset($request->m_operation_id) && isset($request->m_sign)) {
            $sign_hash = strtoupper(hash('sha256', implode(":", array(
                $request->m_operation_id,
                $request->m_operation_ps,
                $request->m_operation_date,
                $request->m_operation_pay_date,
                $request->m_shop,
                $request->m_orderid,
                $request->m_amount,
                $request->m_curr,
                $request->m_desc,
                $request->m_status,
                $params->secret_key
            ))));

            if ($request->m_sign != $sign_hash) {
                $data['status'] = 'error';
                $data['msg'] = translate('digital signature not matched');
                $data['redirect'] = route('failed');
            } else {
                $log = PaymentLog::with(['user','method'])->where('transaction', $request->m_orderid)->latest()->first();
                if ($request->m_amount == round($log->final_amount,2) && $request->m_curr == $log->method->currency && $request->m_status == 'success' && $log->status == StatusEnum::false->status()) {
                    PaymentService::make_payment($log);
                    $data['status'] = 'success';
                    $data['msg'] = trans('default.trx_success');      

                    $data['redirect'] = route('success');

                    return $data;
                } else {
                    $data['status'] = 'error';
                    $data['msg'] = trans('default.trx_failed');
                    $data['redirect'] = route('failed');
                    return $data;
                }
            }
        } else {
            $data['status'] = 'error';
            $data['msg'] = translate('transaction was unsuccessful');
            $data['redirect'] = route('failed');
        }
        return $data;
    }
}
