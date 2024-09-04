@extends('layouts.master')

@push('style-include')
@endpush

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
                                {{translate('Month')}}
                            </th>
                            <th scope="col"  >
                                {{translate('Payslip type')}}
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
                        @forelse($payslips  as $payslip)

                            <tr>
                                <td data-label="#">
                                    @if( check_permission('update_user') )
                                        <input type="checkbox" value="{{$payslip->id}}" name="ids[]" class="data-checkbox form-check-input" id="{{$payslip->id}}" />
                                    @endif
                                    {{$loop->iteration}}
                                </td>

                                <td data-label="{{ translate('Month') }}">
                                    {{ \Carbon\Carbon::parse($payslip->created_at)->format('F') }}
                                </td>

                                <td data-label='{{translate("Payslip type")}}'>
                                    <div class="d-block">
                                        <span class="i-badge info">{{ @ucfirst(strtolower(str_replace("_"," ", \App\Enums\PayslipCycle::from($payslip->user->userDesignation->payslip_cycle)->name))) }}</span>
                                    </div>
                                </td>
                                <td data-label="{{translate('Basic salary')}}">

                                    <span class="i-badge capsuled warning" >{{num_format(@json_decode($payslip->user->userDesignation->salary)->basic_salary->amount , $currency)}}</span>
                                </td>
                                <td data-label="{{translate('Net Salary')}}">
                                    <span class="i-badge capsuled success" >
                                        {{num_format(@$payslip->user->userDesignation->net_salary , $currency)}}
                                    </span>
                                </td>
                                <td data-label="{{translate('Status')}}">
                                    <span class="i-badge capsuled {{@$payslip->user->payslip ?'success' : 'danger'}}" >
                                        {{@$payslip->user->payslip ? 'Paid' : 'Unpaid'}}
                                    </span>
                                </td>
                                <td data-label="{{translate('Options')}}">
                                   <a href="{{route('user.payslip.print' , ['userId' => $payslip->user->id, 'month' => $payslip->created_at])}}" class="fs-18 link-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{'Print'}}">
                                        <i class="las la-print icon-large"></i>
                                    </a>
                                    <a href="{{route('user.payslip.download' , ['userId' => $payslip->user->id, 'month' => $payslip->created_at])}}" class="fs-18 link-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{'Download Pdf'}}">
                                        <i class="las la-file-pdf icon-large"></i>
                                    </a>
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
                    {{ $payslips->links() }}
            </div>
        </div>
    </div>
@endsection

@push('script-include')
@endpush

@push('script-push')
@endpush
