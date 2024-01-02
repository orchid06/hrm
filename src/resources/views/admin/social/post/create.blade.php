@extends('admin.layouts.master')

@push('style-include')
    <link href="{{asset('assets/backend/css/post.css')}}" rel="stylesheet">
    <link href="{{asset('assets/global/css/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')

<div class="compose-wrapper">
    <form action="{{route('admin.social.post.store')}}" method="post" class="compose-form" enctype="multipart/form-data">
        @csrf
        <div class="row gy-4">
          <div class="col-xl-7">
            <div class="i-card-md">
              <div class="card--header">
                    <h4 class="card-title">
                    {{translate('Create your post')}}
                    </h4>
              </div>

              <div class="card-body">
                <div class="caption-wrapper">
                  <div class="form-inner">
                    <div class="compose-body mb-3">
                      <textarea name="text"
                        cols="30"
                        rows="4"
                        placeholder="Start Writing "
                        class="compose-input"
                        id="inputText">{{old('text')}}</textarea>

                      <div class="compose-body-bottom">
                          <div class="caption-action">

                              <div class="action-item i-badge info" data-bs-toggle="collapse" data-bs-target="#hashtag"
                              aria-expanded="false"
                              aria-controls="hashtag"
                              role="button">
                                  <i class="bi bi-credit-card-2-front"></i>
                                  <p>
                                      {{translate('Predefined Content')}}
                                  </p>
                              </div>

                              <div class="action-item i-badge success" data-bs-toggle="modal" data-bs-target="#aiModal">
                                  <i class="bi bi-robot"></i>
                                  <p>
                                      {{translate("AI Assistant")}}
                                  </p>
                              </div>
                          </div>
                      </div>
                    </div>

                    <div class="collapse" id="hashtag">
                      <div class="i-card-md">
                        <div class="card-body">
                          <div class="form-inner">
                            <label for="predefined">
                                {{translate('Predefined Content')}}
                            </label>
                            <select class="form-select" aria-label="Default select example" id="predefined">
                                  <option value="">
                                        {{translate("Select Content")}}
                                  </option>

                                  @foreach ($contents as  $content)
                                      <option value="{{$content->content}}">
                                          {{$content->name}}
                                      </option>
                                  @endforeach

                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-inner">
                    <label for="media-file" class="form-label">
                        {{translate("Images")}}
                    </label>

                    <div class="upload-filed">
                      <input id="media-file" multiple type="file"
                        name="files[]"  />
                      <label for="media-file">
                        <span
                          class="d-flex align-items-center flex-column gap-2">
                          <span class="upload-drop-file">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              version="1.1"
                              xmlns:xlink="http://www.w3.org/1999/xlink"
                              x="0"
                              y="0"
                              viewBox="0 0 512 512"
                              xml:space="preserve">
                              <g>
                                <linearGradient
                                  id="a"
                                  x1="234.996"
                                  x2="234.996"
                                  y1="451"
                                  y2="61"
                                  gradientUnits="userSpaceOnUse">
                                  <stop
                                    offset="0"
                                    stop-color="#ffc2cc"
                                    class="color3"></stop>
                                  <stop
                                    offset="1"
                                    class="color4"
                                    stop-color="#fff2f4"></stop>
                                </linearGradient>

                                <linearGradient
                                  id="b"
                                  x1="256"
                                  x2="256"
                                  y1="496"
                                  y2="16"
                                  gradientUnits="userSpaceOnUse">
                                  <stop offset="0" class="color1"></stop>
                                  <stop offset="1" class="color2"></stop>
                                </linearGradient>

                                <path
                                  fill="url(#a)"
                                  d="M407 316c8.401 0 15-6.601 15-15v-18.9L347 121l-129.529 32.382C223.49 144.034 227 132.923 227 121c0-33.091-26.924-60-60-60s-60 26.909-60 60c0 22.448 12.398 42.039 30.694 52.327L107 181 2.999 376.3C9 393.699 25.499 406 45 406h272c8.401 0 15-6.601 15-15 0-41.4 33.6-75 75-75zm51.094 53.892-28.916-28.799c-5.467-6.82-14.24-10.005-22.178-10.005-9.284 0-17.894 4.554-21.094 8.804l-29.707 29.722c-12.512 11.823-11.826 31.632-.557 42.217C361.15 417.66 368.943 421 377 421c0 16.816 13.184 30 30 30s30-13.184 30-30c8.35 0 16.26-3.457 20.801-8.613 12.323-11.646 12.09-31.35.293-42.495z"
                                  opacity="1"
                                  data-original="url(#a)"></path>

                                <path
                                  fill="url(#b)"
                                  d="M328.715 165.626 422 282.1V61c0-24.853-20.147-45-45-45H45C20.147 16 0 36.147 0 61v300c0 5.4.901 10.499 2.999 15.3l122.29-150.635c6.002-7.516 17.426-7.521 23.434-.01l42.564 53.204c6.005 7.506 17.421 7.506 23.426 0l90.58-113.226c6.003-7.504 17.415-7.507 23.422-.007zM167 166c-24.901 0-45-20.101-45-45 0-24.901 20.099-45 45-45s45 20.099 45 45c0 24.899-20.099 45-45 45zm240 120c-57.9 0-105 47.1-105 105s47.1 105 105 105 105-47.1 105-105-47.1-105-105-105zm40.499 115.499c-5.396 6-15.6 6.002-20.999 0l-4.501-4.2V421c0 8.399-6.599 15-15 15s-15-6.601-15-15v-23.701l-4.501 4.2c-5.7 6-15.298 6-20.999 0-6-5.7-6-15.3 0-21l30-30c4.464-5.582 16.131-6.087 20.999 0l30 30c6.002 5.7 6.002 15.3.001 21z"
                                  opacity="1"
                                  data-original="url(#b)"></path>
                              </g>
                            </svg>
                          </span>

                          <span>
                              {{translate('Upload image')}}
                          </span>
                        </span>
                      </label>
                    </div>
                    <ul class="file-list"></ul>
                  </div>

                  <div class="form-inner">
                    <label for="link">
                      {{translate('Links')}}
                    </label>
                    <div class="input-group mb-0">
                          <input
                          type="text"
                          placeholder="Enter link"
                          name="link"
                          id="link"
                          name="link"
                          value="{{old('link')}}"
                          class="form-control"/>
                          <span class="input-group-text"><i class="bi bi-link-45deg fs-4"></i></span>
                    </div>
                  </div>

                  <div class="form-inner">
                      <label>
                        {{translate('Choose Profile')}}
                      </label>

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
                           <div class="choose-profile-body">
                              <div class="px-3">
                                  <div class="input-group">
                                      <input placeholder="Search profile"  type="search" id="searchProfile" class="form-control">

                                  </div>
                              </div>

                              <ul class="profile-list mt-3" data-simplebar>
                                    @foreach ($accounts as $account)

                                        <li class="profile-item">
                                            <label for="account-{{$account->id}}">
                                                <div class="profile-item-meta">
                                                    <div class="profile-item-img">
                                                        <img class="rounded-circle avatar-md"  src='{{@$account->account_information->avatar }}' alt="{{@$account->account_information->avatar}}">
                                                    </div>

                                                    <div>
                                                        <h6 class="account-name">
                                                            {{$account->name}}
                                                        </h6>

                                                        <a href="{{route('admin.social.account.create',['platform' => $account->platform->slug])}}">
                                                            {{$account->platform->name}}
                                                        </a>

                                                    </div>
                                                </div>

                                                <input @if(old('account_id') && in_array($account->id,@old('account_id'))) checked @endif name="account_id[]" data-id="{{$account->id}}" id="account-{{$account->id}}" value="{{$account->id}}" class="form-check-input mt-0 check_account" name="selected-profile" type="checkbox"
                                                data-account_name="{{$account->name}}" data-platform_name="{{$account->platform->name}}"
                                                data-image="{{imageUrl(@$account->platform->file,"platform",true)}}">

                                            </label>
                                        </li>
                                    @endforeach
                              </ul>

                              <div class="choose-profile-footer">
                                  <a href="{{route('admin.social.account.list')}}" class="i-btn btn--md btn--primary btn--outline">
                                      <i class="bi bi-plus-lg me-1"></i>
                                      {{translate('Create New Account')}}
                                  </a>

                                    <button class="i-btn btn--md btn--danger" type="button" data-bs-toggle="collapse" data-bs-target="#selectProfile" aria-expanded="false" aria-controls="selectProfile">
                                         <i class="bi bi-x-lg"></i>
                                    </button>
                              </div>
                           </div>
                       </div>

                  </div>

                  <div class="form-inner mt-5 mb-0">
                      <div
                        class="d-flex align-items-end flex-wrap gap-md-4 gap-3">

                        <button type="submit" class="i-btn btn--lg btn--primary btn--outline">
                                 {{translate("Post Now")}}
                                <i class="bi bi-send ms-2"></i>
                        </button>

                        <button class="i-btn btn--primary btn--lg" data-bs-toggle="collapse" data-bs-target="#schedule" aria-expanded="false"
                              aria-controls="schedule"
                              type="button">
                          {{translate("Schedule Post")}}
                          <i class="bi bi-plus-lg ms-2"></i>
                        </button>
                      </div>

                      <div class="collapse mt-3" id="schedule">
                        <div class="schedule-body">
                            <div class="schedule-content">
                              <div class="row g-4 align-items-end">
                                <div class="col-xl-8 col-md-9">
                                  <div class="form-inner mb-0">
                                    <label for="schedule_date">
                                        {{translate("Set Date & Time")}}
                                    </label>
                                    <input placeholder="{{translate('Select date time')}}" type="text" class="singleDate flatpickr-input"
                                      name="schedule_date"
                                      value="{{old("schedule_date")}}"
                                      id="schedule_date"/>
                                  </div>
                                </div>

                                <div class="col-xl-4 col-md-3">
                                      <button class="i-btn btn--md btn--danger" type="button" data-bs-toggle="collapse" data-bs-target="#schedule" aria-expanded="false"
                                      aria-controls="schedule">
                                        <i class="bi bi-x-lg fs-5"></i>
                                    </button>
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

          <div class="col-xl-5">
            <div class="i-card-md social-preview">
              <div class="card--header">
                <h4 class="card-title">
                  {{translate("Network Preview")}}
                </h4>
              </div>

              <div class="card-body">
                <p>
                  {{
                      trans('default.preview_text')
                  }}
                </p>

                <div class="row gy-4 mt-5">
                  <div class="col-md-2">
                    <div class="pre-tab-list">
                      <div class="nav" role="tablist" id="preview-tab" aria-orientation="horizontal">

                        @foreach ($platforms as $platform )
                          <a class="nav-link pre-tab-item {{$loop->index ==  0 ? 'active' :''}}" id="{{$platform->slug}}-tab" data-bs-toggle="pill"href="#{{$platform->slug}}" role="tab" aria-controls="{{$platform->slug}}"
                            aria-selected="false"
                            tabindex="-1">
                              <div class="channel-img" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{$platform->slug}} preview">
                                <img src="{{imageUrl(@$platform->file,"platform",true)}}" alt="{{imageUrl(@$platform->file,"platform",true)}}"/>
                              </div>
                          </a>
                        @endforeach

                      </div>
                    </div>
                  </div>

                  <div class="col-md-10">
                    <div class="tab-content" id="preview-tabContent">

                      @foreach ($platforms as $platform )
                        <div class="tab-pane fade {{$loop->index ==  0 ? 'show active' :''}} " id="{{$platform->slug}}" role="tabpanel" aria-labelledby="{{$platform->slug}}-tab" tabindex="0">
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
                                <p>
                                  {{$formattedDate}}
                                </p>
                              </div>

                              <span class="dots"
                                ><i class="bi bi-three-dots"></i
                              ></span>
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
                                    @if($platform->slug == 'facebook')
                                          <div class="caption-action-item">
                                            <i class="las la-thumbs-up"></i>
                                            <span>  {{translate("Like")}}</span>
                                          </div>

                                          <div class="caption-action-item">
                                            <i class="las la-comment"></i>
                                            {{translate("Comment")}}
                                          </div>

                                          <div class="caption-action-item">
                                            <i class="las la-share-square"></i>
                                              <span>
                                                  {{translate("Share")}}
                                              </span>
                                          </div>
                                      @elseif($platform->slug == 'instagram')

                                          <div class="caption-action-item">
                                              <i class="las la-heart"></i>
                                          </div>

                                          <div class="caption-action-item">
                                            <i class="las la-comment"></i>
                                          </div>

                                          <div class="caption-action-item">
                                              <i class="lab la-telegram-plane"></i>
                                          </div>

                                      @elseif($platform->slug == 'twitter')

                                          <div class="caption-action-item">
                                              <i class="las la-comment"></i>
                                          </div>

                                          <div class="caption-action-item">
                                            <i class="las la-retweet"></i>
                                          </div>

                                          <div class="caption-action-item">
                                            <i class="las la-heart"></i>
                                          </div>


                                        @elseif($platform->slug == 'linkedin')

                                        <div class="caption-action-item">
                                          <i class="las la-thumbs-up"></i>
                                          <span>  {{translate("Like")}}</span>
                                        </div>

                                        <div class="caption-action-item">
                                          <i class="las la-sms"></i>
                                          <span>
                                            {{translate("Comment")}}
                                          </span>
                                        </div>

                                        <div class="caption-action-item">
                                          <i class="las la-retweet"></i>
                                          <span>{{translate("Repost")}}</span>
                                        </div>

                                        <div class="caption-action-item">
                                          <i class="lab la-telegram-plane"></i>
                                          <span>
                                            {{translate("Send")}}
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
                    {{translate('Generate Content')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
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
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-inner">
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
                                <div class="form-inner">
                                    <label for="sub_category">
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
                                <div class="form-inner">
                                    <label for="templates">
                                            {{translate("Templates")}}
                                    </label>
                                    <select name="id" class="selectTemplate" id="templates">


                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                    <div class="form-inner">
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

                        <div class="row d-none template-prompt">

                        </div>

                        <div class="row">
                            <div class="col-lg-12">

                                <div class="faq-wrap style-2">
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
                                                            <input placeholder="{{translate('Enter number')}}" type="number" min="1" name="max_result"  value='{{old("max_result")}}' >
                                                        </div>

                                                        <div class="form-inner">
                                                            <label for="ai_creativity" class="form-label">{{ translate('Ai Creativity Level') }}
                                                            <small class="text-danger" >*</small></label>
                                                            <select class="ai_creativity" id="ai_creativity" name="ai_creativity" >
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
                                                            <label for="content_tone" class="form-label">{{ translate('Content Tone') }} <small class="text-danger" >*</small></label>
                                                            <select  class="content_tone" id="content_tone" name="content_tone">
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

                            </div>

                            <div class="col-lg-12 generate-btn d-none {{request()->routeIs('user.*') ? 'mt-3':''}}">
                                <button type="submit" class="ai-btn i-btn btn--primary btn--lg">
                                    {{translate("Generate")}}
                                </button>
                            </div>

                        </div>
                    </form>

                    <div  class="content-form  d-none ai-content-div">

                        <div class="col-lg-12">
                            <div class="form-inner">
                                <label for="content">
                                    {{translate("Content")}} <small class="text-danger">*</small>
                                </label>


                                    <button data-toggle="tooltip" data-placement="top" title="{{translate('Copy')}}" class="delete-item icon-btn info copy-content">
                                        <i class="las la-copy"></i></button>

                                    <button data-toggle="tooltip" data-placement="top" title="{{translate('Download')}}" class="delete-item icon-btn success download-text">
                                        <i class="las la-download"></i></button>



                                <textarea placeholder="Enter Your Content" name="content" id="content" cols="30" rows="10"></textarea>
                            </div>
                        </div>

                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="i-btn btn--md ripple-dark" data-anim="ripple" data-bs-dismiss="modal">
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
    <script src="{{asset('assets/global/js/flatpickr.js')}}"></script>

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

        flatpickr("#schedule_date", {
            dateFormat: "Y-m-d H:i",
            enableTime: true,
        });


        $(document).on('click','.check_account',function(e) {
            var accountName = $(this).attr('data-account_name');
            var platformName = $(this).attr('data-platform_name');
            var image =  $(this).attr('data-image');

            var id = $(this).attr('data-id');

            var html = `<li id="list-account-${id}" class="selected-profile-item">
                <span class="channel-icon">
                    <img src="${image}" alt="google" border="0">
                </span>

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


	})(jQuery);

</script>
@endpush
