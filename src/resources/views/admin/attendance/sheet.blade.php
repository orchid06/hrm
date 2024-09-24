@extends('admin.layouts.master')
@push('style-include')
<link href="{{asset('assets/global/css/datepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
@php
    $selectedDay    = request()->input('day');
    $month  = request()->input('month');
    $year   = request()->input('year');
@endphp
<div class="i-card-md">
    <div class="card-header">

    </div>
    <div class="card-body">
        <div class="container mt-5">


            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">{{ translate('Date') }}</th>
                        <th scope="col">{{ translate('Employee') }}</th>
                        <th scope="col">{{ translate('Status') }}</th>
                        <th scope="col">{{ translate('Clock In') }}</th>
                        <th scope="col">{{ translate('Clock Out') }}</th>
                        <th scope="col">{{ translate('Late') }}</th>
                        <th scope="col">{{ translate('Work Hour') }}</th>
                        <th scope="col">{{ translate('Over Time') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendanceData as $record)
                    <tr>
                        <td>{{ $record['date'] }}</td>
                        <td>{{ $record['employee_name'] }}</td>
                        <td>{{ $record['status'] }}</td>
                        <td>{{ $record['clock_in'] ?? '-' }}</td>
                        <td>{{ $record['clock_out'] ?? '-' }}</td>
                        <td>{{ $record['late_time'] ?? '0' }} min</td>
                        <td>{{ $record['work_hour'] ?? '0' }} hr</td>
                        <td>{{ $record['over_time'] ?? '0' }} hr</td>
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
    </div>
</div>
@endsection

@section('modal')
@include('modal.delete_modal')

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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
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
