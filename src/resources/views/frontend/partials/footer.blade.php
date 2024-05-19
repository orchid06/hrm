
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

<!-- new footer start -->

<footer>
  <div class="container">
    <div class="footer-top pt-110 pb-110">
        <div class="row justify-content-center">
          <div class="col-lg-9">
              <div class="footer-top-content">
                <img src="https://i.ibb.co/DVPw8yg/footer-top.png" alt="footer-top" class="footer-top-img">
                <h2>Improve your social media content</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipiscing elit dolor posuere vel venenatis eu sit massa volutpat.</p>
                <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                  <a href="#" class="i-btn btn--lg btn--primary capsuled">Get Started FREE <span><i class="bi bi-arrow-up-right"></i></span></a>
                  <a href="#" class="i-btn btn--lg btn--white capsuled">BOOK a DEMO<span><i class="bi bi-arrow-up-right"></i></span></a>
                </div>
              </div>
          </div>
        </div>
    </div>
  </div>
  <div class="container-fluid px-0">
    <div class="news-letter-area">
        <div class="newsletter-wrapper">
          <form>
            <input type="email" placeholder="Enter your mail">
            <button href="#" class="i-btn btn--lg btn--primary capsuled">SUBSCRIBE<span><i class="bi bi-arrow-up-right"></i></span></button>
          </form>
        </div>
    </div>
  </div>

  <div class="container">
      <div class="footer-bottom">
        <div class="row gy-5">
          <div class="col-lg-7">
            <div class="row gy-5">
              <div class="col-md-4 col-sm-4 col-6">
                <h4 class="footer-title">Quick link</h4>
                <ul class="footer-list">
                  <li><a href="#">Home</a></li>
                  <li><a href="$">Plans</a></li>
                  <li><a href="#">Services</a></li>
                  <li><a href="#">Contact</a></li>
                </ul>
              </div>
              <div class="col-md-4 col-sm-4 col-6">
                <h4 class="footer-title">Resources</h4>
                <ul class="footer-list">
                  <li><a href="#">Blog</a></li>
                  <li><a href="#">FAQ</a></li>
                  <li><a href="#">Support</a></li>
                </ul>
              </div>
              <div class="col-md-4 col-sm-4 col-6">
                <h4 class="footer-title">Information</h4>
                <ul class="footer-list">
                  <li><a href="#">About Us</a></li>
                  <li><a href="#">Contact Us</a></li>
                  <li><a href="#">Terms & Conditions</a></li>
                  <li><a href="#">Privacy Policy</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="row gy-5">
              <div class="col-md-6 col-sm-6">
                <h4 class="footer-title">Services</h4>
                <ul class="footer-list">
                  <li><a href="#">Ai Content</a></li>
                  <li><a href="#">Social Media Monitor</a></li>
                  <li><a href="#">SEO Management</a></li>
                  <li><a href="#">Social Engagement</a></li>
                </ul>
              </div>
              <div class="col-md-6 col-sm-6">
                <h4 class="footer-title">Blog</h4>
                <ul class="footer-list">
                  <li><a href="#">People saying about footer...</a><span>8 Nov, 2024</span></li>
                  <li><a href="#">People saying footer...</a><span>8 Nov, 2024</span></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="copyright-area d-flex justify-content-lg-between justify-content-center align-items-center flex-wrap gap-4">
          <div class="footer-social">
            <ul>
              <li><a href="https://www.facebook.com/"><i class="bi bi-facebook"></i></a></li>
              <li><a href="https://twitter.com/"><i class="bi bi-twitter"></i></a></li>
              <li><a href="https://www.instagram.com/"><i class="bi bi-instagram"></i></a></li>
              <li><a href="https://www.youtube.com/"><i class="bi bi-youtube"></i></a></li>
            </ul>
          </div>
          <div class="copyright">
            <p class="mb-0 text-white opacity-75 fs-14 lh-1">© 2023 All rights reserved</p>
          </div>
      </div>
  </div>
</footer>

<!-- new footer end -->

<!-- <footer class="footer">
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
                    {{   $langName }}
                </button>
            </div>
        </div>

      </div>

</footer> -->

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
