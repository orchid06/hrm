<?php

namespace Database\Seeders;

use App\Models\MediaPlatform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $existsPlatform = MediaPlatform::pluck('name')->toArray();
        $platforms      = Arr::get(config('settings'),'platforms' ,[]);

        try {
            foreach($platforms as $name){
                if(! in_array($name,$existsPlatform)){
                    MediaPlatform::create([
                        "name"   => $name,
                        "slug"   => make_slug($name),
                    ]);
                }
            }
        } catch (\Throwable $th) {
          
        }

      
      
    }
}
