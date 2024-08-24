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
                    @if(check_permission('create_user') || check_permission('update_user') )
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
                            @if(check_permission('create_user'))
                                <div class="col-md-4 d-flex justify-content-start">
                                    <div class="action">
                                        <a type="button"   href="{{route('admin.user.create')}}" class="i-btn btn--sm success">
                                            <i class="las la-plus me-1"></i>  {{translate('Add New')}}
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
                                    <select name="country" id="filter_country" class="filter-country">
                                        <option value="">
                                            {{translate('Select Country')}}
                                        </option>
                                        @foreach($countries as $country)
                                           <option  {{$country->name ==   request()->input('country') ? 'selected' :""}} value="{{$country->name}}"> {{$country->name}}
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
                                {{translate('Contact')}}
                            </th>
                            <th scope="col">
                                {{translate('Department')}}
                            </th>
                            <th scope="col">
                                {{translate('Designation')}}
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
                                <td data-label='{{translate("Contact")}}'>
                                    <div class="d-block">
                                      {{translate('Email')}} : <a href="mailto:{{ $user->email }}" class="i-badge info">{{ $user->email }}</a>
                                    </div>
                                    {{translate('Phone')}} : <a href="tel:{{ $user->phone }}" class="i-badge info">{{ $user->phone }}</a>
                                </td>
                                <td data-label="{{translate('Department')}}">

                                    <span class="i-badge capsuled info" >{{@$user->userDesignation->designation->department->name}}</span>
                                </td>
                                <td data-label="{{translate('Designation')}}">
                                    <span class="i-badge capsuled success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ translate('Salary : ').num_format(json_decode(@$user->userDesignation->salary)->basic_salary->amount, @$currency) }}">
                                        {{@$user->userDesignation->designation->name}}
                                    </span>
                                </td>
                                <td data-label="{{translate('Status')}}">
                                    <div class="form-check form-switch switch-center">
                                        <input {{!check_permission('update_user') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                            data-column="status"
                                            data-route="{{ route('admin.user.update.status') }}"
                                            data-model="Admin"
                                            data-status="{{ $user->status == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                            data-id="{{$user->uid}}" {{$user->status ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                        id="status-switch-{{$user->id}}" >
                                        <label class="form-check-label" for="status-switch-{{$user->id}}"></label>
                                    </div>
                                </td>
                                <td data-label="{{translate('Options')}}">
                                    <div class="table-action">
                                        @if(check_permission('update_user') ||  check_permission('delete_user'))
                                            @if(check_permission('update_user'))

                                                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('Login')}}" target="_blank" href="{{route('admin.user.login', $user->uid)}}" class="icon-btn success">
                                                    <i class="las la-sign-in-alt"></i>
                                                </a>
                                                <a   href="{{route('admin.user.show', $user->uid)}}"   data-bs-toggle="tooltip" data-bs-placement="top"    data-bs-title="{{translate('Show')}}" class="icon-btn info">
                                                    <i class="las la-eye"></i>
                                                </a>

                                            @endif

                                            @if(check_permission('delete_user'))
                                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('Delete')}}" data-href="{{route('admin.user.destroy',$user->uid)}}" class="delete-item icon-btn danger">
                                                    <i class="las la-trash-alt"></i></a>
                                            @endif
                                        @else
                                          {{translate('N/A')}}
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
        $(".filter-country").select2({
			placeholder:"{{translate('Select Country')}}",

		})
	})(jQuery);
</script>
@endpush





