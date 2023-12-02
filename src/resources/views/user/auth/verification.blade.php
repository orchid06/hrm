@extends('layouts.master')
@section('content')

@php
    $authentication_section = frontend_section()->where("slug",'authentication_section')->first();
@endphp
    <div class="login-section pt-110 pb-110">
        <div class="container">
            <div class="row g-0">
                <div class="col-lg-6 d-lg-block d-none">
                    <div class="login-banner">
                        <div class="login-banner-content">
                            <h2>
                                {{@translate($title)}}
                            </h2>
                            <p> {{trans('default.login_description')}}</p>
                        </div>
                        <div class="login-banner-img">
                            <img src="{{imageUrl(config("settings")['file_path']['frontend']['path']."/".@$authentication_section->file->name,@$authentication_section->file->disk ) }}" alt="{{@$authentication_section->file->name}}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login-form-area">
                        <div class="login-right-title">
                            <h3>
                                {{@translate($title)}}
                            </h3>
                        </div>
                        <form action="{{route('password.verify.code')}}" class="login-right-form" method="post">
                            @csrf

                            <input hidden type="text" name="email" value="{{session()->get("reset_password_email")}}" >

                            <div class="input-type">

                                <label for="login-data">
                                     {{translate("Verification Code")}} <span  class="text-danger" >*</span>
                                </label>

                                <div class="form-inner">
                                     <input placeholder="{{translate('Enter Verification Code')}}"  type="text" value="{{old("code")}}" name="code" class="form-control" >
                                </div>
                            </div>
                            <div class="sign-in-btn">
                                    <button>
                                        {{translate("Verify")}}
                                    </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



