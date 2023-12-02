<?php

use App\Enums\StatusEnum;

return [

    "default_template_code"=>[
        'name'         => "name",
        'message'      => "message",
        'email'        => "Email",
        'phone'        => "Phone Number",
        'company_name' => "Company name",
    ],


    'file_types'=> ['3dmf',    '3dm',    'avi',    'ai',    'bin',    'bin',    'bmp',    'cab',    'c',    'c++',    'class',    'css',    'csv',    'cdr',    'doc',    'dot',    'docx',    'dwg',    'eps',    'exe',    'gif',    'gz',    'gtar',    'flv',    'fh4',    'fh5',    'fhc',    'help',    'hlp',    'html',    'htm',    'ico',    'imap',    'inf',    'jpe',    'jpeg',    'jpg',    'js',    'java',    'latex',    'log',    'm3u',    'midi',    'mid',    'mov',    'mp3',    'mpeg',    'mpg',    'mp2',    'ogg',    'phtml',    'php',    'pdf',    'pgp',    'png',    'pps',    'ppt',    'ppz',    'pot',    'ps',    'qt',    'qd3d',    'qd3',    'qxd',    'rar',    'ra',    'ram',    'rm',    'rtf',    'spr',    'sprite',    'stream',    'swf',    'svg',    'sgml',    'sgm',    'tar',    'tiff',    'tif',    'tgz',    'tex',    'txt',    'vob',    'wav',    'wrl',    'wrl',    'xla',    'xls',    'xls',    'xlc',    'xml',    'xlsx',    'zip'],

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

        "withdraw_method" => [
            'view_withdraw',
            'create_withdraw',
            'update_withdraw',
            'delete_withdraw',
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


        "payment_method" => [
            "view_method",
            "create_method",
            "update_method",
            "delete_method"
        ],

        "category" => [
            "view_category",
            "create_category",
            "update_category",
            "delete_category"
        ],

        "page" => [
            "view_page",
            "create_page",
            "update_page",
            "delete_page"
        ],
        
        "ai_template" => [
            "view_ai_template",
            "create_ai_template",
            "update_ai_template",
            "delete_ai_template"
        ],

        "package" => [
            "view_package",
            "create_package",
            "update_package",
            "delete_package"
        ],

        "menu" => [
            "view_menu",
            "create_menu",
            "update_menu",
            "delete_menu"
        ],

        "frontend" => [
            "view_frontend",
            "update_frontend",
        ],

        "article" => [
            "view_article",
            "create_article",
            "update_article",
            "delete_article"
        ],


        "content" => [
            "view_content",
            "create_content",
            "update_content",
            "delete_content"
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

        'article' => [
            'path' => 'assets/images/global/article',
            'size' => '960x480',
        ],


        'payment' => [
            'path' => 'assets/images/global/payment',
        ],
        'withdraw' => [
            'path' => 'assets/images/global/withdraw',
        ],

        'ticket' => [
            'path' => 'assets/files/global/ticket',
        ],
        'kyc' => [
            'path' => 'assets/files/global/kyc',
        ],
    ],

    "payment_methods" => [

        "bkash" => [
            "code" => "bkash",
            "serial_id" => "1",
            "currency_id" => "1",
            "parameters" =>
                [
                     "api_key" => "#",
                     "username" => "#",
                     "password" => "#",
                     "api_secret" => "#",
                     "sandbox" => StatusEnum::true->status()
                ],
            "extra_parameters" =>
                [
                    "callback"=>"ipn"
                ]
            ,
        ],

        "nagad" => [
            "code" => "nagad",
            "serial_id" => "1",
            "currency_id" => "1",
            "parameters" =>
                [
                     "pub_key" => "#",
                     "pri_key" => "#",
                     "marchent_number" => "#",
                     "marchent_id" => "#",
                     "sandbox" => StatusEnum::true->status()
                ],
            "extra_parameters" =>
                [
                    "callback"=>"ipn"
                ],
        ],

        "paypal" => [
            "code" => "paypal",
            "serial_id" => "3",
            "currency_id" => "1",
            "parameters" =>
                [
                     "cleint_id" => "#",
                     "secret" => "#",

                ],
            "extra_parameters" =>
                [],
        ],

        "stripe" => [
            "code" => "stripe",
            "serial_id" => "4",
            "currency_id" => "1",
            "parameters" =>
                [
                     "secret_key" => "#",
                     "publishable_key" => "#",

                ],
            "extra_parameters" =>
                [],
        ],

        "paytm" => [
            "code" => "paytm",
            "serial_id" => "5",
            "currency_id" => "1",
            "parameters" =>
                [
                     "MID" => "#",
                     "merchant_key" => "#",
                     "WEBSITE" => "#",
                     "INDUSTRY_TYPE_ID" => "#",
                     "CHANNEL_ID" => "#",
                     "transaction_url" => "#",
                     "transaction_status_url" => "#"
                ],
            "extra_parameters" =>
                [],
        ],

        "payeer" => [
            "code" => "payeer",
            "serial_id" => "6",
            "currency_id" => "1",
            "parameters" =>
                [
                     "merchant_id" => "#",
                     "secret_key" => "#",

                ],
            "extra_parameters" =>
                [
                    "status"=>"ipn"
                ],
        ],

        "paystack" => [
            "code" => "paystack",
            "serial_id" => "7",
            "currency_id" => "1",

            "parameters" =>
                [
                     "public_key" => "#",
                     "secret_key" => "#",

                ],
            "extra_parameters" =>
                [
                    "callback"=>"ipn",
                    "webhook"=>"ipn"
                ]
            ,
        ],


        "voguepay" => [
            "code" => "voguepay",
            "serial_id" => "8",
            "currency_id" => "1",

            "parameters" =>
                [
                     "merchant_id" => "#",

                ],
            "extra_parameters" =>
                [

                ],
        ],

        "flutterwave" => [
            "code" => "flutterwave",
            "serial_id" => "9",
            "currency_id" => "1",

            "parameters" =>
                [
                     "public_key" => "#",
                     "secret_key" => "#",
                     "encryption_key" => "#"

                ],
            "extra_parameters" =>
                [

                ],
        ],

        "razorpay" => [
            "code" => "razorpay",
            "serial_id" => "10",
            "currency_id" => "1",

            "parameters" =>
                [
                     "key_id" => "#",
                     "key_secret" => "#"

                ]
           ,
            "extra_parameters" =>
                [

                ],
        ],

        "instamojo" => [
            "code" => "instamojo",
            "serial_id" => "11",
            "currency_id" => "1",

            "parameters" =>
                [
                     "api_key" => "#",
                     "auth_token" => "#",
                     "salt" => "#"

                ],
            "extra_parameters" =>
                [

                ]
            ,
        ],

        "mollie" => [
            "code" => "mollie",
            "serial_id" => "12",
            "currency_id" => "1",

            "parameters" =>
                [
                     "api_key" => "#",


                ],
            "extra_parameters" =>
                [

                ],
        ],

        "authorize.net" => [
            "code" => "authorizenet",
            "serial_id" => "13",
            "currency_id" => "1",
            "parameters" =>
                [
                     "login_id" => "#",
                     "current_transaction_key" => "#"

                ],
            "extra_parameters" =>
                [

                ],
        ],

        "securionpay" => [
            "code" => "securionpay",
            "serial_id" => "14",
            "currency_id" => "1",

            "parameters" =>
                [
                     "public_key" => "#",
                     "secret_key" => "#"
                ],
            "extra_parameters" =>
                [

                ],
        ],

        "payumoney" => [
            "code" => "payumoney",
            "serial_id" => "15",
            "currency_id" => "1",

            "parameters" => (
                [
                     "merchant_key" => "#",
                     "salt" => "#"
                ]
            ),
            "extra_parameters" => (
                [

                ]
            ),
        ],

        "mercadopago" => [
            "code" => "mercadopago",
            "serial_id" => "16",
            "currency_id" => "1",
            "parameters" => (
                [
                     "access_token" => "#",

                ]
            ),
            "extra_parameters" => (
                [

                ]
            ),
        ],

        "cashmaal" => [
            "code" => "cashmaal",
            "serial_id" => "17",
            "currency_id" => "1",

            "parameters" => (
                [
                     "web_id" => "#",
                     "ipn_key" => "#"
                ]
            ),
            "extra_parameters" => (
                [
                  "ipn_url" => "ipn"
                ]
            ),
        ],

        "block.io" => [
            "code" => "blockio",
            "serial_id" => "18",
            "currency_id" => "1",

            "parameters" => (
                [
                     "api_pin" => "#",
                     "api_key" => "#",

                ]
            ),
            "extra_parameters" => json_encode(
                [
                  "cron" => "ipn"
                ]
            ),
        ]

    ] ,

    "notification_template" => [

        "PASSWORD_RESET" => [
            "name" => "Password Reset",
            "subject" => "Password Reset",
            "body" => "We have received a request to reset the password for your account on {{code}} and Request time {{time}}",
            "sms_body" => "",
            "sort_code" => [
                'code' => "Password Reset Code",
                'time' => "Password Reset Time",
            ]
        ],

        "PASSWORD_RESET_CONFIRM" => [
            "name" => "Password Reset Confirm",
            "subject" => "Password Reset Confirm",
            "body" => "<p>We have received a request to reset the password for your account on {{code}} and Request time {{time}}</p>",
            "sms_body" => "",
            "sort_code" => ([
                'code' => "Password Reset Code",
                'time' => "Password Reset Time",
            ])
        ],

        "REGISTRATION_VERIFY" => [
            "name" => "Registration Verify",
            "subject" => "Registration Verify",
            "body" => "<p> We have received a request to create an account, you need to verify email first, your    verification code is {{code}} and request time {{time}}</p>",
            "sms_body" => "",
            "sort_code" => ([
                'code' => "Verification Code",
                'time' => "Time",
            ])
        ],


        "OTP_VERIFY" => [
            "name" => "OTP Verificaton",
            "subject" => "OTP Verificaton",
            "body" => "",
            "sms_body" => "Your Otp {{otp}} and request time {{time}}",
            "sort_code" => ([
                'otp' => "otp",
                'time' => "Time",
            ])
        ],


        "SUBSCRIPTION_EXPIRED" => [
            "name" => "Subscription Expired",
            "subject" => "Subscription Expired",
            "body" => "Your {{name}} Package Subscription Has Been Expired!! at time {{time}}",
            "sms_body" => "",
            "sort_code" => ([
                'time' => "Time",
                'name' => "Package Name",
            ])
        ],


        "SUPPORT_TICKET_REPLY" => [
            "name" => "Support Ticket",
            "subject" => "Support Ticket Reply",
            "body" => "<p>Hello Dear ! To provide a response to Ticket ID {{ticket_number}}, kindly click the link provided below in order to reply to the ticket &nbsp;<a style=\"background-color:#13C56B;border-radius:4px;color:#fff;display:inline-flex;font-weight:400;line-height:1;padding:5px 10px;text-align:center:font-size:14px;text-decoration:none;\" href=\"{{link}}\">Link</a></p>",
            "sms_body" => "Hello Dear ! To get a response to Ticket ID {{ticket_number}}, kindly click the link provided below in order to reply to the ticket.  {{link}}",
            "sort_code" => ([
                'ticket_number' => "Support Ticket Number",
                'link' => "Ticket URL For relpy",
            ])
        ],

        "TEST_MAIL" => [
            "name" => "Mail Configuration Test",
            "subject" => "Test Mail",
            "body" => "<h5>This is testing mail for mail configuration.</h5><h5>Request time<span style=\"background-color: rgb(255, 255, 0);\"> {{time}}</span></h5>",
            "sms_body" => "",
            "sort_code" => ([
                'time' => "Time",
            ])
        ],

        "TICKET_REPLY" => [
            "name" => "Ticket Replay",
            "subject" => "Support Ticket Reply",
            "body" => "<p>Hello Dear! ({{role}}) {{name}}!! Just Replied To A Ticket..  To provide a response to Ticket ID {{ticket_number}},&nbsp;<br>kindly click the link provided below in order to reply to the ticket. <a style=\"background-color:#13C56B;border-radius:4px;color:#fff;display:inline-flex;font-weight:400;line-height:1;padding:5px 10px;text-align:center:font-size:14px;text-decoration:none;\" href=\"{{link}}\">Link</a></p>",
            "sms_body" => "Hello Dear! ({{role}}) {{name}}!! Just Replied To A Ticket..
            To provide a response to Ticket ID {{ticket_number}}, kindly click the link provided below in order to reply to the ticket.  {{link}}",

            "sort_code" => ([
                'role' => "Admin Role",
                'name' => "Admin/Agent/User Name",
                'ticket_number' => "Support Ticket Number",
                'link' => "Ticket URL For relpy"
            ])
        ],

        "CONTACT_REPLY" => [
            "name" => "Contact Message",
            "subject" => "Contact Message reply",
            "body" => "Hello Dear! {{email}} {{message}}",
            "sms_body" => "",
            "sort_code" => ([
                'email' => "email",
                'message' => "message"
            ])
        ]

    ] ,


    "sms_gateway" => [
        '101NEX' => [
            "name" => "Nexmo",
            "credential" => ([
                'api_key' => "#",
                'api_secret' => "#",
                'sender_id' => "#"
            ]),
            'default' => StatusEnum::true->status()
        ],

        '104INFO' => [
            "name" => "InfoBip",
            "credential" => ([
                'sender_id' => "#",
                'infobip_api_key' => "#",
                'infobip_base_url' => "#"
            ])

        ],
        '102TWI' => [
            "name" => "Twilio",
            "credential" => ([
                'account_sid' => "#",
                'auth_token' => "#",
                'from_number' => "#"
            ])
        ],
        '103BIRD' => [
            "name" => "Message Bird",
            "credential" => ([
                'access_key' => "#",

            ])
        ]
    ] ,


    "mail_gateway" => [
        '101SMTP' => [
            "name" => "SMTP",
            "credential" => ([
                'driver' => "#",
                'host' => "#",
                'port' => "#",
                'encryption' => "#",
                'username' => "#",
                'password' => "#",
                "from" => [
                    "address" => "#",
                    "name" => "#",
                ]
            ]),
            'default' => StatusEnum::true->status()
        ],

        '104PHP' => [
            "name" => "PHP MAIL",
            "credential" => []
        ],
        '102SENDGRID' => [
            "name" => "SendGrid Api",
            "credential" => ([
                'app_key' => "#",
                "from" => [
                    "address" => "#",
                    "name" => "#",
                ]

            ])
        ]

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
    ],


    "login_attribute" => [
        'username',
        'phone',
        'email'
    ],

    "logo_keys" => [
        "site_logo",
        "user_site_logo",
        "favicon",
        "meta_image",
    ],


    "currency_alignment" => [
        "[symbol][amount]"  => 0,
        "[amount][symbol]"  => 1,
        "[symbol] [amount]" => 2,
        "[amount] [symbol]" => 3,
    ],

    "price_format" => [
        "show_full_price" => 0,
        "truncate_price"  => 1,
    ],

    "date_format" => [
        "d M, Y",
        "m.d.y",
        "Y-m-d",
        "d-m-Y",
        "d/m/Y",
        "Y/m/d",
    ],

    "time_format" => [
        "h:i A",
        "h:i:s A",
        "H:i",
        "H:i:s",
  
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
        "Dramatic",
    ],

    
    "open_ai_model" => [
        "gpt-4-0613"              => 'ChatGPT 4 Gpt-4-32k3',
        "gpt-3.5-turbo-16k"       => 'ChatGPT 3.5 Turbo-16k',
        "gpt-4"                   => 'ChatGPT 4 (Beta)',
        "gpt-3.5-turbo"           => 'ChatGPT 3.5',
        "text-davinci-001"        => 'Davinci',
        "text-ada-001"            => "Ada",
        "text-babbage-001"        => 'Babbage (Average)',
        "text-curie-001"          => "Curie",
    ],


    "platforms" => [
        'facebook',
        'Instagram',
        'linkedin',
        'youtube',
        'tikTok',
        "twitter"
    ],




    



];
