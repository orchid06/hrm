<?php

use App\Enums\LoginKeyEnum;
use App\Enums\StatusEnum;

return [

    "default_template_code"=>[
        'name'         => "Name",
        'message'      => "Message",
        'email'        => "Email",
        'phone'        => "Phone Number",
        'company_name' => "Company name",
        'logo'         => "Site logo"
    ],


    'file_types'=> ['3dmf',    '3dm',    'avi',    'ai',    'bin',    'bin',    'bmp',    'cab',    'c',    'c++',    'class',    'css',    'csv',    'cdr',    'doc',    'dot',    'docx',    'dwg',    'eps',    'exe',    'gif',    'gz',    'gtar',    'flv',    'fh4',    'fh5',    'fhc',    'help',    'hlp',    'html',    'htm',    'ico',    'imap',    'inf',    'jpe',    'jpeg',    'jpg',    'js',    'java',    'latex',    'log',    'm3u',    'midi',    'mid',    'mov',    'mp3',    'mpeg',    'mpg',    'mp2',    'ogg',    'phtml',    'php',    'pdf',    'pgp',    'png',    'pps',    'ppt',    'ppz',    'pot',    'ps',    'qt',    'qd3d',    'qd3',    'qxd',    'rar',    'ra',    'ram',    'rm',    'rtf',    'spr',    'sprite',    'stream',    'swf',    'svg',    'sgml',    'sgm',    'tar',    'tiff',    'tif',    'tgz',    'tex',    'txt',    'vob',    'wav',    'wrl',    'wrl',    'xla',    'xls',    'xls',    'xlc',    'xml',    'xlsx',    'zip','mp4'],

    "role_permissions" =>[

        "language" => [
            "view_language",
            "translate_language",
            "create_language",
            "update_language",
            "delete_language",
        ],

        "staff" => [
            "view_staff",
            "create_staff",
            "update_staff",
            "delete_staff",
        ],

        "currency" => [
            'view_currency',
            'create_currency',
            'update_currency',
            'delete_currency',
        ],

        "ticket" => [
            "view_ticket",
            "delete_ticket",
        ],

        "user" => [
            "view_user",
            "create_user",
            "update_user",
            "delete_user",
        ],


        "role" => [
            "view_role",
            "create_role",
            "update_role",
            "delete_role",
        ],

        "department" => [
            "view_department",
            "create_department",
            "update_department",
            "delete_department"
        ],

        "designation" => [
            "view_designation",
            "create_designation",
            "update_designation",
            "delete_designation"
        ],

        "salary" => [
            "view_salary",
            "create_salary",
            "update_salary",
            "delete_salary"
        ],

        "payroll" => [
            "view_payroll",
            "create_payroll",
            "update_payroll",
            "delete_payroll"
        ],

        "account" => [
            "view_account",
            "create_account",
            "update_account",
            "delete_account"
        ],

        "expense" => [
            "create_cashIn",
            "view_expense",
            "create_expense",
            "update_expense",
            "delete_expense"
        ],

        "expense_category" => [
            "view_expense_category",
            "create_expense_category",
            "update_expense_category",
            "delete_expense_category"
        ],

        "payslip" => [
            "view_payslip",
            "print_payslip",
            "download_payslip",
            "send_payslip",
            "delete_payslip"
        ],

        "payment" => [
            "make_payslip",
        ],

        "office_hour" => [
            "view_office_hour",
            "create_office_hour",
        ],

        "attendance" => [
            "view_attendance",
            "create_attendance",
            "update_attendance",
            "delete_attendance"
        ],

        "holiday" => [
            "view_holiday",
            "create_holiday",
            "update_holiday",
            "delete_holiday"
        ],

        "leave" => [
            "view_leave",
            "create_leave",
            "update_leave",
            "delete_leave"
        ],

        "menu" => [
            "view_menu",
            "create_menu",
            "update_menu",
            "delete_menu"
        ],

        "security_settings" => [
            "view_security",
            "update_security",
        ],

        "transaction" => [
            "view_report",
            "update_report",
            "delete_report"
        ],

        "platform" => [
            "view_platform",
            "update_platform",
        ],


        "gateway" => [
            "view_gateway",
            "update_gateway",
        ],

        "notification_template" => [
            "view_template",
            "update_template"
        ],


        "notification" => [
            "view_notification",
        ],

        "settings" => [
            "view_settings",
            "update_settings"
        ],

        "dashboard" => [
            "view_dashboard"
        ]

    ],

    "file_path" =>  [
        'profile' => [
            'admin' => [
                'path' => 'assets/images/backend/profile',
                'size' => '150x150',
            ],
            'user' => [
                'path' => 'assets/images/frontend/profile',
                'size' => '150x150',
            ],
        ],

        'site_logo' => [
            'path' => 'assets/images/backend/site_logo',
            'size' => '150x50',
        ],

        'meta_image' => [
            'path' => 'assets/images/backend/site_logo',
            'size' => '150x50',
        ],

        'withdraw_method' => [
            'path' => 'assets/images/backend/withdraw_method',
            'size' => '100x100',
        ],


        'payment_method' => [
            'path' => 'assets/images/backend/payment_method',
            'size' => '100x100',
        ],

        'user_site_logo' => [
            'path' => 'assets/images/frontend/site_logo',
            'size' => '150x50',
        ],

        'favicon' => [
            'path' => 'assets/images/global/favicon',
            'size' => '25x25',
        ],

        'loader_icon' => [
            'path' => 'assets/images/global/loader',
            'size' => '100x100',
        ],


        'category' => [
            'path' => 'assets/images/global/category',
            'size' => '80x80',
        ],

        'platform' => [
            'path' => 'assets/images/global/platform',
            'size' => '50x50',
        ],


        'frontend' => [
            'path' => 'assets/images/global/frontend',
        ],

        'blog' => [
            'path' => 'assets/images/global/blog',
            'size' => '1380x800',
        ],


        'payment' => [
            'path' => 'assets/images/global/payment',
        ],
        'withdraw' => [
            'path' => 'assets/images/global/withdraw',
        ],
        'post' => [
            'path' => 'assets/images/global/post',
        ],

        'ticket' => [
            'path' => 'assets/files/global/ticket',
        ],
        'kyc' => [
            'path' => 'assets/files/global/kyc',
        ],
        'leave_request'=> [
            'path' => 'assets/files/global/leave_request'
        ],
        'leave_request_data'=> [
            'path' => 'assets/files/global/leave_request/custom_data'
        ],
        'expense_data'=> [
            'path' => 'assets/files/global/expense'
        ],

        'account'=> [
            'path' => 'assets/files/global/account'
        ],

    ],


    "json_object" => [
        "aws_s3",
        "ftp",
        "pusher_settings",
        "social_login",
        "google_recaptcha",
        "login_with",
        'site_meta_keywords',
        'rand_api_key',
        'holidays',
        'attendance_settings',
        'office_hour',
        'allowance',
        'cashIn',
    ],


    "login_attribute" => [
        LoginKeyEnum::EMAIL->value,
        LoginKeyEnum::PHONE->value,
        LoginKeyEnum::USERNAME->value
    ],

    "logo_keys" => [
        "site_logo",
        "user_site_logo",
        "favicon",
        "loader_icon",
        "meta_image"
    ],

    "currency_alignment" => [
        "[symbol][amount]"  => 0,
        "[amount][symbol]"  => 1,
        "[symbol] [amount]" => 2,
        "[amount] [symbol]" => 3
    ],

    "price_format" => [
        "show_full_price" => 0,
        "truncate_price"  => 1
    ],

    "date_format" => [
        "d M, Y",
        "m.d.y",
        "Y-m-d",
        "d-m-Y",
        "d/m/Y",
        "Y/m/d"
    ],

    "time_format" => [
        "h:i A",
        "h:i:s A",
        "H:i",
        "H:i:s"
    ],

    "default_creativity" => [
        "High" => 1,
        "Medium" => 0.5,
        "Low" => 0
    ],

    "ai_default_tone" => [
        "Friendly",
        "Luxury" ,
        "Relaxed",
        "Professional",
        "Casual",
        "Excited",
        "Bold",
        "Masculine",
        "Dramatic"
    ],


    "open_ai_model" => [
        "gpt-4-0613"                => 'ChatGPT 4 Gpt-4-32k',
        "gpt-3.5-turbo-16k"         => 'ChatGPT 3.5 Turbo-16k',
        "gpt-3.5-turbo-1106"        => 'GPT 3.5 Turbo (Modified)',
        "gpt-4"                     => 'ChatGPT 4 (Beta)',
        "gpt-3.5-turbo"             => 'ChatGPT 3.5',
        "gpt-4-1106-preview"        => 'GPT-4 Turbo',
        "gpt-4-vision-preview"      => 'GPT-4 Turbo (vision)',
    ],


    #PLATFORM CONFIGURATION

    "platforms" => [

        'facebook' => [
            'name'        => 'Facebook',
            'credential'  => [
                'client_id'       => '@@',
                'client_secret'   => '@@',
                'app_version'     => '@@',
                'graph_api_url'   => '@@',
                'group_url'       => 'https://www.facebook.com/groups',
            ],
            'is_integrated' => StatusEnum::true->status(),
            'is_feature'    => StatusEnum::true->status(),
            'view_option'   => StatusEnum::true->status()
        ],
        'instagram' => [
            'name'        => 'Instagram',
            'credential'  => [
                'client_id'       => '@@',
                'client_secret'   => '@@',
                'app_version'     => '@@',
                'graph_api_url'   => '@@'
            ],

            'is_integrated' => StatusEnum::true->status(),
            'view_option'   => StatusEnum::true->status(),
            'is_feature'    => StatusEnum::true->status()

        ],

        "twitter" => [
            'name'        => 'Twitter',
            'credential'  => [
                'client_id'        => '@@',
                'client_secret'    => '@@',
                'app_version'      => '@@'
            ],
            'is_integrated' => StatusEnum::true->status(),
            'unofficial'    => StatusEnum::false->status(),
            'is_feature'    => StatusEnum::true->status()
        ],

        'linkedin' => [
            'name'        => 'Linkedin',
            'credential'  => [
                'client_id'        => '@@',
                'client_secret'    => '@@'
            ],
            'is_integrated' => StatusEnum::true->status(),
            'unofficial'    => StatusEnum::false->status(),
            'is_feature'    => StatusEnum::true->status()
        ],

        'tiktok' => [
            'name'       => "tikTok",
            'credential' => [
                'client_id'        => '@@',
                'client_secret'    => '@@'
            ],
            'is_integrated' => StatusEnum::false->status()
        ]

    ],

    "platforms_connetion_field" => [

        "facebook" => [
            "access_token"
        ],
        "instagram" => [
            "username",
            "password"
        ],
        "twitter" => [
            'consumer_key',
            'consumer_secret',
            'access_token',
            'token_secret' ,
            'bearer_token'
        ],
    ]

];
