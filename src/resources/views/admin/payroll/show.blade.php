@extends('admin.layouts.master')
@section('content')
@php
    $currency = session()->get('currency');
@endphp
    <div class="col-xl-12">
        <div class="row row-cols-xxl-3 row-cols-xl-3 row-cols-lg-4 row-cols-md-2 row-cols-sm-2 row-cols-1 g-3 mb-4">

            @php
                $cards =  [
                            [
                                "title"  => translate("This month Employee"),
                                "class"  => 'col',
                                "total"  =>  $cardData['totalEmployees'] ?? 'N/A',
                                "icon"   => '<i class="las la-users"></i>',
                                "bg"     => 'info',

                            ],
                            [
                                "title"  => translate("Monthly Payroll"),
                                "class"  => 'col',
                                "total"  => num_format($cardData['totalPayrollAmount'] , $currency) ?? 'N/A',
                                "icon"   => '<i class="las la-money-check-alt"></i>',
                                "bg"     => 'danger',

                            ],
                        ];
            @endphp

            @include("admin.partials.report_card")


        </div>
    </div>
    <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">
                {{@$formattedMonth}}
            </h4>
        </div>
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

                            @endif
                        </div>
                    @endif


                    <div class="col-md-12 d-flex justify-content-md-end justify-content-start">

                        <div class="search-area">

                            <form action="{{route(Route::currentRouteName() , $month)}}" method="get">

                                <div class="form-inner">
                                    <select name="payment_status" class="filter-payment-status" id="payment_status"
                                        placeholder="{{translate('Select status')}}">
                                        <option value="">{{translate('Select Status')}}</option>
                                        @foreach(\App\Enums\PaymentStatus::toArray() as $key => $value)
                                        <option value="{{ $value }}" {{ request()->input('payment_status') == $value ?
                                            'selected' :'' }}>
                                            {{ $key }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>


                                <button class="i-btn btn--sm info">
                                    <i class="las la-sliders-h"></i>
                                </button>
                                <a href="{{route(Route::currentRouteName() , $month)}}" class="i-btn btn--sm danger">
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
                            <th>
                                @if(check_permission('update_user'))
                                   <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                                @endif#
                            </th>
                            <th scope="col">
                                {{translate('Name')}}
                            </th>
                            <th scope="col"  >
                                {{translate('Employee ID')}}
                            </th>
                            <th scope="col"  >
                                {{translate('Designation')}}
                            </th>

                            <th scope="col">
                                {{translate('Basic Salary')}}
                            </th>
                            <th scope="col">
                                {{translate('Net salary')}}
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
                                <td data-label="#">
                                    @if( check_permission('update_user') )
                                        <input type="checkbox" value="{{$payroll->id}}" name="ids[]" class="data-checkbox form-check-input" id="{{$payroll->id}}" />
                                    @endif
                                    {{$loop->iteration}}
                                </td>
                                <td data-label="{{translate('Name')}}">
                                    <div class="user-meta-info d-flex align-items-center gap-2">
                                        <img class="rounded-circle avatar-sm"  src='{{imageURL(@$payroll->user->file,"profile,user",true) }}' alt="{{@$payroll->user->file->name}}">
                                        <p>	{{ $payroll->user->name ?? translate("N/A")}}</p>

                                    </div>
                                </td>

                                <td  data-label="{{translate('Employee ID')}}">
                                    {{@$payroll->user->employee_id}}
                                </td>

                                <td data-label="{{translate('Designation')}}">
                                    <span class="i-badge capsuled success">
                                        {{@$payroll->user->userDesignation->designation->name?? translate("N/A")}}
                                    </span>
                                </td>

                                <td data-label="{{translate('Basic salary')}}">

                                    <span class="i-badge capsuled warning" >{{num_format(@json_decode($payroll->basic_salary) , $currency)}}</span>
                                </td>
                                <td data-label="{{translate('Net Salary')}}">
                                    <span class="i-badge capsuled success" >
                                        {{num_format(@$payroll->net_pay , $currency)}}
                                    </span>
                                </td>
                                <td data-label="{{translate('Status')}}">
                                    <span class="i-badge capsuled {{@$payroll->status == \App\Enums\StatusEnum::true->status() ?'success' : 'danger'}}" >
                                        {{@$payroll->status == \App\Enums\StatusEnum::true->status() ? 'Paid' : 'Unpaid'}}
                                    </span>
                                    @if(@$payroll->status == \App\Enums\StatusEnum::false->status())
                                        @if(check_permission('make_payment') )
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('Pay Current month')}}" href="javascript:void(0);"
                                                data-payroll="{{$payroll}}" class="payNow i-badge capsuled info">
                                                {{translate('Pay now')}}
                                            </a>
                                        @endif
                                    @endif

                                </td>
                                <td data-label="{{translate('Options')}}">
                                    @if(check_permission('view_payslip') )
                                    <a href="{{route('admin.payslip.print' , ['userId' => $payroll->user->id, 'month' => $payroll->pay_period])}}" class="icon-btn info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('View Details')}}">
                                        <i class="las la-eye"></i>
                                    </a>
                                    @endif

                                    @if(@$payroll->status == \App\Enums\StatusEnum::false->status())
                                        @if(check_permission('update_payroll') )
                                            <a href="{{route('admin.payroll.edit'  , $payroll->uid)}}" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="{{translate('Update')}}"
                                                class="update icon-btn warning">
                                                <i class="las la-pen"></i>
                                            </a>
                                        @endif
                                    @endif

                                    @if(check_permission('download_payslip') )
                                        <a href="{{route('admin.payslip.download' , ['userId' => $payroll->user->id, 'month' => $payroll->pay_period])}}" class="icon-btn success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('Download Pdf')}}">
                                            <i class="las la-file-pdf"></i>
                                        </a>
                                    @endif

                                    @if(check_permission('send_payslip') )
                                        <a href="{{route('admin.payslip.send'  , ['userId' => $payroll->user->id, 'month' => $payroll->pay_period])}}" class="icon-btn success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('Send Mail')}}">
                                            <i class="las la-paper-plane"></i>
                                        </a>
                                    @endif

                                    @if(@$payroll->status == \App\Enums\StatusEnum::false->status())

                                        @if(check_permission('delete_payslip') )
                                        <a data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="{{translate('Delete')}}"
                                            data-href="{{route('admin.payroll.destroy',$payroll->uid)}}"
                                            class="pointer delete-item icon-btn danger">
                                            <i class="las la-trash-alt"></i>
                                        </a>
                                        @endif

                                    @endif

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
                    {{ $payrolls->links() }}
            </div>
        </div>
    </div>
@endsection

@section('modal')

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
                    <input type="hidden" name="user_ids[]" >
                    <input type="hidden" name="month" value="{{$month}}">
                    <div class="form-inner">
                        <label for="month" class="form-label">{{translate('Month')}}</label>
                        <input type="text" disabled name="month_name" value="{{$formattedMonth}}">
                    </div>
                    <div class="form-inner">
                        <label for="selectUser" class="form-label">{{translate('Employee')}}</label>
                        <input type="text" disabled name="user_name">
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

    @include('modal.delete_modal')


@endsection

@push('script-push')
<script>
	(function($){
       	"use strict";
        $(".select2").select2({
			placeholder:"{{translate('Select Status')}}",
			dropdownParent: $("#addUser"),
		})

        $(".filter-payment-status").select2({
            placeholder: "{{translate('Select Status')}}",

        })

        $(".month").select2({
			placeholder:"{{translate('Select Month')}}",
            dropdownParent: $("#payNow"),

		})

        $('.select2-multiple').select2({
            placeholder:"{{translate('Select Employees')}}",
            dropdownParent: $('#payNow'),
            allowClear: true
        })



        $(document).on('click', '.payNow', function (e) {

            var payroll = JSON.parse($(this).attr("data-payroll"))
            var modal = $('#payNow')

            modal.find('input[name="user_name"]').val(payroll.user.name)
            modal.find('input[name="user_ids[]"]').val(payroll.user.id)

            modal.modal('show')

        })
	})(jQuery);
</script>
@endpush





