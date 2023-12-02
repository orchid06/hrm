<?php

namespace App\Http\Services\Gateway\mollie;

use Facades\App\Services\BasicService;
use Mollie\Laravel\Facades\Mollie;
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
        config(['mollie.key' => trim($gateway->api_key)]);

        $currency = $log->method->currency;

        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => "$currency",
                'value' => '' . sprintf('%0.2f', round($log->final_amount, 2)) . '',
            ],
            'description' => "Payment To   $siteName Account",
            'redirectUrl' => route('ipn', [$log->method->code, $log->transaction]),
            'metadata' => [
                "order_id" => $log->transaction,
            ],
        ]);
        $payment = Mollie::api()->payments()->get($payment->id);

        session()->put('payment_id',$payment->id);
        session()->put('deposit_id',$log->id);

        $send['redirect'] = true;
        $send['redirect_url'] = $payment->getCheckoutUrl();
        return json_encode($send);
    }

    public static function ipn(mixed $request, PaymentMethod $gateway, PaymentLog $log = null,mixed $trx = null, mixed $type = null)
    {

        $gateway = ($log->method->parameters);
        config(['mollie.key' => trim($gateway->api_key)]);
        $payment = Mollie::api()->payments()->get(session()->get('payment_id'));


        if ($payment->status == "paid") {
            PaymentService::make_payment($log);

            $data['status'] = 'success';
            $data['msg'] = trans('default.trx_success');   

            $data['redirect'] = route('success');
        } else {
            $data['status'] = 'error';
            $data['msg'] = translate('Invalid response.');
            $data['redirect'] = route('failed');
        }

        return $data;
    }
}
