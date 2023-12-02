<?php

namespace Database\Seeders\Admin;

use App\Enums\StatusEnum;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!(Admin::where('super_admin',StatusEnum::true->status())->exists())){
             Admin::create([
                'username' => 'admin',
                'name' => 'SuperAdmin',
                'phone' => '01616243666',
                'email' => 'admin@gmail.com',
                "email_verified_at" => Carbon::now(),
                "password"=>    Hash::make('123123'),
                'status' => StatusEnum::true->status(),
                'super_admin' => StatusEnum::true->status(),
             ]);
        }
    }
}
