<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Admin\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $keys = Page::pluck('slug')->toArray();
        $pages =  [
            "terms-and-conditions",
            "cookies-policy",
            "privacy-policy",
        ];

        foreach($pages as $index => $key){
            if(!in_array($key ,$keys )){

                Page::create([
                    "serial_id"      => $index,
                    "title"          => k2t($key),
                    "slug"           => $key,
                    'description'    => 'description',
                    'show_in_footer' => StatusEnum::true->status(),

                ]);
              
            }
        }
        
    }
}
