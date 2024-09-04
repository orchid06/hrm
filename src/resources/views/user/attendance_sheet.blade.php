@extends('layouts.master')
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

                    @if(check_permission('view_attendance') || check_permission('update_attendance') )
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

                            <th scope="col"  >
                                {{translate('Status')}}
                            </th>

                            <th scope="col"  >
                                {{translate('CLock In')}}
                            </th>

                            <th scope="col"  >
                                {{translate('CLock Out')}}
                            </th>

                            <th scope="col"  >
                                {{translate('Late')}}
                            </th>

                            <th scope="col"  >
                                {{translate('Work Hour')}}
                            </th>

                            <th scope="col"  >
                                {{translate('Over Time')}}
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances  as $attendance)

                            <tr>

                                <td data-label="{{translate('Date')}}">
                                    {{ \Carbon\Carbon::parse($attendance->date)->format('j M, Y')  }}
                                </td>

                                <td data-label="{{translate('Status')}}">
                                    @if ($attendance->clock_in && $attendance->clock_out)
                                    <span class="i-badge capsuled success">{{translate('Present')}}</span>
                                    @elseif ($attendance->clock_in && !$attendance->clock_out)
                                    <span class="i-badge capsuled success">{{translate('Half-Day')}}</span>
                                    @else
                                    <span class="i-badge capsuled success">{{translate('Absent')}}</span>
                                    @endif
                                </td>

                                <td data-label="{{translate('Clock In')}}">
                                    {{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('g:i A') : 'N/A' }}
                                </td>

                                <td data-label="{{translate('Clock Out')}}">
                                    {{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('g:i A') : 'N/A' }}
                                </td>

                                <td data-label="{{translate('Late Time')}}">
                                    <span class="i-badge capsuled {{$attendance->late_time ? "warning" : "success"}}"> {{ $attendance->late_time ? $attendance->late_time . ' minutes' : 'On Time' }} </span>
                                </td>

                                <td data-label="{{translate('Work Hour')}}">
                                    {{ $attendance->work_hour ? floor($attendance->work_hour / 60) . ' Hour' . (floor($attendance->work_hour / 60) != 1 ? 's' : '') . ' ' . ($attendance->work_hour % 60) . ' Minute' . (($attendance->work_hour % 60) != 1 ? 's' : '') : 'N/A' }}
                                </td>

                                <td data-label="{{translate('Over Time')}}">
                                    {{ $attendance->over_time ? $attendance->over_time . ' minutes' : 'N/A' }}
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
              {{ $attendances->links() }}
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






