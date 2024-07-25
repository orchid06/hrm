@extends('layouts.master')
@section('content')

@push('style-include')
        <link href="{{asset('assets/frontend/css/post.css')}}" rel="stylesheet">
@endpush

@section('content')

@php
        $user = auth_user('web')->load(['runningSubscription','runningSubscription.package']);
        $schedule = false;
        if($user->runningSubscription){
            $package = $user->runningSubscription->package;
            if($package && @$package->social_access->schedule_post == App\Enums\StatusEnum::true->status()) $schedule = true;
        }

@endphp

<div class="compose-wrapper">
    <form action="{{route('user.social.post.store')}}" method="post" class="compose-form" enctype="multipart/form-data">
        @csrf
        <div class="row gy-4 gx-3 justify-content-center mt-2">
            <div class="col-xxl-8 col-xl-7 col-lg-7 col-md-6 order-md-1 order-2">
                <div class="i-card-md">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xxl-8 col-xl-12 pe-lg-4">
                                <div class="mb-4">
                                    <h4 class="card-title mb-3">{{translate('Choose Profile')}}</h4>
                                    <div class="slider-wrap mb-4">
                                        <div class="swiper choose-profile-slider justify-content-center">
                                            <ul class="nav nav-tabs style-1 border-0 swiper-wrapper flex-nowrap"
                                                role="tablist">

                                                <li class="nav-item swiper-slide" role="presentation">
                                                    <a class="nav-link pb-1 active" data-bs-toggle="tab"
                                                        href="#tab-all" aria-selected="false" role="tab"
                                                        tabindex="-1">
                                                        {{translate('All')}}
                                                    </a>
                                                </li>

                                                @foreach ($platforms as  $platform)
                                                    <li class="nav-item swiper-slide" role="presentation">
                                                        <a class="nav-link pb-1" data-bs-toggle="tab" href="#tab-{{$platform->slug}}"
                                                            aria-selected="true" role="tab">
                                                            {{$platform->name}}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="swiper-arrow swiper-button-next choose-profile-next"><i
                                                class="bi bi-chevron-right"></i></div>
                                        <div class="swiper-arrow swiper-button-prev choose-profile-prev"><i
                                                class="bi bi-chevron-left"></i></div>
                                    </div>

                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="tab-all" role="tabpanel">
                                                <div class="choose-profile-btn w-100" role="button"
                                                    data-bs-toggle="collapse" data-bs-target="#selectProfile"
                                                    aria-expanded="false" aria-controls="selectProfile">
                                                    <div class="choose-profile-left">
                                                        <i class="bi bi-person-badge"></i>
                                                        {{translate("Select a profile")}}
                                                    </div>

                                                    <span>
                                                        <i class="bi bi-chevron-down"></i>
                                                    </span>
                                                </div>

                                                <div class="collapse mt-2" id="selectProfile">

                                                    <select  name="account_id[]" multiple="multiple" class="w-100 profile-select">
                                                        @foreach ($accounts as $account )

                                                            @if($account->platform 
                                                                    && $account->platform->slug == 'facebook' 
                                                                    && $account->account_type == App\Enums\AccountType::PROFILE->value)

                                                                    @continue 
                                                            @endif

                                                            @php
                                                                $imgUrl = isValidImageUrl(@$account->account_information->avatar) 
                                                                                ?  @$account->account_information->avatar 
                                                                                : route('default.image', '200x200')
                                                            @endphp
                                                            <option @if(old('account_id') && is_array(old('account_id')) && in_array($account->id , old('account_id')))  selected @endif   value="{{$account->id}}"
                                                                data-image="{{  $imgUrl}}">
                                                                {{$account->name}}
                                                            </option>
                                                        @endforeach
                                                    </select>


                                                </div>
                                        </div>

                                        @foreach ($platforms as  $platform)
                                            <div class="tab-pane fade" id="tab-{{$platform->slug}}" role="tabpanel">
                                                <div class="choose-profile-btn w-100" role="button"
                                                        data-bs-toggle="collapse" data-bs-target="#select{{$platform->slug}}Profile"
                                                        aria-expanded="false" aria-controls="select{{$platform->slug}}Profile">
                                                        <div class="choose-profile-left">
                                                            <i class="bi bi-person-badge"></i>
                                                            {{translate("Select a profile")}}
                                                        </div>

                                                        <span>
                                                            <i class="bi bi-chevron-down"></i>
                                                        </span>
                                                </div>

                                                <div class="collapse mt-2" id="select{{$platform->slug}}Profile">
                                                    
                                                    <select  name="account_id[]" multiple="multiple" class="w-100 profile-select">
                                                        @foreach ($platform->accounts as $account )

                                                            @if($platform 
                                                                    && $platform->slug == 'facebook' 
                                                                    && $account->account_type == App\Enums\AccountType::PROFILE->value)

                                                                    @continue 
                                                            @endif
                                                            @php
                                                                $imgUrl = isValidImageUrl(@$account->account_information->avatar) 
                                                                                ?  @$account->account_information->avatar 
                                                                                : route('default.image', '200x200')
                                                            @endphp
                                                            <option  @if(old('account_id') && is_array(old('account_id')) && in_array($account->id , old('account_id')))  selected @endif  value="{{$account->id}}"
                                                                data-image="{{  $imgUrl}}">
                                                                {{$account->name}}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                        
                                                    <div class="choose-profile-body mt-2">
                                                        <div class="choose-profile-footer">
                                                            <a href="{{route('user.social.account.create',['platform' => $platform->slug])}}" class="i-btn btn--primary btn--lg capsuled">
                                                                {{translate('Create New Account')}}
                                                                <i class="bi bi-plus-lg"></i>
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach
                                    
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <h4 class="card-title mb-3">
                                        {{translate('Create your post')}}
                                    </h4>

                                    <div class="caption-wrapper">
                                        <div class="form-inner mb-0">
                                            <div class="compose-body">
                                                <textarea name="text" cols="30" rows="4"
                                                    placeholder="{{translate('Start Writing')}}" class="compose-input"
                                                    id="inputText">{{old('text')}}</textarea>

                                                <div class="compose-body-bottom">
                                                    <div class="caption-action d-flex justify-content-start">

                                                        <div class="action-item ai-modal">
                                                            <i class="bi bi-robot"></i>
                                                            <p>
                                                                {{translate("AI Assistant")}}
                                                            </p>
                                                        </div>

                                                        <div class="upload-filed">
                                                            <input id="media-file" multiple type="file"
                                                                name="files[]">
                                                            <label for="media-file">
                                                                <span
                                                                    class="d-flex align-items-center flex-row gap-2">
                                                                    <span class="upload-drop-file">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            version="1.1"
                                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                            width="512" height="512" x="0" y="0"
                                                                            viewBox="0 0 682.667 682.667"
                                                                            style="enable-background:new 0 0 512 512"
                                                                            xml:space="preserve" >
                                                                            <g>
                                                                                <defs>
                                                                                    <clipPath id="a"
                                                                                        clipPathUnits="userSpaceOnUse">
                                                                                        <path d="M0 512h512V0H0Z"
                                                                                            fill="#000000"
                                                                                            opacity="1"
                                                                                            data-original="#000000">
                                                                                        </path>
                                                                                    </clipPath>
                                                                                </defs>
                                                                                <g clip-path="url(#a)"
                                                                                    transform="matrix(1.33333 0 0 -1.33333 0 682.667)">
                                                                                    <path
                                                                                        d="M0 0a32.118 32.118 0 0 1-9.399 22.718 32.147 32.147 0 0 1-22.734 9.415h-417.734a32.147 32.147 0 0 1-22.734-9.415A32.118 32.118 0 0 1-482 0v-321.334a32.118 32.118 0 0 1 9.399-22.718 32.147 32.147 0 0 1 22.734-9.415h417.734a32.147 32.147 0 0 1 22.734 9.415A32.118 32.118 0 0 1 0-321.334z"
                                                                                        style="stroke-width:30;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                                                        transform="translate(497 416.667)"
                                                                                        fill="none" stroke="#000000"
                                                                                        stroke-width="30"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-miterlimit="10"
                                                                                        stroke-dasharray="none"
                                                                                        
                                                                                        data-original="#000000"></path>
                                                                                    <path
                                                                                        d="m0 0 160.667 160.666 64.267-64.267 128.533 128.535 96.4-96.401"
                                                                                        style="stroke-width:30;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                                                        transform="translate(47.133 63.2)"
                                                                                        fill="none" stroke="#000000"
                                                                                        stroke-width="30"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-miterlimit="10"
                                                                                        stroke-dasharray="none"
                                                                                        data-original="#000000"></path>
                                                                                    <path
                                                                                        d="M0 0c26.591 0 48.2-21.602 48.2-48.2 0-26.598-21.609-48.199-48.2-48.199S-48.2-74.798-48.2-48.2-26.591 0 0 0Z"
                                                                                        style="stroke-width:30;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                                                        transform="translate(127.467 384.533)"
                                                                                        fill="none" stroke="#000000"
                                                                                        stroke-width="30"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-miterlimit="10"
                                                                                        stroke-dasharray="none"
                                                                                        data-original="#000000">
                                                                                   </path>
                                                                                </g>
                                                                            </g>
                                                                        </svg>
                                                                    </span>
                                                                    <span>
                                                                        {{translate('Photo/Video')}}
                                                                    </span>
                                                                </span>
                                                            </label>
                                                        </div>

                                                        <div>
                                                            <select class="form-select predefined-select" aria-label="Default select example" id="predefined">
                                                                <option value="">
                                                                        {{translate("Predefined Content")}}
                                                                </option>
                    
                                                                @foreach ($contents as  $content)
                                                                    <option value="{{$content->content}}">
                                                                        {{$content->name}}
                                                                    </option>
                                                                @endforeach
                    
                                                            </select>
                                                        </div>
                                                        <ul class="file-list"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h4 class="card-title mb-3">{{translate('Links')}}</h4>
                                    <div class="input-group mb-0">
                                        <input type="text" placeholder="{{translate('Enter link')}}" name="link" id="link" value="{{old('link')}}" class="form-control" />
                                    </div>
                                </div>


                                @if($schedule)

                                    <div class="mb-0">
                                        <h4 class="card-title mb-3">{{translate('Schedule Post')}}</h4>
                                        <button class="schedule-btn" data-bs-toggle="collapse"
                                            data-bs-target="#schedule" aria-expanded="false" aria-controls="schedule"
                                            type="button">
                                            {{translate("Schedule Post")}}
                                            <i class="bi bi-plus-lg ms-2"></i>
                                        </button>
                                        <div class="collapse" id="schedule">
                                            <div class="schedule-body mt-1">
                                                <div class="schedule-content">
                                                    <div class="row g-4 align-items-end">
                                                        <div class="col-xl-12 col-md-8">
                                                            <div class="form-inner mb-0">
                                                                <input placeholder="{{translate('Select date time')}}"
                                                                    type="datetime-local" class="singleDate flatpickr-input"
                                                                    name="schedule_date"
                                                                    value="{{old('schedule_date')}}"
                                                                    id="schedule_date" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <button  type="submit"
                                    class="mt-4 i-btn btn--primary btn--lg capsuled postSubmitButton"
                                    id="postSubmitButton">
                                    {{translate("Post")}}
                                    <i class="bi bi-send"></i>
                                </button>
                                
                            </div>
                            <div class="col-xxl-4 col-xl-12">
                                <div class="side-notes bg-danger-soft">
                                    <h6 class="mb-3">Note:</h6>

                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                Facebook
                                            </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                                <div class="accordion-body">
                                                    <ul>
                                                        <li>Sign up with your email or phone number, create a unique password</li>
                                                        <li>Search for friends using the search bar,</li>
                                                        <li>Post status updates, photos, videos, and links on your timeline.</li>
                                                        <li>Find and join groups based on your interests</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Twitter
                                            </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                                                <div class="accordion-body">
                                                    <ul>
                                                        <li>Sign up with your email or phone number, create a unique password</li>
                                                        <li>Search for friends using the search bar,</li>
                                                        <li>Post status updates, photos, videos, and links on your timeline.</li>
                                                        <li>Find and join groups based on your interests</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    Instagram
                                                </button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample" style="">
                                                <div class="accordion-body">
                                                    <ul>
                                                        <li>Sign up with your email or phone number, create a unique password</li>
                                                        <li>Search for friends using the search bar,</li>
                                                        <li>Post status updates, photos, videos, and links on your timeline.</li>
                                                        <li>Find and join groups based on your interests</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingFour">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                    Tiktok
                                                </button>
                                            </h2>
                                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample" style="">
                                                <div class="accordion-body">
                                                    <ul>
                                                        <li>Sign up with your email or phone number, create a unique password</li>
                                                        <li>Search for friends using the search bar,</li>
                                                        <li>Post status updates, photos, videos, and links on your timeline.</li>
                                                        <li>Find and join groups based on your interests</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 order-md-2 order-1">
                <div class="i-card-md social-preview-user">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{translate("Network Preview")}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="slider-wrap mb-4">
                            <div class="swiper social-btn-slider mb-4 justify-content-center">
                                <ul class="nav nav-tabs style-1 border-0 swiper-wrapper flex-nowrap" role="tablist">
                                    <li class="nav-item swiper-slide" role="presentation">
                                        <a class="nav-link pb-1 active" data-bs-toggle="tab" href="#tab-preview-all"
                                            aria-selected="false" role="tab" tabindex="-1">
                                           {{translate('All')}}
                                        </a>
                                    </li>
                                    @foreach ($platforms as  $platform)
                                        <li class="nav-item swiper-slide" role="presentation">
                                            <a class="nav-link pb-1" data-bs-toggle="tab" href="#tab-preview-{{$platform->slug}}"
                                                aria-selected="true" role="tab">
                                                  {{
                                                    $platform->name
                                                  }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="swiper-arrow swiper-button-next social-btn-next"><i
                                    class="bi bi-chevron-right"></i></div>
                            <div class="swiper-arrow swiper-button-prev social-btn-prev"><i
                                    class="bi bi-chevron-left"></i></div>
                        </div>
                        <div class="col-md-12">
                            <div class="tab-content" id="preview-tabContent">
                                <div class="tab-pane fade show active" id="tab-preview-all" role="tabpanel">
                                    <div class="social-preview-body facebook mb-4">
                                        <div class="social-auth">
                                            <div class="profile-img">
                                                <img src="{{get_default_img()}}"
                                                    alt="default.jpg" />
                                            </div>

                                            <div class="profile-meta">
                                                <h6 class="user-name">
                                                    <a href="javascript:void(0)">
                                                         {{translate('Username')}}
                                                    </a>
                                                </h6>
                                                <div class="d-flex align-items-center gap-2">
                                                    <p>
                                                         {{
                                                            Carbon\Carbon::now()->format('F j')
                                                         }}
                                                    </p>
                                                    <i class="bi bi-globe-americas fs-12"></i>
                                                </div>
                                            </div>

                                            <span class="dots">
                                                <i class="bi bi-three-dots"></i>
                                            </span>
                                        </div>
                                        <div class="social-caption">
                                            <div class="caption-text">
                                                <div class="line-loader">
                                                    <div class="wrapper">
                                                        <div class="line-1"></div>
                                                        <div class="line-2"></div>
                                                        <div class="line-3"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="hash-tag"></div>

                                            <div class="caption-imgs"></div>

                                            <div class="caption-link"></div>

                                            <div class="action-count d-flex justify-content-between align-items-center">
                                                <div class="emoji d-flex align-items-center gap-2">
                                                    <ul class="d-flex gap-0 react-icon-list">
                                                        <li><img src="{{asset('assets/images/default/like.png')}}" alt="like.png"></li>
                                                        <li><img src="{{asset('assets/images/default/love.png')}}" alt="love.png"></li>
                                                        <li><img src="{{asset('assets/images/default/care.png')}}" alt="care.png"></li>
                                                    </ul>
                                                    <span class="fs-14">
                                                         {{translate("129")}}
                                                    </span>
                                                </div>
                                                <div class="comment-count py-2 px-0">
                                                    <ul class="d-flex align-items-center gap-3">
                                                        <li class="fs-14">12 {{translate('Comments')}} </li>
                                                        <li class="fs-14">8  {{translate('Shares')}}</li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="caption-action">
                                                <div class="caption-action-item">
                                                    <i class="fa-regular fa-thumbs-up"></i>
                                                    <span>
                                                         {{translate('Like')}}
                                                    </span>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-regular fa-message"></i>
                                                    <span>
                                                        
                                                        {{translate('Comment')}}
                                                    </span>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-solid fa-share"></i>
                                                    <span>
                                                         {{translate('Share')}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="social-preview-body instagram mb-4">
                                        <div class="social-auth">
                                            <div class="profile-img">
                                                <img src="{{get_default_img()}}"
                                                    alt="default.jpg" />
                                            </div>

                                            <div class="profile-meta">
                                                <h6 class="user-name">
                                                    <a href="javascript:void(0)">
                                                        {{translate('Username')}}
                                                    </a>
                                                </h6>
                                                <p>
                                                    {{
                                                        Carbon\Carbon::now()->format('F j')
                                                     }}
                                                </p>
                                            </div>

                                            <span class="dots">
                                                <i class="bi bi-three-dots"></i>
                                            </span>
                                        </div>

                                        <div class="social-caption">
                                            <div class="caption-text">
                                                <div class="line-loader">
                                                    <div class="wrapper">
                                                        <div class="line-1"></div>
                                                        <div class="line-2"></div>
                                                        <div class="line-3"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="hash-tag"></div>

                                            <div class="caption-imgs"></div>

                                            <div class="caption-link"></div>

                                            <div class="caption-action">
                                                <div class="caption-action-item">
                                                    <i class="fa-regular fa-heart"></i>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-regular fa-comment"></i>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-regular fa-paper-plane"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="social-preview-body twitter mb-4">
                                        <div class="social-auth">
                                            <div class="profile-img">
                                                <img src="{{get_default_img()}}"
                                                alt="default.jpg" />
                                            </div>

                                            <div class="profile-meta">
                                                <h6 class="user-name">
                                                    <a href="javascript:void(0)">
                                                        {{translate('Username')}}
                                                    </a>
                                                </h6>
                                                <p>
                                                    {{
                                                        Carbon\Carbon::now()->format('F j')
                                                     }}
                                                </p>
                                            </div>

                                            <span class="dots">
                                                <i class="bi bi-three-dots"></i>
                                            </span>
                                        </div>

                                        <div class="social-caption">
                                            <div class="caption-text">
                                                <div class="line-loader">
                                                    <div class="wrapper">
                                                        <div class="line-1"></div>
                                                        <div class="line-2"></div>
                                                        <div class="line-3"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="hash-tag"></div>

                                            <div class="caption-imgs"></div>

                                            <div class="caption-link"></div>

                                            <div class="caption-action">
                                                <div class="caption-action-item">
                                                    <i class="fa-regular fa-comment"></i>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-solid fa-retweet"></i>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-regular fa-heart"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="social-preview-body linkedin mb-4">
                                        <div class="social-auth">
                                            <div class="profile-img">
                                                <img src="{{get_default_img()}}"
                                                    alt="default.jpg" />
                                            </div>

                                            <div class="profile-meta">
                                                <h6 class="user-name">
                                                    <a href="javascript:void(0)">
                                                        {{translate('Username')}}
                                                    </a>
                                                </h6>
                                                <p>
                                                    {{
                                                        Carbon\Carbon::now()->format('F j')
                                                     }}
                                                </p>
                                            </div>

                                            <span class="dots">
                                                <i class="bi bi-three-dots"></i>
                                            </span>
                                        </div>

                                        <div class="social-caption">
                                            <div class="caption-text">
                                                <div class="line-loader">
                                                    <div class="wrapper">
                                                        <div class="line-1"></div>
                                                        <div class="line-2"></div>
                                                        <div class="line-3"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="hash-tag"></div>

                                            <div class="caption-imgs"></div>

                                            <div class="caption-link"></div>

                                            <div class="caption-action">
                                                <div class="caption-action-item">
                                                    <i class="fa-regular fa-thumbs-up"></i>
                                                    <span> 
                                                         {{translate('Like')}}
                                                    </span>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-regular fa-message"></i>
                                                    <span>
                                                        {{translate('Comment')}}
                                                    </span>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-solid fa-retweet"></i>
                                                    <span>
                                                         {{translate('Repost')}}
                                                    </span>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-solid fa-paper-plane"></i>
                                                    <span>
                                                         {{translate('Send')}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 
                                </div>

                                    @foreach ($platforms as  $platform)
                                    
                                            <div class="tab-pane fade" id="tab-preview-{{$platform->slug}}" role="tabpanel">


                                                @php
                                             
                                                        $postTypes = App\Enums\PostType::toArray();
                                                        if($platform->slug == 'facebook') $postTypes =  Arr::except( $postTypes,[App\Enums\PostType::STORY->name]);
                                                        if($platform->slug == 'twitter') $postTypes  =  Arr::except( $postTypes,[App\Enums\PostType::REELS->name,App\Enums\PostType::STORY->name]);
        
                                                        if($platform->slug == 'linkedin') $postTypes =  Arr::except( $postTypes,[App\Enums\PostType::REELS->name,App\Enums\PostType::STORY->name]);
        
                                                @endphp
            
            
                                                <div class="form-inner">
                                                    <label for="post_type_{{$platform->slug}}">
                                                        {{translate('Where to post')}}
                                                    </label>
                                                    <select class="form-select" name="post_type[{{$platform->slug}}]"  id="post_type_{{$platform->slug}}">
                                                        @foreach ($postTypes as  $type => $value)
                                                            <option value="{{$value}}">
                                                                {{$type}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
        

                                                <div class="social-preview-body facebook">
                                                    <div class="social-auth">
                                                        <div class="profile-img">
                                                            <img src="{{get_default_img()}}"
                                                            alt="default.jpg" />
                                                        </div>

                                                        <div class="profile-meta">
                                                            <h6 class="user-name">
                                                                <a href="javascript:void(0)">
                                                                    {{translate('Username')}}
                                                                </a>
                                                            </h6>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <p>
                                                                    {{
                                                                        Carbon\Carbon::now()->format('F j')
                                                                     }}
                                                                </p>
                                                                <i class="bi bi-globe-americas fs-12"></i>
                                                            </div>
                                                        </div>

                                                        <span class="dots">
                                                            <i class="bi bi-three-dots"></i>
                                                        </span>
                                                    </div>
                                   
                                                    <div class="social-caption">
                                                        <div class="caption-text">
                                                            <div class="line-loader">
                                                                <div class="wrapper">
                                                                    <div class="line-1"></div>
                                                                    <div class="line-2"></div>
                                                                    <div class="line-3"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="hash-tag"></div>

                                                        <div class="caption-imgs"></div>

                                                        <div class="caption-link"></div>

                                                        @if($platform->slug == 'facebook')
                                                            <div class="action-count d-flex justify-content-between align-items-center">
                                                                <div class="emoji d-flex align-items-center gap-2">
                                                                    <ul class="d-flex gap-0 react-icon-list">
                                                                        <li><img src="{{asset('assets/images/default/like.png')}}" alt="like.png"></li>
                                                                        <li><img src="{{asset('assets/images/default/love.png')}}" alt="love.png"></li>
                                                                        <li><img src="{{asset('assets/images/default/care.png')}}" alt="care.png"></li>
                                                                    </ul>
                                                                    <span class="fs-14">129</span>
                                                                </div>
                                                                <div class="comment-count py-2 px-0">
                                                                    <ul class="d-flex align-items-center gap-3">
                                                                        <li>12{{translate('Comments')}} </li>
                                                                        <li>8  {{translate('Shares')}}</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div class="caption-action">
                                                            @if($platform->slug == 'linkedin')

                                                                <div class="caption-action-item">
                                                                    <i class="fa-regular fa-thumbs-up"></i>
                                                                    <span> 
                                                                        {{translate('Like')}}
                                                                    </span>
                                                                </div>
                
                                                                <div class="caption-action-item">
                                                                    <i class="fa-regular fa-message"></i>
                                                                    <span>
                                                                        {{translate('Comment')}}
                                                                    </span>
                                                                </div>
                
                                                                <div class="caption-action-item">
                                                                    <i class="fa-solid fa-retweet"></i>
                                                                    <span>
                                                                        {{translate('Repost')}}
                                                                    </span>
                                                                </div>
                
                                                                <div class="caption-action-item">
                                                                    <i class="fa-solid fa-paper-plane"></i>
                                                                    <span>
                                                                        {{translate('Send')}}
                                                                    </span>
                                                                </div>

                                                            @elseif($platform->slug == 'twitter')

                                                                    <div class="caption-action-item">
                                                                        <i class="fa-regular fa-comment"></i>
                                                                    </div>
                    
                                                                    <div class="caption-action-item">
                                                                        <i class="fa-solid fa-retweet"></i>
                                                                    </div>
                    
                                                                    <div class="caption-action-item">
                                                                        <i class="fa-regular fa-heart"></i>
                                                                    </div>
                                                            @elseif($platform->slug == 'twitter')

                                                                    <div class="caption-action-item">
                                                                        <i class="fa-regular fa-comment"></i>
                                                                    </div>
                    
                                                                    <div class="caption-action-item">
                                                                        <i class="fa-solid fa-retweet"></i>
                                                                    </div>
                    
                                                                    <div class="caption-action-item">
                                                                        <i class="fa-regular fa-heart"></i>
                                                                    </div>
                                                            @elseif($platform->slug == 'instagram')

                                                                <div class="caption-action-item">
                                                                    <i class="fa-regular fa-heart"></i>
                                                                </div>
                
                                                                <div class="caption-action-item">
                                                                    <i class="fa-regular fa-comment"></i>
                                                                </div>
                
                                                                <div class="caption-action-item">
                                                                    <i class="fa-regular fa-paper-plane"></i>
                                                                </div>
                                                            @elseif($platform->slug == 'facebook')

                                                                <div class="caption-action-item">
                                                                    <i class="fa-regular fa-thumbs-up"></i>
                                                                    <span>
                                                                        {{translate('Like')}}
                                                                    </span>
                                                                </div>
                
                                                                <div class="caption-action-item">
                                                                    <i class="fa-regular fa-message"></i>
                                                                    <span>
                                                                        
                                                                        {{translate('Comment')}}
                                                                    </span>
                                                                </div>
                
                                                                <div class="caption-action-item">
                                                                    <i class="fa-solid fa-share"></i>
                                                                    <span>
                                                                        {{translate('Share')}}
                                                                    </span>
                                                                </div>

                                                            @endif
                                                              
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('modal')


<div class="modal fade" id="aiModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="aiModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> {{translate('Generate Content')}}
                </h5>

                <button class="icon-btn icon-btn-sm danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>


            <div class="modal-body p-0 m-0 modal-body-section">

                @include('partials.prompt_content',['content_route' => route("user.ai.content.store"),'modal' => true])

            </div>

            <div class="modal-footer">
                <button type="button" class="i-btn danger btn--lg capsuled" data-anim="ripple" data-bs-dismiss="modal">
                    {{translate("Close")}}
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script-include')
    @include('partials.ai_content_script');
    <script src="{{asset('assets/global/js/post.js')}}"></script>
@endpush


@push('script-push')
<script>
(function($) {
    "use strict";

    $(document).on('change', '#predefined', function(e) {
        e.preventDefault()
        var value = $(this).val();
        $("#inputText").val(value)
        $(".caption-text").html(value)

        e.preventDefault();

    })

    $(".user").select2({})


    $(document).on('click', '.ai-modal', function(e) {
        var modal = $('#aiModal');
        modal.find('.ai-content-form')[0].reset();
        modal.find('.ai-content-div').addClass("d-none")
        modal.find('#ai-form').fadeIn()
        modal.modal('show');

    });


    $(".select2").select2({
        placeholder:"{{translate('Select Category')}}",
        dropdownParent: $("#aiModal"),
    })
    $(".language").select2({
        placeholder:"{{translate('Select Language')}}",
        dropdownParent: $("#aiModal"),
    })

    $(".selectTemplate").select2({
        placeholder:"{{translate('Select Template')}}",
        dropdownParent: $("#aiModal"),
    })
    $(".sub_category_id").select2({
        placeholder:"{{translate('Select Sub Category')}}",
        dropdownParent: $("#aiModal"),
    })



    $(document).on('click', '.copy-content', function(e) {

        var textarea = document.getElementById('content');
        textarea.select();
        document.execCommand('copy');
        window.getSelection().removeAllRanges();

        toastr("{{translate('Text copied to clipboard!')}}", 'success');

    });

    $(document).on('click', '.download-text', function(e) {
        var content = document.getElementById('content').value;
        var blob = new Blob([content], {
            type: 'text/html'
        });
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = 'downloaded_content.html';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

 


    var swiper = new Swiper(".social-btn-slider", {
        slidesPerView: 3,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".social-btn-next",
            prevEl: ".social-btn-prev",
        },
        breakpoints: {
            640: {
                slidesPerView: 3,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 3,
            },
        },
    });

    var swiper = new Swiper(".choose-profile-slider", {
        slidesPerView: 3,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".choose-profile-next",
            prevEl: ".choose-profile-prev",
        },
        breakpoints: {
            640: {
                slidesPerView: 3,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 3,
            },
        },
    });


    function formatState(state) {
        if (!state.id) {
            return state.text;
        }
        var baseUrl = $(state.element).data('image');
        var $state = $(
            '<span class="image-option"><img src="' + baseUrl + '" class="img-flag" /> ' + state.text +
            '</span>'
        );
        return $state;
    }

    $('.profile-select').select2({
        templateResult: formatState,
        templateSelection: formatState
    });


})(jQuery);
</script>
@endpush