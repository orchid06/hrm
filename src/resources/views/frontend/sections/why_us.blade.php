@php
   $content             = get_content("content_why_us")->first();
   $elemets             = get_content("element_why_us");
@endphp


<section class="choose bg--white pt-110 pb-110">
    <div class="container">
      <div class="row g-5">
        <div class="col-lg-5">
          <div class="sticky-item">
            <div class="section-title">
              <span>{{$content->value->sub_title}}</span>
              <h3 class="title-anim">
                  {{$content->value->title}}
              </h3>
              <p>
                {{$content->value->description}}
              </p>
            </div>

            <div>
              <a href="{{url($content->value->button_url)}}" class="learn-more">
                <span class="circle" aria-hidden="true">
                  <span class="icon arrow"> </span>
                </span>
                <span class="button-text">  {{$content->value->button_name}}</span>
              </a>
            </div>
          </div>
        </div>

        <div class="col-lg-7 ps-4 ps-lg-3 ps-0">
          <div class="row g-4 justify-content-center">

            @foreach ($elemets  as $element)


              <div class="col-md-6">
                <div class="choose-card fade-item">
                  <div class="choose-card-icon">
                    <i class="{{$element->value->icon}}"></i>
                  </div>
                  <div>
                      <h4>
                        {{$element->value->title}}
                      </h4>
                      <p>
                        {{$element->value->description}}
                      </p>
                  </div>
                </div>
              </div>

            @endforeach


          </div>
        </div>
      </div>
    </div>
</section>
