@extends('admin.layouts.master')
@section('content')
<div class="i-card-md">
    <div class="card-body">
        <div class="search-action-area">
            <div class="row g-3">
                <form hidden id="bulkActionForm" action='{{route("admin.expense_category.bulk")}}' method="post">
                    @csrf
                    <input type="hidden" name="bulk_id" id="bulkid">
                    <input type="hidden" name="value" id="value">
                    <input type="hidden" name="type" id="type">
                </form>
                @if(check_permission('create_expense_category') || check_permission('update_expense_category') ||
                check_permission('delete_expense_category'))
                <div class="col-md-6 d-flex justify-content-start">
                    @if(check_permission('update_expense_category') || check_permission('delete_expense_category'))
                    <div class="i-dropdown bulk-action d-none">
                        <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="las la-cogs fs-15"></i>
                        </button>
                        <ul class="dropdown-menu">

                            @if(check_permission('update_expense_category'))
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

                    @if(check_permission('create_expense_category'))

                    <div class="action">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addExpense_category"
                            class="add i-btn btn--sm success">
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
                            @if(check_permission('update_expense_category') || check_permission('delete_expense_category'))
                            <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                            @endif#
                        </th>
                        <th scope="col">
                            {{translate('Name')}}
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

                    @forelse($expense_categories as $expense_category)
                    <tr>
                        <td data-label="#">
                            @if(check_permission('create_expense_category') || check_permission('update_expense_category') ||
                            check_permission('delete_expense_category'))
                            <input type="checkbox" value="{{$expense_category->id}}" name="ids[]"
                                class="data-checkbox form-check-input" id="{{$expense_category->id}}" />
                            @endif
                            {{$loop->iteration}}
                        </td>
                        <td data-label='{{translate("Title")}}'>
                            <div class="user-meta-info d-flex align-items-center gap-2">
                                <i class="@php echo @$expense_category->icon  @endphp"></i>
                                <p>
                                    {{($expense_category->name)}}
                                </p>
                            </div>
                        </td>

                        <td data-label='{{translate("Status")}}'>
                            <div class="form-check form-switch switch-center">
                                <input {{!check_permission('update_expense_category') ? "disabled" :"" }} type="checkbox"
                                    class="status-update form-check-input" data-column="status"
                                    data-route="{{ route('admin.expense_category.update.status') }}"
                                    data-status="{{ $expense_category->status == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                    data-id="{{$expense_category->uid}}" {{$expense_category->status
                                ==App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                id="status-switch-{{$expense_category->uid}}" >
                                <label class="form-check-label" for="status-switch-{{$expense_category->uid}}"></label>
                            </div>
                        </td>

                        <td data-label='{{translate("Options")}}'>
                            <div class="table-action">
                                @if(check_permission('update_expense_category') || check_permission('delete_expense_category') )

                                @if(check_permission('update_expense_category') )
                                <a data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="{{translate('Update')}}" href="javascript:void(0);"
                                    data-expense_category="{{$expense_category}}" class="update icon-btn warning"><i
                                        class="las la-pen"></i>
                                </a>
                                @endif

                                @if(check_permission('delete_expense_category'))
                                <a data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="{{translate('Delete')}}"
                                    data-href="{{route('admin.expense_category.destroy',$expense_category->uid)}}"
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
                            @include('admin.partials.not_found',['custom_message' => "No expense_categorys found!!"])
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="Paginations">
            {{ $expense_categories->links() }}
        </div>
    </div>
</div>
@endsection

@section('modal')

<div class="modal fade modal-md" id="addExpense_category" tabindex="-1" aria-labelledby="addExpense_category" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Add New expense_category')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.expense_category.store')}}" method="post" class="add-listing-form">
                @csrf
                <div class="modal-body">
                    <div class="form-inner">
                        <label for="name">{{translate('Name')}} <small class="text-danger">*</small></label>
                        <input type="text" name="name" id="name" value="{{old('name')}}" required>
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

<div class="modal fade modal-md" id="updateExpense_category" tabindex="-1" aria-labelledby="updateExpense_category"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Edit expense_category')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.expense_category.update')}}" method="post" class="add-listing-form">
                @csrf
                <div class="modal-body">
                    <input hidden type="text" name="uid">
                    <div class="form-inner">
                        <label for="name_update">{{translate('Name')}} <small class="text-danger">*</small></label>
                        <input type="text" name="name" id="name_update" required>
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

        $('#addExpense_category').on('shown.bs.modal', function () {
            $(".select2").select2({
                placeholder: "{{translate('Select a Departemnt')}}",
                dropdownParent: $("#addExpense_category"),
            })
        });

        $(document).on('click', '.update', function (e) {

            var expense_category = JSON.parse($(this).attr("data-expense_category"))
            var modal = $('#updateExpense_category')
            modal.find('input[name="uid"]').val(expense_category.uid)
            modal.find('input[name="name"]').val(expense_category.name)
            modal.find('select[name="parent_id"]').val(expense_category.parent_id).trigger('change')
            modal.find('select[name="status"]').val(expense_category.status).trigger('change')

            modal.modal('show')

            $(".select2").select2({
                placeholder: "{{translate('Select a Departemnt')}}",
                dropdownParent: $("#updateExpense_category"),
            })
        })

    })(jQuery);
</script>
@endpush
