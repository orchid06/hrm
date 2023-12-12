@extends('admin.layouts.master')

@section('content')

@php


	$mimeTypes              = json_decode(site_settings('mime_types',[]),true);
	$awsSettings            = json_decode(site_settings('aws_s3',[]),true);
	$ftpSetttings           = json_decode(site_settings('ftp',[]),true);

	$ticketSettings         = json_decode(site_settings('ticket_settings',[]),true);
    //auth settings
	$google_recaptcha       = json_decode(site_settings('google_recaptcha',[]),true);
	$socail_login_settings  = json_decode(site_settings('social_login_with',[]),true);
	$loginAttributes        = Arr::get(config('settings'),'login_attribute', []);

    $authWith               = json_decode(site_settings('login_with'),true);

    $pusher                 = json_decode(site_settings('pusher_settings'),true);


@endphp
    <div class="basic-setting">

        <div class="basic-setting-left">
            <div class="setting-tab sticky-side-div">

                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="v-pills-basic-settings-tab" data-bs-toggle="tab" href="#v-pills-basic-settings" role="tab" aria-controls="v-pills-basic-settings" aria-selected="false" tabindex="-1">
                            <i class="las la-cog"></i> {{translate('Basic Settings')}}
                        </a>
                    </li>


                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="v-pills-basic-seo-tab" data-bs-toggle="tab" href="#v-pills-basic-seo" role="tab" aria-controls="v-pills-basic-seo" aria-selected="false" tabindex="-1">
                            <i class="las la-stream"></i>{{translate("Seo Settings")}}
                        </a>
                    </li>

                    <li class="nav-item" role="presentation">
                            <a class="nav-link " id="v-pills-logging-tab" data-bs-toggle="tab" href="#v-pills-logging" role="tab" aria-controls="v-pills-logging" aria-selected="false" tabindex="-1">
                                <i class="las la-bug"></i> {{translate('Logging')}}
                            </a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="v-pills-rateLimitting-tab" data-bs-toggle="tab" href="#v-pills-rateLimitting" role="tab" aria-controls="v-pills-rateLimitting" aria-selected="false" tabindex="-1">
                            <i class="las la-wave-square"></i> {{translate('Rate Limiting')}}
                        </a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="v-pills-basic-theme-setting-tab" data-bs-toggle="tab" href="#v-pills-basic-theme-settings" role="tab" aria-controls="v-pills-basic-theme-settings" aria-selected="false" tabindex="-1">
                            <i class="las la-palette"></i>{{translate('Theme Settings')}}
                        </a>
                    </li>

                    <li class="nav-item" role="presentation">

                        <a class="nav-link " id="v-pills-storage-tab" data-bs-toggle="tab" href="#v-pills-storage" role="tab" aria-controls="v-pills-storage" aria-selected="true">
                            <i class="las la-box"></i> {{translate('Storage Settings')}}
                        </a>
                    </li>


                    <li class="nav-item" role="presentation">

                        <a class="nav-link " id="v-pills-slack-tab" data-bs-toggle="tab" href="#v-pills-slack" role="tab" aria-controls="v-pills-slack" aria-selected="true">
                            <i class="lab la-slack"></i> {{translate('Slack Settings')}}
                        </a>
                    </li>


                


                    <li class="nav-item" role="presentation">

                        <a class="nav-link " id="v-pills-recap-tab" data-bs-toggle="tab" href="#v-pills-recap" role="tab" aria-controls="v-pills-recap" aria-selected="true">
                            <i class="las la-shield-alt"></i>	{{translate('Recaptcha Settings')}}
                        </a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="v-pills-social-login-tab" data-bs-toggle="tab" href="#v-pills-social-login" role="tab" aria-controls="v-pills-social-login" aria-selected="true">
                            <i class="las la-hashtag"></i> {{translate('Social Login Settings')}}
                        </a>
                    </li>

                 
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="v-pills-login-tab" data-bs-toggle="tab" href="#v-pills-login" role="tab" aria-controls="v-pills-login" aria-selected="true">
                            <i class="las la-sign-in-alt"></i> {{translate('Login Settings')}}
                        </a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="v-pills-ticket-settings-tab" data-bs-toggle="tab" href="#v-pills-ticket-settings" role="tab" aria-controls="v-pills-ticket-settings" aria-selected="false" tabindex="-1">
                            <i class="las la-envelope"></i> {{translate("Ticket Settings")}}
                        </a>
                    </li>

                    <li class="nav-item" role="presentation">

                        <a class="nav-link" id="v-pills-logo-tab" data-bs-toggle="tab" href="#v-pills-logo" role="tab" aria-controls="v-pills-logo" aria-selected="false" tabindex="-1">
                            <i class="las la-image"></i> {{translate('Logo Settings')}}
                        </a>
                    </li>

                </ul>
            </div>
        </div>

        <div class="basic-setting-right">
            <div id="myTabContent2" class="tab-content">
                <div class="tab-pane fade active show" id="v-pills-basic-settings" role="tabpanel" aria-labelledby="v-pills-basic-settings-tab">
                    <form class="settingsForm"   enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                              
                                    {{trans('default.general_settings')}}
                                </h4>

                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#cronjob"  class="i-btn btn--md btn--primary"> <i class="las la-key me-2"></i>
                                  
                                    {{trans('default.cron_setup')}}
                                </a>
                            </div>


                            <div class="card-body">
                               
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="site_name" class="form-label">
                                                {{translate('Site Name')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[site_name]" id="site_name"  value="{{site_settings('site_name')}}" required placeholder="{{translate("Name")}}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">

                                         <div class="form-inner">

                                            <label for="user_site_name">
                                                {{translate('User Site Name')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[user_site_name]" id="user_site_name"  value="{{site_settings('user_site_name')}}" required placeholder="{{translate("User Site Name")}}">

                                         </div>
                                      
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="phone">
                                                {{translate('Phone')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[phone]" id="phone"  value="{{site_settings('phone')}}" required placeholder="{{translate("Phone")}}">
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="email">
                                                {{translate('Email')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="email" name="site_settings[email]" id="email"  value="{{site_settings('email')}}"  placeholder="{{translate("Email")}}">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="address">
                                                {{translate('Address')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[address]" id="address"  value="{{site_settings('address')}}"  placeholder="{{translate("Address")}}">
                                        </div>
                                    </div>

                                  

                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="time_zone" class="form-label">
                                                {{translate('Time Zone')}} <small class="text-danger" >*</small>
                                            </label>

                                            <select  name="site_settings[time_zone]" id="time_zone" class=" select2 " id="time_zone">
                                                @foreach($timeZones as $timeZone)
                                                    <option value="'{{@$timeZone}}'" @if(config('app.timezone') == $timeZone) selected @endif>{{$timeZone}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="input-date_format" class="form-label">
                                                {{translate('Select Date Format')}} <small class="text-danger" >*</small>
                                            </label>

                                            <select name="site_settings[date_format]" id="input-date_format" class="select2" required>

                                                 @foreach (Arr::get(config("settings"),'date_format' ,[]) as  $date_format)
                                                   
                                                     <option {{site_settings("date_format") == $date_format ? 'selected' :"" }} value="{{$date_format}}">{{$date_format}}</option>
                                                     
                                                 @endforeach
                
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="input-time_format" class="form-label">
                                                {{translate('Select Time Format')}} <small class="text-danger" >*</small>
                                            </label>

                                            <select name="site_settings[time_format]" id="input-time_format" class="select2" required>

                                                 @foreach (Arr::get(config("settings"),'time_format' ,[]) as  $time_format)
                                                   
                                                     <option {{site_settings("time_format") == $time_format ? 'selected' :"" }} value="{{$time_format}}">{{$time_format}}</option>
                                                     
                                                 @endforeach
                
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="country" class="form-label">
                                                {{translate('Country')}} <small class="text-danger" >*</small>
                                            </label>

                                            <select   name="site_settings[country]" id="country" class=" select2 " id="country">
                                                 @foreach ($countries as $country)
                                                     <option {{site_settings('country') == $country->name ? "selected" :"" }} value="{{$country->name}}">
                                                          {{$country->name}}
                                                    </option>
                                                 @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="pagination_number" class="form-label">
                                                {{translate('Data Perpage')}} <small class="text-danger" >*</small>
                                            </label>
                                                <input type="number" min="0" name="site_settings[pagination_number]" id="pagination_number"  value="{{site_settings('pagination_number')}}" required placeholder="{{translate("Data Perpage")}}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="vistors" class="form-label">
                                                {{translate('Web Visitors')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="number" min="0" name="site_settings[vistors]" id="vistors"  value="{{site_settings('vistors')}}" required placeholder="{{translate("Site Vistors")}}">
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="form-inner">
                                            <label for="copy_right_text" class="form-label">
                                                {{translate('Copy Right Text')}} <small class="text-danger" >*</small>
                                            </label>
                                          

                                            <textarea name="site_settings[copy_right_text]" placeholder="{{translate("Copy Right Text")}}" id="copy_right_text" cols="30" rows="4">{{site_settings('copy_right_text')}}</textarea>
                                        </div>
                                    </div>





                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="google_adsense_publisher_id" class="form-label">
                                                {{translate('Google Adsense Publisher Id')}} <small class="text-danger" >*</small>
                                            </label>
                                                <input type="checkbox" class="form-check-input status-update" {{ site_settings('google_ads') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                                 
                                                data-key='google_ads'
                                                data-status='{{ site_settings('google_ads') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                                data-route="{{ route('admin.setting.update.status') }}"  >
                                               
                                          
                                            <input type="text"  name="site_settings[google_adsense_publisher_id]" id="google_adsense_publisher_id"  value="{{site_settings('google_adsense_publisher_id')}}" required placeholder="{{translate("Enter Id")}}">
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="google_analytics_tracking_id">
                                                {{translate('Google Analytics Tracking Id')}} <small class="text-danger" >*</small>
                                            </label>

                                            <input type="checkbox" class="form-check-input status-update" {{ site_settings('google_analytics') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                                 
                                            data-key='google_analytics'
                                            data-status='{{ site_settings('google_analytics') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                            data-route="{{ route('admin.setting.update.status') }}"  >

                                            <input type="text"  name="site_settings[google_analytics_tracking_id]" id="google_analytics_tracking_id"  value="{{site_settings('google_analytics_tracking_id')}}" required placeholder="{{translate("Enter Id")}}">
                                        </div>
                                    </div>

                    

                                    <div class="col-12 ">
                                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                            {{translate("Submit")}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- seo settings -->
                <div class="tab-pane fade " id="v-pills-basic-seo" role="tabpanel" aria-labelledby="v-pills-basic-seo-tab">
                    <form class="settingsForm"   enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                              
                                    {{translate("Seo Settings")}}
                      
                                </h4>

                            </div>


                            <div class="card-body">
                               
                                <div class="row">
   
                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="title_separator" class="form-label">
                                                {{translate('Title Separator')}} <small class="text-danger" >*</small>
                                            </label>
                                 
                                             <input type="text" value="{{site_settings('title_separator')}}" name="site_settings[title_separator]" id="title_separator">
                                        </div>
                                    </div>
                    
                                   
                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="site_description" class="form-label">
                                                {{translate('Site Description')}} <small class="text-danger" >*</small>
                                            </label>
                                            <textarea name="site_settings[site_description]" id="site_description" cols="30" rows="10">{{site_settings('site_description')}}</textarea>
                                        </div>
                                    </div>
                    
                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="metaKeywords" class="form-label">
                                                {{translate('Meta Keywords')}} <small class="text-danger" >*</small>
                                            </label>
                                            <select multiple name="site_settings[site_meta_keywords][]" id="metaKeywords">
                                                @if(is_array(json_decode(site_settings("site_meta_keywords"),true)))
                                                   @foreach (json_decode(site_settings("site_meta_keywords"),true) as  $keyword)
                                                       <option selected value="{{$keyword}}">{{$keyword}}</option>
                                                   @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>

                                    
                                  
                                    <div class="col-12 ">
                                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                            {{translate("Submit")}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- loggin tab content -->
                <div class="tab-pane fade" id="v-pills-logging" role="tabpanel" aria-labelledby="v-pills-logging-tab">
                    <form   class="settingsForm"   enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <div>
                                    <h4 class="card-title">
                                        {{translate('Logging')}}
                                    </h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="mb-3">
                                    {{trans('default.loggin_note')}}
                                </p>
                                <div class="row">
                                    <div class="col-xl-6 ">
                                        <div class="form-inner">
                                            <label for="sentry_dns">
                                                {{translate('Sentry Dns')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[sentry_dns]" id="sentry_dns"  value="{{site_settings('sentry_dns')}}" required placeholder="{{translate("Enter Dns")}}">
                                        </div>
                                    </div>

                                    <div class="col-xl-6 ">
                                        <div class="module-note">
                                            <h6 class="mb-2">
                                                {{translate('Information')}}
                                            </h6>
                                            <p>
                                                <a href="https://sentry.io" target="_blank">{{translate("Sentry")}}
                                                </a>
                                                <span>
                     
                                                    {{trans('default.sentry_note')}}
                                                </span>
                                            </p>
                                        </div>

                                    </div>

                                    <div class="col-12 ">
                                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                            {{translate("Submit")}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- rate limiting tab content -->
                <div class="tab-pane fade" id="v-pills-rateLimitting" role="tabpanel" aria-labelledby="v-pills-rateLimitting-tab">
                    <form   class="settingsForm"   enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('Rate Limitting')}}
                                </h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="api_route_rate_limit" class="form-label">
                                                {{translate('Api Hit limit')}} <small class="text-danger" >*({{translate('Per Minute')}})</small>
                                            </label>
                                            <input type="number" name="site_settings[api_route_rate_limit]" id="api_route_rate_limit"  value="{{site_settings('api_route_rate_limit')}}" required placeholder="api_route_rate_limit">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 ">
                                        <div class="form-inner">
                                            <label for="web_route_rate_limit" class="form-label">
                                                {{translate('Web Route limit')}} <small class="text-danger" >*({{translate('Per Minute')}})</small>
                                            </label>
                                            <input type="number" name="site_settings[web_route_rate_limit]" id="web_route_rate_limit" value="{{site_settings('web_route_rate_limit')}}" required placeholder="web_route_rate_limit">
                                        </div>
                                    </div>

                                    <div class="col-12 ">
                                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                            {{translate("Submit")}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- theme color tab content -->
                <div class="tab-pane fade" id="v-pills-basic-theme-settings" role="tabpanel"   aria-labelledby="v-pills-basic-theme-settings-tab">
                    <form  class="settingsForm" enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('Frontend Theme/Color Settings')}}
                                </h4>
                                <button class="i-btn btn--sm danger reset-color">
                                    <i class="las la-sync"></i>
                                </button>

                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="primary_color">
                                                {{translate('Primary Color')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[primary_color]" id="primary_color" class="   colorpicker" value="{{site_settings('primary_color')}}" required >
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="secondary_color">
                                                {{translate('Secondary Color')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[secondary_color]" id="secondary_color" class="   colorpicker" value="{{site_settings('secondary_color')}}" required >
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="text_primary_color">
                                                {{translate('Text Primary Color')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[text_primary]" id="text_primary" class="colorpicker" value="{{site_settings('text_primary')}}" required >
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="text_secondary_color">
                                                {{translate('Text Secondary Color')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[text_secondary]" id="text_secondary_color" class="   colorpicker" value="{{site_settings('text_secondary')}}" required>
                                        </div>
                                    </div>

                                    <div class="col-12 ">
                                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                            {{translate("Submit")}}
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>


                <!-- storage settings tab content -->
                <div class="tab-pane fade" id="v-pills-storage" role="tabpanel" aria-labelledby="v-pills-storage-tab">
                    <div class="i-card-md">
                        <div class="card--header">
                            <h4 class="card-title">
                                {{translate('Storage Settings')}}
                            </h4>
                        </div>

                        <div class="card-body">
                            <!-- Nav tabs -->
                            <div class="nav nav-tabs style-3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#local" role="tab" aria-selected="true">
                                        {{translate('local')}}
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#aws-s3" role="tab" aria-selected="false" tabindex="-1">
                                        {{translate ('Aws S3')}}
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#ftp" role="tab" aria-selected="false" tabindex="-1">
                                        {{translate ('Ftp')}}
                                    </a>
                                </li>
                             

                            </div>
                            <!-- Tab panes -->
                            <div class="tab-content text-muted">
                                <!-- local file system -->
                                <div class="tab-pane active show" id="local" role="tabpanel">
                                    <form  class="settingsForm"  data-route="{{route('admin.setting.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="d-flex align-items-center gap-3 mb-20">
                                            <label for="">{{translate('Local Storage Settings')}}</label>

                                            <div class="form-check form-switch form-switch-md" dir="ltr">
                                                <input {{ site_settings('storage') == "local" ? 'checked' :"" }} type="checkbox" class="form-check-input"
                                                value ='local'
                                                name="site_settings[storage]"  id="storage">
                                                <label class="form-check-label mb-0" for="storage"></label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-inner">
                                                    <label for="mime_types">
                                                        {{translate('Supported File Types')}}  <small class="text-danger" >*</small>
                                                    </label>
                                                    <select multiple class="select2-multi" name="site_settings[mime_types][]" id="mime_types">

                                                        @foreach(config('settings')['file_types'] as $file_type)

                                                            <option {{in_array($file_type,$mimeTypes) ? "selected" :"" }} value="{{$file_type}}">
                                                                {{$file_type}}
                                                            </option>

                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="form-inner">
                                                    <label for="max_file_upload">
                                                        {{translate('Maximum File Upload')}}  <small class="text-danger" >*
                                                            ({{translate('You Can Not Upload More Than That At a Time ')}})
                                                        </small>
                                                    </label>

                                                    <input type="number" min="1" max="10" required  value ="{{site_settings('max_file_upload')}}" name="site_settings[max_file_upload]"  type="text">
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="form-inner">
                                                    <label for="max_file_upload" class="form-label">
                                                        {{translate('Max File Upload size')}}  <small class="text-danger" >*
                                                            ({{translate('In Kilobyte')}})
                                                        </small>
                                                    </label>

                                                    <input type="number" min="1"  required  value ="{{site_settings('max_file_size')}}" name="site_settings[max_file_size]"  type="text">
                                                </div>
                                            </div>

                                            <div class="col-12 ">
                                                <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                                    {{translate("Submit")}}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- aws file system -->
                                <div class="tab-pane" id="aws-s3" role="tabpanel">
                                    <form  class="settingsForm"  data-route="{{route('admin.setting.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="d-flex align-items-center gap-3 mb-20">
                                            <label for="">{{translate('S3 Storage Settings')}}</label>
                                            <div class="form-check form-switch form-switch-md" dir="ltr">
                                                    <input {{ site_settings('storage') == "s3" ? 'checked' :"" }} type="checkbox" class="form-check-input"
                                                    value ='s3'
                                                    name="site_settings[storage]"  id="storage">
                                                    <label class="form-check-label mb-0" for="storage"></label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            @foreach($awsSettings as $awsKey => $val)
                                                <div class="col-xl-6">
                                                    <div class="form-inner">
                                                        <label for="aws_s3">
                                                            {{
                                                                ucfirst(str_replace('_',' ',$awsKey))
                                                            }}  <small class="text-danger" >*</small>
                                                        </label>
                                                        <input required type="text" min="0" name="site_settings[aws_s3][{{$awsKey}}]" id="aws_s3"  value="{{$val}}" required placeholder="**********">
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="col-12">
                                                <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                                    {{translate("Submit")}}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- ftp file system -->
                                <div class="tab-pane" id="ftp" role="tabpanel">
                                    <form  class="settingsForm"  data-route="{{route('admin.setting.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="d-flex align-items-center gap-3 mb-20">
                                            <label for=""> {{translate('Ftp Settings')}}</label>
                                            <div class="form-check form-switch form-switch-md" dir="ltr">
                                                <input {{ site_settings('storage') == "ftp" ? 'checked' :"" }} type="checkbox" class="form-check-input"
                                                value ='ftp'
                                                name="site_settings[storage]"  id="storage">
                                                <label class="form-check-label mb-0" for="storage"></label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            @foreach($ftpSetttings as $ftpKey => $val)
                                                <div class="col-xl-6">
                                                    <div class="form-inner">
                                                        <label for="ftp">
                                                            {{
                                                                ucfirst(str_replace('_',' ',$ftpKey))
                                                            }}  <small class="text-danger" >*</small>
                                                        </label>
                                                        <input required type="text" min="0" name="site_settings[ftp][{{$ftpKey}}]" id="ftp"  value="{{$val}}" required placeholder="**********">
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="col-12 ">
                                                <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                                    {{translate("Submit")}}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                        
                            </div>
                        </div>
                    </div>
                </div>


                <!-- slcak settings tab content -->
                <div class="tab-pane fade" id="v-pills-slack" role="tabpanel"   aria-labelledby="v-pills-slack-tab">
                    <form  class="settingsForm" enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('Slack Configuration')}}
                                </h4>

                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="slack_channel">
                                                {{translate("Slack Channel")}} <small class="text-danger" >({{translate("optional")}})</small>
                                            </label>
                                            <input type="text" name="site_settings[slack_channel]" id="slack_channel"  value="{{site_settings('slack_channel')}}"  placeholder="{{translate("Slack Channel")}}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="slack_web_hook_url">
                                                {{translate('Slack Web Hook Url')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[slack_web_hook_url]" id="slack_web_hook_url"  value="{{site_settings('slack_web_hook_url')}}" required placeholder="{{translate("Slack Web Hook Url")}}">
                                        </div>
                                    </div>




                                    <div class="col-12 ">
                                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                            {{translate("Submit")}}
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>


           
                <!-- google recaptcha tab content -->
                <div class="tab-pane fade" id="v-pills-recap" role="tabpanel" aria-labelledby="v-pills-recap-tab">
                    <form class="settingsForm" data-route="{{route('admin.setting.plugin.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('Recaptcha Settings')}}
                                </h4>
                            </div>

                            <div class="card-body">
                                <div class="d-flex gap-2 flex-wrap">
                                    <div class="form-group form-check form-check-success">
                                        <input {{ site_settings('default_recaptcha') == App\Enums\StatusEnum::true->status() ? 'checked' :"" }} type="checkbox" class="form-check-input status-update"

                                        data-key ='default_recaptcha'
                                        data-status ='{{ site_settings('default_recaptcha') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() :App\Enums\StatusEnum::true->status()}}'
                                        data-route="{{ route('admin.setting.update.status') }}" class="form-check-input" type="checkbox" id="defaultCaptcha" >
                                        <label class="form-check-label mb-0" for="defaultCaptcha">
                                            {{translate("Use Default Captcha")}}
                                        </label>
                                    </div>

                                    <div class="form-group form-check form-check-success">
                                        <input {{ site_settings('captcha_with_registration') == App\Enums\StatusEnum::true->status() ? 'checked' :"" }} type="checkbox" class="form-check-input status-update"

                                        data-key ='captcha_with_registration'
                                        data-status ='{{ site_settings('captcha_with_registration') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() :App\Enums\StatusEnum::true->status()}}'
                                        data-route="{{ route('admin.setting.update.status') }}" class="form-check-input" type="checkbox" id="captcha_with_registration" >
                                        <label class="form-check-label mb-0" for="captcha_with_registration">
                                            {{translate("Captcha With Registration")}}
                                        </label>
                                    </div>

                                    <div class="form-group form-check form-check-success">
                                        <input {{ site_settings('captcha_with_login') == App\Enums\StatusEnum::true->status() ? 'checked' :"" }} type="checkbox" class="form-check-input status-update"

                                        data-key ='captcha_with_login'
                                        data-status ='{{ site_settings('captcha_with_login') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() :App\Enums\StatusEnum::true->status()}}'
                                        data-route="{{ route('admin.setting.update.status') }}" class="form-check-input" type="checkbox" id="captcha_with_login" >
                                        <label class="form-check-label mb-0" for="captcha_with_login">
                                            {{translate("Captcha With Login")}}
                                        </label>
                                    </div>

                                </div>

                                <div class="mt-20">
                                    <h6 class="mb-20">
                                        {{translate('Google Recaptcha (V3)')}}
                                    </h6>

                                    <div class="row google-captcha">
                                        @foreach($google_recaptcha as $key => $settings)
                                            <div class="col-xl-6">
                                                <div class="form-inner">
                                                    <label for="{{$key}}" class="form-label">
                                                        {{
                                                            Str::ucfirst(str_replace("_"," ",$key))
                                                        }}  <small class="text-danger" >*</small>
                                                    </label>
                                                    @if($key == 'status')
                                                    <select class="select2"  name='site_settings[google_recaptcha][{{$key}}]' class="select2"  id="{{$key}}" >
                                                        @foreach( App\Enums\StatusEnum::toArray() as $key => $val)
                                                            <option {{$settings ==  $val ? 'selected' :""}}  value="{{$val}}">
                                                                {{$key}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @else
                                                    <input id="{{$key}}" required  value="{{$settings}}" name='site_settings[google_recaptcha][{{$key}}]' placeholder="************" type="text">
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="col-12 ">
                                            <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                                {{translate("Submit")}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>

                <!-- socail login tab content -->
                <div class="tab-pane fade" id="v-pills-social-login" role="tabpanel" aria-labelledby="v-pills-social-login-tab">
                    <form  class="settingsForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('Socail Login Setup')}}
                                </h4>
                            </div>
                            <div class="card-body">
                                @foreach($socail_login_settings  as $medium => $settings)
                                    <div class="mb-10">
                                        <h6>
                                            {{ ucWords(str_replace('_',' ',$medium))}}
                                        </h6>
                                        <div class="mt-30">
                                            @php
                                                $social_settings = ($settings);
                                            @endphp

                                            <div class="row">
                                                @foreach( $settings as $key => $val)
                                                    <div class="col-xl-6">
                                                        <div class="form-inner">
                                                            <label for="{{$key}}">
                                                                {{
                                                                    Str::ucfirst(str_replace("_"," ",$key))
                                                                }}  <small class="text-danger" >*</small>
                                                            </label>

                                                            @if($key == 'status')
                                                                <select class="form-select" name="site_settings[social_login_with][{{$medium}}][{{$key}}]" id="{{$key}}">
                                                                    <option {{$val == App\Enums\StatusEnum::true->status() ? "selected" :""}} value="{{App\Enums\StatusEnum::true->status()}}">
                                                                        {{translate('Active')}}
                                                                    </option>
                                                                    <option {{$val == App\Enums\StatusEnum::false->status() ? "selected" :""}} value="{{App\Enums\StatusEnum::false->status()}}">
                                                                        {{translate('Inactive')}}
                                                                    </option>
                                                                </select>

                                                            @else
                                                                <input required  value="{{$val}}" name='site_settings[social_login_with][{{$medium}}][{{$key}}]' placeholder="************" type="text">
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <div class="col-xl-6">
                                                    <div class="form-inner">
                                                        <label for="callbackUrl">
                                                            {{translate('Callback Url')}}
                                                        </label>

                                                        <div class="input-group">
                                                            <input id="callbackUrl" readonly value="{{route('auth.social.login.callback',str_replace("_oauth","",$medium))}}" type="text" class="form-control" >
                                                            <span class="input-group-text pointer copy-text pointer"  data-text ="{{route('auth.social.login.callback',str_replace("_oauth","",$medium))}}" ><i class="las la-copy"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div>
                                    <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                        {{translate("Submit")}}
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>


                <!-- Login settings tab content -->
                <div class="tab-pane fade" id="v-pills-login" role="tabpanel" aria-labelledby="v-pills-login-tab">
                    <form data-route="{{route('admin.setting.store')}}"  class="settingsForm"  method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('User Login Settings')}}
                                </h4>
                            </div>

                            <div class="card-body">
                               
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-inner">
                                            <label for="loginWith">
                                                {{translate('Login With')}}
                                                <small class="text-danger" >*</small>
                                            </label>
                                            <select class="select2" required multiple id="loginWith" name="site_settings[login_with][]">
                                                @foreach($loginAttributes  as $auth )
                                                        <option @if(in_array($auth ,$authWith?? [] )) selected @endif   value="{{$auth}}">{{$auth}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    @if(site_settings('login_attempt_validation') == App\Enums\StatusEnum::true->status())
                                        <div class="col-lg-6">
                                            <div class="form-inner">
                                                <label for="max_login_attemtps">
                                                    {{translate('Maximum Login Attempts')}} <small class="text-danger" >*({{translate('Per Minute')}})</small>
                                                </label>
                                                <input type="number" name="site_settings[max_login_attemtps]" id="max_login_attemtps"  value="{{site_settings('max_login_attemtps')}}" required placeholder="max_login_attemtps">
                                            </div>
                                        </div>
                                    @endif


                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="otp_expired_in">
                                                {{translate('Otp expired in')}} <small class="text-danger" >*({{translate('Second')}})</small>
                                            </label>
                                            <input type="number" name="site_settings[otp_expired_in]" id="otp_expired_in"  value="{{site_settings('otp_expired_in')}}" required placeholder="{{translate("Otp expired in")}}">
                                        </div>
                                    </div>


                                        
                                    <div class="col-lg-12 d-none otp-activation">
                                        <div class="form-inner">

                                            <label for="otpVerification">
                                                {{translate('Mobile Otp Verification')}}
                                                <span class="text-danger" >*</span>
                                            </label>

                                            <select class="select2" name="site_settings[sms_otp_verification]" id="otpVerification">

                                                @foreach( App\Enums\StatusEnum::toArray() as $key => $val)
                                                    <option {{site_settings('sms_otp_verification') ==  $val ? 'selected' :""}}  value="{{$val}}">
                                                        {{$key}}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div>
                                    <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                        {{translate("Submit")}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                  <!-- ticket settings tab content -->
                  <div class="tab-pane fade" id="v-pills-ticket-settings" role="tabpanel" aria-labelledby="v-pills-ticket-settings-tab">
                    <form data-route="{{route('admin.setting.ticket.store')}}"  class="settingsForm"  method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('Ticket Settings')}}
                                </h4>

                                <div class="action">
                                    <button id="add-ticket-option" class="i-btn btn--sm success">
                                        <i class="las la-plus me-1"></i>   {{translate('Add More')}}
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <!-- Table Foot -->
                                <div class="table-container">
                                    <table class="align-middle">
                                        <thead class="table-light ">
                                            <tr>
                                                <th scope="col">
                                                    {{translate('Labels')}}
                                                </th>

                                                <th scope="col">
                                                    {{translate('Type')}}
                                                </th>
                                                <th scope="col">
                                                    {{translate('Mandatory/Required')}}
                                                </th>

                                                <th scope="col">
                                                    {{translate('Placeholder')}}
                                                </th>

                                                <th scope="col">
                                                    {{translate('Action')}}
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody id="ticketField">
                                            @foreach ($ticketSettings as $ticketInput)
                                             <tr>
                                                <td data-label="{{translate("Label")}}">
                                                    <div class="form-inner mb-0">
                                                        <input type="text" name="custom_inputs[{{$loop->index}}][labels]"  value="{{$ticketInput['labels']}}">
                                                    </div>
                                                </td>

                                                <td data-label="{{translate("Type")}}">
                                                    <div class="form-inner mb-0">

                                                        @if($ticketInput['default'] == App\Enums\StatusEnum::true->status())
                                                            <input disabled type="text" name="custom_inputs[type]"  value="{{$ticketInput['type']}}">
                                                            <input type="hidden" name="custom_inputs[{{$loop->index}}][type]"  value="{{$ticketInput['type']}}">
                                                        @else
                                                        <select class="select2" name="custom_inputs[{{$loop->index}}][type]" >
                                                            @foreach(['file','textarea','text','date','email'] as $type)
                                                                <option {{$ticketInput['type'] == $type ?'selected' :""}} value="{{$type}}">
                                                                    {{ucfirst($type)}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @endif

                                                    </div>
                                                </td>

                                                <td  data-label="{{translate("Required")}}" >
                                                    <div class="form-inner mb-0">
                                                        @if($ticketInput['default'] == App\Enums\StatusEnum::true->status() && $ticketInput['type'] != 'file' )
                                                            <input disabled  type="text" name="custom_inputs[required]"  value="{{$ticketInput['required'] == App\Enums\StatusEnum::true->status()? 'Yes' :"No"}}">
                                                            <input hidden  type="text" name="custom_inputs[{{$loop->index}}][required]"  value="{{$ticketInput['required']}}">
                                                        @else
                                                            <select class="form-select" name="custom_inputs[{{$loop->index}}][required]" >
                                                                <option {{$ticketInput['required'] == App\Enums\StatusEnum::true->status() ?'selected' :""}} value="{{App\Enums\StatusEnum::true->status()}}">
                                                                    {{translate('Yes')}}
                                                                </option>
                                                                <option {{$ticketInput['required'] == App\Enums\StatusEnum::false->status() ?'selected' :""}} value="{{App\Enums\StatusEnum::false->status()}}">
                                                                    {{translate('No')}}
                                                                </option>
                                                            </select>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td  data-label="{{translate("Placeholder")}}">
                                                    <div class="form-inner mb-0">
                                                        <input type="text" name="custom_inputs[{{$loop->index}}][placeholder]"  value="{{$ticketInput['placeholder']}}">
                                                    </div>
                                                    <input   type="hidden" name="custom_inputs[{{$loop->index}}][default]"  value="{{$ticketInput['default']}}">
                                                    <input   type="hidden" name="custom_inputs[{{$loop->index}}][multiple]"  value="{{$ticketInput['multiple']}}">
                                                    <input   type="hidden" name="custom_inputs[{{$loop->index}}][name]"  value="{{$ticketInput['name']}}">

                                                </td>

                                                <td data-label="{{translate("Option")}}">
                                                    @if($ticketInput['default'] == App\Enums\StatusEnum::true->status())
                                                        {{translate('N/A')}}
                                                        @else
                                                        <div>
                                                            <a href="javascript:void(0);" class="pointer icon-btn danger delete-option">
                                                                <i class="las la-trash-alt"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>

                                <div class="mt-20">
                                    <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                        {{translate("Submit")}}
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>


                <!-- logo settings tab  -->
                <div class="tab-pane fade" id="v-pills-logo" role="tabpanel" aria-labelledby="v-pills-logo-tab">
                    <form  data-route="{{route('admin.setting.logo.store')}}"  class="settingsForm"  method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('Logo Settings')}}
                                </h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                  
                                    @foreach (Arr::get(config('settings'),'logo_keys' ,[]) as $logoKey )

                                        <div class="col-lg-6">
                                            <div class="form-inner">
                                                <label for="{{$logoKey}}">
                                                    {{(k2t($logoKey))}} <small class="text-danger" >* ({{config("settings")['file_path'][$logoKey]['size']}})</small>
                                                </label>
                                                <input type="file" name="site_settings[{{$logoKey}}]" id="{{$logoKey}}" class=" preview" data-size = {{config("settings")['file_path'][$logoKey]['size']}}>
                                                <div class="mt-2 image-preview-section">
                                                    
                                                    <img src="{{imageUrl(@site_logo($logoKey)->file,$logoKey,true)}}" alt="{{@site_settings($logoKey)}}" class="fav-preview">
                                                </div>
                                            </div>
                                        </div>
                                        
                                    @endforeach



                                    <div class="col-12">
                                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                            {{translate("Submit")}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('modal')

<div class="modal fade" id="cronjob" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable  modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-icon" >
                    {{translate('Cron Job Setup')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label for="queue_url" class="form-label">{{translate('Queue')}} <span class="text-danger">* {{translate('Set time for 1 minute')}}</span></label>

                    <div class="input-group">
                        <input readonly class="form-control" value="curl -s {{route('queue.work')}}">
                        <button data-type="modal"  data-text ="curl -s {{route('queue.work')}}" class="copy-text btn btn-info" type="button"><i class="las la-copy"></i></button>
                    </div>

                </div>

                <div class="mb-3">
                    <label for="queue_url" class="form-label">{{translate('Cron Job ')}} <span class="text-danger">* {{translate('Set time for 1 minute')}}</span></label>

                    <div class="input-group">
                        <input readonly class="form-control" value="curl -s {{route('cron.run')}}">
                        <button data-type="modal" data-text ="curl -s {{route('cron.run')}}" class="copy-text btn btn-info" type="button"><i class="las la-copy"></i></button>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="i-btn btn--md ripple-dark" anim="ripple" data-bs-dismiss="modal">
                    {{translate("Close")}}
                </button>

            </div>
        </div>
    </div>
</div>

@endsection

@push('style-include')

<link href="{{asset('assets/global/css/colorpicker.min.css')}}" rel="stylesheet">

@endpush
@push('script-include')
    <script src="{{asset('assets/global/js/colorpicker.min.js')}}"></script>
@endpush
@push('script-push')

<script>
  "use strict";
       $('.colorpicker').colorpicker();

	    check_login_settings($('#loginWith').val())


        $(".select2").select2({
			laceholder:"{{translate('Select Option')}}",
	    })
        $(".select2-multi").select2({
			laceholder:"{{translate('Select Option')}}",
	    })


        $("#metaKeywords").select2({
            placeholder:"{{translate('Enter Keywords')}}",
            tags: true,
            tokenSeparators: [',']
        })

		$(document).on('click','.reset-color',function(e){

			$("[name='site_settings[primary_color]']").val("{{Arr::get(config('site_settings'),'primary_color','#673ab7')}}")
			$("[name='site_settings[secondary_color]']").val("{{Arr::get(config('site_settings'),'secondary_color','#ba6cff')}}")
			$("[name='site_settings[text_primary]']").val("{{Arr::get(config('site_settings'),'text_primary','#26152e')}}");
			$("[name='site_settings[text_secondary]']").val("{{Arr::get(config('site_settings'),'text_secondary','#777777')}}")
			toastr("{{translate('Successfully Reseted To Base Color')}}",'success')

		});

		

		// update seettings
		$(document).on('change','#loginWith',function(e){

			check_login_settings($(this).val())
			e.preventDefault();
		});


		function check_login_settings(loginAttribute){
			$('.otp-activation').addClass('d-none');
			if(Array.isArray(loginAttribute) && loginAttribute.length == 1 ){

				if(loginAttribute.includes("phone")){
					$('.otp-activation').removeClass('d-none')
				}
			}
		}



        var count = "{{count($ticketSettings)-1}}";

		// add more ticket option
		$(document).on('click','#add-ticket-option',function(e){
			count++
			var html = `<tr>
							<td data-label="{{translate("label")}}">
                                <div class="form-inner mb-0">
								  <input placeholder="{{translate("Enter Label")}}" type="text" name="custom_inputs[${count}][labels]" >
                                </div>
							</td>

							<td data-label="{{translate("Type")}}">
                                <div class="form-inner mb-0">
                                    <select class="form-select" name="custom_inputs[${count}][type]" >
                                        <option value="text">Text</option>
                                        <option value="email">Email</option>
                                        <option value="number">Number</option>
                                        <option value="date">Date</option>
                                        <option value="textarea">Textarea</option>
                                    </select>
                                </div>
							</td>

							<td data-label="{{translate("Required")}}">
                                <div class="form-inner mb-0">
                                    <select class="form-select" name="custom_inputs[${count}][required]" >
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
							</td>

							<td data-label="{{translate("placeholder")}}">
                                <div class="form-inner mb-0">
                                    <input placeholder="{{translate("Enter Placeholder")}}"  type="text" name="custom_inputs[${count}][placeholder]" >
                                    <input  type="hidden" name="custom_inputs[${count}][default]"  value="0">
                                    <input  type="hidden" name="custom_inputs[${count}][multiple]"  value="0">
                                    <input  type="hidden" name="custom_inputs[${count}][name]"  value="">
                                </div>
							</td>

							<td data-label='{{translate("Option")}}'>
							   <div >
                                    <a href="javascript:void(0);" class="pointer icon-btn danger delete-option">
                                         <i class="las la-trash-alt"></i>
                                    </a>
                                </div>
							</td>

						</tr>`;
				$('#ticketField').append(html)

			e.preventDefault()
		})

        //delete ticket options
		$(document).on('click','.delete-option',function(e){
			$(this).closest("tr").remove()
			count--
			e.preventDefault()
		})


</script>
@endpush
