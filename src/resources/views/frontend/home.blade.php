@extends('layouts.master')
@section('content')

@php
   $bannerContent  = get_content("content_banner")->first();
   $bannerElements = get_content("element_banner");
   $bannerImg      = $bannerContent->file->where("type",'image')->first();
@endphp

<section class="banner" id="banner" role="banner">
   <div class="container">
     <div class="banner-container">
       <div class="row align-items-center">
         <div class="col-xl-8 col-lg-10 mx-auto">
           <div class="banner-content">
             <h1 class="quote-title">
                  {{@$bannerContent->value->title}}
             </h1>
             <p class="banner-text">
                 {{@$bannerContent->value->description}}
             </p>

             <div
               class="d-flex align-items-center justify-content-center flex-wrap gap-lg-5 gap-4 mt-5">
               <a href="{{url($bannerContent->value->button_left_url)}}" class="i-btn btn--primary btn--lg capsuled">
                    {{@$bannerContent->value->button_left_name}}
               </a>

               <a
                 href="{{url($bannerContent->value->button_right_url)}}"
                 class="i-btn btn--primary-outline btn--lg capsuled">
                  {{@$bannerContent->value->button_right_name}}
               </a>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>

   <ul class="social-media-integrate">
      @foreach ($bannerElements  as  $element)
              @foreach (@get_appearance()->banner->element->images as  $key => $val)

                  @php
                        $file =  $element->file->where("type",$key)->first();
                  @endphp
                  <li>
                     <img src="{{imageUrl(@$file,'frontend',true,$val->size)}}" alt="{{@$file->name}}" />
                  </li>

              @endforeach
      @endforeach
   </ul>

   <div class="primary-shade"></div>

   <div class="banner-texture">
   </div>
</section>


<div class="banner-img-wrapper">
    <div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
        <div class="banner-img">
            <div class="circle-container">
                <div class="circleButton">
                <svg class="textcircle" viewBox="0 0 500 500">
                <defs>
                    <path
                    id="textcircle"
                    d="M250,400 a150,150 0 0,1 0,-300a150,150 0 0,1 0,300Z"
                    ></path>
                </defs>
                <text>

                    <textPath xlink:href="#textcircle" textLength="900">
                    {{@$bannerContent->value->motion_text}}
                    </textPath>
                </text>
                </svg>

                <span>
                <i class="bi bi-play-fill"></i>
                </span>
                </div>
            </div>
            <img src="{{imageUrl(@$bannerImg,'frontend',true,@get_appearance()->banner->content->images->image->size)}}" alt="{{@$bannerImg->name}}" />
        </div>
        </div>
    </div>
    </div>
</div>


@include('frontend.partials.page_section')

@endsection
