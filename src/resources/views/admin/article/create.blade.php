@extends('admin.layouts.master')
@push('style-include')
<link rel="stylesheet" href="{{asset('assets/global/css/summnernote.css')}}">
@endpush
@section('content')


    <form action="{{route('admin.article.store')}}" class="add-listing-form" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row g-4">

            @php
                    $col = @site_settings('site_seo') == App\Enums\StatusEnum::true->status() ? 8 :12;
            @endphp
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
                                    <label for="title"> 
                                        {{translate('Title')}} <small class="text-danger">*</small>
                                    </label>

                                    <input placeholder="{{translate('Enter Title')}}" id="title"  required type="text" name="title" value="{{old("title")}}">

                               
                                
                                </div>
                            </div>
                        
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="slug"> 
                                        {{translate('slug')}} 
                                    </label>

                                    <input placeholder="{{translate('Enter Slug')}}" id="slug"  type="text" name="slug" value="{{old("slug")}}">       
                                 
                                </div>
                            </div>

                            

                            <div class="col-12">
                                <div class="form-inner">
                                    <label for="description"> 
                                        {{translate('Description')}} <small class="text-danger">*</small>
                                    </label>
                                    <textarea  class="summernote" name="description" id="description"  cols="30" rows="5">{{old("description")}}</textarea>
                                </div>
                            </div>
                        
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="image"> 
                                        {{translate('Image')}} <small class="text-danger">({{config("settings")['file_path']['article']['size']}})</small>
                                    </label>
                                
                                    <input data-size = {{config("settings")['file_path']['article']['size']}} id="image" name="image" type="file" class="preview" >
            
                                    <div class="mt-2 image-preview-section">
                                        
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="category"> 
                                        {{translate('Category')}} <small class="text-danger">*</small>
                                    </label>
                                    <select required name="category_id" id="category" class="select2" >
                                        <option value="" >
                                            {{translate("Select Category")}}
                                        </option>
                                        @foreach($categories as $category)
                                            <option {{old("category_id") ==  $category->id ? "selected" :""}} value="{{$category->id}}">
                                                {{($category->title)}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 ">
                                <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
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

<script src="{{asset('assets/global/js/summernote.min.js')}}"></script>

<script src="{{asset('assets/global/js/editor.init.js')}}"></script>

@endpush


@push('script-push')
<script>
	(function($){
       	"use strict";
    
            $(".select2").select2({
			   placeholder:"{{translate('Select Category')}}",
	     	})
            $(".selectMeta").select2({
                placeholder:"{{translate('Enter Keywords')}}",
                tags: true,
                tokenSeparators: [',']
	     	})
	})(jQuery);
</script>
@endpush
