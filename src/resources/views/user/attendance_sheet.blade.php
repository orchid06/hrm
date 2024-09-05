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

                                <div class="form-inner">
                                    <select name="month" class="form-select">
                                        <option value="">{{translate('Month')}}</option>
                                        @foreach(range(1, 12) as $month)
                                            <option value="{{ $month }}" {{ request()->input('month') == $month ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-inner">
                                    <select name="year" class="form-select">
                                        <option value="">{{translate('Year')}}</option>
                                        @foreach(range(date('Y') - 5, date('Y')) as $year)
                                            <option value="{{ $year }}" {{ request()->input('year') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="date-search">
                                    <input type="text" id="datePicker" name="date" value="{{request()->input('date')}}"  placeholder="{{translate('Filter by date')}}">
                                    <button type="submit" class="me-2"><i class="bi bi-search"></i></button>

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

                            <th scope="col">
                                {{translate('Action')}}
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


                                <td data-label="{{translate('Options')}}">
                                    <div class="table-action">

                                        @if(check_permission('update_attendance'))

                                            <button  data-bs-toggle="tooltip" data-bs-placement="top" attendance="{{@$attendance}}" data-bs-title="{{translate('Note')}}" class="note icon-btn info">
                                                <i class="las la-sticky-note"></i>
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
                      <h5 class="modal-title" >
                          {{translate('Add Note')}}
                      </h5>
                      <button class="close-btn" data-bs-dismiss="modal">
                          <i class="las la-times"></i>
                      </button>
                  </div>
                  <form action="{{route('admin.attendance.note')}}" method="post" class="add-listing-form">
                      @csrf
                      <div class="modal-body">
                          <input type="hidden" name="attendance_id" >

                          <div class="form-inner">
                              <label for="note">{{translate('Note')}}</label>
                              <textarea disabled name="note" id="note" cols="30" rows="10"> </textarea>
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

    <div class="modal fade modal-md" id="updateAttendanceModal" tabindex="-1" aria-labelledby="updateAttendanceModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" >
                          {{translate('Update Attendance')}}
                      </h5>
                      <button class="close-btn" data-bs-dismiss="modal">
                          <i class="las la-times"></i>
                      </button>
                  </div>
                  <form action="{{route('admin.attendance.update')}}" method="post" class="add-listing-form">
                      @csrf
                      <div class="modal-body">
                          <input type="hidden" name="attendance_id" >

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

    $('.note').on('click', function() {
        var attendance = JSON.parse($(this).attr("attendance"));
        var modal = $('#noteModal')

        modal.find('input[name="attendance_id"]').val(attendance.id)
        modal.find('textarea[name="note"]').val(attendance.note)
        modal.modal('show');
    });

</script>
@endpush






