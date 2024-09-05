@extends('layouts.masterold')

@section('content')

@php

$loginAttributes = json_decode(site_settings('login_with'),true);
$socialProviders = json_decode(site_settings('social_login_with'),true);
$mediums = [];
foreach($socialProviders as $key=>$login_medium){
if($login_medium['status'] == App\Enums\StatusEnum::true->status()){
array_push($mediums, str_replace('_oauth',"",$key));
}
}

$otpFlag = App\Enums\StatusEnum::false->status();
if( is_array($loginAttributes) &&
count($loginAttributes) == 1 &&
in_array('phone',$loginAttributes) &&
site_settings('sms_otp_verification') == App\Enums\StatusEnum::true->status() ){

$otpFlag = App\Enums\StatusEnum::true->status();
}
$socialAuth = (site_settings('social_login'));
$googleCaptcha = (object) json_decode(site_settings("google_recaptcha"));
$captcha = (site_settings('captcha_with_login'));
$defaultcaptcha = (site_settings('default_recaptcha'));


@endphp


<section class="auth">
    <div class="container-fluid px-0">
        <div class="auth-wrapper">

                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="auth-right">
                            <div class="auth-content ">

                                <h2>
                                    {{trans("default.login_page_title")}}
                                </h2>
                                <p>
                                    {{@$authContent->value->description }}
                                </p>
                                <form class="auth-form" action="{{route('auth.authenticate')}}" method="POST"
                                    id="login-form">
                                    @csrf

                                    <div class="auth-input">
                                        <label for="login_key">
                                            {{ucfirst(str_replace("_"," ",implode(" / ",$loginAttributes)))}} <span
                                                class="text--danger">*</span>
                                        </label>
                                        <input required type="text" name="login_data" id="login_key"
                                            placeholder='{{@ucWords(str_replace("_"," ",implode(" / ",$loginAttributes)))}}' />
                                        <span class="auth-input-icon">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                    </div>

                                    @if($otpFlag == App\Enums\StatusEnum::false->status())
                                    <div class="auth-input">
                                        <label for="password">
                                            {{translate('Password')}} <span class="text--danger">*</span>
                                        </label>
                                        <input name="password" id="password" required type="password"
                                            placeholder="{{translate('Password')}}" class="toggle-input" />
                                        <span class="auth-input-icon toggle-password">
                                            <i class="bi bi-eye toggle-icon "></i>
                                        </span>
                                    </div>
                                    @endif

                                    <div class="d-flex align-items-center justify-content-between gap-3">
                                        <div class="auth-checkbox">
                                            <input type="checkbox" id="remember" value="1" name="remember_me" />
                                            <label for="remember">{{translate("Remember me")}}</label>
                                        </div>

                                        <a href="{{route('auth.password.request')}}" class="forget-pass">
                                            {{translate("Forgot password")}} ? </a>
                                    </div>

                                    @if( $captcha == App\Enums\StatusEnum::true->status() && $defaultcaptcha ==
                                    App\Enums\StatusEnum::true->status() )

                                    <div class="row align-items-center g-3">
                                        <div class="col-sm-6">
                                            <div class="captcha-wrapper">
                                                <a id='genarate-captcha' class="align-middle justify-content-center">
                                                    <div class="captcha-img">
                                                        <img class="captcha-default d-inline me-2  "
                                                            src="{{ route('captcha.genarate',1) }}" alt=""
                                                            id="default-captcha">
                                                    </div>

                                                    <span class="captcha-change">
                                                        <i class="bi bi-arrow-repeat"></i>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="captcha-input">
                                                <input type="text" required name="default_captcha_code"
                                                    placeholder="{{translate('Enter captcha code')}}" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    @endif

                                    <div>
                                        <button @if($captcha==App\Enums\StatusEnum::true->status() && $defaultcaptcha !=
                                            App\Enums\StatusEnum::true->status() && $googleCaptcha->status ==
                                            App\Enums\StatusEnum::true->status()) class="g-recaptcha i-btn btn--primary-2
                                            btn--lg capsuled w-100"
                                            data-sitekey="{{$googleCaptcha->key}}"
                                            data-callback='onSubmit'
                                            data-action='register'
                                            @else
                                            class="i-btn btn--secondary btn--lg capsuled w-100"
                                            @endif
                                            type="submit">
                                            {{trans("default.login_btn_text")}}
                                        </button>
                                    </div>
                                </form>

                                @if($socialAuth == App\Enums\StatusEnum::true->status())

                                <span class="or">
                                    {{translate('OR Continue With')}}
                                </span>

                                <div class="sign-option">

                                    @foreach($mediums as $medium)
                                    <a href="{{route('auth.social.login', $medium)}}" class="{{$medium}}"><i
                                            class="bi bi-{{$medium}}"></i>{{translate("Sign in with")}} {{$medium}}</a>
                                    @endforeach

                                </div>
                                @endif
                            </div>


                            <div class="glass-bg"></div>
                        </div>
                    </div>
                </div>


        </div>
    </div>
</section>


@endsection




@if($captcha == App\Enums\StatusEnum::true->status() && $defaultcaptcha != App\Enums\StatusEnum::true->status() &&
$googleCaptcha->status == App\Enums\StatusEnum::true->status())

@push('script-include')
<script src="https://www.google.com/recaptcha/api.js"></script>
@endpush

@endif


@push('script-push')

@if($captcha == App\Enums\StatusEnum::true->status() && $defaultcaptcha != App\Enums\StatusEnum::true->status() &&
$googleCaptcha->status == App\Enums\StatusEnum::true->status())

<script>
    'use strict'
    function onSubmit(token) {
        document.getElementById("login-form").submit();
    }
</script>

@endif



@endpush
