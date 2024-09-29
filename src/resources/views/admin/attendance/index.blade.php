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
        <h4>{{ \Carbon\Carbon::create()->month($month)->format('F') }} ,  {{$year}}</h4>

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
                                    <option value="{{ $month }}" {{ request()->input('month') == $month ? 'selected' :''
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
                                    <option value="{{ $year }}" {{ request()->input('year') == $year ? 'selected' :
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


                                            <i date="{{$date}}" userId="{{$user->id}}" @if($status != App\Enums\AttendanceStatus::INVALID->status()) data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ App\Enums\AttendanceStatus::from($status)->statusLabel()}}" @endif class="details text-{{App\Enums\AttendanceStatus::from($status)->badgeClass()}} {{  App\Enums\AttendanceStatus::from($status)->getIcon() }}"></i>



                                </td>

                            @endforeach
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
        var month = @json($month);
        var year  = @json($year);



        $.ajax({
            url: "{{ route('admin.attendance.view.details') }}",
            type: 'POST',
            data: {
                date: date,
                userId: userId,
                month: month,
                year: year,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {

                console.log(response);

            },
            error: function(xhr, status, error) {

                alert('An error occurred: ' + error);
            }
        });



    })

</script>
@endpush
