@extends('admin.layouts.master')
@section('content')
@php
     $currency = session()->get('currency');
@endphp
    <div class="i-card-md">
        <div class="card-body">
            <div class="search-action-area">
                <div class="row g-3">
                    <form hidden id="bulkActionForm" action="{{route('admin.user.bulk')}}" method="post">
                        @csrf
                         <input type="hidden" name="bulk_id" id="bulkid">
                         <input type="hidden" name="value" id="value">
                         <input type="hidden" name="type" id="type">
                    </form>
                    @if(check_permission('create_payroll') || check_permission('update_payroll') )
                        <div class="col-md-5 d-flex justify-content-start">
                            @if(check_permission('update_menu'))
                                <div class="i-dropdown bulk-action d-none">
                                    <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="las la-cogs fs-15"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if(check_permission('update_menu'))
                                            @foreach(App\Enums\StatusEnum::toArray() as $k => $v)
                                                <li>
                                                    <button type="button" name="bulk_status" data-type ="status" value="{{$v}}" class="dropdown-item bulk-action-btn" > {{translate($k)}}</button>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            @endif
                            @if(check_permission('create_payroll'))
                                <div class="col-md-4 d-flex justify-content-start">
                                    <div class="action">
                                        <a type="button"    class="i-btn btn--sm success" data-bs-toggle="modal" data-bs-target="#generatePayslipModal">
                                          {{translate('Generate')}}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="col-md-7 d-flex justify-content-md-end justify-content-start">
                        <div class="search-area">
                            <form action="{{route(Route::currentRouteName())}}" method="get">

                                <div class="form-inner  ">
                                      <input name="search" value="{{request()->search}}" type="search" placeholder="{{translate('Search by name,email,phone')}}">
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
                <table>
                    <thead>
                        <tr>
                            <th scope="col">
                                {{translate('Month')}}
                            </th>
                            <th scope="col"  >
                                {{translate('Total Employees')}}
                            </th>
                            <th scope="col"  >
                                {{translate('Created at')}}
                            </th>
                            <th scope="col">
                                {{translate('Salary Expense')}}
                            </th>

                            <th scope="col">
                                {{translate('Status')}}
                            </th>

                            <th scope="col">
                                {{translate('Option')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payrolls  as $payroll)

                            <tr>

                                <td data-label="{{translate('Month')}}">
                                    <span class="i-badge capsuled info" >
                                        {{@$payroll->month}}
                                    </span>
                                </td>

                                <td  data-label="{{translate('Total Employees')}}">
                                    {{$payroll->total_employees}}
                                </td>
                                <td data-label='{{translate("Created at")}}'>
                                    <div class="d-block">
                                        <span >{{\Carbon\Carbon::parse(@$payroll->created_at)->format('F j, Y, g:i A')}}</span>
                                    </div>
                                </td>
                                <td data-label="{{translate('Salary Expense')}}">

                                    <span class="i-badge capsuled warning" >{{ num_format(@$payroll->total_expense , $currency)}}</span>
                                </td>

                                <td data-label="{{translate('Status')}}">

                                    <form action="{{route('admin.payroll.show' , $payroll->pay_period)}}" method="GET">
                                        <input type="hidden" name="payment_status" value="{{$payroll->status}}">
                                        <button type="submit" class="{{$payroll->badge}}">
                                            {{$payroll->text}}
                                        </button>
                                    </form>

                                </td>

                                <td data-label="{{translate('Options')}}">
                                    <div class="table-action">


                                            @if(check_permission('make_payment') )
                                                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('Pay all employee')}}" href="javascript:void(0);"
                                                    data-pay-period="{{$payroll->pay_period}}" data-month="{{$payroll->month}}" class="payNow i-badge capsuled info">
                                                    {{translate('Pay now')}}
                                                </a>
                                            @endif

                                            @if(check_permission('view_payroll'))

                                                <a   href="{{route('admin.payroll.show', $payroll->pay_period)}}"   data-bs-toggle="tooltip" data-bs-placement="top"    data-bs-title="{{translate('Show')}}" class="icon-btn info">
                                                    <i class="las la-eye"></i>
                                                </a>

                                            @endif

                                            @if(check_permission('download_payslip') )
                                                <a href="{{route('admin.payslip.download' , ['userId' => $payroll->user->id, 'month' => $payroll->pay_period])}}" class="icon-btn success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('Download Pdf')}}">
                                                    <i class="las la-file-pdf"></i>
                                                </a>
                                            @endif

                                       
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="border-bottom-0" colspan="8">
                                    @include('admin.partials.not_found')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="Paginations">
                    {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modal.delete_modal')

<div class="modal fade" id="generatePayslipModal" tabindex="-1" aria-labelledby="generatePayslipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generatePayslipModalLabel">{{translate('Generate Payslip')}}</h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="generatePayslipForm" method="POST" action="{{ route('admin.payroll.create') }}">
                    @csrf
                    <div class="form-inner">
                        <label for="month" class="form-label">{{translate('Select month')}}</label>
                        <select name="month" id="month" class="month">
                            <option value="">
                                {{translate('Select Month')}}
                            </option>

                            @foreach($months as $key => $value)
                               <option {{$currentMonth == $value->format('Y-m') ? 'selected' : ''}} value="{{$value}}"> {{$key}}
                              </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-inner">
                        <label for="selectUser" class="form-label">{{translate('Select Employee')}}</label>
                        <select class="form-select select2-multiple" id="selectUser" name="user_ids[]" multiple="multiple" >
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="i-btn btn--md ripple-dark" data-anim="ripple" data-bs-dismiss="modal">
                            {{translate("Close")}}
                        </button>
                        <button type="submit" class="i-btn btn--md btn--primary" data-anim="ripple">
                            {{translate("Generate")}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="payNow" tabindex="-1" aria-labelledby="payNow" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payNow">{{translate('Make Payment')}}</h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="payNow" method="POST" action="{{ route('admin.payroll.make_payment') }}">
                    @csrf
                    <input type="hidden" name="month" >
                    <div class="form-inner">
                        <label for="month" class="form-label">{{translate('Month')}}</label>
                        <input type="text" disabled name="month_name">
                    </div>
                    <div class="form-inner">
                        <label for="payUser" class="form-label">{{translate('Select Employee')}}</label>
                        <select class="form-select select2-multiple" id="payUser" name="user_ids[]" multiple="multiple" >
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="i-btn btn--md ripple-dark" data-anim="ripple" data-bs-dismiss="modal">
                            {{translate("Close")}}
                        </button>
                        <button type="submit" class="i-btn btn--md btn--primary" data-anim="ripple">
                            {{translate("Pay now")}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-push')
<script>
	(function($){
       	"use strict";

        $(".month").select2({
			placeholder:"{{translate('Select Month')}}",
            dropdownParent: $("#generatePayslipModal"),

		})


        $('#generatePayslipModal').on('shown.bs.modal', function () {
            $('.select2-multiple').select2({
                placeholder: "{{translate('Select Employees')}}",
                dropdownParent: $('#generatePayslipModal'),
                allowClear: true
            });
        });


        $(document).on('click', '.payNow', function (e) {

            var payPeriod = $(this).attr("data-pay-period")
            var monthName = $(this).attr("data-month")
            var modal = $('#payNow')

            modal.find('input[name="month"]').val(payPeriod)
            modal.find('input[name="month_name"]').val(monthName)

            $('.select2-multiple').select2({
                placeholder:"{{translate('Select Employees')}}",
                dropdownParent: modal,
                allowClear: true
            })

            modal.modal('show')

        })

	})(jQuery);
</script>
@endpush





