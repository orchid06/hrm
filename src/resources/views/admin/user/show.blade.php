@extends('admin.layouts.master')
@section('content')
@php
$currency       = session()->get('currency');
$currentMonth   = now()->month;
@endphp
<div class="row g-4 mb-4">

    @if(request()->routeIs("admin.user.show"))
    <div class="col-xl-3">
        <div class="i-card-md h-440 mb-4">
            <div class="card--header">
                <h4 class="card-title">
                    {{ translate('Employee Information') }}
                </h4>
            </div>
            <div class="card-body">

                <div
                    class="d-flex flex-column align-items-center justify-content-start border--bottom mb-4 gap-2 bg--light rounded-3 gap-3 p-3">
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
                    <li><span>{{ translate('Country') }} :</span> {{ @$user->country->name }}</li>
                    <li><span>{{ translate('Department') }} :</span> {{
                        @$user->userDesignation->designation->department->name }}</li>
                    <li><span>{{ translate('Joined at') }} :</span> {{ @$user->date_of_joining }}</li>

                </ul>

                <a href="{{route('admin.user.edit',$user->uid)}}"
                    class="i-btn btn--md btn--primary w-100 update-profile"><i class="bi bi-person-gear fs-18 me-3"></i>
                    {{translate("Update Profile")}}
                </a>
            </div>

        </div>

    </div>

    <div class="col-xl-9">

        <div class="row mb-4">

            <div class="col-md-1">
                <button class="pay i-btn btn--sm btn success"><i class="las la-hryvnia"></i>
                    {{translate("Pay")}}
                </button>

            </div>

            <div class="col-md-3">
                @if($user->is_kyc_verified == \App\Enums\StatusEnum::true->status())
                <a href="{{route('admin.kyc.report.list', ['date' => '', 'user' => $user->username])}}"
                    class="i-btn btn--sm btn--primary update-profile"><i class="bi bi-person-gear fs-18 me-3"></i>
                    {{translate("View verification log")}}
                </a>
                @endif
            </div>



        </div>


        <div class="row row-cols-xxl-3 row-cols-xl-3 row-cols-lg-4 row-cols-md-2 row-cols-sm-2 row-cols-1 g-3 mb-4">

            @php
            $cards = [
            [
            "title" => translate("Salary"),
            "class" => 'col',
            "total" => @$card_data['net_salary'] ?num_format($card_data['net_salary'], @$currency) :"--",
            "icon" => '<i class="las la-hryvnia"></i>',
            "bg" => 'primary',
            "url" => ''
            ],
            [
            "title" => translate("Total Work Hour"),
            "class" => 'col',
            "total" => @$card_data['total_work_hours'].' '.translate('Hours') ?? translate("N/A"),
            "icon" => '<i class="las la-clock"></i>',
            "bg" => 'info',
            "url" => ''
            ],
            [
            "title" => translate("Total Salary Received"),
            "class" => 'col',
            "total" => @$card_data['total_payslip_received'] ?? 0,
            translate("N/A"),
            "icon" => '<i class="las la-wallet"></i>',
            "bg" => 'danger',
            "url" => ''
            ],
            [
            "title" => translate("Total Attendence"),
            "class" => 'col',
            "total" => @$card_data['total_attendance'].' '.translate('Days') ?? translate("N/A"),
            "icon" => '<i class="las la-calendar"></i>',
            "bg" => 'success',
            "url" => ''
            ],
            [
            "title" => translate("Total Late"),
            "class" => 'col',
            "total" => @$card_data['total_late'].' '.translate('Days') ?? translate("N/A"),
            "icon" => '<i class="las la-running"></i>',
            "bg" => 'warning',
            "url" => ''
            ],
            [
            "title" => translate("Total Leave"),
            "class" => 'col',
            "total" => @$card_data['total_leave'].' '.translate('Days') ?? translate("N/A"),
            "icon" => '<i class="las la-calendar-times"></i>',
            "bg" => 'danger',
            "url" => ''
            ],
            [
            "title" => translate("verification Request"),
            "class" => 'col',
            "total" => @$card_data['kyc_request'] ?? translate("N/A"),
            "icon" => '<i class="las la-calendar-times"></i>',
            "bg" => 'danger',
            "url" => ''
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

    @endif

</div>

@endsection


@section('modal')
<div class="modal fade modal-md" id="payModal" tabindex="-1" aria-labelledby="payModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" >
                      {{translate('Pay')}}
                  </h5>
                  <button class="close-btn" data-bs-dismiss="modal">
                      <i class="las la-times"></i>
                  </button>
              </div>

                  <div class="modal-body">

                    <form id="generatePayslipForm" method="POST" action="{{ route('admin.payroll.create') }}">
                        @csrf
                        <input type="hidden" user_ids[]="{{$user->id}}">
                        <div class="form-inner">
                            <label for="month" class="form-label">{{translate('Select month')}}</label>
                            <select name="month" id="month" class="month">
                                <option value="">
                                    {{translate('Select Month')}}
                                </option>
                                @foreach($months as $value => $name)
                                   <option {{$currentMonth == $value ? 'selected' : ''}} value="{{$value}}"> {{$name}}
                                  </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="i-btn btn--md ripple-dark" data-anim="ripple" data-bs-dismiss="modal">
                                {{translate("Close")}}
                            </button>
                            <button type="submit" class="i-btn btn--md btn--primary" data-anim="ripple">
                                {{translate("Generate")}}
                            </button>
                        </div>
                    </form>
                  </div>
          </div>
    </div>
</div>
@endsection

@push('script-include')
<script src="{{asset('assets/global/js/apexcharts.js')}}"></script>
@endpush

@push('script-push')
<script>
    (function ($) {

        "use strict";



        $("#year").select2({
            placeholder: "{{translate('Select a year')}}",
        })


        $('.pay').on('click', function() {
            var modal = $('#payModal')

            $("#month").select2({
                placeholder: "{{translate('Select a month')}}",
                allowClear: true,
                dropdownParent: modal
            });

            modal.modal('show');
        });

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


        // Month-wise attendance graph
        var attendanceGraphOptions = {
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
                    data: @json(array_column($attendance_graph_data, 'present')),
                },
                {
                    name: "{{ translate('Late to work') }}",
                    data: @json(array_column($attendance_graph_data, 'absent')),
                },
                {
                    name: "{{ translate('Work Hour') }}",
                    data: @json(array_column($attendance_graph_data, 'late')),
                },

            ],
            xaxis: {
                categories: @json(array_keys($attendance_graph_data)),
            },
            yaxis: {

            },

            tooltip: {
                shared: false,
                intersect: true,

                y: {
                    formatter: function (value) {
                        return value + (value === 1 ? ' Day' : ' Days'); // Tooltip formatting
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

        var attendanceChart = new ApexCharts(document.querySelector("#attendanceChartContainer"), attendanceGraphOptions);
        attendanceChart.render();



	}) (jQuery);
</script>
@endpush
