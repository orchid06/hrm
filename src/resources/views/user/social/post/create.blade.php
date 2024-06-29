@extends('layouts.master')
@section('content')

@push('style-include')
    <link href="{{asset('assets/frontend/css/post.css')}}" rel="stylesheet">
    <link href="{{asset('assets/global/css/datepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@section('content')

@php

      $user = auth_user('web');

      $schedule = false;
      if( $user->runningSubscription){
          $package = $user->runningSubscription->package;

        if($package && @$package->social_access->schedule_post == App\Enums\StatusEnum::true->status()){
            $schedule = true;
        }
      }

@endphp

<div class="compose-wrapper">
    <form action="{{route('user.social.post.store')}}" method="post" class="compose-form" enctype="multipart/form-data">
        @csrf
        <div class="row gy-4">
            <div class="col-xxl-8">
                <div class="i-card-md">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xxl-6">
                                <div class="mb-0">
                                    <div class="card-header">
                                        <h4 class="card-title">{{translate('Choose Profile')}}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="slider-wrap mb-4">
                                            <div class="swiper choose-profile-slider justify-content-center">
                                                <ul class="nav nav-tabs style-1 justify-content-start border-0 swiper-wrapper flex-nowrap" role="tablist">
                                                    <li class="nav-item swiper-slide" role="presentation">
                                                        <a class="nav-link pb-1 active" data-bs-toggle="tab" href="#tab-one" aria-selected="false" role="tab" tabindex="-1">All</a>
                                                    </li>
                                                    <li class="nav-item swiper-slide" role="presentation">
                                                        <a class="nav-link pb-1" data-bs-toggle="tab" href="#tab-two" aria-selected="true" role="tab">Facebook</a>
                                                    </li>
                                                    <li class="nav-item swiper-slide" role="presentation">
                                                        <a class="nav-link pb-1" data-bs-toggle="tab" href="#tab-three" aria-selected="true" role="tab">Instagram</a>
                                                    </li>
                                                    <li class="nav-item swiper-slide" role="presentation">
                                                        <a class="nav-link pb-1" data-bs-toggle="tab" href="#tab-four" aria-selected="true" role="tab">Twitter</a>
                                                    </li>
                                                    <li class="nav-item swiper-slide" role="presentation">
                                                        <a class="nav-link pb-1" data-bs-toggle="tab" href="#tab-five" aria-selected="true" role="tab">Linkedin</a>
                                                    </li>
                                                    <li class="nav-item swiper-slide" role="presentation">
                                                        <a class="nav-link pb-1" data-bs-toggle="tab" href="#tab-six" aria-selected="true" role="tab">You Tube</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="swiper-arrow swiper-button-next choose-profile-next"><i class="bi bi-chevron-right"></i></div>
                                            <div class="swiper-arrow swiper-button-prev choose-profile-prev"><i class="bi bi-chevron-left"></i></div>
                                        </div>

                                        <div id="myTabContent3" class="tab-content">
                                            <div class="tab-pane fade active show" id="tab-one" role="tabpanel">
                                                <ul class="selected-profile"></ul>
                                                <div class="choose-profile-btn w-100" role="button" data-bs-toggle="collapse" data-bs-target="#selectProfile" aria-expanded="false" aria-controls="selectProfile">
                                                    <div class="choose-profile-left">
                                                        <i class="bi bi-person-badge"></i>
                                                        {{translate("Select a profile")}}
                                                    </div>

                                                    <span>
                                                        <i class="bi bi-chevron-down"></i>
                                                    </span>
                                                </div>

                                                <div class="collapse mt-2" id="selectProfile">

                                                <select id="profile-select" multiple="multiple" style="width: 100%;">
                                                    <option value="1" data-image="https://i.ibb.co/VHmD5nt/user2.jpg">Raju Ahmed</option>
                                                    <option value="2" data-image="https://i.ibb.co/VHmD5nt/user2.jpg">Kamrul Hasan</option>
                                                    <option value="3" data-image="https://i.ibb.co/VHmD5nt/user2.jpg">polash</option>
                                                    <option value="3" data-image="https://i.ibb.co/VHmD5nt/user2.jpg">Rakibul Islam</option>
                                                    <option value="3" data-image="https://i.ibb.co/VHmD5nt/user2.jpg">Nafiz Khan</option>
                                                    <option value="3" data-image="https://i.ibb.co/VHmD5nt/user2.jpg">Anamul Haque</option>
                                                    <option value="3" data-image="https://i.ibb.co/VHmD5nt/user2.jpg">Rayhan Ulla</option>
                                                    <option value="3" data-image="https://i.ibb.co/VHmD5nt/user2.jpg">Nurul Amin</option>
                                                    <option value="3" data-image="https://i.ibb.co/VHmD5nt/user2.jpg">Nasif Ahmed</option>
                                                    <option value="3" data-image="https://i.ibb.co/VHmD5nt/user2.jpg">Shakil Khan</option>
                                                </select>


                                                    <div class="choose-profile-body">

                                                        <ul class="profile-list mt-3" data-simplebar>
                                                            @foreach ($accounts as $account )
                                                                <li class="profile-item">
                                                                    <label for="account-{{$account->id}}">
                                                                        <span class="profile-item-meta">
                                                                            <span class="profile-item-img">
                                                                                <img class="rounded-circle avatar-md"  src='{{@$account->account_information->avatar }}' alt="{{translate('profile.jpg')}}">
                                                                            </span>

                                                                            <span class="d-flex flex-column">
                                                                                <small class="account-name">
                                                                                    {{$account->name}}
                                                                                </small>
                                                                                <small>{{$account->platform->name}}</small>
                                                                            </span>
                                                                        </span>

                                                                        <input @if(old('account_id') && in_array($account->id,@old('account_id'))) checked @endif name="account_id[]" id="account-{{$account->id}}" value="{{$account->id}}" class="form-check-input check_account mt-0" name="selected-profile" type="checkbox"
                                                                        data-id="{{$account->id}}"
                                                                        data-account_name="{{$account->name}}"
                                                                        data-platform_image="{{imageURL(@$account->platform->file,"platform",true)}}"
                                                                        data-profile_image = "{{@$account->account_information->avatar}}">
                                                                    </label>
                                                                </li>
                                                            @endforeach
                                                        </ul>

                                                        <div class="choose-profile-footer">
                                                            <a href="{{route('user.social.account.list')}}" class="i-btn btn--primary btn--lg capsuled">
                                                                {{translate('Create New Account')}}
                                                                <i class="bi bi-plus-lg"></i>
                                                            </a>

                                                            <button class="i-btn btn--sm  capsuled bg-danger-solid text--light" type="button" data-bs-toggle="collapse" data-bs-target="#selectProfile" aria-expanded="false" aria-controls="selectProfile">
                                                                <i class="bi bi-x-lg text-white"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab-two" role="tabpanel">
                                                
                                            </div>
                                            <div class="tab-pane fade" id="tab-three" role="tabpanel">
                                                
                                            </div>
                                            <div class="tab-pane fade" id="tab-four" role="tabpanel">
                                                
                                            </div>
                                            <div class="tab-pane fade" id="tab-five" role="tabpanel">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                        {{translate('Create your post')}}
                                        </h4>
                                    </div>

                                    <div class="card-body">
                                        <div class="caption-wrapper">
                                            <div class="form-inner mb-0">
                                                <div class="compose-body">
                                                <textarea name="text"
                                                    cols="30"
                                                    rows="4"
                                                    placeholder="Start Writing "
                                                    class="compose-input bg-light"
                                                    id="inputText">{{old('text')}}</textarea>

                                                <div class="compose-body-bottom">
                                                    <div class="caption-action">
                                                        <div class="action-item" data-bs-toggle="modal" data-bs-target="#aiModal">
                                                            <i class="bi bi-robot"></i>
                                                            <p>
                                                                {{translate("AI Assistant")}}
                                                            </p>
                                                        </div>

                                                            <div class="upload-filed">
                                                                <input id="media-file" multiple type="file"
                                                                    name="files[]">
                                                                <label for="media-file">
                                                                    <span class="d-flex align-items-center flex-row gap-2">
                                                                        <span class="upload-drop-file">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 682.667 682.667" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><defs><clipPath id="a" clipPathUnits="userSpaceOnUse"><path d="M0 512h512V0H0Z" fill="#000000" opacity="1" data-original="#000000"></path></clipPath></defs><g clip-path="url(#a)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)"><path d="M0 0a32.118 32.118 0 0 1-9.399 22.718 32.147 32.147 0 0 1-22.734 9.415h-417.734a32.147 32.147 0 0 1-22.734-9.415A32.118 32.118 0 0 1-482 0v-321.334a32.118 32.118 0 0 1 9.399-22.718 32.147 32.147 0 0 1 22.734-9.415h417.734a32.147 32.147 0 0 1 22.734 9.415A32.118 32.118 0 0 1 0-321.334z" style="stroke-width:30;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(497 416.667)" fill="none" stroke="#000000" stroke-width="30" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path><path d="m0 0 160.667 160.666 64.267-64.267 128.533 128.535 96.4-96.401" style="stroke-width:30;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(47.133 63.2)" fill="none" stroke="#000000" stroke-width="30" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path><path d="M0 0c26.591 0 48.2-21.602 48.2-48.2 0-26.598-21.609-48.199-48.2-48.199S-48.2-74.798-48.2-48.2-26.591 0 0 0Z" style="stroke-width:30;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(127.467 384.533)" fill="none" stroke="#000000" stroke-width="30" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path></g></g></svg>
                                                                        </span>
                                                                        <span>
                                                                            {{translate('Upload image')}}
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                            <ul class="file-list"></ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <div class="card-header">
                                        <h4 class="card-title">{{translate('Links')}}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="input-group mb-0">
                                            <input
                                            type="text"
                                            placeholder="Enter link"
                                            name="link"
                                            id="link"
                                            value="{{old('link')}}"
                                            class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6">
                                <div class="mb-0">
                                    <div class="card-header d-block">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4 class="card-title">{{translate('Schedule Post')}}</h4>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="content-category" class="select-custom">
                                                    <option>Immediately</option>
                                                    <option>Schedule Post</option>
                                                    <option>Category Three</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @if( $schedule)
                                            <button class="schedule-btn" data-bs-toggle="collapse" data-bs-target="#schedule" aria-expanded="false"
                                                aria-controls="schedule"
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
                                                                    <input placeholder="{{translate('Select date time')}}" type="text" class="singleDate flatpickr-input"
                                                                        name="schedule_date"
                                                                        value="{{old('schedule_date')}}"
                                                                        id="schedule_date"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row mt-5 mb-4">
                                            <div class="col-md-12">
                                                <div class="form-inner">
                                                    <label for="schedule_date">Time Post</label>
                                                    <input placeholder="{{translate('Select date time')}}" type="text" class="singleDate flatpickr-input"
                                                        name="schedule_date"
                                                        value="{{old('schedule_date')}}"
                                                        id="time_post"/>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-inner">
                                                    <label for="interval">Interval Per Post(minute)</label>
                                                    <input placeholder="Interval" id="interval" type="text" name="interval"/>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-inner">
                                                    <label for="interval">Repost frequency per day</label>
                                                    <input placeholder="Repost" id="interval" type="text" name="interval"/>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-inner">
                                                    <label for="schedule_date">Repost until</label>
                                                    <input placeholder="{{translate('Select date time')}}" type="text" class="singleDate flatpickr-input"
                                                        name="schedule_date"
                                                        value="{{old('schedule_date')}}"
                                                        id="repost"/>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="i-btn btn--primary btn--lg capsuled postSubmitButton" id="postSubmitButton">
                                            {{translate("Post")}}
                                                <i class="bi bi-send"></i>      
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    

            <div class="col-xxl-4 col-xl-6 col-md-6">
                <div class="i-card-md social-preview-user">
                    <div class="card-header">
                        <h4 class="card-title">
                        {{translate("Network Preview")}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="slider-wrap mb-4">
                            <div class="swiper social-btn-slider mb-4 justify-content-center">
                                <ul class="nav nav-tabs style-1 justify-content-start border-0 swiper-wrapper flex-nowrap" role="tablist">
                                    <li class="nav-item swiper-slide" role="presentation">
                                        <a class="nav-link pb-1 active" data-bs-toggle="tab" href="#tab-preview-one" aria-selected="false" role="tab" tabindex="-1">All</a>
                                    </li>
                                    <li class="nav-item swiper-slide" role="presentation">
                                        <a class="nav-link pb-1" data-bs-toggle="tab" href="#tab-preview-two" aria-selected="true" role="tab">Facebook</a>
                                    </li>
                                    <li class="nav-item swiper-slide" role="presentation">
                                        <a class="nav-link pb-1" data-bs-toggle="tab" href="#tab-preview-three" aria-selected="true" role="tab">Instagram</a>
                                    </li>
                                    <li class="nav-item swiper-slide" role="presentation">
                                        <a class="nav-link pb-1" data-bs-toggle="tab" href="#tab-preview-four" aria-selected="true" role="tab">Twitter</a>
                                    </li>
                                    <li class="nav-item swiper-slide" role="presentation">
                                        <a class="nav-link pb-1" data-bs-toggle="tab" href="#tab-preview-five" aria-selected="true" role="tab">Linkedin</a>
                                    </li>
                                    <li class="nav-item swiper-slide" role="presentation">
                                        <a class="nav-link pb-1" data-bs-toggle="tab" href="#tab-preview-six" aria-selected="true" role="tab">Tiktok</a>
                                    </li>
                                    <li class="nav-item swiper-slide" role="presentation">
                                        <a class="nav-link pb-1" data-bs-toggle="tab" href="#tab-preview-seven" aria-selected="true" role="tab">You Tube</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="swiper-arrow swiper-button-next social-btn-next"><i class="bi bi-chevron-right"></i></div>
                            <div class="swiper-arrow swiper-button-prev social-btn-prev"><i class="bi bi-chevron-left"></i></div>
                        </div>


                        <div class="col-md-12">
                            <div class="tab-content" id="preview-tabContent">
                                <!-- @foreach ($platforms as $platform )
                                    <div class="tab-pane fade {{$loop->index ==  0 ? 'show active' :''}} " id="{{$platform->slug}}" role="tabpanel"    aria-labelledby="{{$platform->slug}}-tab" tabindex="0">
                                        <div class="social-preview-body {{$platform->slug}}">
                                            <div class="social-auth">
                                                <div class="profile-img">
                                                    <img
                                                    src="{{get_default_img()}}"

                                                    alt="{{get_default_img()}}"/>
                                                </div>

                                                <div class="profile-meta">
                                                    <h6 class="user-name">
                                                        <a href="javascript:void(0)">
                                                            {{translate("Username")}}
                                                        </a>
                                                    </h6>
                                                    @php
                                                        $currentDate   = Carbon\Carbon::now();
                                                        $formattedDate = $currentDate->format('M j');
                                                    @endphp
                                                    <div class="d-flex align-items-center gap-2">
                                                        <p>
                                                            {{$formattedDate}}
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
                                                            <li><img src="https://i.ibb.co/8dQF08Y/like.png" alt="like"></li>
                                                            <li><img src="https://i.ibb.co/8XNyprT/love.png" alt="love"></li>
                                                            <li><img src="https://i.ibb.co/F8mtm0r/care.png" alt="care"></li>
                                                        </ul>
                                                        <span class="fs-14">129</span>
                                                    </div>
                                                    <div class="comment-count py-2 px-0">
                                                        <ul class="d-flex align-items-center gap-3">
                                                            <li><a href="#" class="fs-13 text--light">12 Comments</a></li>
                                                            <li><a href="#" class="fs-13 text--light">8 Shares</a></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="caption-action">
                                                    @if($platform->slug == 'facebook')
                                                        <div class="caption-action-item">
                                                            <i class="fa-regular fa-thumbs-up"></i>
                                                            <span> {{translate("Like")}}</span>
                                                        </div>

                                                        <div class="caption-action-item">
                                                            <i class="fa-regular fa-message"></i>
                                                            <span>
                                                                {{translate("Comment")}}
                                                            </span>
                                                        </div>

                                                        <div class="caption-action-item">
                                                            <i class="fa-solid fa-share"></i>
                                                            <span>
                                                                {{translate("Share")}}
                                                            </span>
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

                                                        @elseif($platform->slug == 'linkedin')

                                                        <div class="caption-action-item">
                                                            <i class="fa-regular fa-thumbs-up"></i>
                                                            <span>  {{translate("Like")}}</span>
                                                        </div>

                                                        <div class="caption-action-item">
                                                            <i class="fa-regular fa-message"></i>
                                                            <span>
                                                                {{translate("Comment")}}
                                                            </span>
                                                        </div>

                                                        <div class="caption-action-item">
                                                            <i class="fa-solid fa-retweet"></i>
                                                            <span>{{translate("Repost")}}</span>
                                                        </div>

                                                        <div class="caption-action-item">
                                                            <i class="fa-solid fa-paper-plane"></i>
                                                            <span>
                                                                {{translate("Send")}}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach -->

                                <div class="tab-pane fade show active" id="tab-preview-one" role="tabpanel">
                                    <div class="social-preview-body facebook mb-4">
                                        <div class="social-auth">
                                            <div class="profile-img">
                                                <img src="http://localhost/EngageHub/assets/images/default/default.jpg" alt="http://localhost/EngageHub/assets/images/default/default.jpg" />
                                            </div>

                                            <div class="profile-meta">
                                                <h6 class="user-name">
                                                    <a href="javascript:void(0)">
                                                        Username
                                                    </a>
                                                </h6>
                                                <div class="d-flex align-items-center gap-2">
                                                    <p>
                                                        May 6
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
                                                        <li><img src="https://i.ibb.co/8dQF08Y/like.png" alt="like" /></li>
                                                        <li><img src="https://i.ibb.co/8XNyprT/love.png" alt="love" /></li>
                                                        <li><img src="https://i.ibb.co/F8mtm0r/care.png" alt="care" /></li>
                                                    </ul>
                                                    <span class="fs-14">129</span>
                                                </div>
                                                <div class="comment-count py-2 px-0">
                                                    <ul class="d-flex align-items-center gap-3">
                                                        <li><a href="#" class="fs-13 text--light">12 Comments</a></li>
                                                        <li><a href="#" class="fs-13 text--light">8 Shares</a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="caption-action">
                                                <div class="caption-action-item">
                                                    <i class="fa-regular fa-thumbs-up"></i>
                                                    <span> Like</span>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-regular fa-message"></i>
                                                    <span>
                                                        Comment
                                                    </span>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-solid fa-share"></i>
                                                    <span>
                                                        Share
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="social-preview-body instagram">
                                        <div class="social-auth">
                                            <div class="profile-img">
                                                <img src="http://localhost/EngageHub/assets/images/default/default.jpg" alt="http://localhost/EngageHub/assets/images/default/default.jpg" />
                                            </div>

                                            <div class="profile-meta">
                                                <h6 class="user-name">
                                                    <a href="javascript:void(0)">
                                                        Username
                                                    </a>
                                                </h6>
                                                <p>
                                                    May 6
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
                                </div>

                                <div class="tab-pane fade" id="tab-preview-two" role="tabpanel">
                                    <div class="social-preview-body facebook">
                                        <div class="social-auth">
                                            <div class="profile-img">
                                                <img src="http://localhost/EngageHub/assets/images/default/default.jpg" alt="http://localhost/EngageHub/assets/images/default/default.jpg" />
                                            </div>

                                            <div class="profile-meta">
                                                <h6 class="user-name">
                                                    <a href="javascript:void(0)">
                                                        Username
                                                    </a>
                                                </h6>
                                                <div class="d-flex align-items-center gap-2">
                                                    <p>
                                                        May 6
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
                                                        <li><img src="https://i.ibb.co/8dQF08Y/like.png" alt="like" /></li>
                                                        <li><img src="https://i.ibb.co/8XNyprT/love.png" alt="love" /></li>
                                                        <li><img src="https://i.ibb.co/F8mtm0r/care.png" alt="care" /></li>
                                                    </ul>
                                                    <span class="fs-14">129</span>
                                                </div>
                                                <div class="comment-count py-2 px-0">
                                                    <ul class="d-flex align-items-center gap-3">
                                                        <li><a href="#" class="fs-13 text--light">12 Comments</a></li>
                                                        <li><a href="#" class="fs-13 text--light">8 Shares</a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="caption-action">
                                                <div class="caption-action-item">
                                                    <i class="fa-regular fa-thumbs-up"></i>
                                                    <span> Like</span>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-regular fa-message"></i>
                                                    <span>
                                                        Comment
                                                    </span>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-solid fa-share"></i>
                                                    <span>
                                                        Share
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tab-preview-three" role="tabpanel">
                                    <div class="social-preview-body instagram">
                                        <div class="social-auth">
                                            <div class="profile-img">
                                                <img src="http://localhost/EngageHub/assets/images/default/default.jpg" alt="http://localhost/EngageHub/assets/images/default/default.jpg" />
                                            </div>

                                            <div class="profile-meta">
                                                <h6 class="user-name">
                                                    <a href="javascript:void(0)">
                                                        Username
                                                    </a>
                                                </h6>
                                                <p>
                                                    May 6
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
                                </div>

                                <div class="tab-pane fade" id="tab-preview-four" role="tabpanel">
                                    <div class="social-preview-body twitter">
                                        <div class="social-auth">
                                            <div class="profile-img">
                                                <img src="http://localhost/EngageHub/assets/images/default/default.jpg" alt="http://localhost/EngageHub/assets/images/default/default.jpg" />
                                            </div>

                                            <div class="profile-meta">
                                                <h6 class="user-name">
                                                    <a href="javascript:void(0)">
                                                        Username
                                                    </a>
                                                </h6>
                                                <p>
                                                    May 6
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
                                </div>

                                <div class="tab-pane fade" id="tab-preview-five" role="tabpanel">
                                    <div class="social-preview-body linkedin">
                                        <div class="social-auth">
                                            <div class="profile-img">
                                                <img src="http://localhost/EngageHub/assets/images/default/default.jpg" alt="http://localhost/EngageHub/assets/images/default/default.jpg" />
                                            </div>

                                            <div class="profile-meta">
                                                <h6 class="user-name">
                                                    <a href="javascript:void(0)">
                                                        Username
                                                    </a>
                                                </h6>
                                                <p>
                                                    May 6
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
                                                    <span> Like</span>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-regular fa-message"></i>
                                                    <span>
                                                        Comment
                                                    </span>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-solid fa-retweet"></i>
                                                    <span>Repost</span>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-solid fa-paper-plane"></i>
                                                    <span>
                                                        Send
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tab-preview-six" role="tabpanel">
                                    <div class="social-preview-body tiktok">
                                        <div class="profile-img">
                                            <img src="http://localhost/EngageHub/assets/images/default/default.jpg" alt="http://localhost/EngageHub/assets/images/default/default.jpg" />
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
                                                    <i class="fa-solid fa-heart"></i>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-solid fa-comment-dots"></i>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-solid fa-share"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-preview-seven" role="tabpanel">
                                    <div class="social-preview-body youtube">
                                        <div class="social-caption">
                                            <div class="hash-tag"></div>

                                            <div class="caption-imgs"></div>

                                            <div class="caption-text">
                                                <div class="line-loader">
                                                    <div class="wrapper">
                                                        <div class="line-1"></div>
                                                        <div class="line-2"></div>
                                                        <div class="line-3"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="caption-action">
                                                <div class="caption-action-item">
                                                    <i class="fa-regular fa-thumbs-up"></i>
                                                    <span> Like</span>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-regular fa-thumbs-down"></i>
                                                    <span> Unlike</span>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-solid fa-share"></i>
                                                    <span>
                                                        Share
                                                    </span>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-solid fa-download"></i>
                                                    <span>Download</span>
                                                </div>

                                                <div class="caption-action-item">
                                                    <i class="fa-regular fa-bookmark"></i>
                                                    <span>
                                                        Save
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="social-auth">
                                                <div class="profile-img">
                                                    <img src="http://localhost/EngageHub/assets/images/default/default.jpg" alt="http://localhost/EngageHub/assets/images/default/default.jpg" />
                                                </div>

                                                <div class="profile-meta">
                                                    <h6 class="user-name">
                                                        <a href="javascript:void(0)">
                                                            Voice of Books
                                                        </a>
                                                    </h6>
                                                    <p>
                                                        May 6
                                                    </p>
                                                </div>

                                                <span class="dots">
                                                    <h6 class="text-danger text-upppercase fs-13">SUBSCRIBE</h6>
                                                </span>
                                            </div>

                                            <div class="caption-link"></div>
                                        </div>
                                    </div>
                                </div>
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


<div class="modal fade" id="aiModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="aiModal"   aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                   <i class="fa-solid fa-wand-magic-sparkles"></i>  {{translate('Generate Content')}}
                </h5>

                <button class="icon-btn icon-btn-sm danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

                @php
                    $generateRoute = route('admin.ai.template.content.generate');
                    $iconClass  = "las la-question-circle";

                    if(request()->routeIs('user.*')){
                        $generateRoute  =  route('user.ai.content.generate');
                        $iconClass      = "bi bi-info-circle";
                    }
                @endphp


                <div class="modal-body">
                    <form id="ai-form" data-route="{{$generateRoute}}" class="ai-content-form">
                        @csrf
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="form-inner mb-0">
                                    <label for="category">
                                        {{translate('Category')}} <small class="text-danger">*</small>
                                    </label>
                                    <select required name="category_id" id="category" class="select2" >
                                        <option value="" >
                                            {{translate("Select Category")}}
                                        </option>
                                        @foreach($categories as $category)
                                            <option {{old("category_id") ==  $category->id ? "selected" :""}} value="{{$category->id}}">
                                                {{($category->title)}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner mb-0">
                                    <label for="sub_category_id">
                                        {{translate('Sub Category')}}
                                    </label>
                                    <select  name="sub_category_id" id="sub_category_id" class="sub_category_id" >
                                        <option value="" >
                                            {{translate("Select One")}}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner mb-0">
                                    <label for="templates">
                                            {{translate("Templates")}}
                                    </label>
                                    <select name="id" class="selectTemplate" id="templates">


                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                    <div class="form-inner mb-0">
                                        <label for="language">
                                            {{translate('Select input & output language')}} <small class="text-danger">*</small>
                                        </label>

                                        <select name="language" class="language" id="language">
                                            @foreach ($languages as $language )
                                                <option {{session()->get('locale') == $language->code ? "selected" :"" }} value="{{$language->name}}">
                                                    {{$language->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                            </div>
                        </div>

                        <div class="row mt-4 d-none template-prompt">

                        </div>

                        <div class="mt-4">
                            <div class="modal-aiwrap faq-wrap">
                                    <div class="accordion" id="advanceOption">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="advanceContent">
                                                <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#advanceAcc"
                                                aria-expanded="true"
                                                aria-controls="advanceAcc">
                                                    {{translate("Advance Options")}}
                                                    <i title="{{translate('Browse More Fields')}}" class="ms-1 {{$iconClass}}"></i>
                                                </button>
                                            </h2>
                                            <div id="advanceAcc" class="accordion-collapse collapse {{request()->routeIs('user.*') ? 'show' :''}}" aria-labelledby="advanceContent" data-bs-parent="#advanceOption">
                                                <div class="accordion-body">
                                                    <div class="form-inner">
                                                        <label for="max_result">
                                                            {{translate("Max Results Length")}} <i title="{{translate('Maximum words for each result')}}" class="ms-1 pointer {{$iconClass}}"></i>
                                                            @if(request()->routeIs('user.*'))
                                                                <span class="text-danger">*</span>
                                                            @endif
                                                        </label>
                                                        <input placeholder="{{translate('Enter number')}}" type="number" id="max_result" min="1" name="max_result"  value='{{old("max_result")}}' >
                                                    </div>

                                                    <div class="form-inner">
                                                        <label for="ai_creativity">{{ translate('Ai Creativity Level') }}
                                                        <small class="text-danger" >*</small></label>
                                                        <select class="ai_creativity form-select" id="ai_creativity" name="ai_creativity" >
                                                            <option  value="">
                                                                {{translate("Select Creativity")}}
                                                            </option>
                                                            @foreach (Arr::get(config('settings'),'default_creativity',[]) as $k => $v )
                                                                <option  value="{{$v}}" >
                                                                    {{ $k }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-inner">
                                                        <label for="content_tone">{{ translate('Content Tone') }} <small class="text-danger" >*</small></label>
                                                        <select  class="content_tone form-select" id="content_tone" name="content_tone">
                                                                <option value="">
                                                                    {{translate("Select Tone")}}
                                                                </option>
                                                                @foreach (Arr::get(config('settings'),'ai_default_tone',[]) as $v )
                                                                        <option {{old("content_tone") == $v ? 'selected' :""}} value="{{$v}}">
                                                                            {{ $v }}
                                                                        </option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <div class="generate-btn d-none {{request()->routeIs('user.*') ? 'mt-4':''}}">
                                <button type="submit" class="ai-btn i-btn btn--primary btn--lg capsuled">
                                    {{translate("Generate")}}
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="content-form  d-none ai-content-div">
                        <div class="form-inner">
                             <div class="d-flex gap-2 align-items-center mb-3">

                                    <label for="content" class="mb-0">
                                        {{translate("Content")}} <small class="text-danger">*</small>
                                    </label>
                                    <button data-toggle="tooltip" data-placement="top" title="{{translate('Copy')}}" class="icon-btn icon-btn-sm success copy-content">
                                        <i class="bi bi-clipboard-check"></i>
                                    </button>

                                    <button data-toggle="tooltip" data-placement="top" title="{{translate('Download')}}" class="icon-btn icon-btn-sm info download-text">
                                        <i class="bi bi-download"></i>
                                    </button>
                             </div>

                            <textarea placeholder="Enter Your Content" name="content" id="content" cols="30" rows="10"></textarea>
                        </div>
                    </div>

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
     <script src="{{asset('assets/global/js/datepicker/moment.min.js')}}"></script>
  <script src="{{asset('assets/global/js/datepicker/daterangepicker.min.js')}}"></script>
    <script src="{{asset('assets/global/js/datepicker/init.js')}}"></script>

@endpush


@push('script-push')
<script>

	(function($){
       	"use strict";

        $(document).on('keyup','#searchProfile',function(e){
            e.preventDefault()
            var value = $(this).val().toLowerCase();

            $(".profile-item").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });

            e.preventDefault();

        })

        $(document).on('change','#predefined',function(e){
            e.preventDefault()
            var value = $(this).val();
            $("#inputText").val(value)
            $(".caption-text").html(value)

            e.preventDefault();

        })
        $(".user").select2({
            
        })

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


        $(document).on('click','.copy-content',function(e){

            var textarea = document.getElementById('content');
            textarea.select();
            document.execCommand('copy');
            window.getSelection().removeAllRanges();

            toastr("{{translate('Text copied to clipboard!')}}", 'success');

        });

        $(document).on('click','.download-text',function(e){
            var content = document.getElementById('content').value;
            var blob = new Blob([content], { type: 'text/html' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'downloaded_content.html';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // flatpickr("#schedule_date", {
        //     dateFormat: "Y-m-d H:i",
        //     enableTime: true,
        // });

        // flatpickr("#time_post", {
        //     dateFormat: "Y-m-d H:i",
        //     enableTime: true,
        // });

        // flatpickr("#repost", {
        //     dateFormat: "Y-m-d H:i",
        //     enableTime: true,
        // });

        // Choose Profiles
        $(document).on('click','.check_account',function(e) {
            var accountName = $(this).attr('data-account_name');
            var platformName = $(this).attr('data-platform_name');
            var profile_image =  $(this).attr('data-profile_image');
            var platform_image =  $(this).attr('data-platform_image');

            var id = $(this).attr('data-id');

            var html = `<li id="list-account-${id}" class="selected-profile-item">
                <div class="post-profile">
                    <div class="post-profile-img">
                        <img src="${profile_image}" alt="${profile_image}">
                    </div>

                    <span class="channel-icon">
                        <img src="${platform_image}" alt="${platform_image}">
                    </span>
                </div>


                <p> ${accountName} <span data-id=${id} class="account_remove"><i class="bi bi-x-lg"></i></span></p>
            </li>`;


            if ($(this).is(':checked')) {
               $(".selected-profile").append(html);
            }else{
                $(`#list-account-${id}`).remove()
            }


            if ($(".selected-profile").children().length >= 0) {
                $(".selected-profile").addClass('mb-2');
            }else{
                $(".selected-profile").removeClass('mb-2');
            }

        });

        $(document).on('click','.account_remove',function(e) {
            var remove_id = $(this).attr('data-id');
            $(`#account-${remove_id}`).prop('checked', false);
            $(this).parent().parent().remove();

        });

   var swiper = new Swiper(".social-btn-slider", {
      slidesPerView: 4,
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
          slidesPerView: 4,
        },
        768: {
          slidesPerView: 4,
        },
        1024: {
            slidesPerView: 4,
        },
      },
    });

    var swiper = new Swiper(".choose-profile-slider", {
      slidesPerView: 4,
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
          slidesPerView: 4,
        },
        768: {
          slidesPerView: 4,
        },
        1024: {
            slidesPerView: 4,
        },
      },
    });


    function formatState (state) {
    if (!state.id) {
        return state.text;
    }
    var baseUrl = $(state.element).data('image');
    var $state = $(
        '<span class="image-option"><img src="' + baseUrl + '" class="img-flag" /> ' + state.text + '</span>'
    );
    return $state;
    }

    $('#profile-select').select2({
        templateResult: formatState,
        templateSelection: formatState
    });


	})(jQuery);

</script>
@endpush
