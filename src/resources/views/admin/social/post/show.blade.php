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
                    @php
                    $lists  =  [
                                    [
                                                    "title"  =>  translate('Platform'),
                                                    "value"  =>  @$post->account->platform->name ?? "N/A",
                                    ],
                                        
                                    [
                                                    "title"  =>  translate('User'),
                                                    "href"   =>  @$post->user ?  route('admin.user.show',$post->user->uid) : NULL,
                                                    "value"  =>  @$post->user->name ?? "N/A" ,
                                    ],
                                    [
                                                    "title"  =>  translate('Admin'),
                                                    "value"  =>  @$post->admin ? @$post->admin->name : translate('N/A')
                                    ],
                                    [
                                                    "title"  =>  translate('Schedule Time'),
                                                    "value"  =>  @$post->schedule_time ? get_date_time($post->schedule_time ) : translate('N/A')
                                    ],
                                 
                                    [
                                                    "title"     =>  translate('Status'),
                                                    "is_html"   =>  true,
                                                    "value"     =>  post_status($post->status)
                                    ],
                                    [
                                                    "title"     =>  translate('Post Type'),
                                                    "is_html"   =>  true,

                                                    "value"     =>  post_type($post->post_type)
                                    ],
                                        
                            ];

                    @endphp
                     @include('admin.partials.custom_list',['list'  => $lists])
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
                    <ul class="custom-info-list list-group-flush">

                        <li> <span>{{ translate('Content') }} :</span>   <span> {{$post->content?? 'N/A'}} </span></li>
                        <li> <span>{{ translate('Link') }} :</span>   <span> {{$post->link?? 'N/A'}} </span></li>
             
                        @if($post->file->count() > 0)
                            <li>  <span>{{ translate('Images')}} : </span>
   
                                        @foreach ($post->file as $file)

                                           <div class="custom-profile">
                                                <a href="{{imageURL($file,"post",true)}}" class="image-v-preview">
                                                    <img src="{{imageURL($file,"post",true)}}"  alt="{{ @$file->name }}">
                                                </a>
                                           </div>
                                                        
                                        @endforeach
                              
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