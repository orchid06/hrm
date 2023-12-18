@extends('admin.layouts.master')
@section('content')
    <div class="i-card-md">
        <div class="card-body">
            <div class="search-action-area">
                <div class="row g-4">
                    <form hidden id="bulkActionForm" action='{{route("admin.category.bulk")}}' method="post">
                        @csrf
                         <input type="hidden" name="bulk_id" id="bulkid">
                         <input type="hidden" name="value" id="value">
                         <input type="hidden" name="type" id="type">
                    </form>
                    @if(check_permission('create_category') || check_permission('update_category') || check_permission('delete_category'))
                        <div class="col-md-4 d-flex justify-content-start">
                            @if(check_permission('update_category') || check_permission('delete_category'))
                                <div class="i-dropdown bulk-action d-none">
                                    <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="las la-cogs fs-15"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if(check_permission('delete_category'))
                                            <li>
                                                <button data-type="delete"  class="dropdown-item bulk-action-modal">
                                                    {{translate("Delete")}}
                                                </button>
                                            </li>
                                        @endif
                                       
                                        @if(check_permission('update_category'))
                                            @foreach(App\Enums\StatusEnum::toArray() as $k => $v)
                                                <li>
                                                    <button type="button" name="bulk_status" data-type ="status" value="{{$v}}" class="dropdown-item bulk-action-btn" > {{translate($k)}}</button>
                                                </li>
                                            @endforeach

                                            @foreach(App\Enums\StatusEnum::toArray() as $k => $v)
                                                <li>
                                                    <button type="button" name="bulk_status" data-type ="is_feature" value="{{$v}}" class="dropdown-item bulk-action-btn" > 

                                                        {{$v == App\Enums\StatusEnum::true->status() ? 'Feature' :"Exclude "}}
                                                    
                                                    </button>
                                                </li>
                                            @endforeach

                                            
                                        @endif
                                    </ul>
                                </div>
                             @endif
                       
                            @if(check_permission('create_category'))
                                <div class="action">
                                    <a href="{{request()->routeIs('admin.ai.template.categories') ? route('admin.ai.template.category.create') :  route('admin.category.create')}}" class="i-btn btn--sm success">
                                        <i class="las la-plus me-1"></i>  {{translate('Add New')}}
                                    </a>
                                </div>
                            @endif
                               
                     
                        </div>
                    @endif
                    <div class="col-md-8 d-flex justify-content-md-end justify-content-start">
                        <div class="search-area">
                            <form action="{{route(Route::currentRouteName())}}" method="get">
                                <div class="form-inner">
                                    <input name="search" value="{{request()->input('search')}}" type="search" placeholder="{{translate('Search by title')}}">
                                </div>
                                <button class="i-btn btn--sm info">
                                    <i class="las la-sliders-h"></i>
                                </button>
                                <a href="{{route(Route::currentRouteName())}}"  class="i-btn btn--sm danger">
                                    <i class="las la-sync"></i>
                                </a>
                            </form>
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
                                @if(check_permission('update_category') || check_permission('delete_category'))
                                    <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                                @endif#
                            </th>
                            <th scope="col">
                                {{translate('Title')}}
                            </th>

                            @if(!request()->routeIs("admin.category.subcategories"))
                                <th scope="col">
                                    {{translate('Sub Categories')}}
                                </th>
                             @else
                              
                                <th scope="col">
                                    {{translate('Parent')}}
                                </th>
                              
                            @endif

                            <th scope="col">
                                {{translate('Template')}}
                            </th>

                
                            <th scope="col">
                                {{translate('Created By')}}
                            </th>

                            <th scope="col">
                                {{translate('Status')}}
                            </th>


                            <th scope="col">
                                {{translate('Feature')}}
                            </th>

                            <th scope="col">
                                {{translate('Options')}}
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($categories as $category)

                                <tr>
                                    <td data-label="#">
                                        @if(check_permission('create_category') || check_permission('update_category') || check_permission('delete_category'))
                                            <input type="checkbox"
                                                value="{{$category->id}}" name="ids[]"
                                                    class="data-checkbox form-check-input"
                                                                        id="{{$category->id}}" />
                                        @endif
                                        {{$loop->iteration}}
                                    </td>

                                    <td data-label='{{translate("Title")}}'>
                                        <div class="user-meta-info d-flex align-items-center gap-2">
                         
                                             <i class="@php echo @$category->icon  @endphp" ></i>

                                            <p>	  
                                                {{($category->title)}}
                                            </p>

                                        </div>
                                    </td>

                                    @if(!request()->routeIs("admin.category.subcategories"))
                                        <td data-label='{{translate("Sub Categories")}}'>
                                            <a href="{{route('admin.category.subcategories',['parent' => $category->slug])}}">
                                            {{translate('Subcategories : ')}} ({{$category->childrens_count}})
                                            </a>
                                        </td>
                                       @else

                                        <td data-label='{{translate("Parent")}}'>
                                            <a href="{{route('admin.category.edit',['uid' => $category->parent->uid])}}">
                                                {{$category->parent->title}}
                                            </a>
                                        </td>

                                    @endif

                                    <td data-label='{{translate("Template")}}'>
                                         <a href="{{route('admin.ai.template.list',['category' => $category->slug])}}">
                                           {{translate('No of template')}} ({{$category->templates_count}})
                                         </a>
                                    </td>

          
            
                                    <td data-label='{{translate("Created By")}}'>
                                        <span class="i-badge capsuled info">
                                            {{$category->createdBy->name}}
                                        </span>
                                    </td>

                                    <td data-label='{{translate("Status")}}'>
                                        <div class="form-check form-switch switch-center">
                                            <input {{!check_permission('update_category') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                                data-column="status"
                                                data-route="{{ route('admin.category.update.status') }}"
                                                data-status="{{ $category->status == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                                data-id="{{$category->uid}}" {{$category->status ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                            id="status-switch-{{$category->id}}" >
                                            <label class="form-check-label" for="status-switch-{{$category->id}}"></label>
                                        </div>
                                    </td>
                                    <td data-label='{{translate("Feature")}}'>
                                        <div class="form-check form-switch switch-center">
                                            <input {{!check_permission('update_category') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                                data-column="is_feature"
                                                data-route="{{ route('admin.category.update.status') }}"
                                                data-status="{{ $category->is_feature == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                                data-id="{{$category->uid}}" {{$category->is_feature ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                            id="status-switch-feature-{{$category->id}}" >
                                            <label class="form-check-label" for="status-switch-feature-{{$category->id}}"></label>
                                        </div>
                                    </td>

                                    <td data-label='{{translate("Options")}}'>
                                        <div class="table-action">
                                            @if(check_permission('update_category') || check_permission('delete_category') )

                                                @if(check_permission('update_category') )
                                                    <a  href="{{route('admin.category.edit',$category->uid)}}"  class="update icon-btn warning"><i class="las la-pen"></i></a>
                                                @endif

                                                @if(check_permission('delete_category'))
                                                    <a href="javascript:void(0);"    data-href="{{route('admin.category.destroy',$category->id)}}" class=" pointer delete-item icon-btn danger">
                                                        <i class="las la-trash-alt"></i>
                                                    </a>
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
                                        @include('admin.partials.not_found',['custom_message' => "No Categories found!!"])
                                    </td>
                                </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="Paginations">
                    {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection

@section('modal')

    @include('modal.delete_modal')

    @include('modal.bulk_modal')

@endsection





