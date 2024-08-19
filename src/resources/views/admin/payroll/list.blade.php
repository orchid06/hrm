@extends('admin.layouts.master')
@section('content')
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
                                        <a type="button"   href="{{route('admin.payroll.create')}}" class="i-btn btn--sm success">
                                          {{translate('Generate for all')}}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="col-md-7 d-flex justify-content-md-end justify-content-start">
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
                        @forelse($users  as $user)

                            <tr>
                                <td data-label="#">
                                    @if( check_permission('update_user') )
                                        <input type="checkbox" value="{{$user->id}}" name="ids[]" class="data-checkbox form-check-input" id="{{$user->id}}" />
                                    @endif
                                    {{$loop->iteration}}
                                </td>
                                <td data-label="{{translate('Name')}}">
                                    <div class="user-meta-info d-flex align-items-center gap-2">
                                        <img class="rounded-circle avatar-sm"  src='{{imageURL($user->file,"profile,user",true) }}' alt="{{@$user->file->name}}">
                                        <p>	{{ $user->name ?? translate("N/A")}}</p>

                                    </div>
                                </td>

                                <td  data-label="{{translate('Employee ID')}}">
                                    {{$user->employee_id}}
                                </td>
                                <td data-label='{{translate("Payslip type")}}'>
                                    <div class="d-block">
                                      <span class="i-badge info">{{'Monthly' }}</span>
                                    </div>
                                </td>
                                <td data-label="{{translate('Basic salary')}}">

                                    <span class="i-badge capsuled warning" >{{@json_decode($user->userDesignation->salary)->basic_salary->amount}}</span>
                                </td>
                                <td data-label="{{translate('Designation')}}">
                                    <span class="i-badge capsuled success" >
                                        {{@$user->userDesignation->net_salary}}
                                    </span>
                                </td>
                                <td data-label="{{translate('Status')}}">
                                    <span class="i-badge capsuled {{@$user->payslip ?'success' : 'danger'}}" >
                                        {{@$user->payslip ? 'Paid' : 'Unpaid'}}
                                    </span>
                                </td>
                                <td data-label="{{translate('Options')}}">
                                    <i class="las la-print icon-large"></i>
                                    <i class="las la-file-pdf icon-large"></i>
                                    <i class="las la-paper-plane icon-large"></i>
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





