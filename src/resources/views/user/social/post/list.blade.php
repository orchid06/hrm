@extends('layouts.master')
@section('content')
@push('style-include')
    <link href="{{asset('assets/global/css/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')

    <div class="i-card-md mb-4 border">
            <div class="card-header">
            <h4 class="card-title">
                Latest feeds
            </h4>
        </div>
        <div class="card-body">
            <div class="row g-lg-4 g-3">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="social-preview-body">
                        <div class="social-auth">
                            <div class="profile-img">
                                <img src="https://i.ibb.co/DzZSQGB/Image.jpg" alt="Image">
                            </div>

                            <div class="profile-meta">
                                <h6 class="user-name">
                                    <a href="javascript:void(0)">
                                        Username
                                    </a>
                                </h6>
                            
                                <div class="d-flex align-items-center gap-2">
                                    <p>
                                    Apr 17
                                    </p>
                                    <i class="bi bi-globe-americas fs-12"></i>
                                </div>
                            </div>

                            <span class="dots">
                                <i class="bi bi-three-dots"></i>
                            </span>
                        </div>

                        <div class="social-caption">
                            <!-- <div class="caption-text">
                                <div class="line-loader">
                                    <div class="wrapper">
                                    <div class="line-1"></div>
                                    <div class="line-2"></div>
                                    <div class="line-3"></div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="caption-text">Some default post text here... I have nothing to say but you need to buy it.</div>
                            <div class="caption-imgs">
                                <img src="https://i.ibb.co/DzZSQGB/Image.jpg" alt="Image">
                            </div>

                            <div class="action-count d-flex justify-content-between align-items-center">
                                <div class="emoji d-flex align-items-center gap-1">
                                    <ul class="d-flex gap-0 react-icon-list">
                                        <li><img src="https://i.ibb.co/8dQF08Y/like.png" alt="like"></li>
                                        <li><img src="https://i.ibb.co/8XNyprT/love.png" alt="love"></li>
                                        <li><img src="https://i.ibb.co/F8mtm0r/care.png" alt="care"></li>
                                    </ul>
                                    <span class="fs-13">129</span>
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
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="social-preview-body">
                        <div class="social-auth">
                            <div class="profile-img">
                                <img src="https://i.ibb.co/DzZSQGB/Image.jpg" alt="Image">
                            </div>

                            <div class="profile-meta">
                                <h6 class="user-name">
                                    <a href="javascript:void(0)">
                                        Username
                                    </a>
                                </h6>
                            
                                <div class="d-flex align-items-center gap-2">
                                    <p>
                                    Apr 17
                                    </p>
                                    <i class="bi bi-globe-americas fs-12"></i>
                                </div>
                            </div>

                            <span class="dots">
                                <i class="bi bi-three-dots"></i>
                            </span>
                        </div>

                        <div class="social-caption">
                            <!-- <div class="caption-text">
                                <div class="line-loader">
                                    <div class="wrapper">
                                    <div class="line-1"></div>
                                    <div class="line-2"></div>
                                    <div class="line-3"></div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="caption-text">Some default post text here... I have nothing to say but you need to buy it.</div>
                            <div class="caption-imgs">
                                <img src="https://i.ibb.co/DzZSQGB/Image.jpg" alt="Image">
                            </div>

                            <div class="action-count d-flex justify-content-between align-items-center">
                                <div class="emoji d-flex align-items-center gap-1">
                                    <ul class="d-flex gap-0 react-icon-list">
                                        <li><img src="https://i.ibb.co/8dQF08Y/like.png" alt="like"></li>
                                        <li><img src="https://i.ibb.co/8XNyprT/love.png" alt="love"></li>
                                        <li><img src="https://i.ibb.co/F8mtm0r/care.png" alt="care"></li>
                                    </ul>
                                    <span class="fs-13">129</span>
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
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="social-preview-body">
                        <div class="social-auth">
                            <div class="profile-img">
                                <img src="https://i.ibb.co/DzZSQGB/Image.jpg" alt="Image">
                            </div>

                            <div class="profile-meta">
                                <h6 class="user-name">
                                    <a href="javascript:void(0)">
                                        Username
                                    </a>
                                </h6>
                            
                                <div class="d-flex align-items-center gap-2">
                                    <p>
                                    Apr 17
                                    </p>
                                    <i class="bi bi-globe-americas fs-12"></i>
                                </div>
                            </div>

                            <span class="dots">
                                <i class="bi bi-three-dots"></i>
                            </span>
                        </div>

                        <div class="social-caption">
                            <!-- <div class="caption-text">
                                <div class="line-loader">
                                    <div class="wrapper">
                                    <div class="line-1"></div>
                                    <div class="line-2"></div>
                                    <div class="line-3"></div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="caption-text">Some default post text here... I have nothing to say but you need to buy it.</div>
                            <div class="caption-imgs">
                                <img src="https://i.ibb.co/DzZSQGB/Image.jpg" alt="Image">
                            </div>

                            <div class="action-count d-flex justify-content-between align-items-center">
                                <div class="emoji d-flex align-items-center gap-1">
                                    <ul class="d-flex gap-0 react-icon-list">
                                        <li><img src="https://i.ibb.co/8dQF08Y/like.png" alt="like"></li>
                                        <li><img src="https://i.ibb.co/8XNyprT/love.png" alt="love"></li>
                                        <li><img src="https://i.ibb.co/F8mtm0r/care.png" alt="care"></li>
                                    </ul>
                                    <span class="fs-13">129</span>
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
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="social-preview-body">
                        <div class="social-auth">
                            <div class="profile-img">
                                <img src="https://i.ibb.co/DzZSQGB/Image.jpg" alt="Image">
                            </div>

                            <div class="profile-meta">
                                <h6 class="user-name">
                                    <a href="javascript:void(0)">
                                        Username
                                    </a>
                                </h6>
                            
                                <div class="d-flex align-items-center gap-2">
                                    <p>
                                    Apr 17
                                    </p>
                                    <i class="bi bi-globe-americas fs-12"></i>
                                </div>
                            </div>

                            <span class="dots">
                                <i class="bi bi-three-dots"></i>
                            </span>
                        </div>

                        <div class="social-caption">
                            <!-- <div class="caption-text">
                                <div class="line-loader">
                                    <div class="wrapper">
                                    <div class="line-1"></div>
                                    <div class="line-2"></div>
                                    <div class="line-3"></div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="caption-text">Some default post text here... I have nothing to say but you need to buy it.</div>
                            <div class="caption-imgs">
                                <img src="https://i.ibb.co/DzZSQGB/Image.jpg" alt="Image">
                            </div>

                            <div class="action-count d-flex justify-content-between align-items-center">
                                <div class="emoji d-flex align-items-center gap-1">
                                    <ul class="d-flex gap-0 react-icon-list">
                                        <li><img src="https://i.ibb.co/8dQF08Y/like.png" alt="like"></li>
                                        <li><img src="https://i.ibb.co/8XNyprT/love.png" alt="love"></li>
                                        <li><img src="https://i.ibb.co/F8mtm0r/care.png" alt="care"></li>
                                    </ul>
                                    <span class="fs-13">129</span>
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
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="social-preview-body">
                        <div class="social-auth">
                            <div class="profile-img">
                                <img src="https://i.ibb.co/DzZSQGB/Image.jpg" alt="Image">
                            </div>

                            <div class="profile-meta">
                                <h6 class="user-name">
                                    <a href="javascript:void(0)">
                                        Username
                                    </a>
                                </h6>
                            
                                <div class="d-flex align-items-center gap-2">
                                    <p>
                                    Apr 17
                                    </p>
                                    <i class="bi bi-globe-americas fs-12"></i>
                                </div>
                            </div>

                            <span class="dots">
                                <i class="bi bi-three-dots"></i>
                            </span>
                        </div>

                        <div class="social-caption">
                            <!-- <div class="caption-text">
                                <div class="line-loader">
                                    <div class="wrapper">
                                    <div class="line-1"></div>
                                    <div class="line-2"></div>
                                    <div class="line-3"></div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="caption-text">Some default post text here... I have nothing to say but you need to buy it.</div>
                            <div class="caption-imgs">
                                <img src="https://i.ibb.co/DzZSQGB/Image.jpg" alt="Image">
                            </div>

                            <div class="action-count d-flex justify-content-between align-items-center">
                                <div class="emoji d-flex align-items-center gap-1">
                                    <ul class="d-flex gap-0 react-icon-list">
                                        <li><img src="https://i.ibb.co/8dQF08Y/like.png" alt="like"></li>
                                        <li><img src="https://i.ibb.co/8XNyprT/love.png" alt="love"></li>
                                        <li><img src="https://i.ibb.co/F8mtm0r/care.png" alt="care"></li>
                                    </ul>
                                    <span class="fs-13">129</span>
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
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="social-preview-body">
                        <div class="social-auth">
                            <div class="profile-img">
                                <img src="https://i.ibb.co/DzZSQGB/Image.jpg" alt="Image">
                            </div>

                            <div class="profile-meta">
                                <h6 class="user-name">
                                    <a href="javascript:void(0)">
                                        Username
                                    </a>
                                </h6>
                            
                                <div class="d-flex align-items-center gap-2">
                                    <p>
                                    Apr 17
                                    </p>
                                    <i class="bi bi-globe-americas fs-12"></i>
                                </div>
                            </div>

                            <span class="dots">
                                <i class="bi bi-three-dots"></i>
                            </span>
                        </div>

                        <div class="social-caption">
                            <!-- <div class="caption-text">
                                <div class="line-loader">
                                    <div class="wrapper">
                                    <div class="line-1"></div>
                                    <div class="line-2"></div>
                                    <div class="line-3"></div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="caption-text">Some default post text here... I have nothing to say but you need to buy it.</div>
                            <div class="caption-imgs">
                                <img src="https://i.ibb.co/DzZSQGB/Image.jpg" alt="Image">
                            </div>

                            <div class="action-count d-flex justify-content-between align-items-center">
                                <div class="emoji d-flex align-items-center gap-1">
                                    <ul class="d-flex gap-0 react-icon-list">
                                        <li><img src="https://i.ibb.co/8dQF08Y/like.png" alt="like"></li>
                                        <li><img src="https://i.ibb.co/8XNyprT/love.png" alt="love"></li>
                                        <li><img src="https://i.ibb.co/F8mtm0r/care.png" alt="care"></li>
                                    </ul>
                                    <span class="fs-13">129</span>
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
            </div>
        </div>
    </div>    

    <div class="i-card-md mb-4 border">
         <div class="card-header">
            <h4 class="card-title">
                 {{translate(Arr::get($meta_data,'title'))}}
            </h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs gap-4 style-2 mb-30" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-one" data-bs-toggle="tab" data-bs-target="#tab-one-pane" type="button" role="tab" aria-controls="tab-one-pane" aria-selected="true"><span><img src="https://i.ibb.co/NLk868y/facebook.png" alt="facebook"></span>Facebook</button>
                </li>
                <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-two" data-bs-toggle="tab" data-bs-target="#tab-two-pane" type="button" role="tab" aria-controls="tab-two-pane" aria-selected="false"><span><img src="https://i.ibb.co/QJ7MCHY/instagram.png" alt="instagram"></span>Instagram</button>
                </li>
                <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-three" data-bs-toggle="tab" data-bs-target="#tab-three-pane" type="button" role="tab" aria-controls="tab-three-pane" aria-selected="false"><span><img src="https://i.ibb.co/Rg1Vz7X/twitter.png" alt="twitter"></span>Twitter</button>
                </li>
                <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-four" data-bs-toggle="tab" data-bs-target="#tab-four-pane" type="button" role="tab" aria-controls="tab-four-pane" aria-selected="false"><span><img src="https://i.ibb.co/mcGZcTg/linkedin.png" alt="linkedin"></span>Linkedin</buttons>
                </li>
            </ul>
        </div>
    </div>
    <div class="i-card-md">
        <div class="card-header">
             <div class="d-flex align-items-center gap-2">
                <a href="{{route('user.social.post.create')}}" class="i-btn primary btn--sm capsuled">
                    <i class="bi bi-plus-lg"></i>
                     {{translate('Create New Post')}}
                </a>
                <button class="icon-btn icon-btn-lg info circle" type="button" data-bs-toggle="collapse" data-bs-target="#tableFilter"     aria-expanded="false"
                    aria-controls="tableFilter">
                    <i class="bi bi-sliders"></i>
                </button>
            </div>
        </div>

        <div class="collapse" id="tableFilter">
            <div class="search-action-area">
                 <div class="search-area">
                    <form action="{{route(Route::currentRouteName())}}" method="get">
                        <div class="form-inner mb-0">
                            <input type="text" id="datePicker" name="date" value="{{request()->input('date')}}"  placeholder='{{translate("Filter by date")}}'>
                        </div>

                        <div class="form-inner mb-0">
                            <select name="account" id="accounts" class="account">
                                <option value="">
                                    {{translate('Select Account')}}
                                </option>

                                @foreach($accounts as $account)
                                    <option  {{$account->account_id ==   request()->input('account') ? 'selected' :""}} value="{{$account->account_id}}"> {{$account->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-inner mb-0">
                            <select name="status" id="status" class="status">
                                <option value="">
                                    {{translate('Select Status')}}
                                </option>

                                @foreach(App\Enums\PostStatus::toArray() as $k => $v)
                                    <option  {{$v  ==   request()->input('status',-1) ? 'selected' :""}} value="{{$v}}">   {{$k}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="i-btn primary btn--lg capsuled">
                                <i class="bi bi-search"></i>
                            </button>

                            <a href="{{route(Route::currentRouteName())}}"  class="i-btn danger btn--lg capsuled">
                                 <i class="bi bi-arrow-repeat"></i>
                            </a>
                        </div>
                    </form>
                 </div>
            </div>
        </div>

        <div class="card-body px-0">
            <div class="table-container ">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">
                                #
                            </th>
                            <th scope="col">{{translate('Platform')}}</th>
                            <th scope="col">{{translate('Account')}}</th>
                            <th scope="col">{{translate('Schedule Time')}}</th>
                            <th scope="col">{{translate('Send time')}}</th>
                            <th scope="col">{{translate('Status')}}</th>
                            <th scope="col">{{translate('Post Type')}}</th>
                            <th scope="col">{{translate('Options')}}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($posts as $post)
                            <tr>
                                <td data-label="#">
                                    {{$loop->iteration}}
                                </td>

                                <td data-label='{{translate("Name")}}'>
                                    <div class="user-meta-info d-flex align-items-center gap-2">
                                        <img class="rounded-circle avatar-sm" src='{{imageUrl(@$post->account->platform->file,"platform",true)}}' alt="{{@$post->account->platform->file}}">
                                        <p>	 {{$post->account->platform->name}}</p>
                                    </div>

                                </td>

                                <td data-label='{{translate("Account")}}'>
                                    <div class="user-meta-info d-flex align-items-center gap-2">
                                        <img class="rounded-circle avatar-sm"  src='{{@$post->account->account_information->avatar }}' alt="{{@$post->account->account_information->avatar}}">

                                        @if(@$post->account->account_information->link)
                                            <a target="_blank" href="{{@$post->account->account_information->link}}">
                                                <p>	{{ @$post->account->account_information->name}}</p>
                                            </a>
                                        @else
                                            <p>	{{ @$post->account->account_information->name}}</p>
                                        @endif
                                        @if( $post->platform_response && $post->platform_response->url )

                                            <a class="i-badge success" title="{{translate('Show')}}" target="_blank"  href="{{@$post->platform_response->url}}" class="fs-15"> {{translate("View Post")}}
                                            </a>
                                        @endif
                                    </div>
                                </td>

                                <td data-label='{{translate("Schedule time")}}'>
                                    {{@$post->schedule_time ? get_date_time($post->schedule_time ) : translate('N/A')}}
                                </td>

                                <td data-label='{{translate("Send time")}}'>
                                    {{@$post->updated_at ? diff_for_humans($post->updated_at ) : translate('N/A')}}
                                </td>

                                <td data-label='{{translate("Status")}}'>
                                    <div class="d-flex align-items-center gap-2">
                                        @php echo post_status($post->status)   @endphp

                                        @if( $post->platform_response && @$post->platform_response->response )
                                           <a href="javascript:void(0);" data-message="{{$post->platform_response->response }}" class="icon-btn icon-btn-sm show-info info">
                                               <i class="bi bi-info fs-4"></i>
                                           </a>
                                       @endif
                                    </div>
                                </td>

                                <td data-label='{{translate("Type")}}'>
                                     @php echo post_type($post->post_type)   @endphp
                                </td>

                                <td data-label='{{translate("Action")}}'>
                                    <div class="table-action">
                                        <a  title="{{translate('Show')}}"  href="{{route('user.social.post.show',['uid' => $post->uid])}}" class="icon-btn icon-btn-sm info"><i class="bi bi-eye"></i>
                                        </a>

                                        <a title="{{translate('Delete')}}" href="javascript:void(0);"    data-href="{{route('user.social.post.destroy',  $post->id)}}" class="icon-btn icon-btn-sm danger delete-item">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="border-bottom-0" colspan="90">
                                    @include('admin.partials.not_found')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="Paginations">
                {{ $posts->links() }}
            </div>
        </div>
    </div>

@endsection
@section('modal')
  @include('modal.delete_modal')

  <div class="modal fade" id="report-info" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="report-info"   aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Response Message')}}
                </h5>

                <button type="button" class="icon-btn icon-btn-sm danger" data-bs-dismiss="modal">
                   <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="content">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-include')
  <script src="{{asset('assets/global/js/flatpickr.js')}}"></script>
@endpush
@push('script-push')
<script>
	(function($){
       	"use strict";

        $(".user").select2({

        });

        $(".account").select2({

        });
        $(".status").select2({

        });

        flatpickr("#datePicker", {
            dateFormat: "Y-m-d",
            mode: "range",
        })

        $(document).on('click','.show-info',function(e){

            var modal = $('#report-info');

            var report = $(this).attr('data-message')

            $('.content').html(report)

            modal.modal('show')
        });



	})(jQuery);

</script>
@endpush





