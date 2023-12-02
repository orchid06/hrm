<?php

namespace App\Http\Services\Gateway\instamojo;


use App\Http\Services\CurlService;
use App\Http\Services\PaymentService;
use App\Models\Admin\PaymentMethod;
use App\Models\PaymentLog;

class Payment
{
    public static function paymentData(PaymentLog $log)
    {
        $siteName = site_settings('site_name');
        $gateway = ($log->method->parameters);
        $api_key = ($gateway->api_key ?? '');
        $auth_token = ($gateway->auth_token ?? '');
        $url = 'https://instamojo.com/api/1.1/payment-requests/';
        $headers = [
            "X-Api-Key:$api_key",
            "X-Auth-Token:$auth_token"
        ];
  
        $postParam = [
            'purpose' => 'Payment to ' . $siteName  ?? 'Photoica',
            'amount' => $log->amount,
            'buyer_name' => optional($log->user)->name ?? 'User Name',
            'redirect_url' => route('success'),
            'webhook' => route('ipn', [$log->method->code, $log->transaction]),
            'email' => optional($log->user)->email ?? 'example@example.com',
            'send_email' => true,
            'allow_repeated_payments' => false
        ];

        $response = CurlService::curlPostRequestWithHeaders($url, $headers, $postParam);
        $response = json_decode($response);

        if ($response->success) {
            $send['redirect'] = true;
            $send['redirect_url'] = $response->payment_request[0]->longurl;
        } else {
            $send['error'] = true;
            $send['message'] = "Invalid Request";
        }
        return json_encode($send);
    }

    public static function ipn(mixed $request, PaymentMethod $gateway, PaymentLog $log = null,mixed $trx = null, mixed $type = null)
    {
        $params = ($gateway->parameters);
        $salt = trim($params->salt);
        $imData = $request;
        $macSent = $imData['mac'];
        unset($imData['mac']);
        ksort($imData, SORT_STRING | SORT_FLAG_CASE);
        $mac = hash_hmac("sha1", implode("|", $imData), $salt);

        if ($macSent == $mac && $imData['status'] == "Credit" && $log->status == '0') {
            PaymentService::make_payment($log);
        }
    }
}
