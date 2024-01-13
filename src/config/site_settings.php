<?php

use App\Enums\StatusEnum;
use Carbon\Carbon;
use Predis\Response\Status;

return [

    "site_name"      => "quick_pack",
    "logo_icon"      => "@@",
    "site_logo"      => "@@",
    "user_site_logo" => "@@",
    "favicon"        => "@@",
    "phone"          => "0xxxxxxxx",
    "address"        => "",

    "email"               => "quickpack@gmail.com",
    "last_corn_run"       => Carbon::now(),
    "user_authentication" => json_encode([
        'registration'   => StatusEnum::true->status(),
        'login'          => StatusEnum::true->status(),
        'login_with'     => [
            'user_name',
            'email',
            'phone',
        ]
    ]),

    "login_with" => json_encode([
        'user_name',
        'email',
        'phone',
    ]),


    "default_sms_template"  => "hi {{name}}, {{message}}",
    "default_mail_template" => "hi {{name}}, {{message}}",
    "two_factor_auth"       => StatusEnum::false->status(),

    "two_factor_auth_with" => json_encode([
        'google' => StatusEnum::true->status(),
        'sms'    => StatusEnum::false->status(),
        'mail'   => StatusEnum::false->status(),
    ]),


    "sms_otp_verification"          => StatusEnum::false->status(),
    "registration_otp_verification" => StatusEnum::false->status(),
    "otp_expired_status"            => StatusEnum::false->status(),
    "sms_notifications"             => StatusEnum::false->status(),
    "email_verification"            => StatusEnum::false->status(),
    "email_notifications"           => StatusEnum::false->status(),
    "slack_notifications"           => StatusEnum::false->status(),
    "browser_notifications"         => StatusEnum::false->status(),
    "currency_alignment"            => 0,
    "num_of_decimal"                => "2",
    "decimal_separator"             => ".",
    "thousands_separator"           => ",",
    "price_format"                  => StatusEnum::false->status(),
    "truncate_after"                => 1000,
    "slack_channel"                 => "@@",
    "slack_web_hook_url"            => "@@",
    "time_zone"                     => null,
    "site_seo"                      => StatusEnum::false->status(),
    "app_debug"                     => StatusEnum::false->status(),
    "maintenance_mode"              => StatusEnum::false->status(),
    "demo_mode"                     => StatusEnum::false->status(),      
    "pagination_number"             => '10',
    "copy_right_text"               => '2023',
    "same_site_name"                => StatusEnum::false->status(),
    "country"                       => 'United States',

    "user_site_name"   => "Demo Name",
    "google_recaptcha" => json_encode([
        'key'        => '6Lc5PpImAAAAABM-m4EgWw8vGEb7Tqq5bMOSI1Ot',
        'secret_key' => '6Lc5PpImAAAAACdUh5Hth8NXRluA04C-kt4Xdbw7',
        'status'     => StatusEnum::false->status()
    ]),

    "strong_password" => StatusEnum::true->status(),

    "captcha" => StatusEnum::false->status(),
    "vistors" => '500',

    "sign_up_bonus" => StatusEnum::false->status(),

    "default_recaptcha"         => StatusEnum::false->status(),
    "captcha_with_login"        => StatusEnum::true->status(),
    "captcha_with_registration" => StatusEnum::true->status(),
    "social_login"              => StatusEnum::false->status(),
    "social_login_with"         => json_encode([
        'google_oauth' => [
            'client_id'     => '@@',
            'client_secret' => '@@',
            'status'        => StatusEnum::true->status(),
        ],
        'facebook_oauth' => [
            'client_id'     => '@@',
            'client_secret' => '@@',
            'status'        => StatusEnum::true->status(),
        ],
    ]),

    'google_map' => json_encode([
        'key' => '#',
    ]),

    'storage'    => "local",
    'mime_types' => json_encode([
        'png',
        'jpg',
        'jpeg',
        'jpe',
    ]),

    'max_file_size'   => 20000,
    "max_file_upload" => 4,
    'aws_s3' => json_encode( [
        's3_key' => '@@',
        's3_secret' => '@@',
        's3_region' => '@@',
        's3_bucket' => '@@',

    ]),

    'ftp' => json_encode( [
        'host'      => '@@',
        'port'      => '@@',
        'user_name' => '@@',
        'password'  => '@@',
        'root'      => '/',
    ]),

    'pusher_settings' => json_encode( [
        'app_id'      => '@@',
        'app_key'     => '@@',
        'app_secret'  => '@@',
        'app_cluster' => '@@',
        'chanel'      => '@@',
        'event'       => '@@',
    ]),

    'database_notifications'    => StatusEnum::false->status(),
    'cookie'                    => StatusEnum::false->status(),
    'cookie_text'               => "demo cookie_text",
    'google_map_key'            => "@@",
    'geo_location'              => "map_base",
    'sentry_dns'                => "@@",
    'login_attempt_validation'  =>  StatusEnum::false->status(),
    "max_login_attemtps"        => 5,

    "otp_expired_in"       => 2,
    'api_route_rate_limit' => 1000,
    'web_route_rate_limit' => 1000,

    'primary_color'   => "#8158fc",
    'secondary_color' => "#00b3ba",
    'text_primary'    => '#26152E',
    'text_secondary'  => '#676767',
    'btn_text_primary'    => '#ffffff',
    'btn_text_secondary'  => '#24282c',
    

    /** newly added content */
    'site_description'       => 'demo description',

    "telegram_notifications" => StatusEnum::false->status(),
    "sms_notification"       => StatusEnum::false->status(),

    "max_pending_withdraw"   => "1",
    "force_ssl"              => StatusEnum::false->status(),
    "dos_prevent"            => StatusEnum::false->status(),
    "dos_attempts"           => StatusEnum::false->status(),
    "dos_attempts_in_second" => "5",
    "dos_security"           => "captcha",

    "google_ads"                   => StatusEnum::false->status(),
    'google_adsense_publisher_id'  => "@@",
    "google_analytics"             => StatusEnum::false->status(),
    'google_analytics_tracking_id' => "@@",
    
    'breadcrumbs'                  => StatusEnum::true->status(),

    'expired_data_delete'       => StatusEnum::false->status(),
    'expired_data_delete_after' => 10,

    "site_meta_keywords" => json_encode(['demo']),
    "title_separator"    => ":",

    'live_chat' => StatusEnum::true->status(),

    "ai_default_creativity" => 0.5,
    "ai_default_tone"       => "Casual",
    "ai_max_result"         => 4,
    "default_max_result"    => 20,
    "ai_result_length"      => 20,
    "ai_bad_words"          => null,
    "open_ai_model"         => null,
    "open_ai_secret"        => "@@",
    "ai_key_usage"          => StatusEnum::false->status(),
    "rand_api_key"          => "@@",

    "subscription_carry_forword" => StatusEnum::false->status(),
    "auto_subscription"          => StatusEnum::false->status(),
    "auto_subscription_package"  => null,

    "signup_bonus"          => null,
    "webhook_api_key"       => "@@",
    "kyc_settings"          => json_encode(
    [
        [
            'labels' => 'Name',
            'name' => 'name',
            'placeholder' => 'Name',
            'type' => 'text',
            'required' => StatusEnum::true->status(),
            'default' => StatusEnum::true->status(),
            'multiple' => StatusEnum::false->status()
        ]
    ]),
    "kyc_verification"      => StatusEnum::false->status(),
    "ticket_settings" => json_encode(
    [
        [
            'labels' => 'Name',
            'name' => 'name',
            'placeholder' => 'Name',
            'type' => 'text',
            'required' => StatusEnum::true->status(),
            'default' => StatusEnum::true->status(),
            'multiple' => StatusEnum::false->status()
        ],
        [
            'labels' => 'Subject',
            'name' => 'subject',
            'placeholder' => 'Subject',
            'type' => 'text',
            'required' => StatusEnum::true->status(),
            'default' => StatusEnum::true->status(),
            'multiple' => StatusEnum::false->status()
        ],
        [
            'labels' => 'Description',
            'name' => 'description',
            'placeholder' => 'Description',
            'type' => 'textarea',
            'required' => StatusEnum::true->status(),
            'default' => StatusEnum::true->status(),
            'multiple' => StatusEnum::false->status()
        ],
    ]),
    "site_earning"          => StatusEnum::false->status(),
    "continuous_commission" => StatusEnum::false->status(),
    "affiliate_system"      => StatusEnum::false->status(),

    "multi_lang"            => StatusEnum::false->status(),
    "multi_currency"        => StatusEnum::false->status(),
    "meta_image"            => null,


];
