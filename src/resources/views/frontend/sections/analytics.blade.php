@php
   $analyticsContent  = get_content("content_analytics")->first();
   $file              = $analyticsContent->file->where("type",'image')->first();

@endphp

<section class="Analytic pt-110 pb-110">
    <div class="container">
      <div class="row g-5 align-items-center overflow-hidden">
        <div class="col-lg-7 pe-lg-5 order-lg-0 order-2 gs_reveal fromLeft">
          <div>
            <img src='{{imageUrl(@$file,"frontend",true,@get_appearance()->analytics->content->images->image->size)}}' alt="{{@$file->name}}" />
          </div>
        </div>

        <div class="col-lg-5 order-lg-0 order-1 gs_reveal fromRight">
          <div class="section-title">
            <span>{{$analyticsContent->value->sub_title}}</span>
            <h3 class="title-anim">
                {{$analyticsContent->value->title}}
            </h3>
            <p>
              {{$analyticsContent->value->description}}
            </p>
          </div>

          <div>
            <a href="{{url($analyticsContent->value->button_url)}}" class="learn-more">
              <span class="circle" aria-hidden="true">
                <span class="icon arrow"> </span>
              </span>
              <span class="button-text">
                {{$analyticsContent->value->button_name}}
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
</section>
