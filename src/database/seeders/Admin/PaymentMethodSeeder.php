<?php

namespace Database\Seeders\Admin;

use App\Enums\StatusEnum;
use App\Models\Admin\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */ 
    public function run(): void
    {
        $existingPaymentMethods = PaymentMethod::pluck('code')->toArray();
        $paymentMethods = Arr::get(config('settings'),'payment_methods' ,[]);
        foreach($paymentMethods as $k=>$v){
            if(! in_array($v['code'],$existingPaymentMethods)){
                PaymentMethod::withoutEvents(function() use($v, $k) {
                    PaymentMethod::create([
                        "uid" =>  Str::uuid(),
                        "serial_id"=> $v['serial_id'],
                        "created_by"=> 1,
                        "updated_by"=> 1,
                        "name"=> $k,
                        "code"=> $v['code'],
                        "currency_id"=> $v['currency_id'],
                        "parameters"=> $v['parameters'],
                        "extra_parameters"=> $v['extra_parameters'],
                        "type" => StatusEnum::true->status(),
                        "minimum_amount" => 100, 
                        "maximum_amount" => 120,
                        "percentage_charge" => 1,
                        "fixed_charge" => 1
                    ]);
                });
               
            }
        }
        
    }
}
