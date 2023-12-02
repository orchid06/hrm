<?php

namespace App\Http\Services\Gateway\stripe;

use App\Http\Services\PaymentService;
use App\Models\Admin\PaymentMethod;
use App\Models\PaymentLog;
use Illuminate\Support\Arr;
use StripeJS\Charge;
use StripeJS\Customer;
use StripeJS\StripeJS;


require_once('stripe-php/init.php');

class Payment
{
    public static function paymentData(PaymentLog $log)
    {
        $siteName = site_settings('site_name');
        $gateway = ($log->method->parameters);
        $val['key'] = $gateway->publishable_key ?? '';
        $val['name'] = optional($log->user)->name ?? $siteName;
        $val['description'] = "Payment with Stripe";
        $val['amount'] = ($log->final_amount * 100);
        $val['currency'] =  $log->method->currency;
        $send['val'] = $val;
        $send['src'] = "https://checkout.stripe.com/checkout.js";
        $send['view'] = 'user.payment.stripe';
        $send['method'] = 'post';
        $send['url'] = route('ipn',["code" => $log->method->code, "trx" => $log->transaction]);
        return json_encode($send);
    }



    public static function ipn(mixed $request, PaymentMethod $gateway, PaymentLog $log = null,mixed $trx = null, mixed $type = null)
    {
        $params = ($gateway->parameters);
        StripeJS::setApiKey($params->secret_key);

        $customer = Customer::create([
            'email' => $request->stripeEmail,
            'source' => $request->stripeToken,
        ]);

        $charge = Charge::create([
            'customer' => $customer->id,
            'description' => 'Payment with Stripe',
            'amount' => round($log->final_amount) * 100,
            'currency' => $gateway->currency,
        ]);

        if ($charge['status'] == 'succeeded') {
            PaymentService::make_payment($log);
            $data['status'] = 'success';
            $data['msg'] = trans('default.trx_success');
            $data['redirect'] = route('success');
        }else{
            $data['status'] = 'error';
            $data['msg'] = trans('default.trx_failed');
            $data['redirect'] = route('failed');
        }
        return $data;
    }
}
