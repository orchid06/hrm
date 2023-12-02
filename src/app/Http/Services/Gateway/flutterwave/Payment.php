<?php


namespace App\Http\Services\Gateway\flutterwave;

use App\Enums\StatusEnum;
use App\Models\PaymentLog;
use App\Http\Services\CurlService;
use App\Http\Services\PaymentService;
use App\Models\Admin\PaymentMethod;
use Illuminate\Support\Arr;

class Payment
{
    public static function paymentData(PaymentLog $log)
    {
        $gateway = ($log->method->parameters);
        $send['API_publicKey'] = $gateway->public_key ?? '';
        $send['customer_email'] = optional($log->user)->email;
        $send['amount'] = $log->final_amount;
        $send['customer_phone'] = optional($log->user)->phone ?? '';
        $send['currency'] = $log->method->currency;
        $send['txref'] = $log->transaction;
        $send['view'] = 'user.payment.flutterwave';
        return json_encode($send);
    }

    public static function ipn(mixed $request, PaymentMethod $gateway, PaymentLog $log = null,mixed $trx = null, mixed $type = null)
    {
        $params = ($gateway->parameters);
        if ($type == 'error') {
            $data['status'] = 'error';
            $data['msg'] = translate('transaction Failed.');
            $data['redirect'] = route('failed');
        } else {

            $url = 'https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify';
            $headers = ['Content-Type:application/json'];
            $postParam = array(
                "SECKEY" => $params->secret_key ?? '',
                "txref" => $log->transaction
            );

            $response = CurlService::curlPostRequestWithHeaders($url, $headers, $postParam);
            $response = json_decode($response);
            if ($response->data->status == "successful" && $response->data->chargecode == "00" && $log->final_amount == $response->data->amount && $gateway->currency == $response->data->currency && $log->status == StatusEnum::false->status()) {
                PaymentService::make_payment($log);

                $data['status'] = 'success';
                $data['msg'] = trans('default.trx_success');    

                $data['redirect'] = route('success');
            } else {
                $data['status'] = 'error';
                $data['msg'] = translate('unable to Process.');
                $data['redirect'] = route('failed');
            }
        }
        return $data;
    }
}
