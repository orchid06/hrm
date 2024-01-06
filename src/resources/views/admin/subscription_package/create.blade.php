@extends('admin.layouts.master')

@section('content')
    <form action="{{route('admin.subscription.package.store')}}" class="add-listing-form" enctype="multipart/form-data" novalidate method="post">
        @csrf
        <div class="i-card-md">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="title">
                                {{translate('Title')}} <small class="text-danger">*</small>
                            </label>
                            <input placeholder="{{translate('Enter Title')}}" id="title"  required type="text" name="title" value="{{old('title')}}">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <label for="duration">
                            {{translate('Duration')}} <small class="text-danger">*</small>
                        </label>
                        <select id="duration" required name="duration" class="select2" >
                            @foreach( App\Enums\PlanDuration::toArray() as $key => $val)
                                <option {{ old("duration") ==  $val ? 'selected' :""}}  value="{{$val}}">
                                    {{ucfirst(strtolower(str_replace("_"," ",$key)))}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="price">
                                {{translate('Price')}} <small class="text-danger">*</small>

                            </label>
                            <div class="input-group mb-3">
                                <input placeholder="{{translate('Enter Price')}}" id="price" step="any" required type="number" min="0" name="price" value="{{old('price')}}" class="form-control">
                                <span class="input-group-text"> {{(base_currency()->code)}} </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="discount_price">
                                {{translate('Discount Price')}}
                            </label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="discount_price" placeholder="{{translate('Enter Discount Price')}}" step="0.1" type="number" min="0" name="discount_price" value="{{old('discount_price')}}">

                                <span class="input-group-text"> {{(base_currency()->code)}} </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="open_ai_model">
                                {{translate("Template Access")}}
                            </label>
                            <select  class="select-template" name="template_access[]" multiple="multiple">
                                <option value="">
                                    {{translate('Select Template')}}
                                </option>
                                @if(old("template_access") && is_array(old("template_access")))
                                   @foreach (App\Models\AiTemplate::default()->cursor() as $template )
                                    <option selected value="{{$template->id}}">
                                         {{$template->name}}
                                    </option>

                                   @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="affiliate_commission">
                                {{translate('Affiliate Commission')}}
                            </label>
                            <div class="input-group mb-3">
                                <input class="form-control" id="affiliate_commission" placeholder="{{translate('Enter commission')}}" step="0.1" type="number" min="0" max="100" name="affiliate_commission" value="{{old('affiliate_commission')}}">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-inner">
                            <label for="description">
                                {{translate('Description')}} <small class="text-danger">*</small>
                            </label>
                            <textarea required placeholder="{{translate('Enter Description')}}" name="description" id="description"  cols="30" rows="5">{{old("description")}}</textarea>
                        </div>
                    </div>

                    <div class="col-lg-12 mt-3 mb-3">
                        <div class="faq-wrap style-2">
                            <div class="accordion" id="advanceOption">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="socailConfig">
                                        <button
                                        class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#socailSection"
                                        aria-expanded="true"
                                        aria-controls="socailSection">
                                            {{translate("Platform Configuration")}}
                                            <i title="{{translate('Social Platform Configuration')}}" class="ms-1 las la-question-circle"></i>
                                        </button>
                                    </h2>
                                    <div id="socailSection" class="accordion-collapse collapse show" aria-labelledby="socailConfig" data-bs-parent="#advanceOption">
                                        <div class="accordion-body">
                                            <div class="row align-items-center">
                                                <div class="col-sm-6">
                                                    <div class="form-inner">
                                                        <label for="platform_access">
                                                            {{translate("Platform Access")}} <small class="text-danger" >*</small>
                                                        </label>
                                                        <select required multiple class="select2" id="platform_access" name="social_access[platform_access][]" >
                                                            <option  value="">
                                                                {{translate("Select Platform")}}
                                                            </option>
                                                            @foreach ($platforms as $platform )
                                                                <option {{ in_array($platform->id , old("social_access.platform_access") ?? []  ) ? 'selected' :""    }}  value="{{$platform->id}}" >
                                                                    {{ $platform->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                               </div>
                                               <div class="col-sm-6">
                                                    <div class="form-inner">
                                                        <label for="profile"
                                                        >{{ translate('Total Profile') }}
                                                        <small class="text-danger" >*</small></label>
                                                        <input type="number" min="1"
                                                        placeholder="{{translate('Total Profile')}}"
                                                        value="{{old('social_access.profile')}}" name="social_access[profile]" id="profile" required>
                                                    </div>
                                               </div>
                                                <div class="col-sm-6">
                                                    <div class="form-inner">
                                                        <label for="post"
                                                        >{{ translate('Total Post') }}
                                                        <small class="text-danger" >*</small> <i title="{{translate('Set -1 make to it unlimited')}}" class="las la-question-circle pointer"></i></label>

                                                        <input type="number" min="-1"
                                                        value="{{old('social_access.post')}}" name="social_access[post]" id="post" placeholder="{{translate('Total Post')}}" required   >
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-1 d-flex align-items-center gap-2">
                                                        <input id="webhook_access" value="{{App\Enums\StatusEnum::true->status()}}" {{old('social_access.webhook_access') == App\Enums\StatusEnum::true->status() ? "checked" :""}} class="form-check-input" name="social_access[webhook_access]" type="checkbox"   >
                                                        <label for="webhook_access" class="form-check-label me-3 mb-0">
                                                            {{translate('Webhook Access')}}
                                                        </label>
                                                    </div>
                                                    <div class="mb-0 d-flex align-items-center gap-2">
                                                       <input id="schedule_post" value="{{App\Enums\StatusEnum::true->status()}}" {{old('social_access.schedule_post') == App\Enums\StatusEnum::true->status() ? "checked" :""}} class="form-check-input" name="social_access[schedule_post]" type="checkbox"   >
                                                        <label for="schedule_post" class="form-check-label me-3 mb-0">
                                                            {{translate('Schedule Posting')}}
                                                        </label>
                                                    </div>
                                                </div>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="aiConfig">
                                        <button
                                        class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#aiSection"
                                        aria-expanded="true"
                                        aria-controls="aiSection">
                                            {{translate("Ai Configuration")}}
                                            <i title="{{translate('Configure ai settings that package should include')}}" class="ms-1 las la-question-circle"></i>
                                        </button>
                                    </h2>
                                    <div id="aiSection" class="accordion-collapse collapse " aria-labelledby="aiConfig" data-bs-parent="#advanceOption">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-inner">
                                                        <label for="open_ai_model">
                                                            {{translate("Ai Model")}}
                                                        </label>
                                                        <select   class="select2" id="open_ai_model" name="ai_configuration[open_ai_model]" >
                                                            <option  value="">
                                                                {{translate("Select Model")}}
                                                            </option>
                                                            @foreach (Arr::get(config('settings'),'open_ai_model',[]) as $k => $v )
                                                                <option value="{{$k}}" {{old("ai_configuration.open_ai_model") == $k  ? "selected" :""}} >
                                                                    {{ $v }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-inner">
                                                        <label for="word_limit"
                                                        >{{ translate('No. Of Words') }}
                                                        <small class="text-danger" >*</small> <i title="{{translate('Set -1 make to it unlimited')}}" class="las la-question-circle pointer"></i></label>

                                                        <input type="number" min="-1"
                                                        value="{{old('ai_configuration.word_limit')}}" name="ai_configuration[word_limit]" id="word_limit" placeholder="{{translate('No. of Words')}}"   >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
   </form>
@endsection

@push('script-push')
<script>
	(function($){
       	"use strict";
           $(".select2").select2({
			   placeholder:"{{translate('Select Item')}}",
	     	})

            $('.select-template').select2({

                placeholder: "{{ translate('Select Template') }}",
                allowClear: false,
                tags: true,
                ajax: {
                    url: "{{ route('admin.subscription.package.selectSearch') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        };
                    },
                    cache: true
                }
            })

	})(jQuery);

</script>
@endpush
