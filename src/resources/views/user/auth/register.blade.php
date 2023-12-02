
@extends('layouts.master')
@section('content')

@php

    $socialAuth =  (site_settings('social_login'));
    $socialProviders =  json_decode(site_settings('social_login_with'),true);
    $authentication_section = frontend_section()->where("slug",'authentication_section')->first();
    $mediums = [];
    foreach($socialProviders as $key=>$login_medium){
        if($login_medium['status'] == App\Enums\StatusEnum::true->status()){
            array_push($mediums, str_replace('_oauth',"",$key));
            $flag =  App\Enums\StatusEnum::true->status();
        }
    }
    $registrationFields = json_decode(site_settings('user_registration_settings'),true);
    usort($registrationFields, function ($tmp, $tmp1) {
        return $tmp['order'] <=> $tmp1['order'];
    });
    $custom_feild_counter = 0;
    $custom_rules = [];
    $googleCaptcha = (object) json_decode(site_settings("google_recaptcha"));


@endphp

  <div class="login-section pt-110 pb-110">
    <div class="container">
      <div class="row g-0">
        <div class="col-lg-6 d-lg-block d-none">
          <div class="login-banner">
            <div class="login-banner-content">

            </div>
            <div class="login-banner-img">
              {{-- <img src="{{imageUrl(config("settings")['file_path']['frontend']['path']."/".@$authentication_section->file->name,@$authentication_section->file->disk ) }}" alt="{{@$authentication_section->file->name}}"> --}}
            </div>
          </div>
        </div>
        <div class="col-lg-6">
            <div class="login-form-area">
                <div class="login-right-title">
                    <h3>
                        {{@translate('Register Here')}}
                    </h3>
                </div>
              <form action="{{route('register.store')}}" class="login-right-form" method="post" id="registration-form">
                  @csrf
                  <div class="row">

                      @foreach($registrationFields as $inputData)
                          @if($inputData['status'] == App\Enums\StatusEnum::true->status())

                              @php
                                  if(isset($inputData['name']))
                                  {
                                      $field_name = $inputData['name'];
                                  }
                              @endphp

                              <div class="col-lg-{{$inputData['width'] == '100' ? '12' :'6'}} mb-2">

                                      <label for="{{$loop->index}}" class="form-label">
                                          {{$inputData['labels']}} @if($inputData['required'] == App\Enums\StatusEnum::true->status() || $inputData['type'] == 'file') <span class="text-danger">
                                              {{$inputData['required'] == App\Enums\StatusEnum::true->status() ?  "*" :""}}

                                              @if($inputData['type'] == 'file')
                                                  ({{$inputData['placeholder']}} !! {{translate('Max-'). site_settings("max_file_upload")}}  )
                                              @endif
                                          </span>@endif
                                      </label>
                                      <div class="form-inner">

                                          @if($inputData['type'] == 'select')

                                          @php
                                              $country_code = null;
                                              $myCollection = collect(config('country'))->map(function($row) {
                                                  return collect($row);
                                              });
                                              $countries = $myCollection->sortBy('code');
                                          @endphp


                                              <select {{$inputData['required'] == App\Enums\StatusEnum::true->status() ? "required" :""}} class="form-control selectTwo country-code form-style p-md-3"  name="register_data[{{ $field_name }}]" >
                                                  <option value="">{{translate('Select Category')}}</option>
                                                  @foreach(config('country') as $value)
                                                      <option value="{{$value['phone_code']}}"
                                                              data-name="{{$value['name']}}"
                                                              data-code="{{$value['code']}}"
                                                          {{$country_code == $value['code'] ? 'selected' : ''}}> {{$value['name']}}
                                                      </option>
                                                  @endforeach

                                              </select>

                                          @elseif($inputData['type'] == 'textarea')
                                          <textarea {{$inputData['required'] == App\Enums\StatusEnum::true->status() ? "required" :""}}  name="register_data[{{ $field_name }}]"id="text-editor" cols="30" rows="10" placeholder="{{$inputData['placeholder']}}">

                                              {{old('register_data.'.$field_name)}}
                                          </textarea>

                                          @elseif($inputData['type'] == 'file')
                                          <input  {{$inputData['required'] == App\Enums\StatusEnum::true->status() ? "required" :""}}   multiple  type="file" name="register_data[{{ $field_name }}][]" >

                                          @else

                                              <input  {{$inputData['required'] == App\Enums\StatusEnum::true->status() ? "required" :""}} type="{{$inputData['type']}}"   name="register_data[{{ $field_name }}]" value="{{old('register_data.'.$field_name)}}" id="{{$field_name}}" placeholder="{{$inputData['placeholder']}}">
                                          @endif

                                      </div>

                              </div>

                          @endif
                      @endforeach


                        @php
                            $page = App\Models\Admin\Page::whereRaw("JSON_CONTAINS(slug->'$.*', '\"terms-&-condition\"')")->first();
                        @endphp

                        @if( $page)
                            <div class="form-inner">
                                <div class="login-form-bottom">
                                    <div class="login-form-checkbox">
                                        <input  type="checkbox" value="1" name="agree"  id="terms">
                                        <label for="terms">
                                            {{translate("By completing the registration process, you agree and accept our")}} <a href="{{route('page',@get_translation($page->slug))}}">{{@get_translation($page->title)}}</a>
                                        </label>
                                    </div>
                                    
                                </div>
                            </div>
                        @endif

                  </div>



                  @if(site_settings("captcha_with_registration") == App\Enums\StatusEnum::true->status() )


                    <div class="row">

                          @if(site_settings("default_recaptcha") == App\Enums\StatusEnum::true->status())

                                  <div class="col-lg-5">
                                      <a id='genarate-captcha' class="align-middle justify-content-center pointer ">
                                          <img class="captcha-default d-inline me-2  " src="{{ route('captcha.genarate',1) }}" id="default-captcha">
                                          <i class="fa-sharp fa-light fa-rotate fs-22"></i>
                                      </a>
                                  </div>
                                  <div class="col-lg-5">
                                      <div class="form-inner">
                                      <input type="text"  required name="default_captcha_code" value="" placeholder="{{translate('Enter captcha value')}}" autocomplete="off">
                                      </div>
                                  </div>
                          @endif
                     </div>

                  @endif

                  <div class="sign-in-btn ">
                          <button  @if($googleCaptcha->status == App\Enums\StatusEnum::true->status())  class="g-recaptcha"
                          data-sitekey="{{$googleCaptcha->key}}"
                          data-callback='onSubmit'
                          data-action='register'@endif>
                              {{translate("Submit")}}
                          </button>
                  </div>
              </form>


              <div class="login-right-bottom">
                  @if($socialAuth == App\Enums\StatusEnum::true->status())
                      <div class="sign-options">
                          @foreach($mediums as $medium)
                              @php
                                  $class = "btn-primary";
                                  if($medium == 'google'){
                                      $class = "btn-danger";
                                  }
                              @endphp
                            <a href="{{route('social.login', $medium)}}" class=" sign-option  "><i class="fa-brands fa-{{$medium}} "></i> {{ucfirst($medium)}}</a>
                          @endforeach

                      </div>
                  @endif
                   <p>{{translate('Already Have An Account!!')}}
                      <a href="{{route('login')}}">
                          {{translate("Login")}} ?
                      </a>
                  </p>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>

@endsection

@if(site_settings("captcha_with_registration") == App\Enums\StatusEnum::true->status() && $googleCaptcha->status == App\Enums\StatusEnum::true->status())

    @push('script-include')
      <script src="https://www.google.com/recaptcha/api.js"></script>
    @endpush

@endif

@push('script-push')

@if(site_settings("captcha_with_registration") == App\Enums\StatusEnum::true->status() && $googleCaptcha->status == App\Enums\StatusEnum::true->status())
  <script>
    function onSubmit(token) {
      document.getElementById("registration-form").submit();
    }
  </script>
@endif

<script>
    'use strict'
    setCountryCode();
    $(document).on('click','#genarate-captcha',function(e){
        var url = "{{ route('captcha.genarate',[":randId"]) }}"
        url = (url.replace(':randId',Math.random()))
        document.getElementById('default-captcha').src = url;
        e.preventDefault()
    })
    $(document).on('click','#toggle-password',function(e){
        var passwordInput = $("#password-input");
        var passwordFieldType = passwordInput.attr('type');
            if (passwordFieldType == 'password') {
                passwordInput.attr('type', 'text');
                $("#toggle-password").removeClass('fa-duotone fa-eye eye').addClass('fa-duotone fa-eye-slash eye');
            } else {
                passwordInput.attr('type', 'password');
                $("#toggle-password").removeClass('fa-duotone fa-eye-slash eye').addClass('fa-duotone fa-eye eye');
            }
    });

    $(document).on('change', '.country-code', function () {
        setCountryCode();
    });

    function setCountryCode() {
        var code = $('.country-code').val();
        $('#phone').val(code);
    }

</script>

@endpush



