@extends('layouts.master')
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
                                                    '1'     =>  'Sunday',
                                                    '2'     =>  'Monday',
                                                    '3'     =>  'Tuesday',
                                                    '4'     =>  'Wednesday',
                                                    '5'     =>  'Thursday',
                                                    '6'     =>  'Friday',
                                                    '7'     =>  'Saturday',
                                                 ];
                                @endphp

                                <div class="form-inner">
                                    <select name="day" class="select2" id="day" placeholder="{{translate('Select a day')}}">
                                        <option value="">{{translate('Select a Day')}}</option>
                                        @foreach($days as $key=>$day)
                                            <option value="{{ $key }}" {{ request()->input('day') == $key ? 'selected' : ''}}>
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
                                $statusName = $statusEnum->statusLabel();
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

                                    <button data-bs-toggle="tooltip" data-bs-placement="top" attendance="{{$attendance}}"
                                    data-bs-title="{{translate('View note')}}" class="note icon-btn info">
                                    <i class="las la-eye"></i>
                                    </button>

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
                      <h5 class="modal-title" >
                          {{translate('Note')}}
                      </h5>
                      <button class="close-btn" data-bs-dismiss="modal">
                          <i class="las la-times"></i>
                      </button>
                  </div>

                      <div class="modal-body">

                          <div class="form-inner">
                              <label for="note">{{translate('Note')}}</label>
                              <textarea disabled name="note" id="note" cols="30" rows="10"> </textarea>
                          </div>
                      </div>
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

    $('.note').on('click', function() {
        var attendance = JSON.parse($(this).attr("attendance"));
        var modal = $('#noteModal')

        modal.find('input[name="attendance_id"]').val(attendance.id)
        modal.find('textarea[name="note"]').val(attendance.note)
        modal.modal('show');
    });

</script>
@endpush






