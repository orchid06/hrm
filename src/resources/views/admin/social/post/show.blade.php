@extends('admin.layouts.master')

@push('style-include')
    <link href="{{asset('assets/global/css/viewbox/viewbox.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="row g-4 mb-4">


        <div class="col-xl-6">
            <div class="i-card-md">
                <div class="card--header">
                    <h4 class="card-title">
                        {{ translate('Basic Information') }}
                    </h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">{{ translate('Platform') }} :  {{$post->account->platform->name}}</li>
                        <li class="list-group-item">{{ translate('Account') }} :   @if(@$post->account->account_information->link)
                                                                                        <a target="_blank" href="{{@$post->account->account_information->link}}">
                                                                                           	{{ @$post->account->account_information->name}}
                                                                                        </a>
                                                                                    @else
                                                                                     {{ @$post->account->account_information->name}}
                                                                                    @endif
                        </li>
                        <li class="list-group-item">{{ translate('User') }} :        
                            @if($post->user )
                                <a href="{{route('admin.user.show',$post->user->uid)}}">
                                    {{ @$post->user->name }}
                                </a>
                            @else
                                {{ translate('N/A')}}
                            @endif

                        </li>
                        <li class="list-group-item">{{ translate('Admin') }} : {{@$post->admin ? @$post->admin->name : translate('N/A')}}
                        </li>
                        <li class="list-group-item">{{ translate('Schedule Time') }} :    {{@$post->schedule_time ? get_date_time($post->schedule_time ) : translate('N/A')}}
                        </li>
                        <li class="list-group-item">{{ translate('Status') }} :    @php echo post_status($post->status)   @endphp
                        </li>
                        <li class="list-group-item">{{ translate('Post Type') }} :      @php echo post_type($post->post_type)   @endphp
                        </li>
            
                   
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="i-card-md">
                <div class="card--header">
                    <h4 class="card-title">
                        {{ translate('Post  Information') }}
                    </h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item">{{ translate('Content') }} :  {{$post->content?? 'N/A'}}</li>
                        <li class="list-group-item">{{ translate('Link') }} :  {{$post->link?? 'N/A'}}</li>
                        @if($post->file->count() > 0)
                            <li class="list-group-item">{{ translate('Images')}} :
                                    <div class="d-flex gap-3 mt-2">
                                        @foreach ($post->file as $file)
                                            <a href="{{imageURL($file,"post",true)}}" class="image-v-preview">
                                                <img src="{{imageURL($file,"post",true)}}"  alt="{{ @$file->name }}">
                                            </a>
                                                        
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