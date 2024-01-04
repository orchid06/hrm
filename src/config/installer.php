<?php

use App\Enums\StatusEnum;

return [

    'app_name'    => "demo",
    'software_id' => "xxx",


    'core' => [
        'appVersion' => '1.1',
        'minPhpVersion' => '8.1'
    ],

    'requirements' => [

        'php' => [
            'openssl',
            'pdo',
            'mbstring',
            'tokenizer',
            'JSON',
            'cURL',
            'gd',
            'ftp',
        ],
        'apache' => [
            'mod_rewrite',
        ],

    ],
    'permissions' => [
        '.env'     => '666',
        'storage/framework/'     => '775',
        'storage/logs/'          => '775',
        'bootstrap/cache/'       => '775', 
    ],

];