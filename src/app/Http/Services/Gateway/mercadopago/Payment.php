<?php

namespace App\Http\Services\Gateway\mercadopago;


use App\Http\Services\CurlService;
use App\Http\Services\PaymentService;
use App\Models\Admin\PaymentMethod;
use App\Models\PaymentLog;
use Illuminate\Support\Arr;

class Payment
{
    const SANDBOX = true;

    public static function paymentData(PaymentLog $log)
    {
        $siteName = site_settings('site_name');
        $gateway = ($log->method->parameters);
        $url = "https://api.mercadopago.com/checkout/preferences?access_token=" . $gateway->access_token;
        $headers = [
            "Content-Type: application/json",
        ];
        $postParam = [
            'items' => [
                [
                    'id' => $log->transaction,
                    'title' => round_amount($log->amount) . ' '. site_settings('currency_symbol') ?? 'order ' . $log->id,
                    'description' => "Payment To $siteName Account",
                    'quantity' => 1,
                    'currency_id' => $log->method->currency,
                    'unit_price' => round($log->final_amount, 2)
                ]
            ],
            'payer' => [
                'email' => optional($log->user)->email ?? '',
            ],
            'back_urls' => [
                'success' => route('success'),
                'pending' => '',
                'failure' => route('failed'),
            ],
            'notification_url' => route('ipn', [$log->method->code, $log->transaction]),
            'auto_return' => 'approved',
        ];
        $response = CurlService::curlPostRequestWithHeaders($url, $headers, $postParam);
        $response = json_decode($response);

        $send['preference'] = @$preference->id ?? '';
        $send['view'] = 'user.payment.mercado';
        if(isset($response->auto_return) && $response->auto_return == 'approved') {
            if (self::SANDBOX) {
                $send['redirect'] = true;
                $send['redirect_url'] = $response->sandbox_init_point;
            } else {
                $send['redirect'] = true;
                $send['redirect_url'] = $response->init_point;
            }
        }else{
            $send['error'] = true;
            $send['message'] = 'Invalid Request';
        }
        return json_encode($send);
    }

    public static function ipn(mixed $request, PaymentMethod $gateway, PaymentLog $log = null,mixed $trx = null, mixed $type = null)
    {

        $gateway = ($log->method->parameter);
        $url = "https://api.mercadopago.com/v1/payments/" . $request['data']['id'] . "?access_token=" . $gateway->access_token;
        $response = CurlService::curlGetRequest($url);
        $paymentData = json_decode($response);

        if (isset($paymentData->status) && $paymentData->status == 'approved') {
            PaymentService::make_payment($log);

            $data['status'] = 'success';
            $data['msg'] = trans('default.trx_success');  
            $data['redirect'] = route('success');
        } else {
            $data['status'] = 'error';
            $data['msg'] = translate('unexpected error!');
            $data['redirect'] = route('failed');
        }

        return $data;
    }
}
