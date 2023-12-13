@extends('layouts.master')
@section('content')

@php
  
   $feedbackSection   = get_content("content_feedback")->first();  


@endphp

<section class="inner-banner">
      <div class="container">
        <div class="row align-items-center gy-4">
          <div class="col-lg-12">
            <div class="inner-banner-content">
              <h2>{{@$feedbackSection->value->banner_title}}</h2>

              <p>
                {{@$feedbackSection->value->banner_description}}
              </p>
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
            <h3 class="mt-0">{{@$feedbackSection->value->heading}}</h3>
            <p>
              {{@$feedbackSection->value->description}}
            </p>
          </div>
        </div>
      </div>

      <div class="col-lg-7">
        <form action="{{route('feedback.store')}}" class="contact-form ms-xl-5 gs_reveal fromRight" method="post" enctype="multipart/form-data">

          @csrf
          <h4> 
            {{Arr::get($meta_data,"title",'Feedback')}}
          </h4>
          <div class="row gx-4 gy-5 mt-4">
            <div class="col-lg-6">
              <div class="form__group field">
                <input
                  required
                  placeholder="{{translate('Name')}}"
                  class="form__field"
                  name="author"
                  value="{{old('author')}}"
                  type="text"
                  id="author"/>

                <label class="form__label" for="author">
                    {{translate("Name")}}
                </label>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form__group field">
                <input
                  required
                  placeholder="{{translate('Designation')}}"
                  id="designation"
                  class="form__field"
                  type="text"
                  name="designation"
                  value="{{old('designation')}}"/>
                <label class="form__label" for="designation">
                    {{translate("Designation")}}
                </label>
              </div>
            </div>


            <div class="col-lg-6">
           
                <label class="form__label" for="image">
                    {{translate("Image")}}
                </label>
              
                <input  data-size = "100x100" type="file" name="image" id="image" class="preview">

                <div class="mt-2 image-preview-section">
                                        
                </div>

            
                
              </div>
            <div class="col-lg-6">
           
                <div class="rating">
                    @for($i = 5 ; $i>=1 ;$i--)
                            <input required type="radio" value="{{$i}}" @if($i==1) checked  @endif name="rating" id="rating-{{$i}}">
                            <label for="rating-{{$i}}"></label>
                    @endfor
                </div>
                
              </div>
  


            <div class="col-12">
              <div class="form__group field">
                <textarea placeholder="{{translate('Message')}}" required  class="form__field" id="quote" name="quote">{{old('quote')}}</textarea>
                  <label class="form__label" for="quote">
                     {{translate("Write your Message")}}
                  </label>
              </div>
            </div>

            <div class="col-12">
              <button  class="i-btn btn--primary-outline btn--lg capsuled">
                    {{translate("Submit")}}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>


</section>



@include('frontend.partials.page_section')


@endsection

