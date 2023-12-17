@extends('admin.layouts.master')
@section('content')

    <div class="i-card-md">
        <div class="card-body">
            <div class="search-action-area">
                <div class="row g-4">
                    <form hidden id="bulkActionForm" action='{{route("admin.ai.template.bulk")}}' method="post">
                        @csrf
                        <input type="hidden" name="bulk_id" id="bulkid">
                        <input type="hidden" name="value" id="value">
                        <input type="hidden" name="type" id="type">
                    </form>
                    @if(check_permission('create_ai_template') || check_permission('update_ai_template'))
                        <div class="col-md-4 d-flex justify-content-start">
                            @if(check_permission('update_ai_template'))
                                <div class="i-dropdown bulk-action d-none">
                                    <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="las la-cogs fs-15"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                      
                                        @if(check_permission('update_ai_template'))

                                            @foreach(App\Enums\StatusEnum::toArray() as $k => $v)
                                                <li>
                                                    <button type="button" name="bulk_status" data-type ="status" value="{{$v}}" class="dropdown-item bulk-action-btn" > {{translate($k)}}</button>
                                                </li>
                                            @endforeach

                                        @endif
                                    </ul>
                                </div>
                            @endif
                        
                            @if(check_permission('create_ai_template'))
                                <div class="col-md-4 d-flex justify-content-start">
                                    <div class="action">
                                        <a href="{{route('admin.ai.template.create')}}"    class="i-btn btn--sm success">
                                            <i class="las la-plus me-1"></i>  {{translate('Add New')}}
                                        </a>
                                    </div>
                                </div>
                            @endif

                        </div>
                    @endif

                    <div class="col-md-8 d-flex justify-content-end">
                        <div class="filter-wrapper">
                            <button class="i-btn btn--primary btn--sm filter-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="las la-filter"></i>
                            </button>
                            <div class="filter-dropdown">
                            <form action="{{route(Route::currentRouteName())}}" method="get">
                               @if(request()->routeIs("admin.ai.template.default"))
                                 <input hidden name="default" value="{{App\Enums\StatusEnum::true->status()}}"  type="text">
                               @endif

                                <div class="form-inner">
                                    <select name="status" id="status" class="select2">
                                        <option value="">
                                            {{translate('Select status')}}
                                        </option>
                                        @foreach(App\Enums\StatusEnum::toArray() as $k => $v)
                                           <option  {{request()->input('status') ==   $v ? 'selected' :""}} value="{{$v}}"> {{translate($k)}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-inner">
                                    <select name="category" id="category" class="select2">
                                        <option value="">
                                            {{translate('Select Category')}}
                                        </option>
                                        @foreach($categories as $category)
                                           <option  {{$category->slug ==   request()->input('category') ? 'selected' :""}} value="{{$category->slug}}"> {{$category->title}}
                                          </option>
                                        @endforeach
                                    </select>
                                </div>


                       
                        
                                <div class="form-inner">
                                    <select name="user" id="user" class="select2">
                                        <option value="">
                                            {{translate('Select User')}}
                                        </option>
                       
                                        @foreach(system_users() as $user)
                                           <option  {{Arr::get($user,"username",null) ==   request()->input('user') ? 'selected' :""}} value="{{Arr::get($user,"username",null)}}"> {{Arr::get($user,"name",null)}}
                                          </option>
                                        @endforeach
                                    </select>
                                </div>

                              
                                <div class="form-inner">
                                    <input name="search" value='{{request()->input("search")}}' type="search" placeholder="{{translate('Search by  title')}}">
                                </div>

                                <button class="i-btn btn--sm info w-100">
                                    <i class="las la-sliders-h"></i>
                                </button>
                                </form>
                            </div>  
                        </div>  
                        <div class="ms-3">
                            <a href="{{route('admin.ai.template.list')}}"  class="i-btn btn--sm danger">
                                <i class="las la-sync"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-container position-relative">

                @include('admin.partials.loader')

                <table >
                    <thead>
                        <tr>
                            <th scope="col">
                                @if( check_permission('update_ai_template') || check_permission('delete_ai_template'))
                                    <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                                @endif#
                            </th>
                            <th scope="col">
                                {{translate('Name')}}
                            </th>

                            <th scope="col">
                                {{translate('Total Word Generated')}}
                            </th>
                            
                            <th scope="col">
                                {{translate('Category')}}
                            </th>

                            <th scope="col">
                                {{translate('User')}}
                            </th>

                            <th scope="col">
                                {{translate('Status')}}
                            </th>


                            <th scope="col">
                                {{translate('Default')}}
                            </th>

                            <th scope="col">
                                {{translate('Options')}}
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($templates as $template)
  
                                <tr>
                                    <td data-label="#">
                                        @if(check_permission('create_ai_template') || check_permission('update_ai_template') || check_permission('delete_ai_template'))
                                            <input type="checkbox" value="{{$template->id}}" name="ids[]" class="data-checkbox form-check-input" id="{{$template->id}}" />
                                        @endif
                                        {{$loop->iteration}}
                                    </td>

                                    <td data-label='{{translate("Title")}}'>
                                        <div class="user-meta-info d-flex align-items-center gap-2">
                                            <i class="@php echo $template->icon @endphp " ></i>
                                            <p>	 {{$template->name}}</p>
                                        </div>
                                    </td>

                                    <td  data-label='{{translate("No of word")}}'>
                                        <span class="ms-5 i-badge capsuled success">
                                            {{$template->templateUsages->sum("total_words")}}
                                        </span>
                                    </td>

                                    <td data-label='{{translate("Category")}}'>
                                        {{@($template->category->title)}}
                                    </td>

                                    <td data-label='{{translate("User")}}'>
                                        <span class="i-badge capsuled info">
                                            {{$template->user->name}}
                                        </span>
                                    </td>

                                    <td data-label='{{translate("Status")}}'>
                                        <div class="form-check form-switch switch-center">
                                            <input {{!check_permission('update_ai_template') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                                data-column="status"
                                                data-route="{{ route('admin.ai.template.update.status') }}"
                                                data-status="{{ $template->status == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                                data-id="{{$template->uid}}" {{$template->status ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                            id="status-switch-{{$template->id}}" >
                                            <label class="form-check-label" for="status-switch-{{$template->id}}"></label>
                                        </div>
                                    </td>

                                    <td data-label='{{translate("Default")}}'>
                                        <div class="form-check form-switch switch-center">
                                            <input {{!check_permission('update_ai_template') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                                data-column="is_default"
                                                data-route="{{ route('admin.ai.template.update.status') }}"
                                                data-status="{{ $template->is_default == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                                data-id="{{$template->uid}}" {{$template->is_default ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                            id="status-switch-default-{{$template->id}}" >
                                            <label class="form-check-label" for="status-switch-default-{{$template->id}}"></label>
                                        </div>
                                    </td>

                                    <td data-label='{{translate("Options")}}'>
                                        <div class="table-action">

                                            <a  href="{{route('admin.ai.template.content',$template->uid)}}"  class="update icon-btn info"><i class="las la-file-code"></i></a>
                                            
                                            @if(check_permission('update_ai_template') || check_permission('delete_ai_template') )


                                                @if(check_permission('update_ai_template') )
                                                    <a  href="{{route('admin.ai.template.edit',$template->uid)}}"  class="update icon-btn warning"><i class="las la-pen"></i></a>
                                                @endif

                                                @if(check_permission('delete_ai_template') && $template->is_default == App\Enums\StatusEnum::false->status() )
                              
                                                        <a href="javascript:void(0);" data-href="{{route('admin.ai.template.destroy',$template->uid)}}" class="pointer delete-item icon-btn danger">

                                                        <i class="las la-trash-alt"></i></a>
                                                   
                                                @endif
                                            @else
                                                {{translate('N/A')}}
                                            @endif

                                        </div>
                                    </td>
                               </tr>
                         
                            @empty

                            <tr>
                                <td class="border-bottom-0" colspan="90">
                                    @include('admin.partials.not_found',['custom_message' => "No Templates found!!"])
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="Paginations">

                    {{ $templates->links() }}
                
            </div>
        </div>
    </div>

    <div class="i-card-md mt-4" id="ai-form">
        <div class="card--header">
            <h4 class="card-title">Blog section</h4>
        </div>
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="category">Category</label>
                            <select name="category" class="select2" id="category">
                                <option value="1">Category 1</option>
                                <option value="2">Category 2</option>
                                <option value="3">Category 3</option>
                                <option value="4">Category 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="subcategory">Subcategory</label>
                                <select name="subcategory" class="select2" id="subcategory">
                                <option value="1">Subcategory 1</option>
                                <option value="2">Subcategory 2</option>
                                <option value="3">Subcategory 3</option>
                                <option value="4">Subcategory 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="templates">Templates</label>
                                <select name="subcategory" class="select2" id="templates">
                                <option value="1">Templates 1</option>
                                <option value="2">Templates 2</option>
                                <option value="3">Templates 3</option>
                                <option value="4">Templates 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-inner">
                            <label for="languages">Languages</label>
                                <select name="languages" class="select2" id="languages">
                                <option value="1">Templates 1</option>
                                <option value="2">Templates 2</option>
                                <option value="3">Templates 3</option>
                                <option value="4">Templates 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-inner">
                        <label for="category-input">Title</label>
                        <input type="text" id="category-input" placeholder="Write Here">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-inner">
                            <label for="prompt">Prompt Template</label>
                            <textarea name="prompt" id="prompt" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                    <div class="faq-wrap style-2">
                    <div class="accordion" id="advanceOption">
                        <div class="accordion-item">
                        <h2 class="accordion-header" id="advanceContent">
                            <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#advanceAcc"
                            aria-expanded="true"
                            aria-controls="advanceAcc">
                                {{translate("Advance Options")}} 
                                <i title="{{translate('Browse More Fields')}}" class="ms-1 las la-question-circle"></i>
                            </button>
                        </h2>
                        <div id="advanceAcc" class="accordion-collapse collapse" aria-labelledby="advanceContent" data-bs-parent="#advanceOption">
                            <div class="accordion-body">
                                <div class="form-inner">
                                    <label for="max_result">
                                        {{translate("Max Results Length")}} <i title="{{translate('Maximum words for each result')}}" class="ms-1 pointer las la-question-circle"></i>
                                    </label>
                                    <input placeholder="{{translate('Enter number')}}" type="number" min="1" name="max_result"  value='{{old("max_result")}}' >
                                </div>

                                <div class="form-inner">
                                    <label for="ai_creativity" class="form-label">{{ translate('Ai Creativity Level') }}
                                    <small class="text-danger" >*</small></label>
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
                                    <label for="content_tone" class="form-label">{{ translate('Content Tone') }} <small class="text-danger" >*</small></label>
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
                    <div class="col-lg-12">                         
                    <a class="ai-btn i-btn btn--primary btn--lg">Execute Template</a>
                    </div>
                </div>
            </form>

            <!-- advance-form -->
            
            </div>
        </div>
    </div>

    <div class="i-card-md mt-4 ai-form-output">
        <div class="card--header">
            <h4 class="card-title">
                Content Section
            </h4>
        </div> 

        <div class="card-body">
            <div class="row">
                <form data-route="http://localhost/EngageHub/admin/predefined-content/store" class="content-form" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="_token" value="CdkacukyYf6jYV9KlpKjWiNer4pOoOkBzPrZXSWz" autocomplete="off">                                <div class="col-lg-12">
                        <div class="form-inner">
                            <label for="Name"> 
                                Name <small class="text-danger">*</small>
                            </label>
                            <input placeholder="Enter name" id="Name" required="" type="text" name="name" value="">
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-inner">
                            <label for="Content"> 
                                Content <small class="text-danger">*</small>
                            </label>
                            <textarea placeholder="Enter Your Content" name="content" id="content" cols="30" rows="10"></textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="i-btn btn--md btn--primary" data-anim="ripple">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>            
    </div>

@endsection
@section('modal')
    @include('modal.delete_modal')
@endsection


@push('script-push')
<script>
	(function($){

        $(".select2").select2({
           
        })

	})(jQuery);
</script>
@endpush





