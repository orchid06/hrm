
@php

   $featureContent   = get_content("content_feature")->first();
   $featureElements  = get_content("element_feature");
@endphp

<section class="features pt-110 pb-110 mb-110">
    <div class="section-fluid">
      <div class="container-fluid px-0">
        <div class="row">
          <div class="col-xl-7 col-lg-8 mx-auto">
            <div class="section-title text-center">
              <span>{{$featureContent->value->sub_title}}</span>
              <h3 class="title-anim">
                  {{$featureContent->value->title}}
              </h3>
              <p>
                {{$featureContent->value->description}}
              </p>
            </div>
          </div>
        </div>

        <div class="row g-xxl-5 g-4">
          <div class="col-xl-3 col-lg-4">
            <div
              class="nav feature-list tab-on-hover"
              id="v-pills-tab"
              role="tablist"
              aria-orientation="vertical">
              @foreach ($featureElements as  $element)
                  <a
                    class='nav-link {{$loop->index ==  0 ? "active" :""}}'
                    id="v-pills-{{$loop->index}}-tab"
                    data-bs-toggle="pill"
                    href="#v-pills-{{$loop->index}}"
                    role="tab"
                    aria-controls="v-pills-{{$loop->index}}"
                    aria-selected="true">
                    <div class="feature-card-item">
                      <span>
                        <i class="{{$element->value->icon}}"></i>
                      </span>
                      <div>
                        <h4>
                           {{$element->value->title}}
                        </h4>
                        <p>
                          {{$element->value->sub_title}}
                        </p>
                      </div>
                    </div>
                  </a>
              @endforeach
            </div>
          </div>

          <div class="col-xl-9 col-lg-8">
            <div
              class="tab-content text-muted mt-4 mt-md-0"
              id="v-pills-tabContent">

                @foreach ($featureElements as  $element)
                    <div class='tab-pane fade {{$loop->index  == 0 ? "show active" :"" }} ' id="v-pills-{{$loop->index}}" role="tabpanel"
                      aria-labelledby="v-pills-{{$loop->index}}-tab">
                      <div class="row g-4">
                          <div class="col-xxl-8 col-xl-7">
                              @foreach (@get_appearance()->feature->element->images as  $key => $val)
                                @php
                                    $file =  $element->file->where("type",$key)->first();
                                @endphp
                                <div class="platform-content-img">
                                  <img
                                    src='{{imageUrl(@$file,"frontend",true,$val->size)}}'
                                    alt="{{@$file->name}}"
                                    loading="lazy"/>
                                </div>
                              @endforeach

                          </div>

                          <div class="col-xxl-4 col-xl-5">
                              @php  echo  $element->value->description   @endphp
                          </div>
                      </div>
                    </div>
                @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
