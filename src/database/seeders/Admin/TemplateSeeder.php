<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $existingTemplates = Template::pluck('slug')->toArray();
        $templates = Arr::get(config('settings'),'notification_template' ,[]);
        foreach($templates as $k=>$v){
            if(! in_array($k,$existingTemplates)){
                Template::create([
                    "created_by"=> 1,
                    "updated_by"=> 1,
                    'name' => $v['name'],
                    'slug' => $k,
                    'subject' => $v['subject'],
                    'body' => $v['body'],
                    'sms_body' => $v['sms_body'],
                    'sort_code' => $v['sort_code'],
                ]);
            }
        }
    }
}
