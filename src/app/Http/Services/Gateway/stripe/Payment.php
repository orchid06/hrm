<?php

namespace App\Http\Services\Gateway\stripe;

use App\Enums\DepositStatus;
use App\Http\Services\PaymentService;
use App\Http\Services\UserService;
use App\Models\Admin\PaymentMethod;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use StripeJS\Charge;
use StripeJS\Customer;
use StripeJS\StripeJS;


require_once('stripe-php/init.php');

class Payment
{
    public static function paymentData(PaymentLog $log) :string 
    {
        $siteName           = site_settings('site_name');
        $gateway            = ($log->method->parameters);
        $val['key']         = $gateway->publishable_key ?? '';
        $val['name']        = optional($log->user)->name ?? $siteName;
        $val['description'] = "Payment with Stripe";
        $val['amount']      = round($log->final_amount) * 100;
        $val['currency']    = $log->method->currency->code;
        $send['val']        = $val;
        $send['src']        = "https://checkout.stripe.com/checkout.js";
        $send['view']       = 'user.payment.stripe';
        $send['method']     = 'post';
        $send['url']        = route('ipn',[$log->trx_code]);
        return json_encode($send);
    }



    public static function ipn(Request $request , PaymentLog $log ) :array
    {

        $data['status']      = 'error';
        $data['message']     = translate('Invalid amount.');
        $data['redirect']    = route('user.home');
        $data['gw_response'] = $request->all();
        $status              = DepositStatus::value('FAILED',true);

        $params            = ($log->method->parameters);
        StripeJS::setApiKey($params->secret_key);

        $customer = Customer::create([
            'email'  => $request->stripeEmail,
            'source' => $request->stripeToken,
        ]);

        $charge = Charge::create([
            'customer'     => $customer->id,
            'description'  => 'Deposit with Stripe',
            'amount'       => round($log->final_amount) * 100,
            'currency'     => $log->method->currency->code
        ]);

        if ($charge['status'] == 'succeeded') {

            $data['status']   = 'success';
            $data['message']  = trans('default.deposit_success');
            $status           = DepositStatus::value('PAID',true);
        }

        UserService::updateDepositLog($log,$status,$data);

        return $data;
    }
}
