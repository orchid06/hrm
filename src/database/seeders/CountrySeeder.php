<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('countries')->truncate();
        $countries = json_decode(file_get_contents(resource_path('views/partials/country_file.json')),true)['countries'];
        Country::insert($countries);
    }
}
