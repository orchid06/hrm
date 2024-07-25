@extends('layouts.master')

@push('style-include')
    <link href="{{asset('assets/global/css/viewbox/viewbox.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="row g-4">

        <div class="col-xl-12">
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
                             <p class="value">{{ @$post->account?->platform->name ?? "N/A"}}</p>
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

        <div class="col-xl-12">
            <div class="i-card-md">
                <div class="card-header">
                    <h4 class="card-title">
                        {{ translate('Post  Information') }}
                    </h4>
                </div>

                <div class="card-body">
                    <ul class="post-detail-list list-group list-group-flush">

                        @if($post->file->count() > 0)
                            <li class="list-group-item">
                                <h6 class="title">
                                    {{ translate('Images')}}
                                </h6>

                                <div class="d-flex align-items-center flex-wrap gap-3 mt-3">
                                    @foreach ($post->file as $file)
                                        <div class="d-flex">
                                            @php 
                                               $fileURL = (imageURL($file,"post",true));
                                            @endphp

                                            @if(!isValidVideoUrl($fileURL))
                                        
                                                <a href="{{$fileURL}}" class="image-v-preview">
                                                    <img src="{{$fileURL}}" alt="{{ @$file->name ?? 'file-'.$loop->index.'.jpg'}}">
                                                </a>
                                            @else
                                 
                                                <video  width="150" controls>
                                                    <source src="{{$fileURL}}">
                                                </video>
    
                                            @endif
                           
                                        </div>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                        
                        <li class="list-group-item">
                            <h6 class="title">{{ translate('Content') }}</h6>
                            <p class="value"> {{$post->content?? 'N/A'}}</p>
                        </li>

                        <li class="list-group-item">
                            <h6 class="title">{{ translate('Link') }}</h6>
                             <p class="value post__link">{{$post->link?? 'N/A'}}</p>
                        </li>

              
                    </ul>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('script-include')
      <script src="{{asset('assets/global/js/viewbox/jquery.viewbox.min.js')}}"></script>
@endpush


@push('script-push')
<script>
	(function($){
        "use strict";

        $('.image-v-preview').viewbox();


	})(jQuery);
    
</script>

@endpush