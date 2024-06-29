@php
    $intregrationsContent   = get_content("content_integration")->first();  
    $platforms              = get_platform()->where("is_feature",App\Enums\StatusEnum::true->status());
@endphp

<section class="integration pt-110 pb-110">
    <div class="container">
      <div class="integration-wrapper">
        <div class="row">
          <div class="col-lg-7">
            <div class="section-title text-lg-start text-center">
              <span>{{$intregrationsContent->value->sub_title}}</span>
              <h3 class="title-anim">
                  {{$intregrationsContent->value->title}}
              </h3>
              <p>
                {{$intregrationsContent->value->description}}
              </p>
            </div>

            <div class="row g-4 integration-content">
              
              @forelse ($platforms  as  $platform)

                  <div class="col-md-6">
                    <div class="integration-card fade-item">
                      <div class="d-flex align-items-center gap-3 pb-3">
                        <div class="integration-logo">
                          <img
                            src='{{imageURL(@$platform->file,"platform",true)}}'
                            alt="{{@$platform->file->name}}"
                            loading="lazy"/>
                        </div>
                        <h4>
                           {{$platform->name}}
                        </h4>
                      </div>
                      <p>
                          {{$platform->description}}
                      </p>
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
    <div class="scrolling-presets"></div>
</section>