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
                    {{-- <div class="col-md-7 d-flex justify-content-md-end justify-content-start">
                        <div class="search-area">
                            <form action="{{route(Route::currentRouteName())}}" method="get">
                                <div class="form-inner">
                                    <select name="month" id="filter_month" class="filter-month">
                                        <option value="">
                                            {{translate('Select Month')}}
                                        </option>
                                        @foreach($months as $value => $name)
                                           <option {{$currentMonth == $value ? 'selected' : ''}} value="{{$value}}"> {{$name}}
                                          </option>
                                        @endforeach
                                    </select>
                                </div>
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
                    </div> --}}
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
                                    <span class="i-badge capsuled success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="">
                                        {{@$payroll->user->userDesignation->designation->name?? translate("N/A")}}
                                    </span>
                                </td>

                                {{-- <td data-label='{{translate("Payslip type")}}'>
                                    <div class="d-block">
                                        <span class="i-badge info">{{$payroll->user->userDesignation? @ucfirst(strtolower(str_replace("_"," ", \App\Enums\PayslipCycle::from($payroll->user->userDesignation->payslip_cycle)->name))) : "N/A"}}</span>
                                    </div>
                                </td> --}}
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
                                </td>
                                <td data-label="{{translate('Options')}}">
                                    @if(check_permission('view_payroll') )
                                    <a href="{{route('admin.payslip.print' , ['userId' => $payroll->user->id, 'month' => $payroll->created_at])}}" class="icon-btn info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('View Details')}}">
                                        <i class="las la-eye"></i>
                                    </a>
                                    @endif

                                    @if(check_permission('update_payroll') )
                                        <a href="{{route('admin.payroll.edit'  , $payroll->uid)}}" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-title="{{translate('Update')}}"
                                            class="update icon-btn warning">
                                            <i class="las la-pen"></i>
                                        </a>
                                    @endif

                                    @if(check_permission('download_payslip') )
                                        <a href="{{route('admin.payslip.download' , ['userId' => $payroll->user->id, 'month' => $payroll->created_at])}}" class="icon-btn success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('Download Pdf')}}">
                                            <i class="las la-file-pdf"></i>
                                        </a>
                                    @endif

                                    @if(check_permission('send_payslip') )
                                        <a href="{{route('admin.payslip.send'  , ['userId' => $payroll->user->id, 'month' => $payroll->created_at])}}" class="icon-btn success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('Send Mail')}}">
                                            <i class="las la-paper-plane"></i>
                                        </a>
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
        $("#country").select2({
			placeholder:"{{translate('Select Country')}}",
			dropdownParent: $("#addUser"),
		})
        $(".filter-month").select2({
			placeholder:"{{translate('Select Month')}}",

		})
	})(jQuery);
</script>
@endpush





