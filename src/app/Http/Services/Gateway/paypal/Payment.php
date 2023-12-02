<?php
namespace App\Http\Services\Gateway\paypal;

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

        $param['cleint_id'] = $gateway->cleint_id ?? '';
        $param['description'] = "Payment To {$siteName} Account";
        $param['custom_id'] = $log->transaction;
        $param['amount'] = round($log->final_amount);
        $param['currency'] = $log->method->currency;
        $param['view'] = 'user.payment.paypal';
        return json_encode($param);
    }

    public static function ipn(mixed $request, PaymentMethod $gateway, PaymentLog $log = null,mixed $trx = null, mixed $type = null)
    {
        $url = "https://api.paypal.com/v2/checkout/orders/{$type}";
        $params = ($gateway->parameters);
        $client_id = $params->cleint_id ?? '';
        $secret = $params->secret ?? '';
        $headers = [
            'Content-Type:application/json',
            'Authorization:Basic ' . base64_encode("{$client_id}:{$secret}")
        ];
        $response = CurlService::curlGetRequestWithHeaders($url, $headers);
        $paymentData = json_decode($response, true);
        if (isset($paymentData['status']) && $paymentData['status'] == 'COMPLETED') {
            if ($paymentData['purchase_units'][0]['amount']['currency_code'] == $gateway->currency && $paymentData['purchase_units'][0]['amount']['value'] == round($log->final_amount, 2)) {
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
            $data['msg'] = trans('default.trx_failed');

            $data['redirect'] = route('failed');
        }
        return $data;
    }
}
