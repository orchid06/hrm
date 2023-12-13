
@extends('admin.layouts.auth')
@section('main_content')
    <div class="row form-area justify-content-center align-items-stretch g-0">
        <div class="col-lg-5">
            <div class="form-wrapper">
                <div class="row mb-25 gy-5">
                    <div class="col-md-6 order-md-1 order-2 text-start">
                        <h4>
                            {{@translate($title)}}
                        </h4>
                    </div>
                    <div class="col-md-6 order-md-2 order-1 text-md-end text-center">
                        <a href="{{route('admin.home')}}" class="site-logo">
                            <img src="{{imageUrl(@site_logo('site_logo')->file,'site_logo',true)}}" class="ms-md-auto me-md-0 mx-auto" alt="{{@site_logo('site_logo')->file->name}}">
                        </a>
                    </div>
                </div>
                <form action="{{route('admin.authenticate')}}" class="login-right-form" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-inner">
                                <label for="username" class="form-label">
                                    {{translate("Username/Email")}} <span class="text-danger" >*</span>
                                </label>
                                <input type="text" name="login" required value="admin"  id="username" placeholder='{{translate("Enter Username or email")}}'>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-inner password-inner">
                                <label class="form-label" for="password">
                                    {{translate("Password")}} <span class="text-danger" >*</span>
                                </label>
                                <input required  type="password" value="123123" name="password" class="form-control pe-5 password" placeholder="Enter password" id="password">
                                <i id="toggle-password"  class="fa-duotone fa-eye eye"></i>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-inner d-flex justify-content-between align-items-center">
                                <div class="checkbox-wrapper">
                                    <input  type="checkbox" name="remember_me"  id="auth-remember-check">
                                    <label for="auth-remember-check">
                                        {{translate("Remember me")}}
                                    </label>
                                </div>
                                <a class="forget-pass"  href="{{route('admin.password.request')}}">{{translate("Forgot password")}}?</a>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="i-btn btn--primary btn--lg w-100">{{translate("Sign In")}}</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('script-push')
<script>
    'use strict'
    $(document).on('click','#toggle-password',function(e){
        var passwordInput = $("#password");
        var passwordFieldType = passwordInput.attr('type');
        if (passwordFieldType == 'password') {
        passwordInput.attr('type', 'text');
           $("#toggle-password").removeClass('fa-duotone fa-eye eye').addClass('fa-duotone fa-eye-slash eye');
        } else {
        passwordInput.attr('type', 'password');
          $("#toggle-password").removeClass('fa-duotone fa-eye-slash eye').addClass('fa-duotone fa-eye eye');
        }
   });
</script>

@endpush
