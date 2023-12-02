<?php

namespace App\Http\Services\Gateway\paystack;

use App\Http\Services\CurlService;
use App\Http\Services\PaymentService;
use App\Models\Admin\PaymentMethod;
use App\Models\PaymentLog;
use Illuminate\Support\Arr;

class Payment
{
    public static function paymentData(PaymentLog $log)
    {
        $gateway = ($log->method->parameters);
        $send['key'] = $gateway->public_key ?? '';
        $send['email'] = optional($log->user)->email;
        $send['amount'] = $log->final_amount * 100;
        $send['currency'] = $log->method->currency;
        $send['ref'] = $log->transaction;
        $send['view'] = 'user.payment.paystack';
        return json_encode($send);
    }

    public static function ipn(mixed $request, PaymentMethod $gateway, PaymentLog $log = null,mixed $trx = null, mixed $type = null)
    {

        $params = ($gateway->parameters);
        $secret_key = $params->secret_key ?? '';
        $url = 'https://api.paystack.co/transaction/verify/' . $trx;
        $headers = [
            "Authorization: Bearer {$secret_key}"
        ];
        $response = CurlService::curlGetRequestWithHeaders($url, $headers);
        $response = json_decode($response, true);
        if ($response) {
            if ($response['data']) {
                if ($response['data']['status'] == 'success') {
                    $log = PaymentLog::with(['method'])->where('transaction', $trx)->latest()->first();
                    $payable = round(($log->final_amount * 100), 2);

                    if (round($response['data']['amount'], 2) == $payable && $response['data']['currency'] == $log->method->currency) {
                        PaymentService::make_payment($log);
                        $data['status'] = 'success';
                        $data['msg'] =trans('default.trx_success');        
                        $data['redirect'] = route('success');
                    } else {
                        $data['status'] = 'error';
                        $data['msg'] = 'invalid amount.';
                        $data['redirect'] = route('failed');
                    }
                } else {
                    $data['status'] = 'error';
                    $data['msg'] = $response['data']['gateway_response'];
                    $data['redirect'] = route('failed');
                }
            } else {
                $data['status'] = 'error';
                $data['msg'] = $response['message'];
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
