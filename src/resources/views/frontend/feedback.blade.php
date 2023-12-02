@extends('layouts.master')
@section('content')
     @php
        $breadcrumb = frontend_section()->where("slug",'breadcrumb_section')->first();
     @endphp

     @includeWhen(@site_settings('breadcrumbs') == App\Enums\StatusEnum::true->status(),'frontend.partials.breadcrumb',['breadcrumb' => $breadcrumb])

    <section class="form-section pt-110 pb-110">
        <div class="container">
            <div class="row">
                    <div class="col-12">
                        <div class="section-title text-start mb-50">
                            <h2 class="title-header">
                                {{translate("Give Us Feedback")}}
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row g-lg-5 g-4">

                <div class="col-lg-8">
                    <form action="{{route('feedback.store')}}" method="POST" class="add-review-form p-0"  enctype="multipart/form-data">
                        @csrf
                        <div class="form-inner">
                            <label for="rate">
                                {{translate("Rating")}}
                            </label>
                            <div class="rating">
                                @for($i = 5 ; $i>=1 ;$i--)
                                    <input required type="radio" value="{{$i}}" @if($i==1) checked  @endif name="rating" id="rating-{{$i}}">
                                    <label for="rating-{{$i}}"></label>
                                @endfor
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="form-inner">
                                    <input type="text" required name="name" value="{{old('name')? old('name') : auth_user('web')?->name }}" class="input-outline" id="inputname4" placeholder="{{translate("Enter Your Name")}}" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-inner">
                                    <input type="text" required name="address" value="{{old("address")}}" class="input-outline"
                                    placeholder="{{translate("Your Address")}}" />
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-inner">
                                    <input id="image" name="image" type="file">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-inner">
                                    <textarea required class="input-outline" name="review" id="exampleFormControlTextarea1" rows="4"
                                        placeholder="{{translate("Your Review")}}">{{old("review")}}</textarea>
                                </div>
                            </div>

                        </div>

                        <button class="ig-btn btn--primary btn--md" type="submit">
                                {{translate("Submit")}}
                        </button>
                    </form>
                </div>


                @if(site_settings("google_ads") != App\Enums\StatusEnum::true->status())
                    <div class="col-lg-4">
                        <div class="row gy-4">
                            @if(add_shortcode("contact_top"))
                            <div class="col-lg-12">
                                @php echo add_shortcode("contact_top") @endphp
                            </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection



