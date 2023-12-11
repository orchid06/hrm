@extends('layouts.master')
@section('content')

@php
    $authContent     =  get_content("content_authentication_section")->first();  

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

                  <img src="{{imageUrl(@site_logo('user_site_logo')->file,"user_site_logo",true)}}" alt="{{@site_logo('user_site_logo')->file->name}}">

                </a>
                <h2>
                    {{Arr::get($meta_data,'title',translate("Verify your account"))}}
                </h2>

                <p>
                    {{@$authContent->value->description }}
                </p>
                <form class="auth-form" action="{{route('auth.password.update')}}" method="POST" id="login-form">
                  @csrf

                  <div class="auth-input">
                      <input name="password" required type="password" placeholder="{{translate("Password")}}" class="toggle-input" autocomplete="new-password" />
                      <span class="toggle-password">
                          <i class="bi bi-eye toggle-icon "></i>
                      </span>
                  </div>

                  <div class="auth-input">
                      <input name="password_confirmation" required type="password" placeholder="{{translate("Confrim password")}}" class="toggle-input" />
                      <span class="toggle-password">
                          <i class="bi bi-eye toggle-icon "></i>
                      </span>
                  </div>

                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <a href="{{route('auth.login')}}" class="forget-pass"> {{translate("Login")}} ? </a>
                    </div>

                    <div>
                          <button type="submit"    class="i-btn btn--secondary btn--lg capsuled w-100">
                              {{trans("Submit")}}
                          </button>
                    </div>

                </form>
           
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



