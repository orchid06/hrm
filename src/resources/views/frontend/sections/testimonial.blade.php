@php
   $testimonialContent  = get_content("content_testimonial")->first();
   $testimonialElements = get_content("element_testimonial")->take(10);

@endphp


<section class="reviews pb-110">
    <div class="container">
      <div class="row">
        <div class="col-lg-7 mx-auto">
          <div class="section-title text-center">
            <span>{{$testimonialContent->value->sub_title}}</span>

            <h3 class="title-anim">{{$testimonialContent->value->title}}</h3>

            <p>
              {{$testimonialContent->value->description}}
            </p>
          </div>
        </div>
      </div>

        <div class="row g-lg-4 g-0 align-items-center">
            <div class="col-12">
                @if( 0 < $testimonialElements->count())
                    <div class="review-wrapper">
                      <div class="swiper review-slider">
                        <div class="swiper-wrapper">
                          @foreach ($testimonialElements as  $element)
                            <div class="swiper-slide">
                                <div class="review-card">
                                  <div class="quote-icon quote-one">
                                    <i class="bi bi-quote"></i>
                                  </div>
                                  <div class="d-flex justify-content-start gap-3 mb-4">
                                    <ul class="review-rating d-flex align-items-center gap-1">
                                      @php  echo show_ratings($element->value->rating) @endphp
                                    </ul>
                                  </div>

                          
                                  <p>
                                      {{$element->value->quote}}
                                  </p>

                                  <div class="reviewer-meta">
                                    <span class="reviewer-img">

                                      @foreach (@get_appearance()->testimonial->element->images as  $key => $val)
                                        @php
                                            $file =  $element->file->where("type",$key)->first();
                                        @endphp

                                        <img src='{{imageUrl(@$file,"frontend",true,$val->size)}}' alt="{{@$file->name}}" />

                                      @endforeach


                                    </span>
                                    <div>
                                      <h6>{{$element->value->author}}</h6>
                                      <span>{{$element->value->designation}}</span>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                      </div>
                    </div>
                @else
                  @include("frontend.partials.not_found")
                @endif
            </div>

        </div>
    </div>
</section>
