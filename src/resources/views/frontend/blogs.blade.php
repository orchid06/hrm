@extends('layouts.master')
@section('content')

@php
   $blogContent  = get_content("content_blog")->first();  
@endphp


<section class="inner-banner">
    <div class="container">
      <div class="row">
        <div class="col-xl-7 col-lg-8 mx-auto">
          <div class="inner-banner-content text-center">
            <h2>
                 {{@$blogContent->value->banner_title}}
            </h2>
            <p>
                {{@$blogContent->value->banner_description}}
            </p>

            <form action="{{route(Route::currentRouteName())}}" class="blog-search">
              <input name="search" value="{{request()->input("search")}}" type="search" placeholder="{{translate('Search by  title')}}"/>

              <div>
                <div class="blog-filter">
                  <div class="filter-select">
                    <select class="select-two"  name="category" id="category">
                        <option value="">
                            {{translate('Select Category')}}
                        </option>
                        @foreach($categories as $category)
                           <option  {{$category->slug ==   request()->input('category') ? 'selected' :""}} value="{{$category->slug}}"> {{$category->title}}
                          </option>
                        @endforeach
                    </select>
                  </div>
                </div>

                <button
                  type="submit"
                  class="i-btn btn--primary btn--lg capsuled"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    version="1.1"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0"
                    y="0"
                    viewBox="0 0 64 64"
                    style="enable-background: new 0 0 512 512"
                    xml:space="preserve"
                    class=""
                  >
                    <g>
                      <path
                        d="m60.08 53.34-16-16a22.57 22.57 0 1 0-6.74 6.74l16 16a4.76 4.76 0 1 0 6.73-6.74zM11.26 39A19.58 19.58 0 1 1 39 39a19.6 19.6 0 0 1-27.74 0z"
                        data-name="Layer 18"
                        opacity="1"
                        data-original="#000000"
                        class=""
                      ></path>
                    </g>
                  </svg>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="primary-shade"></div>
    <div class="banner-texture"></div>
  </section>

  <section class="blog pt-110 pb-110">
    <div class="container">
      <div class="blog-top">
        <div class="row gy-md-5 gy-4 align-items-end">
          <div class="col-md-7">
            <div class="section-title mb-0">
                <span>{{@$blogContent->value->sub_title}}</span>
                <h3 class="title-anim">
                    {{@$blogContent->value->title}}
                </h3>
                <p>
                    {{@$blogContent->value->description}}
                </p>
            </div>
          </div>
        </div>
      </div>

      <div class="blog-slider-wrapper ms-0">
        <div class="row gx-4 gy-xl-5 gy-4 justify-content-center">
                @forelse($blogs  as $blog)
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-item fade-item">
                        <div class="blog-img">
                            <img src="{{imageUrl(@$blog->file,"article",true)}}" alt="{{@$blog->file->name}}" />

                            <div class="blog-card__pop">
                            <span class="shape shape-left">
                                <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="120"
                                height="120"
                                viewBox="0 0 120 120"
                                fill="none"
                                >
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M22.6667 0H0V120H120V97.3333H54.6667C36.9936 97.3333 22.6667 83.0064 22.6667 65.3333V0Z"
                                />
                                </svg>
                            </span>
                            <a href="{{route('blog.details',$blog->slug)}}">
                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                            <span class="shape shape-right">
                                <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="120"
                                height="120"
                                viewBox="0 0 120 120"
                                fill="none"
                                >
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M22.6667 0H0V120H120V97.3333H54.6667C36.9936 97.3333 22.6667 83.0064 22.6667 65.3333V0Z"
                                />
                                </svg>
                            </span>
                            </div>
                        </div>

                        <div class="blog-content">
                            <div class="blog-meta">
                            <span>{{get_date_time($blog->created_at,"F j, Y")}}</span>
                            <span> {{get_date_time($blog->created_at," g a")}}</span>
                            </div>

                            <a href="{{route('blog.details',$blog->slug)}}" class="blog-title">
                                <h4>
                                    {{limit_words($blog->title,28)}}
                                </h4>
                            </a>

                            <ul class="blog-tags">
                                 <li><a href="{{route('blog',['category' =>$blog->category->slug ])}}">  {{$blog->category->title}}</a></li>
                            </ul>
                        </div>
                        </div>
                    </div>
                @empty

                   <div class="col-12 justify-content-center text-center">
                       @include("frontend.partials.not_found")
                   </div>

                @endforelse

        </div>
      </div>

      <div class="pagination-wrapper">
           {{ $blogs->links() }}
      </div>
    </div>
  </section>


  @include('frontend.partials.page_section')

@endsection

