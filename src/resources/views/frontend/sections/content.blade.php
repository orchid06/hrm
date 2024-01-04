@php
   $contentSection      = get_content("content_content")->first();
   $contentBanner       = $contentSection->file->where("type",'image')->first();
@endphp


<section class="ai pb-110 ">
    <div class="horizontal-scroll">
      <div class="bg-texture"></div>
      <div class="i-panel ai-assistant">
        <div class="ai-panel-content">
          <div class="container">
            <div class="row align-items-center g-lg-5 g-4 overflow-hidden">
              <div class="col-lg-5 gs_reveal fromLeft">
                <div class="section-title mb-0">
                  <span>{{$contentSection->value->sub_title}}</span>
                  <h3 class="title-anim">
                      {{$contentSection->value->title}}
                  </h3>
                  <p>
                    {{$contentSection->value->description}}
                  </p>
                </div>
              </div>

              <div class="col-lg-7 ps-lg-5 gs_reveal fromRight">
                <div>
                  <img
                    src='{{imageUrl(@$contentBanner,"frontend",true,@get_appearance()->content->content->images->image->size)}}'
                    alt="{{@$contentBanner->name}}"
                    loading="lazy"/>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
