@extends('layouts.master')
@section('content')

@php

   $contactSection   = get_content("content_contact_us")->first();

   $file   = $contactSection->file->where("type",'image')->first();

@endphp

<section class="inner-banner">
  <div class="container">
    <div class="row align-items-center gy-4">
      <div class="col-lg-6">
        <div class="inner-banner-content">
          <h2>{{@$contactSection->value->banner_title}}</h2>
          <p>
            {{@$contactSection->value->banner_description}}
          </p>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="w-75 mx-auto">
          <img src="{{imageUrl(@$file,'frontend',true,@get_appearance()->contact_us->content->images->image->size)}}" alt="{{@$file->name}}" />
        </div>
      </div>
    </div>
  </div>
  <div class="primary-shade"></div>
  <div class="banner-texture"></div>
</section>

<section class="contact pb-110">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-5">
        <div class="contact-left gs_reveal fromLeft">
          <div class="section-title light">
            <h3 class="mt-0">{{@$contactSection->value->section_heading}}</h3>
            <p>
              {{@$contactSection->value->section_description}}
            </p>
          </div>
          <ul class="contact-list">
            <li>
              <span><i class="bi bi-envelope-open"></i></span>
              <div>
                <a href="mailto:{{site_settings('email')}}">
                    {{site_settings("email")}}
                </a>
              </div>
            </li>
            <li>
              <span><i class="bi bi-telephone"></i></span>
              <div>
                <a href="tel:{{site_settings('phone')}}"> {{site_settings("phone")}}</a>
              </div>
            </li>
            <li>
              <span><i class="bi bi-geo-alt"></i></span>
              <div>
                <a href="javascript:void(0)"> {{site_settings("address")}}</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-lg-7">
        <form action="{{route('contact.store')}}" class="contact-form ms-xl-5 gs_reveal fromRight" method="post">
          @csrf
          <h4>  {{$contactSection->value->section_title}}</h4>
          <div class="row gx-4 gy-5 mt-4">
            <div class="col-lg-6">
              <div class="form__group field">
                <input
                  required
                  placeholder="{{translate('Name')}}"
                  class="form__field"
                  name="name"
                  value="{{old('name')}}"
                  type="text"
                  id="name"/>
                <label class="form__label" for="name">
                    {{translate("Name")}}
                </label>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form__group field">
                <input
                  required
                  placeholder="{{translate('Phone')}}"
                  id="number"
                  class="form__field"
                  type="text"
                  name="phone"
                  value="{{old('phone')}}"/>
                <label class="form__label" for="number">
                    {{translate("Phone")}}
                </label>
              </div>
            </div>
            <div class="col-12">
              <div class="form__group field">
                <input
                  required
                  placeholder="{{translate('Email')}}"
                  class="form__field"
                  type="email"
                  name="email"
                  value="{{old('email')}}"
                  id="email"/>
                <label class="form__label" for="email">
                    {{translate('Email')}}
                </label>
              </div>
            </div>
            <div class="col-12">
              <div class="form__group field">
                <input
                  required
                  placeholder="{{translate('Subject')}}"
                  name="subject"
                  class="form__field"
                  value="{{old('subject')}}"
                  type="text"
                  id="subject"
                />
                <label class="form__label" for="subject">
                   {{translate("Subject")}}
                </label>
              </div>
            </div>
            <div class="col-12">
              <div class="form__group field">
                <textarea placeholder="{{translate('Message')}}" required  class="form__field" id="message" name="message">{{old('message')}}</textarea>
                  <label class="form__label" for="message">
                     {{translate("Write your Message")}}
                  </label>
              </div>
            </div>
            <div class="col-12">
              <button  class="i-btn btn--primary-outline btn--lg capsuled">
                    {{translate("Send Message")}}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="existing-customer">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
      <div>
        <h5> {{@$contactSection->value->support_title}}</h5>
        <p>
           {{@$contactSection->value->support_description}}
        </p>
      </div>
      <a
        href="{{url(@$contactSection->value->button_url)}}"
        class="i-btn btn--secondary btn--lg capsuled">
        {{@$contactSection->value->button_name}}
      </a>
    </div>
  </div>
</section>



@include('frontend.partials.page_section')

@endsection

