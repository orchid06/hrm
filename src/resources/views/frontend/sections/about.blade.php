@php
   $aboutContent  = get_content("content_about")->first();  
   $aboutElements = get_content("element_about"); 
   $aboutImg      = $aboutContent->file->where("type",'image')->first();
@endphp

<section class="about pt-110 pb-110">
    <div class="container">
      <div class="about-wrapper">
        <div class="row">
          <div class="col-lg-6 col-md-11">
            <div class="about-content">
              <div class="section-title">
                  <span>{{$aboutContent->value->sub_title}}</span>
                  <h3 class="title-anim">
                      {{$aboutContent->value->title}}
                  </h3>
              </div>
              <p>
                {{$aboutContent->value->description}}
              </p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <div class="about-more">
              <div class="about-vision">
                  @foreach ($aboutElements as $element )
                      <div class="about-vision-item">
                        <span class="about-vision-icon">
                          <i class="@php echo @$element->value->icon @endphp "></i>
                        </span>
                        <h6>
                          {{@$element->value->name}}
                        </h6>
                      </div>
                  @endforeach
              </div>

              <a href="{{url($aboutContent->value->button_url)}}" class="learn-more">
                <span class="circle" aria-hidden="true">
                  <span class="icon arrow"> </span>
                </span>
                <span class="button-text">{{$aboutContent->value->button_name}}</span>
              </a>
            </div>
          </div>
        </div>

        <div class="about-image">
          <img src="{{imageUrl(@$aboutImg,"frontend",true,@get_appearance()->about->content->images->image->size)}}" alt="{{@$aboutImg->name}}" />
        </div>

      </div>
    </div>
</section>
