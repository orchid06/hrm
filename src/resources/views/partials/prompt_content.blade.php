<div  class="content-section">

      @php
           $generateRoute = route('admin.ai.template.content.generate');
           $iconClass  = "las la-question-circle text--danger";

            if(request()->routeIs('user.*')){
                $generateRoute  =  route('user.ai.content.generate');
                $iconClass      = "bi bi-info-circle text--danger";
            }
      @endphp

    <div class="i-card-md  @if(!@$modal) mt-4 @endif position-relative @if(@$modal) border-0 @endif  " id="ai-form">

        @include('admin.partials.card_loader')

        @if(!@$modal)
            <div class="{{request()->routeIs('user.*') ? 'card-header' :'card--header' }}">
                <h4 class="card-title">
                    {{translate("Generate Content")}}
                </h4>
            </div>
        @endif

        <div class="card-body">
            <form data-route="{{$generateRoute}}" class="ai-content-form" >
                @csrf
                <div class="row">

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
                            <label for="sub_category_id">
                                {{translate('Sub Category')}}
                            </label>
                            <select  name="sub_category_id" id="sub_category_id" class="sub_category_id" >
                                <option value="" >
                                    {{translate("Select One")}}
                                </option>
                            </select>
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="templates">
                                {{translate("Templates")}}
                            </label>
                            <select name="id" class="selectTemplate" id="templates">


                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-inner">
                                <label for="language">
                                    {{translate('Select input & output language')}} <small class="text-danger">*</small>
                                </label>

                                <select name="language" class="select2" id="language">
                                    @foreach ($languages as $language )
                                        <option {{session()->get('locale') == $language->code ? "selected" :"" }} value="{{$language->name}}">
                                            {{$language->name}}
                                        </option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>

                <div class="row d-none template-prompt">

                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="faq-wrap style-2">
                                <div class="accordion" id="advanceOption">
                                    <div class="accordion-item mb-0">
                                        <h2 class="accordion-header" id="advanceContent">
                                            <button
                                            class="accordion-button  @if(!request()->routeIs('user.*')) collapsed @endif"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#advanceAcc"
                                            aria-expanded="true"
                                            aria-controls="advanceAcc">
                                                {{translate("Advance Options")}}
                                                <i  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('Browse More Fields')}}" class="ms-1 {{$iconClass}}"></i>

                                                
                                            </button>
                                        </h2>
                                        <div id="advanceAcc" class="accordion-collapse collapse @if(request()->routeIs('user.*')) collapse show" @endif aria-labelledby="advanceContent" data-bs-parent="#advanceOption">
                                            <div class="accordion-body">
                                                <div class="form-inner">
                                                    <label for="max_result">
                                                        {{translate("Max Results Length")}} <i  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('Maximum words for each result')}}"  class="ms-1 pointer {{$iconClass}}"></i>
                                                        @if(request()->routeIs('user.*'))
                                                            <span class="text--danger">*</span>
                                                        @endif
                                                    </label>
                                                    <input placeholder="{{translate('Enter number')}}" type="number" min="1"
                                                    id="max_result" name="max_result"  value='{{old("max_result")}}' >
                                                </div>

                                                <div class="form-inner">
                                                    <label for="ai_creativity" class="form-label">{{ translate('AI Creativity Level') }}
                                                </label>
                                                    <select class="select2" id="ai_creativity" name="ai_creativity" >
                                                        <option  value="">
                                                            {{translate("Select Creativity")}}
                                                        </option>
                                                        @foreach (Arr::get(config('settings'),'default_creativity',[]) as $k => $v )
                                                            <option  value="{{$v}}" >
                                                                {{ $k }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-inner">
                                                    <label for="content_tone" class="form-label">{{ translate('Content Tone') }} </label>
                                                    <select  class="select2" id="content_tone" name="content_tone">
                                                            <option value="">
                                                                {{translate("Select Tone")}}
                                                            </option>
                                                            @foreach (Arr::get(config('settings'),'ai_default_tone',[]) as $v )
                                                                    <option {{old("content_tone") == $v ? 'selected' :""}} value="{{$v}}">
                                                                        {{ $v }}
                                                                    </option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>

                    </div>

                <div class="col-lg-12 generate-btn  {{request()->routeIs('user.*') ? 'mt-3':''}}">
                        <button type="submit" class="{{request()->routeIs('user.*') ? ' ai-btn i-btn btn--lg btn--primary capsuled' : 'ai-btn i-btn btn--primary btn--lg' }}">
                            {{translate("Generate")}}

                            @if(request()->routeIs('user.*'))
                            <span><i class="bi bi-arrow-up-right"></i></span>
                            @endif
                        </button>
                </div>

                </div>
            </form>
        </div>
  

    </div>


    @if(!@$modal)
        <div class="i-card-md mt-4 d-none ai-content-div">
            <div class="{{request()->routeIs('user.*') ? 'card-header' :'card--header' }}">
                <h4 class="card-title">
                    {{translate("Content")}}
                </h4>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-lg-12 d-flex justify-content-end">
                        @if(request()->routeIs('admin.*'))
                            <div class="action">
                                <a href="{{route("admin.content.list")}}"    class="i-btn btn--sm success">
                                    <i class="las la-arrow-left me-1"></i>  {{translate('Back')}}
                                </a>
                            </div>
                        @else
                                <a   href="{{route('user.ai.content.list')}}" class="i-btn primary btn--sm capsuled">
                                    <i class="bi bi-arrow-left"></i>
                                    {{translate('Back')}}
                                </a>
                        @endif
                    </div>


                    <form action="{{$content_route}}" class="content-form" enctype="multipart/form-data" method="post">
                        @csrf
                    <div class="col-lg-12">
                            <div class="form-inner">
                                <label for="Name">
                                    {{translate('Name')}} <small class="text-danger">*</small>
                                </label>
                                <input placeholder="Enter name" id="Name" required="" type="text" name="name" value="">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-inner">
                                <label for="content">
                                    {{translate("Content")}} <small class="text-danger">*</small>
                                </label>
                                <textarea placeholder="Enter Your Content" name="content" id="content" cols="30" rows="10"></textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class=" {{request()->routeIs('user.*') ? 'i-btn btn--lg btn--primary capsuled' : 'i-btn btn--md btn--primary'}}  " data-anim="ripple">
                                    {{translate("Save")}}
                                    @if(request()->routeIs('user.*'))
                                        <span><i class="bi bi-arrow-up-right"></i></span>
                                    @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else

        <div class="i-card-md d-none ai-content-div">
            <div class="card-body">
                <div class="content-form">
                    <div class="form-inner">
                        <div class="d-flex gap-2 align-items-center mb-3">

                            <label for="content" class="mb-0">
                                {{translate("Content")}} <small class="text-danger">*</small>
                            </label>
                            <button data-toggle="tooltip" data-placement="top" title="{{translate('Copy')}}"
                                class="icon-btn icon-btn-sm success copy-content">
                                <i class="bi bi-clipboard-check"></i>
                            </button>

                            <button data-toggle="tooltip" data-placement="top" title="{{translate('Download')}}"
                                class="icon-btn icon-btn-sm info download-text">
                                <i class="bi bi-download"></i>
                            </button>
                        </div>

                        <textarea placeholder="Enter Your Content" name="content" id="content" cols="30"
                            rows="10"></textarea>
                    </div>
                </div> 
            </div>
        </div>
    @endif


</div>
