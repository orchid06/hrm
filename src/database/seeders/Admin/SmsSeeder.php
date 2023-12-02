<?php

namespace Database\Seeders\Admin;

use App\Enums\StatusEnum;
use App\Models\Admin\SmsGateway;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class SmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $existingGateway = SmsGateway::pluck('code')->toArray();
        $gateway = Arr::get(config('settings'),'sms_gateway' ,[]);
        foreach($gateway as $k=>$v){
            if(! in_array($k,$existingGateway)){
                SmsGateway::create([
                    "created_by"=> 1,
                    "updated_by"=> 1,
                    'name' => $v['name'],
                    'code' => $k,
                    'credential' => $v['credential'],
                    'default' =>  Arr::get($v , "default" , StatusEnum::false->status() )  

                ]);
            }
        }
    }
}
