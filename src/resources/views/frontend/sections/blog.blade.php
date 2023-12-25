
@php
   $blogContent  = get_content("content_blog")->first();  
   $blogs        = App\Models\Article::active()->feature()->take(10)->get();
@endphp


<section class="blog pb-110">
      <div class="container-fluid wrapper-fluid">
        <div class="row g-5">
          <div class="col-xl-3 col-lg-8 col-md-11 col-12">
            <div class="section-title">
              <span>{{@$blogContent->value->sub_title}}</span>
              <h3 class="title-anim">
                  {{@$blogContent->value->title}}
              </h3>
              <p>
                  {{@$blogContent->value->description}}
              </p>
            </div>

            <div>
              <a href='{{url(@$blogContent->value->button_url)}}' class="learn-more">
                <span class="circle" aria-hidden="true">
                  <span class="icon arrow"> </span>
                </span>
                <span class="button-text">
                   {{@$blogContent->value->button_name}}
                </span>
              </a>
            </div>
          </div>

       
          <div class="col-xl-9 col-12">
            @if(0 <    $blogs->count())
                <div class="blog-slider-wrapper">
                  
                  <div class="blog-preview-next">
                    <div class="preview-next">
                      <button class="blog-button-prev">
                        <i class="bi bi-arrow-left"></i>
                      </button>

                      <button class="blog-button-next">
                        <i class="bi bi-arrow-right"></i>
                      </button>
                    </div>
                  </div>

                  <div class="swiper blog-slider">
                    <div class="swiper-wrapper">
                        @foreach ($blogs as $blog)

                          <div class="swiper-slide">
                            <div class="blog-item">
                              <div class="blog-img">
                                <img
                                  src='{{imageUrl(@$blog->file,"article",true)}}'
                                  alt="{{@$blog->file->name}}"
                                  loading="lazy"/>

                                <div class="blog-card__pop">
                                  <span class="shape shape-left">
                                    <svg
                                      xmlns="http://www.w3.org/2000/svg"
                                      width="120"
                                      height="120"
                                      viewBox="0 0 120 120"
                                      fill="none">
                                      <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M22.6667 0H0V120H120V97.3333H54.6667C36.9936 97.3333 22.6667 83.0064 22.6667 65.3333V0Z"/>
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
                                      fill="none">
                                      <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M22.6667 0H0V120H120V97.3333H54.6667C36.9936 97.3333 22.6667 83.0064 22.6667 65.3333V0Z"/>
                                    </svg>
                                  </span>
                                </div>
                              </div>

                              <div class="blog-content">
                                <div class="blog-meta">

                                  <span> {{get_date_time($blog->created_at,"F j, Y")}}
                                  </span>
                                  <span> 
                                    {{get_date_time($blog->created_at," g a")}}
                                  </span>
                                </div>

                                <a href="{{route('blog.details',$blog->slug)}}" class="blog-title">
                                    <h4>
                                        {{limit_words($blog->title,28)}}
                                    </h4>
                                </a>

                                <ul class="blog-tags">
                                  <li>
       
                                    <a href="{{route('blog',['category' =>@$blog->category->slug ])}}">
                                         {{@$blog->category->title}}
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                            
                        @endforeach
                        
                    </div>
                  </div>
                </div>
            @else
               @include("frontend.partials.not_found")
            @endif
          </div>
        </div>
      </div>
</section>
