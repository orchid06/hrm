<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
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



        
        $existsPlatform = MediaPlatform::pluck('slug')->toArray();
        $platforms      = Arr::get(config('settings'),'platforms' ,[]);

        try {
            foreach($platforms as $name => $config){

                if(! in_array($name,$existsPlatform)){
                    MediaPlatform::create([
                        "name"            => ucfirst($name),
                        "slug"            => make_slug($name),
                        "url"             => '@@',
                        "description"     => 'Seamlessly execute social media management and social customer care on '.$name.' from a single, scalable platform',
                        "configuration"   => Arr::get($config,'credential',[]),
                        "is_integrated"   => Arr::get($config,'is_integrated',StatusEnum::false->status()),
                        "is_feature"      => Arr::get($config,'is_feature',StatusEnum::false->status()),
                    ]);
                }
            }
        } catch (\Throwable $th) {
          
        }

      
      
    }
}
