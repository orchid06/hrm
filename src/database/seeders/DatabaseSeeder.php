<?php

namespace Database\Seeders;

use App\Models\Admin\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Core\Setting;
use Database\Seeders\Admin\AdminSeeder;
use Database\Seeders\Admin\MailSeeder;
use Database\Seeders\Admin\PaymentMethodSeeder;
use Database\Seeders\Admin\RoleSeeder;

use Database\Seeders\Admin\SmsSeeder;
use Database\Seeders\Admin\TemplateSeeder;
use Database\Seeders\Core\LangSeeder;
use Database\Seeders\Core\SettingsSeeder;
use Database\Seeders\FrontendSeeder as SeedersFrontendSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            
            CurrencySeeder::class,
            SettingsSeeder::class,
            LangSeeder::class,
            RoleSeeder::class,
            PaymentMethodSeeder::class,
            TemplateSeeder::class,
            SmsSeeder::class,
            MailSeeder::class,

            /** new  tested seeder */
            CountrySeeder::class,
            PackageSeeder::class,
            SeedersFrontendSeeder::class,
            MenuSeeder::class,
            PageSeeder::class,
            TemplateSeeder::class,
            PlatformSeeder::class,


        ]);
    }
}
