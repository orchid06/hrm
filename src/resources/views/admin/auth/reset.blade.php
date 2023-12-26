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
                        <img src="{{imageUrl(@site_logo('site_logo')->file,'site_logo',true)}}" class="ms-md-auto me-md-0 mx-auto" alt="{{@site_logo('site_logo')->file->name}}">                    </a>
                </div>
            </div>
            <form action="{{route('admin.password.update.request')}}" class="login-right-form" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-inner">
                            <label class="form-label" for="password-input">
                                {{translate("Password")}} <span class="text-danger" >*</span>
                            </label>
                            <input required  type="password"  name="password" placeholder='{{translate("Enter password")}}' id="password-input">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-inner">
                            <label class="form-label" for="confrim-password-input">
                                {{translate("Confrim Password")}} <span class="text-danger" >*</span>
                            </label>
                            <input required  type="password"  name="password_confirmation"  placeholder='{{translate("Enter Confrim password")}}' id="confrim-password-input">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-inner d-flex justify-content-between align-items-center">

                            <a class="forget-pass"  href="{{route('admin.login')}}">{{translate("Login")}}?</a>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="i-btn btn--primary btn--lg w-100">{{translate("Submit")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

