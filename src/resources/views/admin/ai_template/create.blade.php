@extends('admin.layouts.master')
@push('style-include')
    <link rel="stylesheet" href="{{asset('assets/global/css/bootstrapicons-iconpicker.css')}}">
@endpush
@section('content')


    <form action="{{route('admin.ai.template.store')}}" class="add-listing-form" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row g-4">

     
            <div class="col-xl-12">
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
                                    <label for="Name"> 
                                        {{translate('Name')}} <small class="text-danger">*</small>
                                    </label>

                                    <input placeholder="{{translate('Enter name')}}" id="Name"  required type="text" name="name" value='{{old("name")}}'>

                                
                                
                                </div>
                            </div>
                        
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="slug"> 
                                        {{translate('slug')}} 
                                    </label>

                                    <input placeholder="{{translate('Enter Slug')}}" id="slug"  type="text" name="slug" value='{{old("slug")}}'>       
                                    
                                    
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


                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="Icon"> 
                                        {{translate('Icon')}} <span class="text-danger">*</span>
                                    </label>

                                    <input placeholder='{{translate("Search Icon")}}' class="icon-picker" value='{{old("icon")}}' type="text" name="icon" id="Icon">
                                
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="form-inner">
                                    <label for="description"> 
                                        {{translate('Short Description')}}  <span class="text-danger">*</span>
                                    </label>

                                    <textarea  placeholder='{{translate("Enter Short Description")}}' name="description" id="description" cols="30" rows="2">{{old("description")}}</textarea>

                                </div>
                            </div>
                        


                       
                        </div>
                    </div>            
                </div>
            </div>



            <div class="col-xl-12">
                <div class="i-card-md">
                    <div class="card--header">
                        <h4 class="card-title">
                            {{translate('Prompt Information')}}
                        </h4>
                    </div> 

                    <div class="card-body">
                        <div class="row">

                            <div class="col-12 mb-20">
                                <a href="javascript:void(0)" class="i-btn btn--md success" id="addNew">  <i class="las la-plus me-1"></i> {{translate('Add New Field')}}</a>
                            </div>  

                           <div class="col-12">
                                <div class="addedField form-inner">  
                                    
                                </div>
                           </div>

                            <div class="col-lg-12">


                                <div class="mb-4 input-hint d-none">
                                    <label>{{ translate('Input Variables') }}</label>
                                    <div class="input-var">
                                    </div>
                                    <small>{{ translate('Click on variable to set the user input of it in your prompts')}}</small>
                                </div>

                      
                                <div class="form-inner">

                                    <label for="customPrompt"> 
                                        {{translate('Prompt')}} <small class="text-danger">*</small>
                                    </label>

                                    <textarea  placeholder='{{translate("Enter Prompt")}}' name="custom_prompt" id="customPrompt" cols="30" rows="2">{{old("custom_prompt")}}</textarea>

                                </div>
                            </div>


                            <div class="col-12">
                              
                                <div class="form-inner ">
                                    <label class="me-2">
                                        {{translate("Is Default")}}
                                    </label>
                                    @foreach (App\Enums\StatusEnum::toArray() as $k => $v )
                                        <input id="{{ $k }}"  {{$v == 0 ? "checked" :""}}  value="{{ $v }}" class="form-check-input" name="is_default" type="radio">
                                        <label for="{{ $k }}"  class="form-check-label me-2">
                                            {{translate($v == 1 ? "Yes" : "No")}}
                                        </label>
                                    @endforeach

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

        </div>
   </form>

@endsection
@push('script-include')
    <script src="{{asset('assets/global/js/bootstrapicon-iconpicker.js')}}"></script>
    @include('partials.ai_template_script');
@endpush


@push('script-push')
<script>
	(function($){
       	"use strict";
    
       
            $(".select2").select2({
			   placeholder:"{{translate('Select Category')}}",
	     	})

            $('.icon-picker').iconpicker({
               title: "{{translate('Search Here !!')}}",
            });

           
        
	})(jQuery);
</script>
@endpush
