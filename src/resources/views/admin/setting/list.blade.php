@extends('admin.layouts.master')

@section('content')

@php
	$mimeTypes              = json_decode(site_settings('mime_types',[]),true);
	$awsSettings            = json_decode(site_settings('aws_s3',[]),true);
	$ftpSetttings           = json_decode(site_settings('ftp',[]),true);
	$ticketSettings         = json_decode(site_settings('ticket_settings',[]),true);
	$google_recaptcha       = json_decode(site_settings('google_recaptcha',[]),true);
	$socail_login_settings  = json_decode(site_settings('social_login_with',[]),true);
	$loginAttributes        = Arr::get(config('settings'),'login_attribute', []);
    $authSetup              = json_decode(site_settings('login_with'),true);
    $tabs = [ 
                'basic'                   => [
                                                    "title" => translate("Basic Settings"),
                                                    "icon"  => 'las la-cog',
                                                ],
                'seo'                     => ["title" => translate("Seo Settings"),  "icon"  => 'las la-stream'],
                'logging'                 => ["title" => translate("Logging"),"icon"  => 'las la-bug'],
                'rate_limiting'           => ["title" => translate("Rate Limiting") , "icon"  => 'las la-wave-square'],
                'theme'                   => ["title" => translate("Theme Settings") ,"icon"  => 'las la-palette'],
                'storage'                 => ["title" => translate("Storage Settings") ,"icon"  => 'las la-box'],
                'slack'                   => ["title" => translate("Slack Settings") ,"icon"  => 'lab la-slack'],
                'recaptcha'               => ["title" => translate("Recaptcha Settings") ,"icon"  => 'las la-shield-alt'],
                'social_login'            => ["title" => translate("Social Login Settings") ,"icon"  => 'las la-hashtag'],
                'login'                   => ["title" => translate('Login Settings') ,"icon"  => 'las la-sign-in-alt'],
                'logo'                    => ["title" => translate('Logo Settings') ,"icon"  => 'las la-image'],
                'ticket'                  => ["title" => translate('Ticket Settings') ,"icon"  => 'las la-envelope'],

                ];

@endphp
    <div class="basic-setting">
        <div class="basic-setting-left">
            <div class="setting-tab sticky-side-div">
                <ul class="nav nav-tabs" role="tablist">

                    @foreach ($tabs  as $key => $tab )

                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{$loop->index == 0 ? 'active' :''}}" id="v-pills-basic-{{$key}}-tab" data-bs-toggle="tab" href="#v-pills-basic-{{$key}}" role="tab" aria-controls="v-pills-basic-{{$key}}" aria-selected="false" tabindex="-1">
                                    <i class="{{Arr::get($tab,'icon')}}"></i> {{  Arr::get($tab,'title') }}
                                </a>
                            </li>

                    @endforeach

                </ul>
            </div>
        </div>
        <div class="basic-setting-right">
            <div id="settingsTabContent" class="tab-content">
                @foreach ($tabs  as $key => $tab )
                    <div class="tab-pane fade  {{$loop->index == 0 ? 'active show' :''}}" id="v-pills-basic-{{$key}}" role="tabpanel" aria-labelledby="v-pills-basic-{{$key}}-tab">
                        @include('admin.setting.partials.'.$key)
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('modal')
   @include('admin.partials.modal.cron_job')
@endsection

@push('style-include')
     <link href="{{asset('assets/global/css/colorpicker.min.css')}}" rel="stylesheet">
@endpush
@push('script-include')
    <script src="{{asset('assets/global/js/colorpicker.min.js')}}"></script>
    @include('admin.setting.partials.script')
@endpush
