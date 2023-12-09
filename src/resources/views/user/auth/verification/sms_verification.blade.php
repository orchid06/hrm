
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
                                {{Arr::get($meta,'meta_data','Otp verification')}}
                            </h2>
                        <p>
                            {{@$authContent->value->description }}   
                        </p>

                        <form action="#" class="auth-form otp-form">
                            
                             <input type="hidden" name="otp" class="otp-code">
                             
                            <div class="otp-field">

                                <input required type="text"  maxlength="1" />
                                <input required type="text"  maxlength="1" />
                                <input required type="text"  maxlength="1" />
                                <input required type="text"  maxlength="1" />
                                <input required type="text"  maxlength="1" />

                            </div>

                            <div>
                                <button class="i-btn btn--secondary btn--lg capsuled w-100" type="submit" >
                                    {{translate('Verify')}}
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