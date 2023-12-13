@php
   $platformContent  = get_content("content_platform")->first();  
   $platformElements = get_content("element_platform");
   $platformImg      = $platformContent->file->where("type",'image')->first();
@endphp

<section class="platform pt-110 pb-110">
    <div class="container-fluid section-fluid">
      <div class="row align-items-center g-lg-5 gx-4 gy-5">
        <div
          class="col-xl-5 col-lg-6 offset-xl-1 offset-0 order-1 order-lg-0">
          <div
            class="d-flex flex-column align-items-center justify-content-center">
            <div  class="tab-content platform-tab-content" id="platform-tabContent">
                @foreach ($platformElements as  $element)
                    <div  class="tab-pane fade   {{$loop->index == 0 ? 'active show' :''}}" id="{{$loop->index}}-platform-element" role="tabpanel" aria-labelledby="{{$loop->index}}-platform-element-tab">
                      <div class="platform-content-wrapper">

                        
                      @foreach (@get_appearance()->platform->element->images as  $key => $val)

                          @php
                                $file =  $element->file->where("type",$key)->first();
                          @endphp
                          <div class="platform-content-img">
                            <img
                              src="{{imageUrl(@$file,'frontend',true,$val->size)}}"
                              alt="{{@$file->name}}"
                              loading="lazy"/>
                          </div>
                      @endforeach

                        <div class="platform-content">
                            
                          @php echo @$element->value->description @endphp
                         
                        </div>

                      </div>
                    </div>
                @endforeach

            </div>
          </div>
        </div>

        <div
          class="col-xl-4 col-lg-5 offset-lg-1 offset-0 order-0 order-lg-1">
          <div class="section-title">
            <span>{{$platformContent->value->sub_title}}</span>

            <h3 class="title-anim">{{$platformContent->value->title}}</h3>

            <p>
              {{$platformContent->value->description}}
            </p>
          </div>

          <div
            class="nav platform-card-list"
            id="platform-tab"
            role="tablist"
            aria-orientation="vertical">


            @foreach ($platformElements as  $element)
              
              <a class='nav-link platform-card-item {{$loop->index == 0 ?  "active" :""}} '
              id="{{$loop->index}}-platform-element-tab"
              data-bs-toggle="pill"
              href="#{{$loop->index}}-platform-element"
              role="tab"
              aria-controls="{{$loop->index}}-platform-element"
              aria-selected="true">
                  <span>
                    <i class="@php echo $element->value->icon @endphp"></i>
                  </span>
                  <div>
                    <h4>
                       {{$element->value->title}}
                    </h4>
                    <p>{{$element->value->sub_title}}</p>
                  </div>
              </a>

            @endforeach
       
           
          </div>
        </div>
      </div>
    </div>
</section>