@extends('admin.layouts.master')
@section('content')

<div class="col-xl-12">
    <div class="row row-cols-xxl-3 row-cols-xl-3 row-cols-lg-4 row-cols-md-2 row-cols-sm-2 row-cols-1 g-3 mb-4">

        @php

            $currency = session()->get('currency');

            $cards =  [
                        [
                            "title"  => translate("Total Expense"),
                            "class"  => 'col',
                            "total"  => num_format($cardData['totalExpense'], $currency),
                            "icon"   => '<i class="las la-hryvnia"></i>',
                            "bg"     => 'info',

                        ],
                        [
                            "title"  => translate("Highest Expense :").' '.$cardData['categoryWithHighestExpense']['name'],
                            "class"  => 'col',
                            "total"  => num_format($cardData['categoryWithHighestExpense']['total_amount'] , $currency) ?? 'N/A',
                            "icon"   => '<i class="las la-hryvnia"></i>',
                            "bg"     => 'danger',

                        ],
                        [
                            "title"  => translate("Average Daily Expense"),
                            "class"  => 'col',
                            "total"  => num_format($cardData['averageDailyExpense'], $currency),
                            "icon"   => '<i class="las la-hryvnia"></i>',
                            "bg"     => 'warning',

                        ],
                    ];
        @endphp

        @include("admin.partials.report_card")


    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="i-card-md mb-4">
                <div class="card--header text-end">
                    <h4 class="card-title">
                         {{ translate('Expenses (Current Year)')}}
                    </h4>
               </div>
                <div class="card-body">
                    <div id="postReport"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="i-card-md">
    <div class="card--header">
        <h4 class="card-title">{{translate('Recent Expenses')}}</h4>
    </div>
    <div class="card-body">
        <div class="search-action-area">
            <div class="row g-3">
                <form hidden id="bulkActionForm" action='{{route("admin.expense.bulk")}}' method="post">
                    @csrf
                    <input type="hidden" name="bulk_id" id="bulkid">
                    <input type="hidden" name="value" id="value">
                    <input type="hidden" name="type" id="type">
                </form>
                @if(check_permission('create_expense') || check_permission('update_expense') ||
                check_permission('delete_expense'))
                <div class="col-md-6 d-flex justify-content-start">
                    @if(check_permission('update_expense') || check_permission('delete_expense'))
                    <div class="i-dropdown bulk-action d-none">
                        <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="las la-cogs fs-15"></i>
                        </button>
                        <ul class="dropdown-menu">

                            @if(check_permission('update_expense'))
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

                    @if(check_permission('create_expense'))

                    <div class="action">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addExpense"
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
                            @if(check_permission('update_expense') || check_permission('delete_expense'))
                            <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                            @endif#
                        </th>
                        <th scope="col">
                            {{translate('Category')}}
                        </th>

                        <th scope="col">
                            {{translate('Amount')}}
                        </th>

                        <th scope="col">
                            {{translate('Details')}}
                        </th>

                        <th scope="col">
                            {{translate('Option')}}
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($expenses as $expense)
                    <tr>
                        <td data-label="#">
                            @if(check_permission('create_expense') || check_permission('update_expense') ||
                            check_permission('delete_expense'))
                            <input type="checkbox" value="{{$expense->id}}" name="ids[]"
                                class="data-checkbox form-check-input" id="{{$expense->id}}" />
                            @endif
                            {{$loop->iteration}}
                        </td>
                        <td data-label='{{translate("Category")}}'>
                            <div class="user-meta-info d-flex align-items-center gap-2">
                                <i class="@php echo @$expense->icon  @endphp"></i>
                                <p>
                                    {{(@$expense->category->name ? @$expense->category->name : 'N/A')}}
                                </p>
                            </div>
                        </td>

                        <td data-label='{{translate("Amount")}}'>
                            <div class="user-meta-info d-flex align-items-center gap-2">
                                <p>
                                    {{($expense->amount)}}
                                </p>
                            </div>
                        </td>

                        <td data-label='{{translate("Details")}}'>
                            <div class="user-meta-info d-flex align-items-center gap-2">
                                <p>
                                    {{($expense->description)}}
                                </p>
                            </div>
                        </td>

                        <td data-label='{{translate("Options")}}'>
                            <div class="table-action">
                                @if(check_permission('update_expense') || check_permission('delete_expense') )

                                @if(check_permission('update_expense') )
                                <a data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="{{translate('Update')}}" href="javascript:void(0);"
                                    data-expense="{{$expense}}" class="update icon-btn warning"><i
                                        class="las la-pen"></i>
                                </a>
                                @endif

                                @if(check_permission('delete_expense'))
                                <a data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="{{translate('Delete')}}"
                                    data-href="{{route('admin.expense.destroy',@$expense->uid)}}"
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
                            @include('admin.partials.not_found',['custom_message' => "No expenses found!!"])
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="Paginations">
            {{ $expenses->links() }}
        </div>
    </div>
</div>
@endsection

@section('modal')

<div class="modal fade modal-md" id="addExpense" tabindex="-1" aria-labelledby="addExpense" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Add New expense')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.expense.store')}}" method="post" class="add-listing-form">
                @csrf
                <div class="modal-body">

                    <div class="form-inner">
                        <label for="category_id"> {{translate('Category')}} </label>
                        <select class="select2" name="category_id" id="category_id" required>
                            <option value="">{{translate('Select Category')}}</option>
                            @foreach (@$expense_categories as $category)
                            <option value="{{@$category->id}}" >
                                {{@$category->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-inner">
                        <label for="amount">{{translate('Amount')}} <small class="text-danger">*</small></label>
                        <input type="number" name="amount" id="amount" value="{{old('amount')}}" required>
                    </div>

                    <div class="form-inner">
                        <label for="description" >{{ translate('Description') }} <small class="text-danger">*</small></label>
                        <textarea name="description" id="description" rows="4" cols="50" required>{{old('description')}}</textarea>
                    </div>

                    <div class="form-inner">
                        <label for="attachment" {{ translate('Attachment') }}</label>
                        <input type="file" name="attachment" id="attachment">
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

<div class="modal fade modal-md" id="updateExpense" tabindex="-1" aria-labelledby="updateExpense"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Edit expense')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.expense.update')}}" method="post" class="add-listing-form">
                @csrf
                <div class="modal-body">
                    <input hidden type="text" name="uid">
                    <div class="form-inner">
                        <label for="category_id"> {{translate('Category')}} </label>
                        <select class="select2" name="category_id" id="category_id" required>
                            <option value="">{{translate('Select Category')}}</option>
                            @foreach (@$expense_categories as $category)
                            <option value="{{@$category->id}}" >
                                {{@$category->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-inner">
                        <label for="amount">{{translate('Amount')}} <small class="text-danger">*</small></label>
                        <input type="number" name="amount" id="amount" value="{{old('amount')}}" required>
                    </div>

                    <div class="form-inner">
                        <label for="description" >{{ translate('Description') }} <small class="text-danger">*</small></label>
                        <textarea name="description" id="description" rows="4" cols="50" required>{{old('description')}}</textarea>
                    </div>

                    <div class="form-inner">
                        <label for="attachment" {{ translate('Attachment') }}</label>
                        <input type="file" name="attachment" id="attachment">
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

        $('#addExpense').on('shown.bs.modal', function () {
            $(".select2").select2({
                placeholder: "{{translate('Select a Category')}}",
                dropdownParent: $("#addExpense"),
            })
        });

        $(document).on('click', '.update', function (e) {

            var expense = JSON.parse($(this).attr("data-expense"))
            var modal = $('#updateExpense')
            modal.find('input[name="uid"]').val(expense.uid)
            modal.find('select[name="category_id"]').val(expense.expense_category_id).trigger('change')
            modal.find('input[name="amount"]').val(expense.amount)
            modal.find('textarea[name="description"]').val(expense.description)

            modal.modal('show')

            $(".select2").select2({
                placeholder: "{{translate('Select a Category')}}",
                dropdownParent: $("#updateExpense"),
            })
        })

        var options = {
            chart: {
                height: 300,
                type: 'line',
            },
            dataLabels: {
                enabled: false,
            },
            series: @json($graph_data),
            xaxis: {
                categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            },
            colors: ['var(--color-info)', 'var(--color-primary)', 'var(--color-success)', 'var(--color-danger)'],
            markers: {
                size: 6,
            },
            stroke: {
                width: 2,
            },
            tooltip: {
                shared: false,
                intersect: true,
            },
            legend: {
                horizontalAlign: 'left',
                offsetX: 40,
            },
        };

        var chart = new ApexCharts(document.querySelector("#postReport"), options);
        chart.render();


    })(jQuery);
</script>
@endpush
