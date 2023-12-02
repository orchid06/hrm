@extends('layouts.master')
@section('content')
     @php
        $breadcrumb = frontend_section()->where("slug",'breadcrumb_section')->first();
     @endphp

     @includeWhen(@site_settings('breadcrumbs') == App\Enums\StatusEnum::true->status(),'frontend.partials.breadcrumb',['breadcrumb' => $breadcrumb])

      <section class="pt-110">
          <div class="container">
            <div class="row g-4 justify-content-center">
              <div class="col-lg-4 col-md-6 col-sm-10">
                <div class="address-item">
                  <div class="icon-wrap">
                    <div class="icon">
                      <i class="fa-sharp fa-light fa-envelope"></i>
                    </div>
                  </div>
                  <div class="content">
                    <h4>
                      {{translate("Email")}}
                    </h4>
                    <a href="mailto:{{site_settings('email')}}">{{site_settings('email')}}</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-sm-10">
                <div class="address-item">
                  <div class="icon-wrap">
                    <div class="icon">
                      <i class="fa-sharp fa-light fa-phone"></i>
                    </div>
                  </div>
                  <div class="content">
                    <h4>
                      {{translate("Phone")}}
                    </h4>
                    <a href="tel:{{site_settings('phone')}}">{{site_settings('phone')}}</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-sm-10">
                <div class="address-item">
                  <div class="icon-wrap">
                    <div class="icon">
                      <i class="fa-sharp fa-light fa-location-dot"></i>
                    </div>
                  </div>
                  <div class="content">
                    <h4>
                      {{translate("Address")}}
                    </h4>

                    {{site_settings('address')}}

                  </div>
                </div>
              </div>
            </div>
          </div>
      </section>

      <section class="form-section pt-110 pb-110">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="section-title text-start mb-50">
                <h2 class="title-header">
                    {{translate("Get In Touch")}}
                </h2>
              </div>
            </div>
          </div>
          <div class="row g-lg-5 g-4">
            <div class="col-lg-8">
              <form class="rounded-3" method="post" action="{{route('contact.store')}}">
                @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-inner">
                                <input type="text" name="name" value="{{old('name')}}" class="form-control input-outline" id="inputname4" placeholder="{{translate("Enter Your Name")}}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-inner">
                            <input type="email" required name="email" class="form-control input-outline" id="inputEmail4"
                                placeholder="{{translate("Enter Your Email")}}" value="{{old("email")}}" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-inner">
                                <input type="text" required name="address" value="{{old("address")}}" class="form-control input-outline"
                                placeholder="{{translate("Your Address")}}" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-inner">
                                <textarea required class="form-control input-outline" name="message" id="exampleFormControlTextarea1" rows="4"
                                    placeholder="{{translate("Your Message")}}">{{old("message")}}</textarea>
                            </div>
                        </div>

                        <div class="col-12 d-flex align-items-center justify-content-start mt-30">
                            <button type="submit" class="ig-btn btn--primary btn--md">
                                {{translate("Submit")}}
                            </button>
                        </div>
                    </div>
              </form>
            </div>

            @if(site_settings("google_ads") != App\Enums\StatusEnum::true->status())
              <div class="col-lg-4">
                <div class="row g-3">
                    @if(add_shortcode("contact_top"))
                      <div class="col-lg-12">
                            <div class="box-sm shadow-one">
                                @php echo add_shortcode("contact_top") @endphp
                            </div>
                      </div>
                    @endif
                </div>
              </div>
            @endif
          </div>
        </div>
      </section>

@endsection

