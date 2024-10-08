@extends('layouts.master')
@section('content')
@php
    $currency = session()->get('currency');
@endphp
<div class="row g-4 mb-4">


        <div class="col-xl-3">
            <div class="i-card-md h-440 mb-4">
                <div class="card--header">
                    <h4 class="card-title">
                        {{ translate('Employee Information') }}
                    </h4>
                </div>
                <div class="card-body">

                    <div class="d-flex flex-column align-items-center justify-content-start border--bottom mb-4 gap-2 bg--light rounded-3 gap-3 p-3">
                        <div class="user-profile-image bg--light">
                            <img src="{{ imageURL($user->file,'profile,user',true) }}" alt="profile.jpg">
                        </div>
                        <div class="text-center">
                            <h6 class="mb-1">
                                {{$user->name}}
                            </h6>
                            <span class="i-badge capsuled info">{{(@$user->userDesignation->designation->name)}}</span>
                        </div>
                    </div>

                    <ul class="admin-info-list">

                        <li><span>{{ translate('Name') }} :</span> {{ @$user->name }}</li>
                        <li><span>{{ translate('Employee ID') }} :</span> {{ @$user->employee_id }}</li>
                        <li><span>{{ translate('Username') }} :</span> {{ @$user->username ?? 'N/A' }}</li>
                        <li><span>{{ translate('Phone') }} :</span> {{ @$user->phone }}</li>
                        <li><span>{{ translate('Email') }} :</span> {{ @$user->email }}</li>
                        <li><span>{{ translate('Country') }} :</span> {{ @$user->country->name  }}</li>
                        <li><span>{{ translate('Department') }} :</span> {{ @$user->userDesignation->designation->department->name  }}</li>
                        <li><span>{{ translate('Joined at') }} :</span> {{ @$user->date_of_joining  }}</li>

                    </ul>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('user.profile.edit') }}" class="i-btn btn--sm btn--primary flex-grow-1 text-center update-profile">
                            <i class="bi bi-person-gear fs-18 me-3"></i>
                            {{ translate("Update Profile") }}
                        </a>

                        <a href="{{ route('user.profile.password') }}" class="i-btn btn--sm btn--danger flex-grow-1 text-center update-profile">
                            <i class="bi bi-person-gear fs-18 me-3"></i>
                            {{ translate("Update Password") }}
                        </a>
                    </div>


                </div>
            </div>
        </div>

        <div class="col-xl-9">
            <div class="row row-cols-xxl-3 row-cols-xl-3 row-cols-lg-4 row-cols-md-2 row-cols-sm-2 row-cols-1 g-3 mb-4">

                @php
                    $cards =  [
                                [
                                    "title"  => translate("Salary"),
                                    "class"  => 'col',
                                    "total"  => @$card_data['net_salary'] ?num_format($card_data['net_salary'], @$currency) :"--",
                                    "icon"   => '<i class="las la-hryvnia"></i>',
                                    "bg"     => 'primary',
                                    "url"    => ''
                                ],
                                [
                                    "title"  => translate("Total Work Hour"),
                                    "class"  => 'col',
                                    "total"  => @$card_data['total_work_hours'] ?? translate("N/A"),
                                    "icon"   => '<i class="las la-clock"></i>',
                                    "bg"     => 'info',
                                    "url"    => ''
                                ],
                                [
                                    "title"  => translate("Total Payslip Received"),
                                    "class"  => 'col',
                                    "total"  => @$card_data['total_payslip_received'] ,
                                    "icon"   => '<i class="las la-wallet"></i>',
                                    "bg"     => 'danger',
                                    "url"    => ''
                                ],
                                [
                                    "title"  => translate("Total Attendence"),
                                    "class"  => 'col',
                                    "total"  => @$card_data['total_attendance'] ?? translate("N/A"),
                                    "icon"   => '<i class="las la-calendar"></i>',
                                    "bg"     => 'success',
                                    "url"    => ''
                                ],
                                [
                                    "title"  => translate("Total Late"),
                                    "class"  => 'col',
                                    "total"  => @$card_data['total_late'] ?? translate("N/A"),
                                    "icon"   => '<i class="las la-running"></i>',
                                    "bg"     => 'warning',
                                    "url"    => ''
                                ],
                                [
                                    "title"  => translate("Total Leave"),
                                    "class"  => 'col',
                                    "total"  => @$card_data['total_leave'] ?? translate("N/A"),
                                    "icon"   => '<i class="las la-calendar-times"></i>',
                                    "bg"     => 'danger',
                                    "url"    => ''
                                ],
                            ];
                @endphp

                @include("admin.partials.report_card")


            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="i-card-md mb-4">
                        <div class="card--header text-end">


                            <h4 class="card-title">
                                {{ translate('Work Statistics') }}
                            </h4>


                                <form action="{{route(Route::currentRouteName() ,  ['uid' => $user->uid])}}" method="get">
                                    <div class="col-lg-auto ms-auto d-flex justify-content-end">
                                        <div class="search-area">
                                            <div class="form-inner">
                                                <select name="year" class="select2" id="year"
                                                    placeholder="{{ translate('Select a year') }}">
                                                    <option value="">{{ translate('Select a Year') }}</option>
                                                    @foreach(range(date('Y') - 5, date('Y')) as $year)
                                                    <option value="{{ $year }}" {{ request()->input('year') == $year ?
                                                        'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <button class="i-btn btn--sm info">
                                                <i class="las la-sliders-h"></i>
                                            </button>
                                            <a href="{{route(Route::currentRouteName() ,  ['uid' => $user->uid])}}"
                                                class="i-btn btn--sm danger">
                                                <i class="las la-sync"></i>
                                            </a>
                                        </div>
                                    </div>


                                </form>


                        </div>
                        <div class="card-body">
                            <div id="workReport"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



</div>

@endsection


@section('modal')

@endsection

@push('script-include')
    <script  src="{{asset('assets/global/js/apexcharts.js')}}"></script>
@endpush

@push('script-push')
<script>
	(function($){

        "use strict";



        $("#year").select2({
            placeholder:"{{translate('Select year')}}",
        })

        var options = {
            chart: {
                height: 300,
                type: "line",
            },
            dataLabels: {
                enabled: false,
            },
            colors: ['var(--color-info)', 'var(--color-primary)', 'var(--color-success)', "var(--color-danger)"],
            series: [
                {
                    name: "{{ translate('Over Time') }}",
                    data: @json(array_column($graph_data, 'over_time')),
                },
                {
                    name: "{{ translate('Late to work') }}",
                    data: @json(array_column($graph_data, 'late_hour')),
                },
                {
                    name: "{{ translate('Work Hour') }}",
                    data: @json(array_column($graph_data, 'work_hour')),
                },

            ],
            xaxis: {
                categories: @json(array_keys($graph_data)),
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return value + (value === 1 ? ' Hour' : ' Hours');
                    }
                }
            },

            tooltip: {
                shared: false,
                intersect: true,

                y: {
                    formatter: function (value) {
                        return value + (value === 1 ? ' Hour' : ' Hours'); // Tooltip formatting
                    }
                }

            },
            markers: {
                size: 6,
            },
            stroke: {
                width: [4, 4],
            },
            legend: {
                horizontalAlign: "left",
                offsetX: 40,
            },
        };

        var chart = new ApexCharts(document.querySelector("#workReport"), options);
        chart.render();


	})(jQuery);
</script>
@endpush
