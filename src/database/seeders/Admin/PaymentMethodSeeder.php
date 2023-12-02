<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

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
                PaymentMethod::create([
                    "serial_id"=> $v['serial_id'],
                    "created_by"=> 1,
                    "updated_by"=> 1,
                    "name"=> $k,
                    "code"=> $v['code'],
                    "currency_id"=> $v['currency_id'],
                    "parameters"=> $v['parameters'],
                    "extra_parameters"=> $v['extra_parameters'],
                ]);
            }
        }
        
    }
}
