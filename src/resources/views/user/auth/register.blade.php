@extends('layouts.master')
@section('content')

@php
    $authContent     =  get_content("content_authentication_section")->first();  

    $socialProviders =  json_decode(site_settings('social_login_with'),true);
    $mediums = [];
    foreach($socialProviders as $key=>$login_medium){
        if($login_medium['status'] == App\Enums\StatusEnum::true->status()){
            array_push($mediums, str_replace('_oauth',"",$key));
        }
    }


    $socialAuth           = (site_settings('social_login'));

    $googleCaptcha        = (object) json_decode(site_settings("google_recaptcha"));

    $captcha              = (site_settings('captcha_with_registration'));
    $defaultcaptcha       = (site_settings('default_recaptcha'));
    $geoCountry           = Arr::get(get_ip_info() , "country",'');

    $countries            = get_countries();

    $termsPage            =  App\Models\Admin\Page::active()
                                   ->where('slug',"terms-and-conditions")
                                   ->first();

@endphp


<section class="auth">
    <div class="container-fluid px-0">
      <div class="auth-wrapper">
        <div class="row g-0">

           @include("user.partials.auth_slider")
     

          <div class="col-xl-8 col-lg-7 order-lg-1 order-0">
            <div class="auth-right">
              <div class="auth-content">
                <a href="{{route('home')}}"class="site-log text-center mb-4 d-inline-block">

                  <img src="{{imageUrl(@site_logo('user_site_logo')->file,'user_site_logo',true)}}" alt="{{@site_logo('user_site_logo')->file->name}}">

                </a>

                <h2>
                   {{trans("default.register_page_title")}}
                </h2>

                <p>
                    {{@$authContent->value->description }}
                </p>
                <form class="auth-form" action="{{route('auth.register.store')}}" method="POST" id="login-form">
                  @csrf


                  <input hidden type="text" name="referral_code" value="{{request()->route('referral_code')}}">

                  <div class="auth-input">
                        <input required type="text" value="{{old('name')}}" name="name" placeholder="{{translate('Enter your name')}}" />
                        <span>
                            <i class="bi bi-person"></i>
                        </span>
                  </div>

                  <div class="auth-input">
                        <input required type="text" value="{{old('username')}}" name="username" placeholder="{{translate('Enter your username')}}" />
                        <span>
                            <i class="bi bi-person"></i>
                        </span>
                  </div>

                  <div class="auth-input">
                        <input required type="email" value="{{old('email')}}" name="email" placeholder="{{translate('Enter your email')}}"/>
                        <span>
                            <i class="bi bi-envelope"></i>
                        </span>
                  </div>

                  <div class="auth-input">

                         <select class="select-two" name="country_id" id="country_id">
                             <option value="">
                                 {{translate("Select country")}}
                             </option>
                              @foreach ($countries  as  $country)
                                
                                 <option {{ $geoCountry  == $country || old("country_id") == $country ? 'selected' :""}} value="{{$country->id}}">
                                       {{ $country->name}}
                                 </option>
                                  
                              @endforeach
                         </select>
                        <span>
                            <i class="bi bi-globe-americas"></i>
                        </span>
                  </div>


                  <div class="auth-input">
                    <input required type="phone" value="{{old('phone')}}" name="phone" placeholder="{{translate('Enter your phone')}}"/>
                    <span>
                        <i class="bi bi-telephone"></i>
                    </span>
                 </div>


                    <div class="auth-input">
                        <input name="password" required type="password" placeholder="{{translate('Password')}}" class="toggle-input" autocomplete="new-password" />
                        <span class="toggle-password">
                            <i class="bi bi-eye toggle-icon "></i>
                        </span>
                    </div>

                    <div class="auth-input">
                        <input name="password_confirmation" required type="password" placeholder="{{translate('Confrim password')}}" class="toggle-input" />
                        <span class="toggle-password">
                            <i class="bi bi-eye toggle-icon "></i>
                        </span>
                    </div>


                  <div class="d-flex align-items-center justify-content-between gap-3">
                    <div class="auth-checkbox">
                      <input required type="checkbox" id="terms_condition" value="1" name="terms_condition" />
                      <label for="terms_condition">{{translate("By completing the registration process, you agree and accept our")}}
                        @if($termsPage)
                            <a href="{{route('page',$termsPage->slug)}}"> {{$termsPage->title}}</a>
                        @endif
                     </label>
                    </div>

                  </div>

                  @if( $captcha  == App\Enums\StatusEnum::true->status() && $defaultcaptcha == App\Enums\StatusEnum::true->status()  )

                    <div class="row g-1">
                          <div class="col-lg-6">
                              <a id='genarate-captcha' class="align-middle justify-content-center cursor-pointer ">
                                  <img class="captcha-default d-inline me-2  " src="{{ route('captcha.genarate',1) }}" id="default-captcha">

                                  <i class="bi bi-arrow-repeat"></i>
                              </a>
                          </div>
                          <div class="col-lg-6">
                              <input type="text"  required name="default_captcha_code"placeholder="{{translate('Enter captcha code')}}" autocomplete="off">
                          </div>
                    </div>

                   @endif
    
                    <div>
                          <button @if($captcha  == App\Enums\StatusEnum::true->status() && $defaultcaptcha != App\Enums\StatusEnum::true->status() && $googleCaptcha->status == App\Enums\StatusEnum::true->status())       class="g-recaptcha i-btn btn--secondary btn--lg capsuled w-100"
                            data-sitekey="{{$googleCaptcha->key}}"
                            data-callback='onSubmit'
                            data-action='register'
                            @else
                               class="i-btn btn--secondary btn--lg capsuled w-100"
                            @endif
                            type="submit">
                              {{trans("Register")}}
                          </button>
                    </div>
                </form>


                @if($socialAuth == App\Enums\StatusEnum::true->status())

                    <span class="or">
                       {{translate('Or')}}
                    </span>

                    <div class="sign-option">

                      @foreach($mediums as $medium)
                           <a href="{{route('auth.social.login', $medium)}}" class="{{$medium}}"><i class="bi bi-{{$medium}}"></i>{{translate("Sign in with")}} {{$medium}}</a>
                      @endforeach

                    </div>
                @endif

                <div class="have-account">
                  <p>
                    {{translate("Already Have An Account")}} ?
                    <a href="{{route('auth.login')}}">
                        {{translate("Login")}}
                    </a>
                  </p>
                </div>
              </div>
              

                @include("user.partials.auth_shape")
               

              <div class="glass-bg"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


@endsection




@if($captcha  == App\Enums\StatusEnum::true->status() && $defaultcaptcha != App\Enums\StatusEnum::true->status() && $googleCaptcha->status == App\Enums\StatusEnum::true->status())

    @push('script-include')
        <script src="https://www.google.com/recaptcha/api.js"></script>
    @endpush

@endif


@push('script-push')

  @if($captcha  == App\Enums\StatusEnum::true->status() &&    $defaultcaptcha != App\Enums\StatusEnum::true->status() && $googleCaptcha->status == App\Enums\StatusEnum::true->status())

      <script>
          'use strict'
          function onSubmit(token) {
            document.getElementById("login-form").submit();
          }
      </script>

    @endif

  

@endpush
