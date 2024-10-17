@extends('admin.layouts.master')
@section('content')
<div class="i-card-md">
    <div class="card-body">
        <div class="search-action-area">
            <div class="row g-3">
                <form hidden id="bulkActionForm" action='{{route("admin.leave_type.bulk")}}' method="post">
                    @csrf
                    <input type="hidden" name="bulk_id" id="bulkid">
                    <input type="hidden" name="value" id="value">
                    <input type="hidden" name="type" id="type">
                </form>
                @if(check_permission('create_leave') || check_permission('update_leave') ||
                check_permission('delete_leave'))
                <div class="col-md-6 d-flex justify-content-start">
                    @if(check_permission('update_leave') || check_permission('delete_leave'))
                    <div class="i-dropdown bulk-action d-none">
                        <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="las la-cogs fs-15"></i>
                        </button>
                        <ul class="dropdown-menu">

                            @if(check_permission('update_leave'))
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

                    @if(check_permission('create_leave'))

                    <div class="action">

                        <a href="{{route('admin.leave_type.create')}}">
                            <button type="button" class="add i-btn btn--sm success">
                                <i class="las la-plus me-1"></i> {{translate('Add New')}}
                            </button>
                        </a>
                    </div>

                    @endif

                </div>
                @endif
                <div class="col-md-6 d-flex justify-content-end">
                    <div class="search-area">
                        <form action="{{route(Route::currentRouteName())}}" method="get">
                            <div class="form-inner">
                                <input name="search" value="{{request()->input('search')}}" type="search"
                                    placeholder="{{translate('Search by name')}}">
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
                            @if(check_permission('update_leave') || check_permission('delete_leave'))
                            <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                            @endif#
                        </th>
                        <th scope="col">
                            {{translate('Name')}}
                        </th>

                        <th scope="col">
                            {{translate('Days (Yearly)')}}
                        </th>

                        <th scope="col">
                            {{translate('Paid/Unpaid')}}
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

                    @forelse($leave_types as $leave_type)
                    <tr>
                        <td data-label="#">
                            @if(check_permission('create_leave') || check_permission('update_leave') ||
                            check_permission('delete_leave'))
                            <input type="checkbox" value="{{$leave_type->id}}" name="ids[]"
                                class="data-checkbox form-check-input" id="{{$leave_type->id}}" />
                            @endif
                            {{$loop->iteration}}
                        </td>
                        <td data-label='{{translate("Name")}}'>
                            <div class="user-meta-info d-flex align-items-center gap-2">

                                <p>
                                    {{($leave_type->name)}}
                                </p>
                            </div>
                        </td>

                        <td data-label='{{translate("Name")}}'>
                            <div class="user-meta-info d-flex align-items-center gap-2">

                                <p>
                                    {{($leave_type->days ?? 'N/A')}}
                                </p>
                            </div>
                        </td>

                        <td data-label='{{translate("Paid/Unpaid")}}'>
                            <div class="user-meta-info d-flex align-items-center gap-2">
                                <p>
                                    {{($leave_type->is_paid == App\Enums\StatusEnum::true->status()? translate("Paid") : translate("Unpaid"))}}
                                </p>
                            </div>
                        </td>

                        <td data-label='{{translate("Status")}}'>
                            <div class="form-check form-switch switch-center">
                                <input {{!check_permission('update_leave') ? "disabled" :"" }} type="checkbox"
                                    class="status-update form-check-input" data-column="status"
                                    data-route="{{ route('admin.leave_type.update.status') }}"
                                    data-status="{{ $leave_type->status == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                    data-id="{{$leave_type->uid}}"
                                    {{$leave_type->status==App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                id="status-switch-{{$leave_type->uid}}" >
                                <label class="form-check-label" for="status-switch-{{$leave_type->uid}}"></label>
                            </div>
                        </td>

                        <td data-label='{{translate("Options")}}'>
                            <div class="table-action">
                                @if(check_permission('update_leave') || check_permission('delete_leave') )

                                @if(check_permission('update_leave') )
                                <a data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="{{translate('Update')}}" href="{{route('admin.leave_type.edit' , $leave_type->id)}}"
                                    class="icon-btn warning"> <i class="las la-pen"></i>
                                </a>
                                @endif

                                @if(check_permission('delete_leave'))
                                <a data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="{{translate('Delete')}}"
                                    data-href="{{route('admin.leave_type.destroy',$leave_type->id)}}"
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
                            @include('admin.partials.not_found',['custom_message' => "No leave_types found!!"])
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="Paginations">
            {{ $leave_types->links() }}
        </div>
    </div>
</div>
@endsection

@section('modal')

<div class="modal fade modal-md" id="updateLeave_type" tabindex="-1" aria-labelledby="updateLeave_type"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Edit Leave_type')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.leave_type.update')}}" method="post" class="add-listing-form">
                @csrf
                <div class="modal-body">
                    <input hidden type="text" name="id">
                    <div class="form-inner">
                        <label for="name_update">{{translate('Name')}} <small class="text-danger">*</small></label>
                        <input type="text" name="name" id="name_update" required>
                    </div>

                    <div class="form-inner">
                        <label for="days_update">{{translate('Allowed Days')}} </label>
                        <i class="las la-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('These are yearly allowed leave days.')}}"></i>
                        <input type="number" name="days" id="days_update">
                    </div>

                    <div class="form-inner">
                        <label for="is_paid_update">{{translate('Paid/Unpaid')}}<small
                                class="text-danger">*</small></label>
                        <select class="select2" name="is_paid" id="is_paid_update" placeholder="{{translate('Select Type')}}" required>
                            <option value="">{{translate('Select a type')}}</option>
                            @foreach(App\Enums\StatusEnum::toArray() as $status=>$value)
                            <option {{old('status')==$value ? "selected" :"" }} value="{{$value}}">
                                {{$value == App\Enums\StatusEnum::true->status()? 'Paid' : 'Unpaid'}}
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

        $('#addLeave_type').on('shown.bs.modal', function () {
            $(this).find(".select2").each(function () {
                $(this).select2({
                    placeholder: $(this).attr('placeholder'),
                    dropdownParent: $('#addLeave_type'),
                });
            });
        });

        $(document).on('click', '.update', function (e) {

            var leave_type = JSON.parse($(this).attr("data-leave_type"))
            var modal = $('#updateLeave_type')
            modal.find('input[name="id"]').val(leave_type.id)
            modal.find('input[name="name"]').val(leave_type.name)
            modal.find('input[name="days"]').val(leave_type.days)
            modal.find('select[name="is_paid"]').val(leave_type.is_paid).trigger('change')
            modal.find('select[name="status"]').val(leave_type.status).trigger('change')

            modal.modal('show')

            $(".select2").select2({
                placeholder: "{{translate('Select a type')}}",
                dropdownParent: $("#updateLeave_type"),
            })
        })

    })(jQuery);
</script>
@endpush
