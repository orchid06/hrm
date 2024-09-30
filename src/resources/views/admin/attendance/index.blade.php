@extends('admin.layouts.master')
@push('style-include')
<style>

        tr:nth-child(even) td {
            background-color: #f1f1f1;
        }
        .date-header {
            font-size: 11px;
        }
        .date-header span {
            font-size: 15px;
            display: block;
            font-weight: bold;
            margin-top: 5px;
            max-width: 20px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .current-date {
            background-color: #ff0800;
            color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }
        .employee-name {
            text-align: left;
            font-weight: bold;
            color: #333;
            background-color: #f1f1f1;
        }
        .employee-name:hover {
            background-color: #eaeaea;
        }
        /* Hover effect for attendance data */
        td:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
        table thead th {
            position: sticky;
            top: 0;
        }
</style>
@endpush
@section('content')


<div class="i-card-md">
    <div class="card--header">
        <h4>{{ \Carbon\Carbon::create()->month($selectedMonth)->format('F') }} -  {{$selectedYear}}</h4>

        <div class="d-flex flex-wrap align-items-center mt-3">

            @foreach (App\Enums\AttendanceStatus::toArray() as $status )

                <span class="me-3 text-{{App\Enums\AttendanceStatus::from($status)->badgeClass()}}">
                    <i class="{{ App\Enums\AttendanceStatus::from($status)->getIcon() }}"></i>
                    {{translate(App\Enums\AttendanceStatus::from($status)->statusLabel())}}
                </span>

            @endforeach

        </div>

    </div>
    <div class="card-body">
        <div class="search-action-area">
            <div class="row g-3">

                <div class="col-md-12 d-flex justify-content-md-end justify-content-start">

                    <div class="search-area">



                        <form action="{{route(Route::currentRouteName())}}" method="get">

                            <div class="form-inner">
                                <select name="user_id" class="select2" id="user_id"
                                    placeholder="{{translate('Select a User')}}">
                                    <option value="">{{translate('User')}}</option>
                                    @foreach(App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" {{ request()->input('user_id') == $user->id ?
                                        'selected' :'' }}>
                                        {{ $user->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-inner">
                                <select name="month" class="select2" id="month"
                                    placeholder="{{translate('Select a month')}}">
                                    <option value="">{{translate('Month')}}</option>
                                    @foreach(range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' :''
                                        }}>
                                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-inner">
                                <select name="year" class="select2" id="year"
                                    placeholder="{{translate('Select a year')}}">
                                    <option value="">{{translate('Select a Year')}}</option>
                                    @foreach(range(date('Y') - 5, date('Y')) as $year)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' :
                                        ''}}>
                                        {{ $year }}
                                    </option>
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
            <table>
                <thead>
                    <tr>
                        <th>{{translate('Employee')}}</th>
                        @foreach ($dates as $date )

                            <th class="date-header {{$date->original_format == $currentDate ? 'current-date' : ''}}"><div>{{$date->original_format->format('D')}}<span>{{$date->original_format->format('d')}}</span></div></th>
                        @endforeach

                        <th><h5>{{translate('Total')}}</h5></th>

                    </tr>
                </thead>
                <tbody>
                    <!-- List of employees and their attendance data -->
                    @foreach ($users as $user )
                        <tr>
                            <td class="employee-name">{{$user->name}}</td>

                            {{-- Attendance Status --}}

                            @foreach ($user->attendanceStatus as $date => $status )

                                <td>

                                    @php
                                        $attendanceStatus = App\Enums\AttendanceStatus::from($status);
                                    @endphp

                                    <i date="{{ $date }}" userId="{{ $user->id }}"
                                        @if ($status != App\Enums\AttendanceStatus::INVALID->status())
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-title="{{ $attendanceStatus->statusLabel() }}"
                                        @endif
                                        class="details text-{{ $attendanceStatus->badgeClass() }} {{ $attendanceStatus->getIcon() }}">
                                    </i>
                                    @if($status == App\Enums\AttendanceStatus::CLOCKED_IN->status() || $status == App\Enums\AttendanceStatus::CLOCKED_OUT->status() )
                                        <i class="bi bi-exclamation"></i>
                                    @endif

                                </td>

                            @endforeach

                            <td>
                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Total working days"> {{$user->attendanceTotal->working_days}} </span> |
                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Total present days"> {{$user->attendanceTotal->present_count}} </span> |
                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Total absent days"> {{$user->attendanceTotal->absent_count}} </span> |
                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Total days on leave"> {{$user->attendanceTotal->leave_count}} </span>
                            </td>

                        </tr>
                    @endforeach

                    <!-- Add more rows for employees -->
                </tbody>
            </table>
	     </div>
	   </div>
</div>

@endsection

@section('modal')
@include('modal.delete_modal')
@include('modal.bulk_modal')

<div class="modal fade modal-md" id="attendanceDetails" tabindex="-1" aria-labelledby="attendanceDetails" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" >
                      {{translate('Attendance Details')}}
                  </h5>
                  <button class="close-btn" data-bs-dismiss="modal">
                      <i class="las la-times"></i>
                  </button>
              </div>
              <form action="{{route('admin.attendance.update')}}" method="post" class="add-listing-form">
                @csrf
                    <input type="hidden" name="user_id" >
                  <div class="modal-body">



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

@endpush

@push('script-push')
<script>
    "use strict"
    $('.select2').each(function () {
        $(this).select2({
            placeholder: $(this).attr('placeholder')
        });
    });

    $('.details').on('click' , function(){
        var date   = $(this).attr('date');
        var userId = $(this).attr('userId');
        var selectedMonth = @json($selectedMonth);
        var selectedYear  = @json($selectedYear);
        var modal = $('#attendanceDetails');
        modal.find('input[name="user_id"]').val(userId);
        modal.modal('show');

        $.ajax({
            url: "{{ route('admin.attendance.view.details') }}",
            type: 'POST',
            data: {
                date: date,
                userId: userId,
                month:  selectedMonth,
                year:   selectedYear,
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {

                modal.find('.modal-body').html(`
                    <div class="d-flex justify-content-center my-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                `);
            },
            success: function(response) {

                console.log(response);


                modal.find('.modal-body').html(response.html);

            },
            error: function(xhr, status, error) {

                alert('An error occurred: ' + error);
            }
        });


    });

</script>
@endpush
