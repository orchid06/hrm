<?php

use App\Enums\StatusEnum;

return [

    'app_name'    => "FeedsWiz",
    'software_id' => "@@",

    'cacheFile'   => 'RmVlZHNfV2l6',

    'core' => [
        'appVersion' => '1.1',
        'minPhpVersion' => '8.1'
    ],

    'requirements' => [

        'php' => [
            'Core',
            'bcmath',
            'openssl',
            'pdo_mysql',
            'mbstring',
            'tokenizer',
            'json',
            'curl',
            'gd',
            'zip',
            'mbstring',
        

        ],
        'apache' => [
            'mod_rewrite',
        ],

    ],
    'permissions' => [
        '.env'     => '666',
        'storage'     => '775',
        'bootstrap/cache/'       => '775', 
    ],
    
];