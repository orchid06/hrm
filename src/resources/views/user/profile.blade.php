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
                        <li><span>{{ translate('Username') }} :</span> {{ @$user->user_name ?? 'N/A' }}</li>
                        <li><span>{{ translate('Phone') }} :</span> {{ @$user->phone }}</li>
                        <li><span>{{ translate('Email') }} :</span> {{ @$user->email }}</li>
                        <li><span>{{ translate('Country') }} :</span> {{ @$user->country->name  }}</li>
                        <li><span>{{ translate('Department') }} :</span> {{ @$user->userDesignation->designation->department->name  }}</li>
                        <li><span>{{ translate('Joined at') }} :</span> {{ @$user->date_of_joining  }}</li>

                    </ul>

                    <a href="{{route('user.profile.edit')}}" class="i-btn btn--md btn--primary w-100 update-profile" ><i class="bi bi-person-gear fs-18 me-3"></i>
                            {{translate("Update Profile")}}
                    </a>
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
                                    "total"  => @num_format(json_decode(@$user->userDesignation->salary)->basic_salary->amount, @$currency),
                                    "icon"   => '<i class="las la-hryvnia"></i>',
                                    "bg"     => 'primary',
                                    "url"    => route('admin.subscription.report.list',['user' => $user->username])
                                ],
                                [
                                    "title"  => translate("Total Work Hour"),
                                    "class"  => 'col',
                                    "total"  => @$card_data['total_work_hours'] ?? translate("N/A"),
                                    "icon"   => '<i class="las la-clock"></i>',
                                    "bg"     => 'info',
                                    "url"    => route('admin.ticket.list',['user' => $user->username])
                                ],
                                [
                                    "title"  => translate("Total Salary Received"),
                                    "class"  => 'col',
                                    "total"  => $user->transactions->count(),
                                    "icon"   => '<i class="las la-wallet"></i>',
                                    "bg"     => 'danger',
                                    "url"    => route('admin.transaction.report.list',['user' => $user->username])
                                ],
                                [
                                    "title"  => translate("Total Attendence"),
                                    "class"  => 'col',
                                    "total"  => @$card_data['total_attendance'] ?? translate("N/A"),
                                    "icon"   => '<i class="las la-calendar"></i>',
                                    "bg"     => 'success',
                                    "url"    => route('admin.deposit.report.list',['user' => $user->username])
                                ],
                                [
                                    "title"  => translate("Total Late"),
                                    "class"  => 'col',
                                    "total"  => @$card_data['total_late'] ?? translate("N/A"),
                                    "icon"   => '<i class="las la-running"></i>',
                                    "bg"     => 'warning',
                                    "url"    => route('admin.withdraw.report.list',['user' => $user->username])
                                ],
                                [
                                    "title"  => translate("Total Leave"),
                                    "class"  => 'col',
                                    "total"  => @$card_data['total_leave'] ?? translate("N/A"),
                                    "icon"   => '<i class="las la-calendar-times"></i>',
                                    "bg"     => 'danger',
                                    "url"    => route('admin.credit.report.list',['user' => $user->username])
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
                                 {{ translate('Employee attendence (Current Year)')}}
                            </h4>
                       </div>
                        <div class="card-body">
                            <div id="postReport"></div>
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



        $("#country").select2({
            placeholder:"{{translate('Select Country')}}",
        })

        var options = {
            chart: {
              height: 300,
              type: "line",
            },
          dataLabels: {
            enabled: false,
          },
          colors: ['var(--color-info)','var(--color-primary)','var(--color-success)' ,"var(--color-danger)"],
          series: [
            {
              name: "{{ translate('Total Attendance') }}",
              data: @json(array_column($graph_data , 'attendance')),
            },
            {
              name: "{{ translate('Late to work') }}",
              data: @json(array_column($graph_data , 'late')),
            },
            {
              name: "{{ translate('Total work hour') }}",
              data: @json(array_column($graph_data , 'work_hour')),
            },

          ],
          xaxis: {
            categories: @json(array_keys($graph_data)),
          },

          tooltip: {
                shared: false,
                intersect: true,

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

        var chart = new ApexCharts(document.querySelector("#postReport"), options);
        chart.render();


	})(jQuery);
</script>
@endpush
