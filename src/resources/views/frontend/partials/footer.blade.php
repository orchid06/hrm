
@php
   $ctaContent  = get_content("content_cta")->first();

   $file        = $ctaContent->file->where("type",'image')->first();
   $ctaElements = get_content("element_cta");
   $newsLetter  = get_content("content_newsletter")->first();

   $footer      = get_content("content_footer")->first();
   $paymentImg  = $footer->file->where("type",'payment_image')->first();
   $icons       =  get_content("element_social_icon");

   $lang         = $languages->where('code',session()->get('locale'));
   $code         = count($lang)!=0 ? $lang->first()->code:"en";
   $langName     = count($lang)!=0 ? $lang->first()->name:"en";
   $languages    = $languages->where('status',App\Enums\StatusEnum::true->status());

@endphp

<footer class="footer">
      <div class="cta pb-110 pt-110">
        <div class="container">
          <div class="row">
            <div class="col-lg-7 mx-auto">
              <div class="section-title light text-center">
                  <h3 class="mt-0 title-anim">
                     {{@$ctaContent->value->title}}
                  </h3>
                  <p class="mt-4">
                    {{@$ctaContent->value->description}}
                  </p>
              </div>

              <div class="d-flex align-items-center justify-content-center gap-3 gap-md-4 text-center">

                  @foreach ( $ctaElements as $ctaBtn )
                      <a href="{{url(@$ctaBtn->value->url)}}" class='i-btn {{$loop->even ? " btn--secondary" : "btn--primary" }}  btn--lg capsuled'>
                            {{@$ctaBtn->value->button_name}}
                      </a>
                  @endforeach

              </div>
            </div>
          </div>
        </div>
        <div class="cta-bg">
          <img src='{{imageUrl(@$file,"frontend",true,@get_appearance()->cta->content->images->image->size)}}' alt="{{@$file->name}}" loading="lazy" />
        </div>
      </div>

      <div class="newsletter">
        <div class="container">
          <div class="row gx-0 gy-lg-0 gy-4 align-items-center overflow-hidden">
            <div class="col-lg-5 gs_reveal fromLeft">
              <div class="news-content">
                <h4>
                  {{@$newsLetter->value->title}}
                </h4>
                <p>
                  {{@$newsLetter->value->description}}
                </p>
              </div>
            </div>
            <div class="col-lg-7 gs_reveal fromRight">
              <form action="{{route('subscribe')}}" class="news-form" method="post">
                  @csrf
                    <div class="news-form-content">
                      <input name="email" value="{{old('email')}}" type="email" placeholder='{{translate("Enter your email")}}' />
                      <button
                        type="submit"
                        class="i-btn btn--primary btn--lg capsuled">
                        <span class="d-md-block d-none">
                          {{translate("Subscribe")}}
                        </span>
                        <i class="bi bi-send"></i>
                      </button>
                    </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="footer-content">
        <div class="container">
          <div class="row gx-0">
            <div class="col-lg-6">
              <div class="footer-left">
                <a href="{{route('home')}}" class="site-log">
                    <img
                    src='{{imageUrl(@site_logo("user_site_logo")->file,"user_site_logo",true)}}'
                    alt="{{@site_logo('user_site_logo')->file->name}}" />
                </a>

                <div class="social-media">

                  @foreach ($icons  as  $icon)

                      <a href="{{@$icon->value->url}}">
                        <i class="{{@$icon->value->social_icon}}"></i>
                      </a>

                  @endforeach


                </div>

                <div class="payment-img">
                     <img src="{{imageUrl(@$paymentImg,'frontend',true,@get_appearance()->footer->content->images->payment_image->size)}}" alt="{{@$paymentImg->name}}" />
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="footer-menu-wrapper">
                <div class="row g-4 gy-5">
                  <div class="col-md-6 col-sm-6 col-6">
                    <div class="footer-menu">
                      <h6> {{translate("Important Links")}}</h6>
                      <ul>

                        @foreach ($menus as  $menu)

                            <li><a href="{{url($menu->url)}}">  {{$menu->name}}</a></li>

                        @endforeach

                      </ul>
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-6 col-6">
                    <div class="footer-menu">
                      <h6>
                        {{translate("Quick Link")}}
                      </h6>
                      <ul>
                          @foreach ($pages as  $page)
                              <li><a href="{{route('page',$page->slug)}}"> {{$page->title}}</a></li>
                          @endforeach
                      </ul>
                    </div>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="footer-bottom pb-4 pt-4">
        <div class="container">
            <div class="footer-bottom-wrapper">
                <p>
                    {{site_settings("copy_right_text")}}
                </p>

                 <button class="language-btn" data-bs-toggle="modal" data-bs-target="#langModal">
                    <span class="language-img"><img src="{{asset('assets/images/global/flags/'.strtoupper($code).'.png') }}" alt="{{$code}}"></span>
                    <p>{{   $langName }} </p>
                </button>
            </div>
        </div>

      </div>

</footer>

<div class="modal fade zoomIn" id="langModal" tabindex="-1" aria-labelledby="langModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="langModalLabel"> {{translate("Select Your Language")}} </h1>
        <button type="button" class="modal-closer" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></button>
      </div>
      <div class="modal-body lang-modal">
        <div class="lang-modal-wrapper">
            <div class="row g-1">

                @foreach ($languages  as $language )

                  <div class="col-md-4 col-sm-4 col-6">
                      <a href="{{route('language.change',$language->code)}}" class="language-item @if($code == $language->code) active @endif">
                          <span class="language-item-img"><img src="{{asset('assets/images/global/flags/'.strtoupper($language->code ).'.png') }}" alt="{{$language->code}}"></span>
                          <p>
                            {{$language->name}}
                          </p>
                      </a>
                  </div>
                      
                @endforeach
         
            </div>
        </div>

        <img src="{{asset('assets/images/default/map.jpg')}}" alt="map.jpg">
      </div>
      <div class="modal-footer">
        <button type="button" class="i-btn bg--danger  btn--md capsuled" data-bs-dismiss="modal">
            {{translate('Close')}}
        </button>
      </div>
    </div>
  </div>
</div>
