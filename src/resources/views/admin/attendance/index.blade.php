@extends('admin.layouts.master')
@push('style-include')
<link href="{{asset('assets/global/css/datepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
@php

@endphp
<div class="i-card-md">
    <div class="card-header">

    </div>
    <div class="card-body">
        <div class="search-action-area">
            <div class="row g-3">
                <div class="col-md-12 d-flex justify-content-md-end justify-content-start">
                    <div class="search-area">


                        <form action="{{route(Route::currentRouteName())}}" method="get">

                            @php
                                    $days =  [
                                                'Monday'    =>  'Monday',
                                                'Tuesday'   =>  'Tuesday',
                                                'Wednesday' =>  'Wednesday',
                                                'Thursday'  =>  'Thursday',
                                                'Friday'    =>  'Friday',
                                                'Saturday'  =>  'Saturday',
                                                'Sunday'    =>  'Sunday',
                                             ];
                            @endphp

                            <div class="form-inner">
                                <select name="day" class="select2" id="day" placeholder="{{translate('Select a day')}}">
                                    <option value="">{{translate('Select a Day')}}</option>
                                    @foreach($days as $day)
                                        <option value="{{ t2k($day) }}" {{ request()->input('day') == $day ? 'selected' : ''}}>
                                            {{ $day }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-inner">
                                <select name="month" class="select2" id="month" placeholder="{{translate('Select a month')}}">
                                    <option value="">{{translate('Month')}}</option>
                                    @foreach(range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ request()->input('month') == $month ? 'selected' :'' }}>
                                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-inner">
                                <select name="year" class="select2" id="year" placeholder="{{translate('Select a year')}}">
                                    <option value="">{{translate('Select a Year')}}</option>
                                    @foreach(range(date('Y') - 5, date('Y')) as $year)
                                    <option value="{{ $year }}" {{ request()->input('year') == $year ? 'selected' : ''}}>
                                        {{ $year }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="date-search">
                                <input type="text" id="datePicker" name="date" value="{{request()->input('date')}}"
                                    placeholder="{{translate('Filter by date')}}">
                                <button type="submit" class="me-2"><i class="bi bi-search"></i></button>

                            </div>

                            <div class="form-inner  ">
                                <select name="search" id="search" class="select2" placeholder="{{translate('Select a User')}}">
                                    <option value="">{{translate('Select a User')}}</option>
                                    @foreach ($users as $user)
                                    <option value="{{$user->username}}" {{request()->input('search')== $user->username
                                        ?'selected' : ''}}>{{$user->name}}</option>
                                    @endforeach
                                </select>
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
                            {{translate('Emplpoyee')}}
                        </th>

                        <th scope="col">
                            {{translate('Date')}}
                        </th>

                        <th scope="col">
                            {{translate('Status')}}
                        </th>

                        <th scope="col">
                            {{translate('CLock In')}}
                        </th>

                        <th scope="col">
                            {{translate('CLock Out')}}
                        </th>

                        <th scope="col">
                            {{translate('Late')}}
                        </th>

                        <th scope="col">
                            {{translate('Work Hour')}}
                        </th>

                        <th scope="col">
                            {{translate('Over Time')}}
                        </th>

                        <th scope="col">
                            {{translate('Action')}}
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)

                    <tr>

                        <td data-label="{{translate('Employee')}}">
                            <a href="{{route('admin.user.show' , $attendance->user->uid )}}">
                                <div class="user-meta-info d-flex align-items-center gap-2">
                                    <img class="rounded-circle avatar-sm"
                                        src='{{imageURL(@$attendance->user->file,"profile,user",true) }}'
                                        alt="{{@$attendance->user->file->name}}">
                                    <p> {{ @$attendance->user->name ?? translate("N/A")}}</p>
                                </div>
                            </a>
                        </td>

                        <td data-label="{{translate('Date')}}">
                            {{ \Carbon\Carbon::parse($attendance->date)->format('j M, Y') }} --
                            {{\Carbon\Carbon::parse($attendance->date)->format('l')}}
                        </td>

                        <td data-label="{{translate('Status')}}">
                            @if ($attendance->clock_in )
                            <span class="i-badge capsuled success">{{translate('Present')}}</span>
                            @else
                            <span class="i-badge capsuled success">{{translate('Absent')}}</span>
                            @endif
                        </td>

                        <td data-label="{{translate('Clock In')}}">
                            {{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('g:i A') :
                            'N/A' }}
                            @if($attendance->clock_in)
                            @php
                            $statusEnum = \App\Enums\ClockStatusEnum::from($attendance->clock_in_status);
                            $statusName = $statusEnum->statusLabel();
                            $badgeClass = $statusEnum->badgeClass();
                            @endphp
                            <span class="i-badge capsuled {{ $badgeClass }}">
                                {{ translate(ucfirst($statusName)) }}
                            </span>
                            @endif
                        </td>

                        <td data-label="{{translate('Clock Out')}}">
                            {{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('g:i A') :
                            'N/A' }}
                            @if ($attendance->clock_out)
                            @php
                            $statusEnum = \App\Enums\ClockStatusEnum::from($attendance->clock_out_status);
                            $statusName = $statusEnum->status();
                            $badgeClass = $statusEnum->badgeClass();
                            @endphp
                            <span class="i-badge capsuled {{ $badgeClass }}">
                                {{ translate(ucfirst($statusName)) }}
                            </span>
                            @endif
                        </td>

                        <td data-label="{{translate('Late Time')}}">
                            <span class="i-badge capsuled {{$attendance->late_time ? " danger" : "success" }}"> {{
                                $attendance->late_time ? formatTime($attendance->late_time) : 'N/A' }} </span>
                        </td>

                        <td data-label="{{translate('Work Hour')}}">
                            <span class="i-badge capsuled info"> {{ $attendance->work_hour ?
                                formatTime($attendance->work_hour) : 'N/A' }} </span>
                        </td>

                        <td data-label="{{translate('Over Time')}}">
                            {{ $attendance->over_time ? formatTime($attendance->over_time) : 'N/A' }}
                        </td>


                        <td data-label="{{translate('Options')}}">
                            <div class="table-action">

                                @if(check_permission('update_attendance'))

                                <button data-bs-toggle="tooltip" data-bs-placement="top" attendance="{{@$attendance}}"
                                    data-bs-title="{{translate('Edit')}}" class="edit icon-btn warning">
                                    <i class="las la-pen"></i>
                                </button>

                                <button data-bs-toggle="tooltip" data-bs-placement="top" attendance="{{@$attendance}}"
                                    data-bs-title="{{translate('Note')}}" class="note icon-btn info">
                                    <i class="las la-eye"></i>
                                </button>

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
            {{ $attendances->links() }}
        </div>
    </div>
</div>
@endsection

@section('modal')
@include('modal.delete_modal')

<div class="modal fade modal-md" id="noteModal" tabindex="-1" aria-labelledby="noteModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Add Note')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.attendance.note')}}" method="post" class="add-listing-form">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="attendance_id">


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

<div class="modal fade modal-md" id="updateAttendanceModal" tabindex="-1" aria-labelledby="updateAttendanceModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{translate('Update Attendance')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.attendance.update')}}" method="post" class="add-listing-form">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="attendance_id">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-inner">
                                <label for="clock_in">{{translate('CLock In')}}</label>
                                <input type="time" name="clock_in" id="clock_in"
                                    placeholder="{{translate('Set Clock In')}}">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-inner">
                                <label for="clock_in_status">{{translate('Status')}}</label>
                                <select name="clock_in_status" id="clock_in_status" class="form-select">
                                    <option value="">{{translate('Select Status')}}</option>
                                    @foreach(\App\Enums\ClockStatusEnum::toArray() as $key=>$clockStatus);

                                    <option value="{{$clockStatus}}">{{$key}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-inner">
                                <label for="clock_out">{{translate('CLock Out')}}</label>
                                <input type="time" name="clock_out" id="clock_out"
                                    placeholder="{{translate('Set Clock Out')}}">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-inner">
                                <label for="clock_out_status">{{translate('Status')}}</label>
                                <select name="clock_out_status" id="clock_out_status" class="form-select">
                                    <option value="">{{translate('Select Status')}}</option>
                                    @foreach(\App\Enums\ClockStatusEnum::toArray() as $key=>$clockStatus);

                                    <option value="{{$clockStatus}}">{{$key}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-inner">
                        <label for="note">{{translate('Note')}}</label>
                        <textarea name="note" id="note" cols="30" rows="10"> </textarea>
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
@endsection
@push('script-include')

<script src="{{asset('assets/global/js/datepicker/moment.min.js')}}"></script>
<script src="{{asset('assets/global/js/datepicker/daterangepicker.min.js')}}"></script>
<script src="{{asset('assets/global/js/datepicker/init.js')}}"></script>
@endpush
@push('script-push')
<script>
    "use strict"

    $('.select2').each(function () {
        $(this).select2({
            placeholder: $(this).attr('placeholder')
        });
    });

    $('.note').on('click', function () {
        var attendance = JSON.parse($(this).attr("attendance"));
        var modal = $('#noteModal')

        modal.find('input[name="attendance_id"]').val(attendance.id)

        modal.modal('show');
    });

    $('.edit').on('click', function () {
        var attendance = JSON.parse($(this).attr("attendance"));
        var modal = $('#updateAttendanceModal')
        var clockInTime = '';
        var clockOutTime = '';

        if (attendance.clock_in) {
            var clockInTimeStamp = new Date(attendance.clock_in)
            clockInTime = clockInTimeStamp.toTimeString().slice(0, 5);
        }

        if (attendance.clock_out) {
            var clockOutTimeStamp = new Date(attendance.clock_out)
            clockOutTime = clockOutTimeStamp.toTimeString().slice(0, 5);
        }


        modal.find('input[name="attendance_id"]').val(attendance.id)
        modal.find('input[name="clock_in"]').val(clockInTime)
        modal.find('select[name="clock_in_status"]').val(attendance.clock_in_status);
        modal.find('input[name="clock_out"]').val(clockOutTime)
        modal.find('select[name="clock_out_status"]').val(attendance.clock_out_status);
        modal.find('textarea[name="note"]').val(attendance.note)
        modal.modal('show');
    });

</script>
@endpush
