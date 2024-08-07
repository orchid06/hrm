@extends('admin.layouts.master')
@section('content')
<div class="i-card-md">
    <div class="card-body">
        <div class="search-action-area">
            <div class="row g-3">
                <form hidden id="bulkActionForm" action='{{route("admin.department.bulk")}}' method="post">
                    @csrf
                    <input type="hidden" name="bulk_id" id="bulkid">
                    <input type="hidden" name="value" id="value">
                    <input type="hidden" name="type" id="type">
                </form>
                @if(check_permission('create_department') || check_permission('update_department') ||
                check_permission('delete_department'))
                <div class="col-md-6 d-flex justify-content-start">
                    @if(check_permission('update_department') || check_permission('delete_department'))
                    <div class="i-dropdown bulk-action d-none">
                        <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="las la-cogs fs-15"></i>
                        </button>
                        <ul class="dropdown-menu">

                            @if(check_permission('update_department'))
                            @foreach(App\Enums\StatusEnum::toArray() as $k => $v)
                            <li>
                                <button type="button" name="bulk_status" data-type="status" value="{{$v}}"
                                    class="dropdown-item bulk-action-btn"> {{translate($k)}}</button>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    @endif

                    @if(check_permission('create_department'))

                    <div class="action">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addDepartment"
                            class="i-btn btn--sm success">
                            <i class="las la-plus me-1"></i> {{translate('Add New')}}
                        </button>
                    </div>

                    @endif

                </div>
                @endif
                <div class="col-md-6 d-flex justify-content-end">
                    <div class="search-area">
                        <form action="{{route(Route::currentRouteName())}}" method="get">
                            <div class="form-inner">
                                <input name="search" value="{{request()->input('search')}}" type="search"
                                    placeholder="{{translate('Search by title')}}">
                            </div>
                            <button class="i-btn btn--sm info">
                                <i class="las la-sliders-h"></i>
                            </button>
                            <a href="{{route(Route::currentRouteName())}}" class="i-btn btn--sm danger">
                                <i class="las la-sync"></i>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-container position-relative">
            @include('admin.partials.loader')
            <table>
                <thead>
                    <tr>
                        <th scope="col">
                            @if(check_permission('update_department') || check_permission('delete_department'))
                            <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                            @endif#
                        </th>
                        <th scope="col">
                            {{translate('Name')}}
                        </th>

                        {{-- @if(!request()->routeIs("admin.department.subcategories"))
                        <th scope="col">
                            {{translate('Sub Categories')}}
                        </th>
                        @else

                        <th scope="col">
                            {{translate('Parent')}}
                        </th>

                        @endif --}}



                        <th scope="col">
                            {{translate('Status')}}
                        </th>

                        <th scope="col">
                            {{translate('Options')}}
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($departments as $department)
                    <tr>
                        <td data-label="#">
                            @if(check_permission('create_department') || check_permission('update_department') ||
                            check_permission('delete_department'))
                            <input type="checkbox" value="{{$department->id}}" name="ids[]"
                                class="data-checkbox form-check-input" id="{{$department->id}}" />
                            @endif
                            {{$loop->iteration}}
                        </td>
                        <td data-label='{{translate("Title")}}'>
                            <div class="user-meta-info d-flex align-items-center gap-2">
                                <i class="@php echo @$department->icon  @endphp"></i>
                                <p>
                                    {{($department->name)}}
                                </p>
                            </div>
                        </td>

                        {{-- @if(!request()->routeIs("admin.department.subcategories"))
                        <td data-label='{{translate("Sub Categories")}}'>
                            <a href="{{route('admin.department.subcategories',['parent' => $department->slug])}}">
                                {{translate('Subcategories : ')}} ({{$department->childrens_count}})
                            </a>
                        </td>
                        @else

                        <td data-label='{{translate("Parent")}}'>
                            <a href="{{route('admin.department.edit',['uid' => $department->parent->uid])}}">
                                {{$department->parent->title}}
                            </a>
                        </td>
                        @endif --}}



                        <td data-label='{{translate("Status")}}'>
                            <div class="form-check form-switch switch-center">
                                <input {{!check_permission('update_department') ? "disabled" :"" }} type="checkbox"
                                    class="status-update form-check-input" data-column="status"
                                    data-route="{{ route('admin.department.update.status') }}"
                                    data-status="{{ $department->status == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                    data-id="{{$department->uid}}" {{$department->status ==App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                    id="status-switch-{{$department->uid}}" >
                                <label class="form-check-label" for="status-switch-{{$department->uid}}"></label>
                            </div>
                        </td>

                        <td data-label='{{translate("Options")}}'>
                            <div class="table-action">
                                @if(check_permission('update_department') || check_permission('delete_department') )

                                @if(check_permission('update_department') )
                                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-target="#editDepartment"
                                    data-bs-title="{{translate('Update')}}"
                                    href="{{route('admin.department.edit',$department->uid)}}"
                                    class="update icon-btn warning"><i class="las la-pen"></i></a>
                                @endif

                                @if(check_permission('delete_department'))
                                <a data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="{{translate('Delete')}}"
                                    data-href="{{route('admin.department.destroy',$department->id)}}"
                                    class="pointer delete-item icon-btn danger">
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
                        <td class="border-bottom-0" colspan="7">
                            @include('admin.partials.not_found',['custom_message' => "No Departments found!!"])
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="Paginations">
            {{ $departments->links() }}
        </div>
    </div>
</div>
@endsection

@section('modal')

<div class="modal fade modal-md" id="addDepartment" tabindex="-1" aria-labelledby="addDepartment" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Add New Department')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.department.store')}}" method="post" class="add-listing-form">
                @csrf
                <div class="modal-body">
                    <div class="form-inner">
                        <label for="name">{{translate('Name')}} <small class="text-danger">*</small></label>
                        <input type="text" name="name" id="name" value="{{old('name')}}" required>
                        <label for="parent_id"> {{translate('Parent Department')}} </label>
                        <select class="select2" name="parent_id" id="parent_id">
                            @foreach ($departments as $department)
                            <option value="{{$department->uid}}">
                                {{$department->name}}
                            </option>
                            @endforeach
                        </select>
                        <label for="status">{{translate('Status')}}<small class="text-danger">*</small></label>
                        <select class="select2" name="status" id="status">
                            @foreach(App\Enums\StatusEnum::toArray() as $status=>$value)
                            <option {{old('status')==$value ? "selected" :"" }} value="{{$value}}">
                                {{$status}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="i-btn btn--md ripple-dark" data-anim="ripple" data-bs-dismiss="modal">
                        {{translate("Close")}}
                    </button>
                    <button type="submit" class="i-btn btn--md btn--primary" data-anim="ripple">
                        {{translate("Submit")}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal-md" id="editDepartment" tabindex="-1" aria-labelledby="editDepartment" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Edit Department')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.department.update')}}" method="post" class="add-listing-form">
                @csrf
                <div class="modal-body">
                    <div class="form-inner">
                        <label for="name">{{translate('Name')}} <small class="text-danger">*</small></label>
                        <input type="text" name="name" id="name" value="{{old('name')}}" required>
                        <label for="parent_id"> {{translate('Parent Department')}} </label>
                        <select class="select2" name="parent_id" id="parent_id">
                            <option value="0" disabled selected>translate('Select department')</option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->uid }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        <label for="status">{{translate('Status')}}<small class="text-danger">*</small></label>
                        <select class="select2" name="status" id="status">
                            @foreach(App\Enums\StatusEnum::toArray() as $status=>$value)
                            <option {{old('status')==$value ? "selected" :"" }} value="{{$value}}">
                                {{$status}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="i-btn btn--md ripple-dark" data-anim="ripple" data-bs-dismiss="modal">
                        {{translate("Close")}}
                    </button>
                    <button type="submit" class="i-btn btn--md btn--primary" data-anim="ripple">
                        {{translate("Submit")}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('modal.delete_modal')
@include('modal.bulk_modal')
@endsection
