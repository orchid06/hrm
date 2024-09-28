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
            max-width: 20px; /* Adjust this as per your layout */
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
@php
    $start = new DateTime('first day of this month');
    $end = new DateTime('last day of this month');
    $end->setTime(23, 59, 59);


    $period = new DatePeriod($start, new DateInterval('P1D'), $end);

    $dates = [];
    foreach ($period as $date) {
        $dates[] = $date;
    }

    $currentDate = date('Y-m-d');
@endphp


<div class="i-card-md">
    <div class="card--header">
        <h4>september 24</h4>
    </div>
    <div class="card-body">
	     <div class="table-container position-relative">
            <table>
                <thead>
                    <tr>
                        <th>{{translate('Employee')}}</th>
                        @foreach ($dates as $date )
                            <th class="date-header {{$date->format('Y-m-d') == $currentDate ? 'current-date' : ''}}"><div>{{$date->format('D')}}<span>{{$date->format('d')}}</span></div></th>
                        @endforeach

                    </tr>
                </thead>
                <tbody>
                    <!-- List of employees and their attendance data -->
                    @foreach ($users as $user )
                        <tr>
                            <td class="employee-name">{{$user->name}}</td>

                            {{-- Attendance data --}}
                            @foreach ($user->attendanceData as $date => $status )
                                
                                <td>{{App\Enums\AttendanceStatus::from($status)->statusLabel() }}</td>


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
@endpush
