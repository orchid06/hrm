@extends('layouts.master')
@section('content')

@php
   $blogContent  = get_content("content_blog")->first();
   $newsLetter  = get_content("content_newsletter")->first();

@endphp

<section class="blog-details pt-110 mb-110">
    <div class="container">
      <div class="row">
        <div class="col-lg-10">
          <div class="blog-detail-top">
            <h2>
                {{$blog->title}}
            </h2>
            <div class="d-flex align-items-center flex-wrap gap-md-4 gap-3 mt-4">
              <ul class="blog-tags mt-0">
                <li><a href="{{route('blog',['category' =>$blog->category->slug ])}}">{{$blog->category->title}}</a></li>
              </ul>
              <div class="blog-meta">
                <span>{{get_date_time($blog->created_at,"F j, Y")}}</span>
                <span> {{get_date_time($blog->created_at," g a")}}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row gx-4 gy-5">
        <div class="col-lg-8 pe-xl-5">
          <div class="blog-thumbnail">
            <img src='{{imageUrl(@$blog->file,"article",true)}}' alt="{{@$blog->file->name}}" />
          </div>

          <div class="blog-contents">

              @php  echo @$blog->description @endphp

            <div class="blog-share d-flex align-items-center flex-wrap gap-3">
              <h6> {{translate("Share on")}} :</h6>
              <div class="social-media">



                <a onclick="social_share('https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}',  'Facebook','600','300');" href="javascript:void(0);"><i class="bi bi-facebook"></i>
                </a>

                <a onclick="social_share('http://twitter.com/share?text={{str_replace("'", "\'", $blog->slug)}}&url={{url()->current()}}','Twitter','600','450');"
                    href="javascript:void(0);"><i class="bi bi-twitter"></i>
                </a>

                <a onclick="social_share('https://api.whatsapp.com/send?text={{str_replace("'", "\'", $blog->slug)}} {{url()->current()}}','WhatsApp','700','650');" href="javascript:void(0);"><i class="bi bi-whatsapp"></i></a>


                <a onclick="social_share('https://www.linkedin.com/sharing/share-offsite/?url={{url()->current()}}','Linkedin','600','450');" href="javascript:void(0);"><i class="bi bi-linkedin"></i></a>


                <a onclick="social_share('https://t.me/share/url?url={{url()->current()}}&text={{str_replace("'", "\'", $blog->title)}}','Telegram','600','450');" href="javascript:void(0);"><i class="bi bi-telegram"></i></a>

                <a href="mailto:?subject={{ $blog->title }}&amp;body={{url()->current()}}"><i class="bi bi-envelope-at-fill"></i></a>

              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
            <div class="blog-newsletter">
              <h4>{{@$newsLetter->value->title}}</h4>
              <p>
                  {{@$newsLetter->value->description}}
              </p>

              <form action="{{route('subscribe')}}" method="post">

                  @csrf
                  <input name="email" value="{{old('email')}}" type="email" placeholder="{{translate('Enter your email')}}" />

                <button class="i-btn btn--secondary btn--lg capsuled w-100">
                  {{translate("Subscribe")}}
                </button>
              </form>
            </div>

          <div class="resources sticky-item">
                <h4>
                    {{translate("Related Resources")}}
                </h4>

                <div class="resource-list">

                        @forelse ($related_blogs as $relatedBlog)

                            <div class="resource-item">
                                    <a href="{{route('blog.details',$relatedBlog->slug)}}" class="resource-thumbnail">
                                        <img src="{{imageUrl(@$relatedBlog->file,'article',true)}}" alt="{{@$relatedBlog->file->name}}" />
                                    </a>

                                    <div class="resource-content">
                                        <a href="{{route('blog.details',$relatedBlog->slug)}}">
                                            <h5>
                                                {{limit_words($relatedBlog->title,28)}}
                                            </h5>
                                        </a>

                                        <div class="blog-meta mt-2">
                                            <span>{{get_date_time($relatedBlog->created_at,"F j, Y")}}</span>
                                        </div>
                                    </div>
                            </div>

                        @empty
                            @include("frontend.partials.not_found")
                        @endforelse

                </div>
          </div>
        </div>
      </div>
    </div>
</section>

@include('frontend.sections.blog')


@endsection

