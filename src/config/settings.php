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


        "social_account" => [
            'view_account',
            'create_account',
            'update_account',
            'delete_account',
        ],

        
        "social_post" => [
            'view_post',
            'create_post',
            'update_post',
            'delete_post',
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

        "blog" => [
            "view_blog",
            "create_blog",
            "update_blog",
            "delete_blog"
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
        'post' => [
            'path' => 'assets/images/global/post',
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
            "code"             => "bkash",
            "serial_id"        => "1",
            "currency_id"      => "1",
            "parameters"       => [
                "api_key"    => "@@",
                "username"   => "@@",
                "password"   => "@@",
                "api_secret" => "@@",
                "sandbox"    => StatusEnum::true->status()
            ],
            "extra_parameters" =>[
                "callback"=>"ipn"
            ],
        ],

        "nagad" => [
            "code"             => "nagad",
            "serial_id"        => "2",
            "currency_id"      => "1",
            "parameters"       => [
                "pub_key"         => "@@",
                "pri_key"         => "@@",
                "marchent_number" => "@@",
                "marchent_id"     => "@@",
                "sandbox"         => StatusEnum::true->status()
            ],
            "extra_parameters" => [
                "callback" => "ipn"
            ],
        ],

        "paypal" => [
            "code"             => "paypal",
            "serial_id"        => "3",
            "currency_id"      => "1",
            "parameters"       => [
                "cleint_id" => "@@",
                "secret"    => "@@",
            ],
            "extra_parameters" => [],
        ],

        "stripe" => [
            "code"             => "stripe",
            "serial_id"        => "4",
            "currency_id"      => "1",
            "parameters"       => [
                "secret_key"      => "@@",
                "publishable_key" => "@@",
            ],
            "extra_parameters" => [],
        ],

        "payeer" => [
            "code"             => "payeer",
            "serial_id"        => "5",
            "currency_id"      => "1",
            "parameters"       => [
                "merchant_id" => "@@",
                "secret_key"  => "@@",
            ],
            "extra_parameters" => [
                "status" => "ipn"
            ],
        ],

        "paystack" => [
            "code"             => "paystack",
            "serial_id"        => "6",
            "currency_id"      => "1",
            "parameters"       => [
                "public_key" => "@@",
                "secret_key" => "@@",
            ],
            "extra_parameters" => [
                "callback" => "ipn",
                "webhook"  => "ipn"
            ],
        ],

        "flutterwave" => [
            "code"             => "flutterwave",
            "serial_id"        => "7",
            "currency_id"      => "1",
            "parameters"       => [
                "public_key"     => "@@",
                "secret_key"     => "@@",
                "encryption_key" => "@@"
            ],
            "extra_parameters" => [],
        ],

        "razorpay" => [
            "code"             => "razorpay",
            "serial_id"        => "8",
            "currency_id"      => "1",
            "parameters"       => [
                "key_id"     => "@@",
                "key_secret" => "@@"
            ],
            "extra_parameters" => [],
        ],

        "instamojo" => [
            "code"             => "instamojo",
            "serial_id"        => "9",
            "currency_id"      => "1",

            "parameters"       => [
                "api_key"    => "@@",
                "auth_token" => "@@",
                "salt"       => "@@"
            ],
            "extra_parameters" => [],
        ],

        "mollie" => [
            "code"             => "mollie",
            "serial_id"        => "10",
            "currency_id"      => "1",
            "parameters"       => [
                "api_key" => "@@",
            ],
            "extra_parameters" => [],
        ],

        "payumoney" => [
            "code"             => "payumoney",
            "serial_id"        => "11",
            "currency_id"      => "1",
            "parameters"       => [
                "merchant_key" => "@@",
                "salt"         => "@@"
            ],
            
            "extra_parameters" => [],
            
        ],

        "mercadopago" => [
            "code"             => "mercadopago",
            "serial_id"        => "12",
            "currency_id"      => "1",
            "parameters"       => [
                "access_token" => "@@",
            ],
            "extra_parameters" =>  [],
        ],

        "cashmaal" => [
            "code"             => "cashmaal",
            "serial_id"        => "13",
            "currency_id"      => "1",
            "parameters"       => [
                "web_id"  => "@@",
                "ipn_key" => "@@"
            ],
            "extra_parameters" => [
                "ipn_url" => "ipn"
            ],
        ],

        "paytm" => [
            "code"             => "paytm",
            "serial_id"        => "14",
            "currency_id"      => "1",
            "parameters"       => [
                "MID"                    => "@@",
                "merchant_key"           => "@@",
                "WEBSITE"                => "@@",
                "INDUSTRY_TYPE_ID"       => "@@",
                "CHANNEL_ID"             => "@@",
                "transaction_url"        => "@@",
                "transaction_status_url" => "@@"
            ],
            "extra_parameters" => [],
        ],

        "voguepay" => [
            "code"             => "voguepay",
            "serial_id"        => "15",
            "currency_id"      => "1",
            "parameters"       => [
                "merchant_id" => "@@",
            ],
            "extra_parameters" => [],
        ],
        
        "authorize.net" => [
            "code"             => "authorizenet",
            "serial_id"        => "16",
            "currency_id"      => "1",
            "parameters"       => [
                "login_id"                => "@@",
                "current_transaction_key" => "@@"
            ],
            "extra_parameters" => [],
        ],

        "NMI" => [

            "code"             => "nmi",
            "serial_id"        => "17",
            "currency_id"      => "1",
            "parameters"       => [
                "api_key" => '@@',
            ],
            "extra_parameters" => [],
        ],

        "BTCPay" => [

            "code"             => "btcpay",
            "serial_id"        => "18",
            "currency_id"      => "1",
            "parameters"       => [
                "store_id"    => '@@',
                "api_key"     => '@@',
                "server_name" => '@@',
                "secret_code" => '@@',
            ],
            "extra_parameters" => [
                "callback" => 'ipn',
            ],
        ],

        "Perfect Money" => [

            "code"             => "PerfectMoney",
            "serial_id"        => "19",
            "currency_id"      => "1",
            "parameters"       => [
                "passphrase" => '@@',
                "wallet_id" => '@@',
            ],
            "extra_parameters" => [],
        ],

        "Coingate" => [
            "code"             => "coingate",
            "serial_id"        => "22",
            "currency_id"      => "1",
            "parameters"       => [
                "api_key" => '@@',
            ],
            "extra_parameters" => [],
        ],

        "Skrill" => [
            "code"             => "skrill",
            "serial_id"        => "23",
            "currency_id"      => "1",
            "parameters"       => [
                "secret_key"   => '@@',
                "skrill_email" => '@@',
            ],
            "extra_parameters" => [],
        ],

        "Coinbase Commerce" => [

            "code"             => "coinbase",
            "serial_id"        => "24",
            "currency_id"      => "1",
            "parameters"       => [
                "api_key"        => '@@',
                "webhook_secret" => '@@',
            ],
            "extra_parameters" => [
                "webhook" => "ipn"
            ],
        ],

    ] ,

    "notification_template" => [

        "PASSWORD_RESET" => [
            "name"      => "Password Reset",
            "subject"   => "Password Reset",
            "body"      => "We have received a request to reset the password for your account on {{otp_code}} and Request time {{time}}",
            "sms_body"  => "We have received a request to reset the password for your account on {{otp_code}} and Request time {{time}}",
            "sort_code" => [
                'otp_code' => "Password Reset Code",
                'time'     => "Password Reset Time",
            ]
        ],

        "REGISTRATION_VERIFY" => [
            "name"      => "Registration Verify",
            "subject"   => "Registration Verify",
            "body"      => "We have received a request to create an account, you need to verify email first, your verification code is {{otp_code}} and request time {{time}}",
            "sms_body"  => "We have received a request to create an account, you need to verify email first, your verification code is {{otp_code}} and request time {{time}}",
            "sort_code" => ([
                'otp_code'  => "Verification Code",
                'time' => "Time",
            ])
        ],

        "SUPPORT_TICKET_REPLY" => [
            "name"      => "Support Ticket",
            "subject"   => "Support Ticket",
            "body"      => "<p>Hello Dear ! To provide a response to Ticket ID {{ticket_number}}, kindly click the link provided below in order to reply to the ticket &nbsp;<a style=\"background-color:#13C56B;border-radius:4px;color:#fff;display:inline-flex;font-weight:400;line-height:1;padding:5px 10px;text-align:center:font-size:14px;text-decoration:none;\" href=\"{{link}}\">Link</a></p>",
            "sms_body"  => "Hello Dear ! To get a response to Ticket ID {{ticket_number}}, kindly click the link provided below in order to reply to the ticket. {{link}}",
            "sort_code" => ([
                'ticket_number' => "Support Ticket Number",
                'link'          => "Ticket URL For relpy",
            ])
        ],

        "TEST_MAIL" => [
            "name"      => "Mail Configuration Test",
            "subject"   => "Test Mail",
            "body"      => "This is testing mail for mail configuration Request time<span style=\"background-color: rgb(255, 255, 0);\"> {{time}}</span></h5>",
            "sms_body"  => "",
            "sort_code" => ([
                'time' => "Time",
            ])
        ],  

        "TICKET_REPLY" => [
            "name"      => "Ticket Replay",
            "subject"   => "Support Ticket Reply",
            "body"      => "{{name}}!! Just Replied To A Ticket..  To provide a response to Ticket ID {{ticket_number}}, kindly click the link provided below in order to reply to the ticket.  {{link}}",
            "sms_body"  => "{{name}}!! Just Replied To A Ticket..  To provide a response to Ticket ID {{ticket_number}}, kindly click the link provided below in order to reply to the ticket.  {{link}}",
            "sort_code" => ([
                
                'name'          => "Admin/Agent/User Name",
                'ticket_number' => "Support Ticket Number",
                'link'          => "Ticket URL For relpy"
            ])
        ],

        "CONTACT_REPLY" => [
            "name"      => "Contact Message",
            "subject"   => "Contact Message reply",
            "body"      => "Hello Dear! {{email}} {{message}}",
            "sms_body"  => "Hello Dear! {{email}} {{message}}",
            "sort_code" => ([
                'email'   => "email",
                'message' => "message"
            ])
        ],

        "OTP_VERIFY" => [
            "name"      => "OTP Verificaton",
            "subject"   => "OTP Verificaton",
            "body"      => "Your Otp {{otp_code}} and request time {{time}}, expired time {{expire_time}}",
            "sms_body"  => "Your Otp {{otp_code}} and request time {{time}}, expired time {{expire_time}}",
            "sort_code" => ([
                'otp_code'         => "OTP (One time password)",
                'time'        => "Time",
                'expire_time' => "OTP Expired Time"
            ])
        ],

        "SUBSCRIPTION_EXPIRED" => [
            "name"      => "Subscription Expired",
            "subject"   => "Subscription Expired",
            "body"      => "Your {{name}} Package Subscription Has Been Expired!! at time {{time}}",
            "sms_body"  => "Your {{name}} Package Subscription Has Been Expired!! at time {{time}}",
            "sort_code" => ([
                'time' => "Time",
                'name' => "Package Name",
            ])
        ],

        "WITHDRAWAL_REQUEST_ACCEPTED" => [
            "name"      => "Withdrawal Request Accepted",
            "subject"   => "Withdrawal Request Accepted",
            "body"      => "We are pleased to inform you that your withdrawal request has been accepted. Here are the details: - Transaction Code: {{trx_code}} - Amount: {{amount}} - Method: {{method}} - Time of Approval: {{time}} The funds will be processed accordingly.",
            "sms_body"  => "We are pleased to inform you that your withdrawal request has been accepted. Here are the details: - Transaction Code: {{trx_code}} - Amount: {{amount}} - Method: {{method}} - Time of Approval: {{time}} The funds will be processed accordingly.",
            "sort_code" => ([
                'time'     => "Time",
                'trx_code' => "Transaction id",
                'amount'   => "Withdraw amount",
                'method'   => "Withdraw method",
            ])
        ],
        
        "WITHDRAWAL_REQUEST_SUBMIT" => [
            "name"      => "New Withdrawal Request Submitted",
            "subject"   => "New Withdrawal Request Submitted",
            "body"      => "A new withdrawal request has been submitted. Here are the details: User: {{name}} Transaction ID: {{trx_code}} Amount: {{amount}} Withdrawal Method: {{method}} Requested On: {{time}}",
            "sms_body"  => "A new withdrawal request has been submitted. Here are the details: User: {{name}} Transaction ID: {{trx_code}} Amount: {{amount}} Withdrawal Method: {{method}} Requested On: {{time}}",
            "sort_code" => ([
                'name'     => "User name",
                'trx_code' => "Transaction id",
                'amount'   => "Withdraw amount",
                'method'   => "Withdraw method",
            ])
        ],

        "DEPOSIT_REQUEST" => [
            "name"      => "New Deposit Request",
            "subject"   => "New Deposit Request",
            "body"      => "We have received your deposit request for an amount of {{amount}} via {{payment_method}} at {{time}} Your transaction code is {{trx_code}}. Please wait for our confirmation",
            "sms_body"  => "We have received your deposit request for an amount of {{amount}} via {{payment_method}} at {{time}} Your transaction code is {{trx_code}}. Please wait for our confirmation",
            "sort_code" => ([
                'time'           => "Time",
                'trx_code'       => "Transaction id",
                'amount'         => "Deposited amount",
                'payment_method' => "Payment method",
            ])
        ],

        "DEPOSIT_REQUEST_ACCEPTED" => [
            "name"      => "Deposit Request Accepted",
            "subject"   => "Deposit Request Accepted",
            "body"      => "We are pleased to inform you that your deposit request has been accepted. Your transaction code is {{trx_code}}. The deposited amount is {{amount}} via {{payment_method}}",
            "sms_body"  => "We are pleased to inform you that your deposit request has been accepted. Your transaction code is {{trx_code}}. The deposited amount is {{amount}} via {{payment_method}}",
            
            "sort_code" => ([
                'trx_code'       => "Transaction id",
                'amount'         => "Deposited amount",
                'payment_method' => "Payment method",
            ])
        ],

        "NEW_DEPOSIT" => [
            "name"      => "Newly Deposited Amount",
            "subject"   => "Newly Deposited Amount",
            "body"      => "A new deposit has been made by {{name}}. Here are the details: - User: {{name}} - Transaction Code: {{trx_code}} - Amount: {{amount}} - Payment Method: {{payment_method}} - Time of Deposit: {{time}} Please review and take the necessary actions.",
            "sms_body"  => "A new deposit has been made by {{name}}. Here are the details: - User: {{name}} - Transaction Code: {{trx_code}} - Amount: {{amount}} - Payment Method: {{payment_method}} - Time of Deposit: {{time}} Please review and take the necessary actions.",
            "sort_code" => ([
                'time'           => "Time",
                'trx_code'       => "Transaction id",
                'amount'         => "Deposited amount",
                'payment_method' => "Payment method",
                'name'           => "User name"
            ])
        ],

        "WITHDRAWAL_REQUEST_REJECTED" => [
            "name"      => "Withdrawal Request Rejected",
            "subject"   => "Withdrawal Request Rejected",
            "body"      => "We regret to inform you that your withdrawal request has been rejected. Please review the details: - Transaction Code: {{trx_code}} - Amount: {{amount}} - Method: {{method}} - Reason for Rejection: {{reason}} - Time of Rejection: {{time}}",
            "sms_body"  => "We regret to inform you that your withdrawal request has been rejected. Please review the details: - Transaction Code: {{trx_code}} - Amount: {{amount}} - Method: {{method}} - Reason for Rejection: {{reason}} - Time of Rejection: {{time}}",
            "sort_code" => ([
                'time'     => "Time",
                'trx_code' => "Transaction id",
                'amount'   => "Withdraw amount",
                'method'   => "Withdraw method",
                'reason'   => "Rejection reason"
            ])
        ],

        "WITHDRAWAL_REQUEST_RECEIVED" => [
            "name"      => "Withdrawal Request Received",
            "subject"   => "Withdrawal Request Received",
            "body"      => "We have received your withdrawal request. Here are the details: - Transaction Code: {{trx_code}} - Amount: {{amount}} - Method: {{method}} - Time : {{time}} Your request is currently being processed. We will notify you once the status is updated.",
            "sms_body"      => "We have received your withdrawal request. Here are the details: - Transaction Code: {{trx_code}} - Amount: {{amount}} - Method: {{method}} - Time : {{time}} Your request is currently being processed. We will notify you once the status is updated.",
            "sort_code" => ([
                'time'     => "Time",
                'trx_code' => "Transaction id",
                'amount'   => "Withdraw amount",
                'method'   => "Withdraw method"
            ])
        ],

        "SUBSCRIPTION_CREATED" => [
            "name"      => "New Subscription Created",
            "subject"   => "New Subscription Created",
            "body"      => "A new subscription has been created. Subscription Details: - User: {{name}} - Subscription Plan: {{package_name}} - Start Date: {{start_date}} - End Date: {{end_date}}",
            "sms_body"  => "A new subscription has been created. Subscription Details: - User: {{name}} - Subscription Plan: {{package_name}} - Start Date: {{start_date}} - End Date: {{end_date}}",
            "sort_code" => ([
                'name'         => "User name",
                'start_date'   => "Start Date",
                'end_date'     => "End Date",
                'package_name' => "Package name"
            ])
        ],

        "NEW_TICKET" => [
            "name"      => "New Ticket",
            "subject"   => "New Ticket",
            "body"      => "A new ticket has been created with the following details: Ticket ID: {{ticket_number}} Created by: {{name}} Date and Time: {{time}} Priority: {{priority}}",
            "sms_body"  => "A new ticket has been created with the following details: Ticket ID: {{ticket_number}} Created by: {{name}} Date and Time: {{time}} Priority: {{priority}}",
            "sort_code" => ([
                'ticket_number' => "Support Ticket Number",
                'name'          => "User name",
                'time'          => "Created Date and time",
                'priority'      => "Ticket Priority"
            ])
        ],

        "SUBSCRIPTION_STATUS" => [
            "name"      => "Subscription Status Updated",
            "subject"   => "Subscription Status Updated",
            "body"      => "We wanted to inform you that the status of your subscription has been updated. Subscription Details: - Plan: {{plan_name}} - Status: {{status}} - Time :{{time}}",
            "sms_body"  => "We wanted to inform you that the status of your subscription has been updated. Subscription Details: - Plan: {{plan_name}} - Status: {{status}} - Time :{{time}}",
            "sort_code" => ([
                'plan_name' => "Support Ticket Number",
                'time'      => "Time",
                'status'    => "Status"
            ])
        ],

        "SUBSCRIPTION_FAILED" => [
            "name"      => "Auto Subscription Renewal Failed",
            "subject"   => "Auto Subscription Renewal Failed",
            "body"      => "We regret to inform you that the automatic renewal of your subscription has failed. Subscription Details: - Plan: {{name}} - Reason: {{reason}} - Time :{{time}}",
            "sms_body"  => "We regret to inform you that the automatic renewal of your subscription has failed. Subscription Details: - Plan: {{name}} - Reason: {{reason}} - Time :{{time}}",
            "sort_code" => ([
                'name'   => "Package Name",
                'time'   => "Time",
                'reason' => "Failed Reason"
            ])
        ],

        "DEPOSIT_REQUEST_REJECTED" => [
            "name"      => "Deposit Request Rejected",
            "subject"   => "Deposit Request Rejected",
            "body"      => "We regret to inform you that your deposit request has been rejected. reason : {{reason}} Your transaction code is {{trx_code}}. The deposited amount is {{amount}} via {{payment_method}}",
            "sms_body"  => "We regret to inform you that your deposit request has been rejected. reason : {{reason}} Your transaction code is {{trx_code}}. The deposited amount is {{amount}} via {{payment_method}}",
            "sort_code" => ([
                'trx_code'       => "Transaction id",
                'amount'         => "Deposited amount",
                'payment_method' => "Payment method",
                'reason'         => "Rejection reason"
            ])
        ],

        "USER_ACTION" => [
            "name"      => "New User Action",
            "subject"   => "New User Action",
            "body"      => "A new {{type}}  has occurred. Here are the details: {{details}} Please respond promptly.",
            "sms_body"  => "A new {{type}}  has occurred. Here are the details: {{details}} Please respond promptly.",
            "sort_code" => ([
                'type'       => "Action type",
                'details'    => "Action Details"
            ])
        ],


        
        "KYC_UPDATE" => [
            "name"      => "KYC Log Status Updated",
            "subject"   => "KYC Log Status Updated",
            "body"      => "We're here to inform you that there has been an update to your KYC (Know Your Customer) log status.
                            Kyc Information:
                                Applied By : {{name}}
                                status     : {{status}}",

            "sms_body"  => "We're here to inform you that there has been an update to your KYC (Know Your Customer) log status.
                            Kyc Information:Applied By : {{name}} status : {{status}}",
            "sort_code" => ([
                'name'       => "User name",
                'status'     => "Verification status"
            ])
        ],


        
        "KYC_APPLIED" => [
            "name"      => "New KYC Verification Application Received",
            "subject"   => "New KYC Verification Application Received",
            "body"      => "A new user has applied for KYC (Know Your Customer) verification. Here are the details
            Kyc Information:Applied By :{{name}} Application time :{{time}}",
            "sms_body"  => "A new user has applied for KYC (Know Your Customer) verification. Here are the details
             Kyc Information:Applied By :{{name}} Application time :{{time}}",
            "sort_code" => ([
                'name'       => "User name",
                'time'     => "Time"
            ])
        ],
    ] ,


    "sms_gateway" => [
        '101NEX' => [
            "name" => "Nexmo(VONAGE)",
            "credential" => ([
                'api_key' => "@@",
                'api_secret' => "@@",
                'sender_id' => "@@"
            ]),
            'default' => StatusEnum::true->status()
        ],

        '104INFO' => [
            "name" => "InfoBip",
            "credential" => ([
                'sender_id' => "@@",
                'infobip_api_key' => "@@",
                'infobip_base_url' => "@@"
            ])

        ],
        '102TWI' => [
            "name" => "Twilio",
            "credential" => ([
                'account_sid' => "@@",
                'auth_token' => "@@",
                'from_number' => "@@"
            ])
        ],
        '103BIRD' => [
            "name" => "Message Bird",
            "credential" => ([
                'access_key' => "@@",

            ])
        ]
    ] ,


    "mail_gateway" => [
        '101SMTP' => [
            "name" => "SMTP",
            "credential" => ([
                'driver' => "@@",
                'host' => "@@",
                'port' => "@@",
                'encryption' => "@@",
                'username' => "@@",
                'password' => "@@",
                "from" => [
                    "address" => "@@",
                    "name" => "@@",
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
                'app_key' => "@@",
                "from" => [
                    "address" => "@@",
                    "name" => "@@",
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
        "loader_icon",
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

    /** platform configuration start */
    
    "platforms" => [

        'facebook' => [
            'credential' => [
                'client_id'     => '@@',
                'client_secret' => '@@',
                'app_version'   => '@@',
                'graph_api_url'   => '@@',
                'group_url'   => 'https://www.facebook.com/groups',
            ],
            'is_integrated' => StatusEnum::true->status(),
            'is_feature'    => StatusEnum::true->status(),
            'view_option'   => StatusEnum::true->status(),
        ],
        'instagram' => [
           
            'credential' => [
                'client_id'     => '@@',
                'client_secret' => '@@',
                'app_version'   => '@@',
                'graph_api_url'   => '@@',
            ],

            'is_integrated' => StatusEnum::true->status(),
            'view_option'   => StatusEnum::true->status(),
            'is_feature'    => StatusEnum::true->status(),
            
        ],

        "twitter" => [

            'credential' => [
                'client_id'        => '@@',
                'client_secret'    => '@@',
                'app_version'      => '@@',
            ],
            'is_integrated' => StatusEnum::true->status(),
            'official'      => StatusEnum::false->status(),
            'is_feature'    => StatusEnum::true->status(),

     
        ],
        
        'linkedin' => [
            'credential' => [
                'client_id'        => '@@',
                'client_secret'    => '@@',
            ],
            'is_integrated' => StatusEnum::true->status(),
            'unofficial'    => StatusEnum::false->status(),
            'is_feature'    => StatusEnum::true->status(),
        ],
        'youtube' => [

            'credential' => [
                'client_id'     => '@@',
                'client_secret' => '@@',
                'app_version'   => '@@',
                'graph_api_url'   => '@@'
            ],
            'is_integrated' => StatusEnum::false->status(),


        ],
        'tikTok' => [
            'credential' => [
                'client_id'        => '@@',
                'client_secret'    => '@@',
            ],
            'is_integrated' => StatusEnum::false->status(),
        ]
  
    ],

    "platforms_connetion_field" => [

        "facebook" => [
            "access_token"
        ],
        "instagram" => [
            "username",
            "password",
        ],
        "twitter" => [
            'consumer_key',
            'consumer_secret',
            'access_token',    
            'token_secret' ,   
            'bearer_token'   
        ],
    ]

    /** platform configuration end */
    



    



];
