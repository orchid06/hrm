
@php
   $ctaContent  = get_content("content_cta")->first();  

   $file        = $ctaContent->file->where("type",'image')->first();
   $ctaElements = get_content("element_cta");
   $newsLetter  = get_content("content_newsletter")->first();

   $footer      = get_content("content_footer")->first();
   $paymentImg  = $ctaContent->file->where("type",'payment_image')->first();
   $icons       =  get_content("element_social_icon");



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
                        <a href="{{url(@$ctaBtn->value->url)}}" class="i-btn {{$loop->even ? " btn--secondary" : "btn--primary" }}  btn--lg capsuled">
                             {{@$ctaBtn->value->button_name}}
                        </a>
                    @endforeach
  
              </div>
            </div>
          </div>
        </div>
        <div class="cta-bg">
          <img src="{{imageUrl(@$file,"frontend",true,@get_appearance()->cta->content->images->image->size)}}" alt="{{@$file->name}}" loading="lazy" />
        </div>
      </div>

      <div class="newsletter">
        <div class="container">
          <div class="row gx-0 gy-lg-0 gy-4 align-items-center">
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
                      <input name="email" value="{{old('email')}}" type="email" placeholder="{{translate("Enter your email")}}" />
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
                  <h3>
                        <img
                        src="{{imageUrl(@site_logo('user_site_logo')->file,"user_site_logo",true)}}"
                        alt="{{@site_logo('user_site_logo')->file->name}}" />
                  </h3>
                </a>

                <div class="social-media">

                  @foreach ($icons  as  $icon)

                      <a href="{{@$icon->value->url}}">
                        <i class="{{@$icon->value->social_icon}}"></i>
                      </a>

                  @endforeach
             
                 
                </div>

                <div class="payment-img">
                     <img src="{{imageUrl(@$paymentImg,"frontend",true,@get_appearance()->footer->content->images->payment_image->size)}}" alt="" />
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
          <div class="row gy-3">
            <div class="col-md-4 order-md-0 order-1">
              <div class="text-center text-md-start">
                <p>
                   {{site_settings("copy_right_text")}}
                </p>
              </div>
            </div>

            <div class="col-md-8 order-md-1 order-0">
              <div
                class="d-flex align-items-center justify-content-md-end justify-content-center flex-wrap gap-5">

                <div class="currency d-lg-flex d-none">
                  <h6>{{translate("Currency")}} :</h6>
                  <div class="dropup">
                    <button
                      class="dropdown-toggle"
                      type="button"
                      data-bs-toggle="dropdown"
                      aria-expanded="false">
                      {{session()->get('currency')?->code}}
                    </button>
                    @if(site_currencies() && !site_currencies()->isEmpty())
                        <ul class="dropdown-menu dropdown-menu-end">

                          @foreach(site_currencies()->where("code",'!=',session()->get('currency')->code) as $currency)
                              <li>
                                <a class="dropdown-item" href="{{route('currency.change',$currency->code)}}">
                                   {{$currency->code}}
                                </a>
                              </li>
                          @endforeach
                           
                        </ul>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

</footer>

<div class="back-to-top d-md-flex d-none">
      <p>{{trans('default.back_to_top')}}</p>
      <span></span>
</div>