<?php

use App\Enums\StatusEnum;

return [

       "site_name" => "quick_pack",
       "logo_icon" => "#",
       "site_logo" => "#",
       "user_site_logo" => "#",
       "site_favicon" => "#",
       "phone" => "0xxxxxxxx",
       "address" => "",

       "email" => "quickpack@gmail.com",
       "user_authentication" => json_encode([
            'registration'=> StatusEnum::true->status(),
            'login' => StatusEnum::true->status(),
            'login_with'=> [
                'user_name',
                'email',
                'phone',
            ]
        ]),

        "login_with"=> json_encode([
            'user_name',
            'email',
            'phone',
        ]),


       "default_sms_template" =>"hi {{name}}, {{message}}",
       "default_mail_template" =>"hi {{name}}, {{message}}",
       "two_factor_auth" => StatusEnum::false->status(),

       "two_factor_auth_with" => json_encode([
            'google' => StatusEnum::true->status(),
            'sms' => StatusEnum::false->status(),
            'mail' => StatusEnum::false->status(),
       ]),


       "sms_otp_verification" => StatusEnum::false->status(),
       "registration_otp_verification" => StatusEnum::false->status(),
       "sms_notifications" => StatusEnum::false->status(),
       "email_verification" => StatusEnum::false->status(),
       "email_notifications" => StatusEnum::false->status(),
       "slack_notifications" => StatusEnum::false->status(),
       "browser_notifications" => StatusEnum::false->status(),
       "slack_channel" => "#",
       "slack_web_hook_url" => "#",
        "time_zone" => null,
        "app_debug" => StatusEnum::false->status(),
        "maintenance_mode" => StatusEnum::false->status(),
        "pagination_number" => '10',
        "copy_right_text" => '2023',
        "country" => 'United States',
    
        "user_site_name" => "Demo Name",
        "google_recaptcha" => json_encode([
            'key'=>'6Lc5PpImAAAAABM-m4EgWw8vGEb7Tqq5bMOSI1Ot',
            'secret_key'=>'6Lc5PpImAAAAACdUh5Hth8NXRluA04C-kt4Xdbw7',
            'status' => StatusEnum::false->status()
        ]),

        "strong_password" => StatusEnum::false->status(),

        "captcha" => StatusEnum::false->status(),
        "vistors" => '500',

        "default_recaptcha" => StatusEnum::false->status(),
        "captcha_with_login" => StatusEnum::true->status(),
        "captcha_with_registration" => StatusEnum::true->status(),
        "social_login" => StatusEnum::false->status(),
        "social_login_with" => json_encode([
            'google_oauth'   => [
                'client_id'     => '580301070453-job03fms4l7hrlnobt7nr5lbsk9bvoq9.apps.googleusercontent.com',
                'client_secret' => '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',
                'status'        => StatusEnum::true->status(),
            ],
            'facebook_oauth' => [
                'client_id'     => '5604901016291309',
                'client_secret' => '41c62bf15c8189171196ffde1d2a6848',
                'status'        => StatusEnum::true->status(),
            ],
        ]),

        'google_map' => json_encode([
            'key'=>'#',
        ]),

        'storage' => "s3",
        'mime_types' => json_encode([
            'png'
        ]),

        'max_file_size' => 20000,
        "max_file_upload" => 4,
        'aws_s3' => json_encode( [
            's3_key' => '#',
            's3_secret' => '#',
            's3_region' => '#',
            's3_bucket' => '#',

        ]),

        'ftp' => json_encode( [
            'host' => '#',
            'port' => '#',
            'user_name' => '#',
            'password' => '#',
            'root' => '/',
        ]),

        'pusher_settings' => json_encode( [
            'app_id' => '#',
            'app_key' => '#',
            'app_secret' => '#',
            'app_cluster' => '#',
            'chanel' => '#',
            'event' => '#',
        ]),
        'wasabi' => json_encode([
            'driver' => '#',
            'key' => '#',
            'secret' => '#',
            'region' => '#',
            'bucket' => '#',
            'endpoint' => '#'
        ]),

        'database_notifications' => StatusEnum::false->status(),
        'cookie' => StatusEnum::false->status(),
        'cookie_text' => "demo cookie_text",
        'google_map_key' => "#",
        'geo_location' => "map_base",
        'sentry_dns' => "#",
        'loggin_attempt_validation'=>  StatusEnum::false->status(),
        "max_login_attemtps" => 5,

        "otp_expired_in" => 2,
        'api_route_rate_limit' => 1000,
        'web_route_rate_limit' => 1000,

        'primary_color' => "#673ab7",
        'secondary_color' => "#ba6cff",
        'text_primary' => '#26152e',
        'text_secondary' => '#777777',
        'dark_mood' => StatusEnum::false->status(),

        /** newly added content */
        'site_description' => 'demo description',

        'twiter_username' => 'username',

        "google_analytics_tracking_id" => null,
        'show_pages_in_header'=> StatusEnum::true->status(),
        'breadcrumbs'=> StatusEnum::true->status(),
        'pre_loader'=> StatusEnum::true->status(),

        'ip_base_view_count'=> StatusEnum::false->status(),
        'social_sharing'=> StatusEnum::true->status(),

        'expired_data_delete'=> StatusEnum::false->status(),
        'expired_data_delete_after'=> 10,


        'live_chat'=> StatusEnum::true->status(),

        "socket_port" => 3000,
        "socket_ip" => 3000,


];
