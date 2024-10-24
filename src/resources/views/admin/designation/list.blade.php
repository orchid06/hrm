@extends('admin.layouts.master')
@section('content')
<div class="i-card-md">
    <div class="card-body">
        <div class="search-action-area">
            <div class="row g-3">
                <form hidden id="bulkActionForm" action='{{route("admin.designation.bulk")}}' method="post">
                    @csrf
                    <input type="hidden" name="bulk_id" id="bulkid">
                    <input type="hidden" name="value" id="value">
                    <input type="hidden" name="type" id="type">
                </form>
                @if(check_permission('create_designation') || check_permission('update_designation') ||
                check_permission('delete_designation'))
                <div class="col-md-6 d-flex justify-content-start">
                    @if(check_permission('update_designation') || check_permission('delete_designation'))
                    <div class="i-dropdown bulk-action d-none">
                        <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="las la-cogs fs-15"></i>
                        </button>
                        <ul class="dropdown-menu">

                            @if(check_permission('update_designation'))
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

                    @if(check_permission('create_designation'))

                    <div class="action">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addDesignation"
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
                                <select name="department_id" class="filter_select2" id="department_id" placeholder="{{translate('Select a Department')}}">
                                    <option value="">{{translate('Select Department')}}</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ request()->input('department_id') == $department->id ? 'selected' :'' }}>
                                        {{ $department->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-inner">
                                <input name="search" value="{{request()->input('search')}}" type="search"
                                    placeholder="{{translate('Search by name or department')}}">
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
                            @if(check_permission('update_designation') || check_permission('delete_designation'))
                            <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                            @endif#
                        </th>
                        <th scope="col">
                            {{translate('Name')}}
                        </th>

                        <th scope="col">
                            {{translate('Total Employees')}}
                        </th>

                        <th scope="col">
                            {{translate('Department')}}
                        </th>

                        <th scope="col">
                            {{translate('Status')}}
                        </th>

                        <th scope="col">
                            {{translate('Options')}}
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($designations as $designation)
                    <tr>
                        <td data-label="#">
                            @if(check_permission('create_designation') || check_permission('update_designation') ||
                            check_permission('delete_designation'))
                            <input type="checkbox" value="{{$designation->id}}" name="ids[]"
                                class="data-checkbox form-check-input" id="{{$designation->id}}" />
                            @endif
                            {{$loop->iteration}}
                        </td>
                        <td data-label='{{translate("Title")}}'>
                            <div class="user-meta-info d-flex align-items-center gap-2">
                                <i class="@php echo @$designation->icon  @endphp"></i>
                                <p>
                                    {{($designation->name)}}
                                </p>
                            </div>
                        </td>

                        <td data-label='{{translate("Total Employees")}}'>
                            <div class="user-meta-info d-flex align-items-center gap-2">
                                <i class="@php echo @$designation->icon  @endphp"></i>
                                <p>
                                    {{($designation->users_count)}}
                                </p>
                            </div>
                        </td>

                        <td data-label='{{translate("Department")}}'>
                            <div class="user-meta-info d-flex align-items-center gap-2">
                                <i class="@php echo @$designation->icon  @endphp"></i>
                                <p>
                                    <span class="i-badge capsuled info">{{($designation->department->name)}}</span>
                                </p>
                            </div>
                        </td>

                        <td data-label='{{translate("Status")}}'>
                            <div class="form-check form-switch switch-center">
                                <input {{!check_permission('update_designation') ? "disabled" :"" }} type="checkbox"
                                    class="status-update form-check-input" data-column="status"
                                    data-route="{{ route('admin.designation.update.status') }}"
                                    data-status="{{ $designation->status == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                    data-id="{{$designation->uid}}" {{$designation->status
                                ==App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                id="status-switch-{{$designation->uid}}" >
                                <label class="form-check-label" for="status-switch-{{$designation->uid}}"></label>
                            </div>
                        </td>

                        <td data-label='{{translate("Options")}}'>
                            <div class="table-action">
                                @if(check_permission('update_designation') || check_permission('delete_designation') )

                                @if(check_permission('update_designation') )
                                <a data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="{{translate('Update')}}" href="javascript:void(0);"
                                    data-designation="{{$designation}}" class="update icon-btn warning"><i
                                        class="las la-pen"></i>
                                </a>
                                @endif

                                @if(check_permission('delete_designation'))
                                    <a data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="{{translate('Delete')}}"
                                        data-href="{{route('admin.designation.destroy',$designation->uid)}}"
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
                            @include('admin.partials.not_found',['custom_message' => "No designations found!!"])
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="Paginations">
            {{ $designations->links() }}
        </div>
    </div>
</div>
@endsection

@section('modal')

<div class="modal fade modal-md" id="addDesignation" tabindex="-1" aria-labelledby="adddesignation" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Add New designation')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.designation.store')}}" method="post" class="add-listing-form">
                @csrf
                <div class="modal-body">
                    <div class="form-inner">
                        <label for="name">{{translate('Name')}} <small class="text-danger">*</small></label>
                        <input type="text" name="name" id="name" value="{{old('name')}}" required>
                    </div>

                    <div class="form-inner">
                        <label for="department_id_add"> {{translate('Department')}} </label>
                        <select class="select2" name="department_id" id="department_id_add" >
                            <option value="">{{translate('Select department')}}</option>
                            @foreach ($departments as $department)
                            <option value="{{$department->id}}">
                                {{$department->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-inner">
                        <label for="status_add">{{translate('Status')}}<small class="text-danger">*</small></label>
                        <select class="select2" name="status" id="status_add" required>

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

<div class="modal fade modal-md" id="updateDesignation" tabindex="-1" aria-labelledby="updatedesignation"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Edit designation')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.designation.update')}}" method="post" class="add-listing-form">
                @csrf
                <div class="modal-body">
                    <input hidden type="text" name="uid">
                    <div class="form-inner">
                        <label for="name_update">{{translate('Name')}} <small class="text-danger">*</small></label>
                        <input type="text" name="name" id="name_update" required>
                    </div>

                    <div class="form-inner">
                        <label for="department_id_update"> {{translate('Department')}} </label>
                        <select class="select2" name="department_id" id="department_id_update" >
                            <option value="">{{translate('Select department')}}</option>
                            @foreach (@$departments as $department)
                            <option value="{{@$department->id}}" {{@$designation->department->uid == $department->uid ? 'selected' : ''}}>
                                {{@$department->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-inner">
                        <label for="status_update">{{translate('Status')}}<small class="text-danger">*</small></label>
                        <select class="select2" name="status" id="status_update" required>
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

@push('script-push')
<script>
    (function ($) {
        "use strict";

        $(".filter_select2").select2({
                placeholder: "{{translate('Select a Department')}}",
        })

        $('#addDesignation').on('shown.bs.modal', function () {
            $(".select2").select2({
                placeholder: "{{translate('Select a Department')}}",
                dropdownParent: $("#addDesignation"),
            })
        });

        $(document).on('click', '.update', function (e) {

            var designation = JSON.parse($(this).attr("data-designation"))
            var modal = $('#updateDesignation')
            modal.find('input[name="uid"]').val(designation.uid)
            modal.find('input[name="name"]').val(designation.name)
            modal.find('select[name="status"]').val(designation.status).trigger('change')

            modal.modal('show')

            $(".select2").select2({
                placeholder: "{{translate('Select a Department')}}",
                dropdownParent: $("#updateDesignation"),
            })
        })

    })(jQuery);
</script>
@endpush
