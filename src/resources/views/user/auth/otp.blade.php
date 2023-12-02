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
                                {{@translate("Otp Verification")}}
                            </h2>

                        </div>
                        <div class="login-banner-img">
                            {{-- <img src="{{imageUrl(config("settings")['file_path']['frontend']['path']."/".  @$authentication_section->file->name,@$authentication_section->file->disk ) }}" alt="{{@$authentication_section->file->name}}"> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login-form-area">
                        <div class="login-right-title">
                            <h3>
                                {{@translate('Verify by Opt')}}
                            </h3>
                        </div>
                        <form action="{{route('login.verify.otp')}}" class="login-right-form" method="post">
                            @csrf
                            @if(session()->has("otp_expired_alert"))

                              @php
                                $dateTime = session()->get("otp_expired_alert");
                                $message =  translate("Your Otp  Will Expired At "). get_date_time($dateTime);
                                if($dateTime < \Carbon\Carbon::now()){
                                    $message = translate('Your Otp Is Expired!! Request Again!!');
                                    session()->put("resend_otp",true);
                                }

                              @endphp
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ $message}}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                                    </button>
                                </div>
                            @endif

                            <div class="input-type">

                                <label for="login-data">
                                     {{translate("Otp")}} <span  class="text-danger" >*</span>
                                </label>

                                <div class="form-inner">
                                     <input placeholder="{{translate('Enter Otp')}}"  type="text" value="{{old("otp")}}" name="otp" class="form-control" >
                                </div>

                            </div>

                            <div class="sign-in-btn">
                                <button>
                                    {{translate("Verify")}}
                                </button>
                            </div>


                             @if(session()->has("resend_otp") )
                                <a class="ig-btn btn--primary btn--sm" href="{{route('login.otp.resend')}}">
                                    {{translate("Resend")}}
                                </a>
                             @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



