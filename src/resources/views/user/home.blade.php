@extends('layouts.master')
@push('style-include')
<link href="{{asset('assets/global/css/datepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
@php
$currency = session()->get('currency');
$user     = Auth::user();
@endphp

<div class="container-fluid ps-lg-0">
    {{-- Cards --}}
    <div class="row mb-3 g-3">
        <div class="col">
            <div class="page-title-box">
                <h4 class="page-title">
                    {{translate($title)}}
                </h4>
                <div class="clock-actions">
                    <!-- Clock In Button -->
                    <form action="{{route('user.attendance.clock_in.request')}}" method="GET" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary" {{ @$clockInButtonDisabled ? 'disabled' : '' }}>
                            {{ @$clockInButtonDisabled ? 'Clocked In' : 'Clock In' }}
                        </button>
                    </form>

                    <!-- Clock Out Button -->
                    <form action="{{route('user.attendance.clock_out.request')}}" method="GET" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger" {{ @$clockOutButtonDisabled ? 'disabled' : '' }}>
                            {{ @$clockOutButtonDisabled ? 'Clocked Out' : 'Clock Out' }}
                        </button>
                    </form>
                </div>

            </div>
            <div class="d-flex align-items-center gap-4 mb-4">

                <div class="page-title-content d-lg-block d-none">
                    <h4>{{translate("Welcome")}}, <span class="text--primary">{{$user->name }}</span></h4>
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="i-card-sm style-2 primary">
                        <div class="card-info">
                            <h3>
                                {{num_format(Arr::get($data,"salary",0) , $currency)}}
                            </h3>
                            <h5 class="title">
                                {{translate("Salary")}}
                            </h5>
                            <a href="{{route('user.payslip.index')}}" class="i-btn btn--sm btn--primary-outline">
                                {{translate("View All")}}
                            </a>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-4">
                            <div class="icon">
                                <i class="las la-money-bill-wave"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="i-card-sm style-2 success">
                        <div class="card-info">
                            <h3>
                                {{Arr::get($data,"total_work_hours",0)}}
                            </h3>
                            <h5 class="title">
                                {{translate("Total work hour")}}
                            </h5>
                            <a href="{{route('user.attendance.index')}}" class="i-btn btn--sm btn--primary-outline">
                                {{translate("View All")}}
                            </a>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-4">
                            <div class="icon">
                                <i class="las la-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="i-card-sm style-2 info">
                        <div class="card-info">
                            <h3>
                                {{(Arr::get($data,"total_attendance",0))}}
                            </h3>
                            <h5 class="title">
                                {{translate('Total Attendance')}}
                            </h5>
                            <a href="{{route('user.attendance.index')}}" class="i-btn btn--sm btn--primary-outline">
                                {{translate("View All")}}
                            </a>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-4">
                            <div class="icon">
                                <i class="las la-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="i-card-sm style-2 danger">
                        <div class="card-info">
                            <h3>{{(Arr::get($data,"total_late",0))}} </h3>
                            <h5 class="title">{{translate('Total late')}}</h5>
                            <a href="{{route('user.attendance.index')}}"
                                class="i-btn btn--sm btn--primary-outline">{{translate("View All")}}</a>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-4">

                            <div class="icon">
                                <i class="las la-running"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="i-card-sm style-2 success">
                        <div class="card-info">
                            <h3>
                                {{Arr::get($data,"total_leave",0)}}
                            </h3>
                            <h5 class="title">
                                {{translate("Total Leave")}}
                            </h5>
                            <a href="{{route('user.leave.index')}}"
                                class="i-btn btn--sm btn--primary-outline">{{translate("View All")}}</a>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-4">
                            <div class="icon">
                                <i class="las la-calendar-times"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="i-card-sm style-2 warning">
                        <div class="card-info">
                            <h3>
                                {{Arr::get($data,"last_payslip","--")}}
                            </h3>
                            <h5 class="title">
                                {{translate("Last Pay slip")}}
                            </h5>
                            <a href="{{route('user.payslip.index')}}"
                                class="i-btn btn--sm btn--primary-outline">{{translate("View All")}}</a>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-4">

                            <div class="icon">
                                <i class="las la-money-bill-wave"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>


    </div>
    {{-- Charts --}}

</div>

@php
$primaryRgba = hexa_to_rgba(site_settings('primary_color'));
$secondaryRgba = hexa_to_rgba(site_settings('secondary_color'));
$primary_light = "rgba(".$primaryRgba.",0.1)";
$primary_light2 = "rgba(".$primaryRgba.",0.702)";
$primary_light3 = "rgba(".$primaryRgba.",0.5)";
$primary_light4 = "rgba(".$primaryRgba.",0.3)";
$secondary_light = "rgba(".$secondaryRgba.",0.1)";
$symbol = @session()->get('currency')?->symbol ?? base_currency()->symbol;
@endphp
@endsection

@push('script-include')
<script src="{{asset('assets/global/js/apexcharts.js')}}"></script>
<script src="{{asset('assets/global/js/datepicker/moment.min.js')}}"></script>
<script src="{{asset('assets/global/js/datepicker/daterangepicker.min.js')}}"></script>
<script src="{{asset('assets/global/js/datepicker/init.js')}}"></script>
@endpush

@push('script-push')
<script>
    "use strict";



    /** net expense chart */



    function formatCurrency(value) {
        var symbol = "{{  $symbol }}";
        var suffixes = ["", "K", "M", "B", "T"];
        var order = Math.floor(Math.log10(value) / 3);
        var suffix = suffixes[order];
        if (value < 1) { return symbol + value }
        var scaledValue = value / Math.pow(10, order * 3);
        return symbol + scaledValue.toFixed(2) + suffix;
    }




    var swiper = new Swiper(".testi-slider", {
        direction: 'vertical',
        slidesPerView: 2,
        spaceBetween: 10,
        grabCursor: true,
        loop: true,
        mousewheel: {
            eventsTarged: ".swiper-slide",
            sensitivity: 5
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

</script>
@endpush
