@extends('admin.layouts.master')
@section('content')
@php
    $currency = session()->get('currency');
@endphp
    <div class="i-card-md">
        <div class="card-header">

        </div>
        <div class="card-body">
            <div class="search-action-area">
                <div class="row g-3">

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
                                {{translate('Date')}}
                            </th>
                            @forelse($users  as $user)
                            <th scope="col"  >
                                {{translate($user->name)}}
                            </th>
                            @empty
                            <th scope="col"  >
                                {{translate('No Employee found !!!')}}
                            </th>
                            @endforelse
                            <th scope="col">
                                {{translate('Action')}}
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($datesInMonth  as $date)

                            @php
                                 $formattedDate = $date->format('d-m-Y');
                                 $dataDate = $date->format('Y-m-d');
                            @endphp

                            <tr>

                                <td data-label="{{translate('Date')}}">
                                    {{htmlspecialchars($formattedDate)}}
                                </td>

                                @forelse ($users as $user)
                                    @php
                                    $isPresent = isset($attendanceData[$dataDate][$user->id]['clock_in']);
                                    $status = $isPresent ? 'Present' : 'Absent';
                                    $badgeClass = $isPresent ? 'success' : 'danger';
                                    @endphp
                                    <td>
                                        <span class="i-badge capsuled {{ $badgeClass }}">{{ htmlspecialchars($status) }}</span>
                                    </td>
                                @empty
                                <td> -- </td>
                                @endforelse

                                <td data-label="{{translate('Options')}}">
                                    <div class="table-action">
                                        @if(check_permission('update_user') ||  check_permission('delete_user'))
                                            @if(check_permission('update_user'))

                                                <button  data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="{{translate('Manage')}}" class="icon-btn info">
                                                    <i class="las la-tasks"></i>
                                                </button>

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






