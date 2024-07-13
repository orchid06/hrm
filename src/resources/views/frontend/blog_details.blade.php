@extends('layouts.master')
@section('content')

@php
   $blogContent  = get_content("content_blog")->first();
   $newsLetter  = get_content("content_newsletter")->first();

@endphp

@include("frontend.partials.breadcrumb")

<section class="blog-details pb-110">
  <div class="container">
    <h3 class="title"> {{$blog->title}} </h3>
    <div class="d-flex gap-4 align-items-center mb-30">
      <ul class="date">
        <li>{{get_date_time($blog->created_at,"F j, Y")}}</li>
        <li>{{get_date_time($blog->created_at," g a")}}</li>
      </ul>
      <a href="{{route('blog',['category' =>@$blog->category->slug ])}}" class="blog-category">
          {{@$blog->category->title}}
      </a>
    </div>
    <div class="mb-30 blog-d-image">
      <img src='{{imageURL(@$blog->file,"blog",true)}}'
      alt="{{@$blog->file->name ?? "blog-image.jpg"}}">
    </div>
    <div class="row gy-5">
      <div class="col-lg-8 pe-lg-5">
          @php  echo @$blog->description @endphp

          <div class="share-blog mt-5">
            <h6>
               {{translate('Like what you see? Share with a friend.')}}
            </h6>
              <div class="footer-social">
                <ul>

                    <li>
                      <a onclick="social_share('https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}',  'Facebook','600','300');" href="javascript:void(0);"><i class="bi bi-facebook"></i>
                      </a>
                    </li>

                    <li>
                        <a onclick="social_share('http://twitter.com/share?text={{str_replace("'", "\'", $blog->slug)}}&url={{url()->current()}}','Twitter','600','450');"
                            href="javascript:void(0);"><i class="bi bi-twitter"></i>
                        </a>
                    </li>
                    
                    <li>
                       <a onclick="social_share('https://api.whatsapp.com/send?text={{str_replace("'", "\'", $blog->slug)}} https://cartuser.kodepixel.com/product/formal-elegance-dress/6','WhatsApp','700','650');" href="javascript:void(0);"><i class="bi bi-whatsapp"></i></a>
                    </li>

                    <li>
                        <a onclick="social_share('https://www.linkedin.com/sharing/share-offsite/?url={{url()->current()}}','Linkedin','600','450');" href="javascript:void(0);"><i class="bi bi-linkedin"></i></a>
                    </li>

                    <li>
                        <a onclick="social_share('https://t.me/share/url?url={{url()->current()}}&text={{str_replace("'", "\'", $blog->title)}}', 'Telegram','600','450');" href="javascript:void(0);"><i class="bi bi-telegram"></i></a>
                    </li>

                    <li>
                        <a href="mailto:?subject={{ $blog->title }}&amp;body={{url()->current()}}"><i class="bi bi-envelope-at-fill"></i></a>
                    </li>

                </ul>
              </div>
          </div>
      </div>
      <div class="col-lg-4">
        <h5 class="mb-4 text-uppercase">{{translate("Related Resources")}}</h5>
        <ul class="popular-post-list">
          @forelse($related_blogs as $blog)
              <li>
                  <div class="image">
                       <img  src='{{imageURL(@$blog->file,"blog",true)}}'
                       alt="{{@$blog->file->name ?? "blog-image.jpg"}}">
                  </div>
                  <div class="content">
                      <a href="{{route('blog',['category' =>@$blog->category->slug ])}}">
                          {{@$blog->category->title}}
                      </a>
                        <h6> <a href="{{route('blog.details',$blog->slug)}}"> {{limit_words($blog->title,28)}}</a></h6>
                  </div>
              </li>
          @empty
               <li>
                    @include('frontend.partials.page_section') 
               </li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
</section>

@endsection

