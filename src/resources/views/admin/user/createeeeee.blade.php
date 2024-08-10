@extends('admin.layouts.master')

@push('style-include')
    <link rel="stylesheet" href="{{asset('assets/global/css/bootstrapicons-iconpicker.css')}}">
@endpush

@section('content')

   @php
        $sortedArray = translateable_locale($languages);
        $col = @site_settings('site_seo') == App\Enums\StatusEnum::true->status() ? 8 :12;
   @endphp

    <form action="{{route('admin.category.store')}}" class="add-listing-form" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row g-4">
            <div class="col-xl-{{$col}}">
                <div class="i-card-md">
                    <div class="card--header">
                        <h4 class="card-title">
                            {{translate('Basic Information')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label  for="Name">
                                        {{translate('Name')}} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="Name"  required  placeholder="{{translate('Enter Name')}}"
                                        value="{{old('name')}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="username">
                                        {{translate('Username')}}
                                            <small class="text-danger">*</small>
                                    </label>
                                    <input type="text" name="username" id="username"  placeholder="{{translate('Enter User Name')}}"
                                        value="{{old('username')}}" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-inner">
                                    <label for="email">
                                        {{translate('Email')}}
                                            <small class="text-danger">*</small>
                                    </label>

                                    <input type="email" name="email" id="email"   placeholder="{{translate('Enter Email')}}"
                                        value="{{old('email')}}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="country">
                                        {{translate('Country')}}
                                    </label>
                                    <select name="country_id" id="country">
                                        <option value="">
                                            {{translate('Select Country')}}
                                        </option>
                                        {{-- @foreach ($countries as $country )
                                            <option {{old('country_id') == $country->id ? "selected" :""}} value="{{$country->id}}">
                                                 {{$country->name}}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="phone">
                                        {{translate('Phone')}}
                                    </label>
                                    <input type="text" name="phone" id="phone" placeholder="{{translate('Enter Phone')}}"
                                        value="{{old('phone')}}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="status">
                                        {{translate('Status')}}
                                            <small class="text-danger">*</small>
                                    </label>
                                    <select class="select2" name="status" id="status">
                                        @foreach(App\Enums\StatusEnum::toArray() as $status=>$value)
                                            <option {{old('status') == $value ? "selected" :"" }} value="{{$value}}">
                                                {{$status}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="image">
                                        {{translate('Profile Image')}}
                                    </label>
                                    <input data-size = "{{config('settings')['file_path']['profile']['user']['size']}}" id="image" name="image" type="file" class="preview" >
                                    <div class="mt-2 image-preview-section">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-inner">
                                    <label for="password">
                                        {{translate('Password')}}
                                            <small class="text-danger">*({{translate('Minimum 6 Characters')}})</small>
                                    </label>
                                    <input placeholder="{{translate('Enter Password')}}" type="text" id="password"  name="password" value="{{old('password')}}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-inner">
                                    <label for="password_confirmation">
                                        {{translate('Confrim Password')}}
                                            <small class="text-danger">*({{translate('Minimum 6 Characters')}})</small>
                                    </label>
                                    <input placeholder="{{translate('Enter Confirm Password')}}" type="text" id="password_confirmation"  name="password_confirmation" value="{{old('password_confirmation')}}">
                                </div>
                            </div>
                        </div>

                            <div class="col-12 ">
                                <button type="submit" class="i-btn btn--md btn--primary" data-anim="ripple">
                                    {{translate("Submit")}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @includeWhen(@site_settings('site_seo') == App\Enums\StatusEnum::true->status(),'admin.partials.seo')
        </div>
   </form>
@endsection

@push('script-include')
    <script src="{{asset('assets/global/js/bootstrapicon-iconpicker.js')}}"></script>
@endpush

@push('script-push')
<script>
	(function($){
       	"use strict";
            "use strict";

            $(".selectMeta").select2({
                placeholder:"{{translate('Enter Keywords')}}",
                tags: true,
                tokenSeparators: [',']
	     	})

            $('.icon-picker').iconpicker({
               title: "{{translate('Search Here !!')}}",
            });
            $('#parent_id').select2({});

	})(jQuery);
</script>
@endpush
