@extends('layouts.master')
@section('content')
    <div class="row g-4">

        <div class="col-xl-6">
            <div class="i-card-md">
                <div class="card-header">
                    <h4 class="card-title">
                        {{ translate('Basic Information') }}
                    </h4>
                </div>
                <div class="card-body">
                    <ul class="post-detail-list list-group list-group-flush">
                        <li class="list-group-item">
                            <h6 class="title">{{ translate('Platform') }}</h6>
                             <p class="value">{{$post->account->platform->name}}</p>
                        </li>

                        <li class="list-group-item">
                            <h6 class="title">
                                {{ translate('Account')}}
                            </h6>

                            <div class="value">
                                @if(@$post->account->account_information->link)
                                    <a class="text--primary" target="_blank" href="{{@$post->account->account_information->link}}">
                                        {{ @$post->account->account_information->name}}
                                    </a>
                                @else
                                    {{ @$post->account->account_information->name}}
                                @endif
                            </div>
                        </li>

                        <li class="list-group-item">
                            <h6 class="title">
                                {{ translate('Schedule Time') }}
                            </h6>

                            <p> {{@$post->schedule_time ? get_date_time($post->schedule_time ) : translate('N/A')}}</p>
                        </li>

                        <li class="list-group-item">
                            <h6 class="title">{{ translate('Status') }}</h6>
                            @php echo post_status($post->status)   @endphp
                        </li>

                        <li class="list-group-item">
                            <h6 class="title">{{ translate('Post Type') }}</h6>
                            @php echo post_type($post->post_type)   @endphp
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="i-card-md">
                <div class="card-header">
                    <h4 class="card-title">
                        {{ translate('Post  Information') }}
                    </h4>
                </div>

                <div class="card-body">
                    <ul class="post-detail-list list-group list-group-flush">
                        <li class="list-group-item">
                            <h6 class="title">{{ translate('Content') }}</h6>
                            <p class="value"> {{$post->content?? 'N/A'}}</p>
                        </li>

                        <li class="list-group-item">
                            <h6 class="title">{{ translate('Link') }}</h6>
                             <p class="value post__link">{{$post->link?? 'N/A'}}</p>
                        </li>

                        @if($post->file->count() > 0)
                            <li class="list-group-item">
                                <h6 class="title">
                                    {{ translate('Images')}}
                                </h6>

                                <div class="d-flex align-items-center flex-wrap gap-3 mt-3">
                                    @foreach ($post->file as $file)
                                    <div class="post-detail-img">
                                        <img src='{{imageUrl($file,"post",true)}}'
                                            alt="{{ @$file->name }}">
                                    </div>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

    </div>
@endsection

