@extends('admin.layouts.master')
@push('style-include')
    <link rel="stylesheet" href="{{asset('assets/global/css/bootstrapicons-iconpicker.css')}}">
@endpush

@section('content')
    @php
         $sortedArray = translateable_locale($languages);
         $col = @site_settings('site_seo') == App\Enums\StatusEnum::true->status() ? 8 :12;
    @endphp

    <form action="{{route('admin.category.update')}}" class="add-listing-form" enctype="multipart/form-data" method="post">
        @csrf
        <input hidden type="text" name="id" value="{{$category->id}}">
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

                            <div class="col-lg-12">
                                <ul class="nav nav-tabs style-1" role="tablist">                                  
                                    @foreach($sortedArray as $code)
                                        <li class="nav-item" role="presentation">
                                            <button class='nav-link  
                                            {{$loop->index == 0 ? "active" :""}}
                                            ' id="lang-tab-{{$code}}" data-bs-toggle="pill" data-bs-target="#lang-tab-content-{{$code}}" type="button" role="tab" aria-controls="lang-tab-content-{{$code}}" aria-selected="true">
                                                <img class="lang-img" src="{{asset('assets/images/global/flags/'.strtoupper($code ).'.png') }}" alt="{{$code}}" class="me-2 rounded" height="18">
                                                <span class="align-middle">
                                                   
                                                   {{$code}}
                                                    
                                                   
                                                </span>
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>

                                <div id="titleTab" class="tab-content">

                                    @php
                                      $modelTranslations ['default'] = $category->getRawOriginal('title');
                                    
                                     if( 0 < $category->translations->count()){
                                         foreach ($category->translations as $translation) {

                                            $modelTranslations[$translation->locale] =  $translation->value;
                                         }
                                     }
                                    
                                   @endphp


                                    @foreach($sortedArray as $code)

                                      
                                        <div class='tab-pane fade {{$loop->index == 0 ? " show active" :""}}' id="lang-tab-content-{{$code}}" role="tabpanel">                                       
                                            <div class="form-inner">                                               
                                                <label  for="{{$code}}-input">
                                                    {{translate('Title')}} 
                                                    @if("default" == strtolower($code))
                                                       <span class="text-danger d-inline-block nowrap fs-18" >*</span>
                                                       @else
                                                       ({{$code}})
                                                    @endif
                                                </label>
                                                @php
                                                    $lang_code =  strtolower($code)
                                                @endphp
   
                                                <input id="{{$code}}-input" type="text" name="title[{{strtolower($code)}}]"   placeholder='{{translate("Enter Title")}}'
                                                    value="{{data_get($modelTranslations,strtolower($code),null)}}">

                                             
                                               
                                            </div>                                                                         
                                        </div>
                                    @endforeach
                                    
                                </div>
                            </div>
                            

                            <div class="col-lg-6">
                                <div class=" form-inner">
                                    <label  for="slug">
                                        {{translate('Slug')}} 
                                    </label>
                                
                                    <input type="text" name="slug" id="slug"  placeholder='{{translate("Enter Slug")}}'
                                        value="{{$category->slug}}">  
                                                                                               
                                </div>                                                                         
                        
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="Icon"> 
                                        {{translate('Icon')}} <span class="text-danger">*</span>
                                    </label>

                                    <input placeholder='{{translate("Search Icon")}}' class="icon-picker" value="{{$category->icon}}" type="text" name="icon" id="Icon">
                                
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="form-inner">
                                    <label for="description"> 
                                        {{translate('Short Description')}} 
                                    </label>

                                    <textarea placeholder='{{translate("Enter Short Description")}}' name="description" id="description" cols="30" rows="2">{{$category->description}}</textarea>

                                </div>
                            </div>


                            <div class="col-12">
                              
                                <div class="form-inner ">
                                    <label class="me-2">
                                        {{translate("Display In")}}
                                    </label>
                                    @foreach (App\Enums\CategoryDisplay::toArray() as $k => $v )
                                        <input id="{{ $k }}" @if($category->display_in == $v ) checked  @endif value="{{ $v }}" class="form-check-input" name="display_in" type="radio">
                                        <label for="{{ $k }}" class="form-check-label me-2">
                                            {{translate($k)}}
                                        </label>
                                    @endforeach
  
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
            
            @includeWhen(@site_settings('site_seo') == App\Enums\StatusEnum::true->status(),'admin.partials.seo',['model' => $category])
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
    
            $('.icon-picker').iconpicker({
               title: "{{translate('Search Here !!')}}",
            });

            $(".selectMeta").select2({
                placeholder:"{{translate('Enter Keywords')}}",
                tags: true,
                tokenSeparators: [',']
	     	})
	})(jQuery);
</script>
@endpush







