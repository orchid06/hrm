@extends('admin.layouts.master')
@section('content')

    <div class="i-card-md">
        <div class="card-body">
            <ul class="list-group">
                <li
                    class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-3 justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">{{ translate('Email Notification') }}</h6>
                        <p>
                            <small>{{ translate('When enabled, this module sends necessary emails to users. If disabled, no emails will be sent. Prior to disabling, ensure there are no pending emails.') }}</small>
                        </p>
                    </div>
                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('email_notifications') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='email_notifications'
                                data-status='{{ site_settings('email_notifications') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}"
                                id="email-notification">

                            <label class="form-check-label" for="email-notification"></label>
                        </div>
                    </div>
                </li>


                <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-3 justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">{{ translate('Sms Notification') }}</h6>
                        <p>
                            <small>{{ translate('When enabled, this module sends necessary emails to users. If disabled, no emails will be sent. Prior to disabling, ensure there are no pending emails.') }}</small>
                        </p>
                    </div>
                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('sms_notification') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='sms_notification'
                                data-status='{{ site_settings('sms_notification') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}"
                                id="email-notification">

                            <label class="form-check-label" for="email-notification"></label>
                        </div>
                    </div>
                </li>


                <li
                    class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class=" mb-0">{{ translate('Database Notifications') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate('Enable this module for notifications on database events (e.g., New Ticket Generation, New Messages) to users, agents, and administrators.') }}</small>
                        </p>
                    </div>
                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('database_notifications') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='database_notifications'
                                data-status='{{ site_settings('database_notifications') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}"
                                id="database_notifications">
                            <label class="form-check-label" for="database_notifications"></label>
                        </div>
                    </div>
                </li>



                <li
                    class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class=" mb-0">{{ translate('Strong Password') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate('Enable this module for notifications on database events (e.g., New Ticket Generation, New Messages) to users, agents, and administrators.') }}</small>
                        </p>
                    </div>
                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('strong_password') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='strong_password'
                                data-status='{{ site_settings('strong_password') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}"
                                id="strong_password">
                            <label class="form-check-label" for="strong_password"></label>
                        </div>
                    </div>
               </li>


                
                <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">

                    <div>
                        <h6 class=" mb-0">{{ translate('Slack Notification') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("This Module  Enable Slack Notifications") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('slack_notifications') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='slack_notifications'
                                data-status='{{ site_settings('slack_notifications') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}" id="slack_notifications">
                            <label class="form-check-label" for="slack_notifications"></label>
                        </div>
                    </div>

                </li>


                  
                <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">

                    <div>
                        <h6 class=" mb-0">{{ translate('Force Ssl') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("This Module  Enable Slack Notifications") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('force_ssl') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='force_ssl'
                                data-status='{{ site_settings('force_ssl') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}" id="force_ssl">
                            <label class="form-check-label" for="force_ssl"></label>
                        </div>
                    </div>

                </li>


                <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">

                    <div>
                        <h6 class=" mb-0">{{ translate('Kyc Verification') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("This Module  Enable Browser Notifications") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('kyc_verification') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='kyc_verification'
                                data-status='{{ site_settings('kyc_verification') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}" id="kyc_verification">
                            <label class="form-check-label" for="kyc_verification"></label>
                        </div>
                    </div>
                    
                </li>

                <li
                    class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class=" mb-0">{{ translate('Cookie Activation') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("Enabling this module activates the Accept Cookie prompt, allowing personalized user tracking with small files on their computer") }}</small>
                        </p>
                    </div>
                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('cookie') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update" data-key='cookie'
                                data-status='{{ site_settings('cookie') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}" id="cookie">
                            <label class="form-check-label" for="cookie"></label>
                        </div>
                    </div>
                </li>


                <li
                    class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class=" mb-0">{{ translate('App Debug') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("Enabling this module activates system debugging mode, aiding in troubleshooting by providing detailed error messages to identify code issues.") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input {{ env('app_debug') ? 'checked' : '' }} type="checkbox"
                                class="form-check-input status-update" data-key='app_debug'
                                data-status='{{ env("app_debug") ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}" id="app_debug">
                            <label class="form-check-label" for="app_debug"></label>
                        </div>
                    </div>
                </li>

                <li
                    class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class=" mb-0">{{ translate('User Registration') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("Enabling the module activates the User Register Module, indicating their interdependency for proper functioning.") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('registration') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='registration'
                                data-status='{{ site_settings('registration') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}"
                                id="user_register">
                            <label class="form-check-label" for="user_register"></label>
                        </div>
                    </div>
                </li>


                <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">{{ translate('Social Auth') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("It allows users to sign in or register using their social media accounts") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{  site_settings('social_login') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='social_login'
                                data-status='{{ site_settings('social_login') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}"
                                id="social_login">
                            <label class="form-check-label" for="social_login"></label>
                        </div>
                    </div>
               </li>


               <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">{{ translate('Max Login Attempt Validation') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("It allows users to sign in or register using their social media accounts") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{  site_settings('login_attempt_validation') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='login_attempt_validation'
                                data-status='{{ site_settings('login_attempt_validation') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}"
                                id="login_attempt_validation">
                            <label class="form-check-label" for="login_attempt_validation"></label>
                        </div>
                    </div>
               </li>

                <li
                    class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">

                    <div>
                        <h6 class=" mb-0">{{ translate('Email Verfication') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("When enabled, this module prompts users to verify their email addresses during registration by clicking a link or entering a code sent to their email.") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('email_verification') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='email_verification'
                                data-status='{{ site_settings('email_verification') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}"
                                id="email_verification">
                            <label class="form-check-label" for="email_verification"></label>
                        </div>
                    </div>
                </li>

                <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class=" mb-0">{{ translate('Seo Configuration') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("By activating this feature, the system will seamlessly handle the removal of expired links and subscriptions. Additionally, you have the flexibility to configure the time duration, in days, after which the system will automatically delete expired data. You can conveniently manage this functionality within the designated 'App Settings' section. ") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('site_seo') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='site_seo'
                                data-status='{{ site_settings('site_seo') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}" id="site_seo">
                            <label class="form-check-label" for="site_seo"></label>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div>

@endsection

