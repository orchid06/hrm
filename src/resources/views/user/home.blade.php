@extends('layouts.master')
@push('style-include')
<link href="{{asset('assets/global/css/datepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
@php
$currency = session()->get('currency');
@endphp

<div class="container-fluid ps-lg-0">
    {{-- Cards --}}
    <div class="row mb-3 g-3">
        <div class="col">
            <div class="page-title-box">
                <h4 class="page-title">
                    {{translate($title)}}
                </h4>
              
            </div>
            <div class="row g-3 mb-3">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="i-card-sm style-2 primary">
                        <div class="card-info">
                            <h3>

                            </h3>
                            <h5 class="title">
                                {{translate("Salary")}}
                            </h5>
                            <a href="{{route('admin.user.list')}}" class="i-btn btn--sm btn--primary-outline">
                                {{translate("View All")}}
                            </a>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-4">
                            <div class="icon">
                                <i class="las la-cube"></i>
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
                                {{translate("Active Employees")}}
                            </h5>
                            <a href="{{route('admin.user.list')}}" class="i-btn btn--sm btn--primary-outline">
                                {{translate("View All")}}
                            </a>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-4">
                            <div class="icon">
                                <i class="las la-user-friends"></i>
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
                                {{translate('Inactive Employees')}}
                            </h5>
                            <a href="{{route('admin.user.list')}}" class="i-btn btn--sm btn--primary-outline">
                                {{translate("View All")}}
                            </a>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-4">
                            <div class="icon">
                                <i class="las la-wallet"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="i-card-sm style-2 danger">
                        <div class="card-info">
                            <h3>{{(Arr::get($data,"total_absent",0))}} </h3>
                            <h5 class="title">{{translate('Total Payroll Processed')}}</h5>
                            <a href="{{route('admin.category.list')}}"
                                class="i-btn btn--sm btn--primary-outline">{{translate("View All")}}</a>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-4">

                            <div class="icon">
                                <i class="las la-exchange-alt"></i>
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
                                {{translate("Pending payroll")}}
                            </h5>
                            <a href="{{route('admin.payroll.list')}}"
                                class="i-btn btn--sm btn--primary-outline">{{translate("View All")}}</a>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-4">
                            <div class="icon">
                                <i class="las la-user-friends"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="i-card-sm style-2 warning">
                        <div class="card-info">
                            <h3>
                                0
                            </h3>
                            <h5 class="title">
                                {{translate("Net expense")}}
                            </h5>
                            <a href="{{route('admin.expense.list')}}"
                                class="i-btn btn--sm btn--primary-outline">{{translate("View All")}}</a>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-4">

                            <div class="icon">
                                <i class="las la-share-alt"></i>
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
