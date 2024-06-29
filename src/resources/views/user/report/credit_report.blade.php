@extends('layouts.master')

@push('style-include')
    <link href="{{asset('assets/global/css/datepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')

<div>
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="i-card-md">
                <div class="card-body">
                    <div class="row justify-content-end mb-4">
                        <div class="col-lg-3">
                            <select name="content-category" class="select2">
                                <option>Category One</option>
                                <option>Category Two</option>
                                <option>Category Three</option>
                            </select>
                        </div>
                    </div>
                    <div id="credit-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="i-card-md">
                <div class="card-body">
                    <div id="credit-chart-circle"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-100 d-flex align-items-center justify-content-between gap-lg-5 gap-3 flex-md-nowrap flex-wrap mb-4">
        <div>
            <h4>
                {{translate(Arr::get($meta_data,'title'))}}
            </h4>
        </div>

        <div>
            <button
                    class="icon-btn icon-btn-lg solid-info circle"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#tableFilter"
                    aria-expanded="false"
                    aria-controls="tableFilter">
                    <i class="bi bi-sliders"></i>
            </button>
        </div>
    </div>

    <div class="collapse filterTwo mb-3" id="tableFilter">
        <div class="i-card-md">
            <div class="card-body">
                <div class="search-action-area p-0">
                    <div class="search-area">
                        <form action="{{route(Route::currentRouteName())}}">
                            <div class="form-inner">
                                <input type="text" id="datePicker" name="date" value="{{request()->input('date')}}"  placeholder='{{translate("Filter by date")}}'>
                            </div>

                            <div class="form-inner">
                                <select name="trx_type" id="type" class="type">
                                    <option value="">
                                        {{translate('Select TRX Type')}}
                                    </option>
                                    <option {{ App\Models\Transaction::$PLUS == request()->input('trx_type') ? 'selected' :""  }} value="{{App\Models\Transaction::$PLUS}}">{{translate("Plus")}}</option>
                                    <option {{ App\Models\Transaction::$MINUS == request()->input('trx_type') ? 'selected' :""  }} value="{{App\Models\Transaction::$MINUS}}">{{translate("Minus")}}</option>

                                </select>
                            </div>

                            <div class="form-inner">
                                <input type="text"  name="search" value="{{request()->input('search')}}"  placeholder='{{translate("Search by Transaction ID or remarks")}}'>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="i-btn primary btn--lg capsuled">
                                    <i class="bi bi-search"></i>
                                </button>

                                <a href="{{route(Route::currentRouteName())}}"  class="i-btn btn--lg danger capsuled">
                                    <i class="bi bi-arrow-repeat"></i>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="i-card-md">
        <div class="card-body p-0">
            <div class="table-accordion">
                    @if($reports->count() > 0)
                    <div class="accordion" id="wordReports">
                        @forelse($reports as $report)
                        <div class="accordion-item">
                                <div class="accordion-header">
                                    <div class="accordion-button collapsed" role="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$report->id}}"
                                        aria-expanded="false" aria-controls="collapse{{$report->id}}">
                                        <div class="row align-items-center w-100 gy-4 gx-sm-3 gx-0">
                                            <div class="col-lg-3 col-sm-4 col-12">
                                                <div class="table-accordion-header transfer-by">
                                                    <span class="icon-btn icon-btn-sm primary circle">
                                                        <i class="bi bi-file-text"></i>
                                                    </span>
                                                    <div>
                                                        <h6>
                                                            {{translate("TRX Code")}}
                                                        </h6>
                                                        <p> {{$report->trx_code}}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-sm-4 col-6 text-lg-center text-sm-center text-start">
                                                <div class="table-accordion-header">
                                                    <h6>
                                                        {{translate("Date")}}
                                                    </h6>

                                                    <p>
                                                        {{ get_date_time($report->created_at) }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-sm-4 col-6 text-lg-center text-sm-end text-end">
                                                <div class="table-accordion-header">
                                                    <h6>
                                                        {{translate("Credit")}}
                                                    </h6>

                                                    <p class='text--{{$report->type == App\Models\Transaction::$PLUS ? "success" :"danger" }}'>
                                                        <i class='bi bi-{{$report->type == App\Models\Transaction::$PLUS ? "plus" :"dash" }}'></i>
                                                        @if(App\Enums\PlanDuration::value('UNLIMITED') == $report->balance)
                                                            {{translate('Unlimited')}}
                                                        @else
                                                            {{$report->balance}}
                                                        @endif
                                                    </p>

                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-sm-4 col-6 text-lg-center text-start">
                                                <div class="table-accordion-header">
                                                    <h6>
                                                        {{translate("Post Credit")}}
                                                    </h6>

                                                    <p>
                                                        @if(App\Enums\PlanDuration::value('UNLIMITED') == $report->post_balance)
                                                            {{translate('Unlimited')}}
                                                        @else
                                                            {{$report->post_balance}}
                                                        @endif
                                                    </p>

                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-sm-4 col-6 text-lg-end text-md-center text-end">
                                                <div class="table-accordion-header">
                                                    <h6>
                                                        {{translate("Remark")}}
                                                    </h6>
                                                    <p>
                                                        {{k2t($report->remark)}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="collapse{{$report->id}}" class="accordion-collapse collapse" data-bs-parent="#wordReports">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <h6 class="title">
                                                    {{translate("Report Information")}}
                                                </h6>
                                                <p class="value">
                                                    {{$report->details}}
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                        </div>
                        @empty
                        @endforelse

                    </div>
                    @else
                        @include('admin.partials.not_found',['custom_message' => "No Reports found!!"])
                    @endif
            </div>
        </div>
    </div>


    <div class="Paginations">

        {{ $reports->links() }}

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
	(function($){
        "use strict";
        $(".type").select2({

        });


        var options = {
          series: [{
          name: 'Inflation',
          data: [2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3, 1.4, 0.8, 0.5, 0.2]
        }],
          chart: {
          height: 350,
          type: 'bar',
        },
        plotOptions: {
          bar: {
            borderRadius: 10,
            dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return val + "%";
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        
        xaxis: {
          categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          position: 'top',
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          crosshairs: {
            fill: {
              type: 'gradient',
              gradient: {
                colorFrom: '#D8E3F0',
                colorTo: '#BED1E6',
                stops: [0, 100],
                opacityFrom: 0.4,
                opacityTo: 0.5,
              }
            }
          },
          tooltip: {
            enabled: true,
          }
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
            formatter: function (val) {
              return val + "%";
            }
          }
        
        },
        title: {
          text: 'Monthly Inflation in Argentina, 2002',
          floating: true,
          offsetY: 330,
          align: 'center',
          style: {
            color: '#444'
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#credit-chart"), options);
        chart.render();

        var options = {
          series: [44, 55, 13, 43, 22],
          chart: {
          width: 380,
          type: 'pie',
        },
        labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            }, 
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#credit-chart-circle"), options);
        chart.render();
        

	})(jQuery);

</script>
@endpush





