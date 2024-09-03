@extends('admin.layouts.master')
@push('style-include')
    <link href="{{asset('assets/global/css/datepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
@php
     $currency       = session()->get('currency');
@endphp

<div class="container-fluid ps-lg-0">
    {{-- Cards --}}
  <div class="row mb-3 g-3">
    <div class="col">
        <div class="page-title-box">
          <h4 class="page-title">
            {{translate($title)}}
          </h4>
          <div class="page-title-right d-flex justify-content-end align-items-center flex-wrap gap-2">
              <ol class="breadcrumb m-0">
                <li class="breadcrumb-item">
                    @php
                        $last_cron_run = App\Models\Core\Setting::where('key','last_cron_run')->first();
                    @endphp
                    <div class="cron">
                      {{translate("Last Cron Run")}} : {{$last_cron_run && $last_cron_run->value ?  diff_for_humans($last_cron_run->value) : translate("N/A")  }}
                    </div>
                </li>
              </ol>
            <form action="{{route('admin.home')}}" method="get">
              <div class="date-search">
                  <input type="text" id="datePicker" name="date" value="{{request()->input('date')}}"  placeholder="{{translate('Filter by date')}}">
                  <button type="submit" class="me-2"><i class="bi bi-search"></i></button>
                  <a href="{{route(Route::currentRouteName())}}"  class="i-btn btn--sm danger-transparent">
                    <i class="las la-sync"></i>
                  </a>
              </div>
            </form>
            <button type="button" class="right-menu-btn layout-rightsidebar-btn waves ripple-light">
              <i class="las la-wave-square"></i>
            </button>
          </div>
        </div>
      <div class="row g-3 mb-3">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="i-card-sm style-2 primary">
              <div class="card-info">
                <h3>
                    {{Arr::get($data,"total_employees",0)}}
                </h3>
                <h5 class="title">
                  {{translate("Total Employee")}}
                </h5>
                <a href="{{route('admin.user.list')}}" class="i-btn btn--sm btn--primary-outline">
                      {{translate("View All")}}
                </a>
              </div>
              <div class="d-flex flex-column align-items-end gap-4">
                <div class="icon">
                    <i class="las la-users"></i>
                </div>
              </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
          <div class="i-card-sm style-2 success">
            <div class="card-info">
              <h3>
                {{Arr::get($data,"active_employees",0)}}
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
                    {{(Arr::get($data,"inactive_employees",0))}}
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
                    <i class="las la-user-friends"></i>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
          <div class="i-card-sm style-2 danger">
            <div class="card-info">
              <h3>{{num_format(Arr::get($data,"total_payroll_processed",0) , $currency)}} </h3>
              <h5 class="title">{{translate('Total Payroll Processed')}}</h5>
              <a href="{{route('admin.payroll.list')}}" class="i-btn btn--sm btn--primary-outline">{{translate("View All")}}</a>
            </div>
            <div class="d-flex flex-column align-items-end gap-4">

              <div class="icon">
                <i class="las la-money-check-alt"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
          <div class="i-card-sm style-2 success">
            <div class="card-info">
            <h3>
                {{Arr::get($data,"pending_payroll",0)}}
              </h3>
              <h5 class="title">
                {{translate("Pending payroll")}}
              </h5>
              <a href="{{route('admin.payroll.list')}}" class="i-btn btn--sm btn--primary-outline">{{translate("View All")}}</a>
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
                    {{num_format(Arr::get($data,"net_expense",0) , $currency)}}
                  </h3>
                  <h5 class="title">
                    {{translate("Net expense")}}
                  </h5>
                  <a href="{{route('admin.expense.list')}}" class="i-btn btn--sm btn--primary-outline">{{translate("View All")}}</a>
                </div>
                <div class="d-flex flex-column align-items-end gap-4">

                  <div class="icon">
                    <i class="las la-coins"></i>
                  </div>
                </div>
            </div>
        </div>

      </div>

    </div>


  </div>
    {{-- Charts --}}
  <div class="row g-3 mb-3">
    <div class="col-lg-12">
      <div class="i-card-md home home">
        <div class="card--header">
          <h4 class="card-title">
              {{translate("Yearly Expense")}}
          </h4>

        </div>
        <div class="card-body">
            <div class="row g-2 text-center mb-5">
              <div class="col-sm-6">
                  <div class="p-3 border border-dashed border-start-0 rounded-2">
                      <h5 class="mb-1">
                          <span>
                            {{num_format(Arr::get($data,"yearly_total_salary",0) , $currency)}}
                          </span>
                      </h5>
                      <p class="text-muted mb-0">
                          {{translate("Total Payroll")}}
                      </p>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="p-3 border border-dashed border-start-0 rounded-2">
                      <h5 class="mb-1"><span>
                        {{num_format(Arr::get($data,"yearly_total_officeExpenses",0) , $currency)}}
                      </span></h5>
                      <p class="text-muted mb-0">
                          {{translate("Total office Expense")}}
                      </p>
                  </div>
              </div>
            </div>
          <div id="netExpenseChart" class="apex-chart"></div>
        </div>
      </div>
    </div>


  </div>
</div>

  @php
        $primaryRgba =  hexa_to_rgba(site_settings('primary_color'));
        $secondaryRgba =  hexa_to_rgba(site_settings('secondary_color'));
        $primary_light = "rgba(".$primaryRgba.",0.1)";
        $primary_light2 = "rgba(".$primaryRgba.",0.702)";
        $primary_light3 = "rgba(".$primaryRgba.",0.5)";
        $primary_light4 = "rgba(".$primaryRgba.",0.3)";
        $secondary_light = "rgba(".$secondaryRgba.",0.1)";
        $symbol = @session()->get('currency')?->symbol ?? base_currency()->symbol;
  @endphp
  @endsection

@push('script-include')
  <script  src="{{asset('assets/global/js/apexcharts.js')}}"></script>
  <script src="{{asset('assets/global/js/datepicker/moment.min.js')}}"></script>
  <script src="{{asset('assets/global/js/datepicker/daterangepicker.min.js')}}"></script>
  <script src="{{asset('assets/global/js/datepicker/init.js')}}"></script>
@endpush

@push('script-push')
<script>
  "use strict";



    /** net expense chart */
    var options = {
            chart: {
                height: 300,
                type: 'line',
            },
            dataLabels: {
                enabled: false,
            },
            series: @json($data['net_expense_chart_data']),
            xaxis: {
                categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            },
            colors: ['var(--color-info)', 'var(--color-primary)', 'var(--color-success)', 'var(--color-danger)'],
            markers: {
                size: 6,
            },
            stroke: {
                width: 2,
            },
            tooltip: {
                shared: false,
                intersect: true,
            },
            legend: {
                horizontalAlign: 'left',
                offsetX: 40,
            },
        };

        var chart = new ApexCharts(document.querySelector("#netExpenseChart"), options);
        chart.render();



    function formatCurrency(value) {
        var symbol =  "{{  $symbol }}" ;
        var suffixes = ["", "K", "M", "B", "T"];
        var order = Math.floor(Math.log10(value) / 3);
        var suffix = suffixes[order];
        if(value < 1)
        {return symbol+value}
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




