

@extends('layouts.master')
@section('content')

   @php
      $authentication_section = frontend_section()->where("slug",'authentication_section')->first();
   @endphp
    <div class="login-section pt-110 pb-110">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6 d-lg-block d-none">
                    <div class="login-banner">
                        <div class="login-banner-content">
                            <h2>
                                {{@translate($title)}}
                            </h2>
                            <p> {{trans('default.login_description')}}</p>
                        </div>
                        <div class="login-banner-img">
                            {{-- <img src="{{imageUrl(config("settings")['file_path']['frontend']['path']."/".  @$authentication_section->file->name,@$authentication_section->file->disk ) }}" alt="{{@$authentication_section->file->name}}"> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pe-lg-5">
                    <div class="login-form-area">
                        <div class="login-right-title">
                            <h3>
                                {{@translate($title)}}
                            </h3>
                        </div>
                        <form action="{{route('password.update')}}" class="login-right-form" method="post">
                            @csrf

                            <div class="input-type">
                                <label for="login-data">
                                     {{translate("Password")}} <span  class="text-danger" >*</span>
                                </label>

                                <div class="form-inner">
                                     <input required placeholder="{{translate('Enter Password')}}"  type="password" value="{{old("password")}}" name="password" class="form-control" >
                                </div>
                            </div>


                            <div class="input-type">
                                <label for="login-data">
                                     {{translate("Confirm Password")}} <span  class="text-danger" >*</span>
                                </label>

                                <div class="form-inner">
                                     <input required placeholder="{{translate('Enter Confirm Password')}}"  type="password" value="{{old("password_confirmation")}}" name="password_confirmation" class="form-control" >
                                </div>
                            </div>


                            <div class="sign-in-btn">
                                <button>
                                    {{translate("Update")}}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



