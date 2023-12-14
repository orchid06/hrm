@extends('admin.layouts.master')
@section('content')

<div class="page-title-box">
    <h4 class="page-title">
       {{translate($title)}}
    </h4>
    <div class="page-title-right d-flex justify-content-end align-items-center gap-3">
    <ol class="breadcrumb m-0">
        <li class="breadcrumb-item">
             <div class="cron">
              {{translate("Last Cron Run")}} : {{session()->has("last_corn_run") ?  diff_for_humans(session()->get("last_corn_run")) : translate("N/A")  }}
             </div>
        </li>
      </ol>
    <form action="">
      <div class="date-search">
          <input type="text" id="datePicker2" name="date" value="{{request()->input('date')}}"  placeholder="{{translate('Filter by date')}}">
          <button type="submit"><i class="bi bi-search"></i></button>
      </div>
    </form>

    </div>
  </div>

  <!-- card -->

    <div class="row mb-3 g-3">
      <div class="col-xl-6">
      <div class="row g-3">
      <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="i-card-sm style-2 primary">
          <div class="card-info">
              <h3>
                  {{Arr::get($data,"total_package",0)}}
                </h3>
                <h5 class="title">
                  {{translate("Total Package")}}
                </h5>
                <a href="#" class="i-btn btn--sm btn--outline">View All</a>
              </div>
              <div class="d-flex flex-column align-items-end gap-4">
                <span class="i-badge success-text">0.54% <i class="bi bi-graph-up-arrow"></i></span>
                <div class="icon">
                  <i class="las la-cube"></i>
                </div>
              </div>
          </div>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="i-card-sm style-2 success">
          <div class="card-info">
            <h3>
              {{Arr::get($data,"total_user",0)}}
            </h3>
            <h5 class="title">
              {{translate("Total Users")}}
            </h5>
            <a href="#" class="i-btn btn--sm btn--outline">View All</a>
          </div>
          <div class="d-flex flex-column align-items-end gap-4">
          <span class="i-badge danger-text">0.54% <i class="bi bi-graph-down-arrow"></i></span>
          <div class="icon">
            <i class="las la-user-friends"></i>
          </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="i-card-sm style-2 info">
              <div class="card-info">
                <h3>
                  {{site_settings("currency_symbol")}}  {{truncate_price(Arr::get($data,"total_earning",0))}}
                </h3>
                <h5 class="title">
                  {{translate('Total Earning')}}
                </h5>
                <a href="#" class="i-btn btn--sm btn--outline">View All</a>
              </div>
              <div class="d-flex flex-column align-items-end gap-4">
              <span class="i-badge danger-text">0.54% <i class="bi bi-graph-up-arrow"></i></span>
              <div class="icon">
                <i class="las la-cube"></i>
              </div>
              </div>
          </div>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="i-card-sm style-2 danger">
          <div class="card-info">
            <h3>{{Arr::get($data,"total_category",0)}} </h3> 
            <h5 class="title">{{translate('Total Category')}}</h5>
            <a href="#" class="i-btn btn--sm btn--outline">View All</a>
          </div>
          <div class="d-flex flex-column align-items-end gap-4">
          <span class="i-badge success-text">0.54% <i class="bi bi-graph-down-arrow"></i></span>
            <div class="icon">
              <i class="las la-exchange-alt"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="i-card-sm style-2 success">
          <div class="card-info">
          <h3>
              {{Arr::get($data,"total_user",0)}}
            </h3>
            <h5 class="title">
              {{translate("Total Users")}}
            </h5>
            <a href="#" class="i-btn btn--sm btn--outline">View All</a>
          </div>
          <div class="d-flex flex-column align-items-end gap-4">
            <span class="i-badge danger-text">0.54% <i class="bi bi-graph-up-arrow"></i></span>
            <div class="icon">
              <i class="las la-user-friends"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="i-card-sm style-2 warning">
              <div class="card-info">
                <h3>
                  {{Arr::get($data,"total_payment_method",0)}}
                </h3>
                <h5 class="title">
                  {{translate("Total Method")}}
                </h5>
                <a href="#" class="i-btn btn--sm btn--outline">View All</a>
              </div>
              <div class="d-flex flex-column align-items-end gap-4">
                <span class="i-badge danger-text">0.54% <i class="bi bi-graph-up-arrow"></i></span>
              <div class="icon">
                <i class="las la-cube"></i>
              </div>
              </div>
          </div>
      </div>
    </div>
      </div>
      <div class="col-xl-6">
      <div class="i-card-md">
        <div class="card--header">
          <h4 class="card-title">
             {{translate("Subscription Plan Used In")}} {{ \Carbon\Carbon::now()->year }}
          </h4>
        </div>
        <div class="card-body">
          <div id="perform-category" class="apex-chart"></div>
        </div>
      </div>
      </div>
    </div>

  <!-- charts -->

  <div class="row g-3 mb-4">
    <div class="col-xxl-4 col-xl-5">
      <div class="i-card-md">
        <div class="card--header">
          <h4 class="card-title">
             {{translate("Payment Gateway Used in")}} {{ \Carbon\Carbon::now()->year }}
          </h4>
        </div>
        <div class="card-body">
          <div id="paymentGateway" class="apex-chart"></div>
          <div class="row g-0 text-center">
            <div class="col-6 col-sm-4">
                <div class="p-3 border border-dashed border-start-0">
                    <h5 class="mb-1">
                        <span>
                            44
                        </span>
                    </h5>
                    <p class="text-muted mb-0">
                          Total
                    </p>
                </div>
            </div>
            <!--end col-->
            <div class="col-6 col-sm-4">
                <div class="p-3 border border-dashed border-start-0">
                    <h5 class="mb-1">
                        <span>
                            30
                        </span>
                    </h5>
                    <p class="text-muted mb-0">
                          Opened
                    </p>
                </div>
            </div>
            <!--end col-->
            <div class="col-6 col-sm-4">
                <div class="p-3 border border-dashed border-start-0">
                    <h5 class="mb-1"><span>
                        6
                    </span></h5>
                    <p class="text-muted mb-0">
                          Closed
                    </p>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xxl-8 col-xl-7">
      <div class="i-card-md">
        <div class="card--header">
          <h4 class="card-title">
             {{translate("Latest Payment Log")}}
          </h4>
        </div>

        <div class="card-body">
            <div class="table-container">
              <table >
                  <thead>
                      <tr>
                          <th scope="col">
                            {{translate("Transaction Id")}}
                          </th>

                      
                        <th scope="col">
                          {{translate("User")}}
                        </th>
                      
                          <th scope="col">
                            {{translate("Method")}}
                          </th>

                          <th scope="col">
                            {{translate("Amount")}}
                          </th>
    
                          <th scope="col">
                            {{translate("Created Date")}}
                          </th>

                    
                          <th scope="col">
                            {{translate("Status")}}
                          </th>

                          <th scope="col">
                              {{translate('Options')}}
                          </th>
    
                        </tr>
                  </thead>

                  <tbody>

                      @forelse($data['latest_log'] as $log)
                      <tr>
                          <td data-label="{{translate('Transaction Id')}}">{{$log->trx_code}}</td>

                
                            <td data-label="{{translate('User')}}">
                            
                                @if($log->user)

                                  <a href="{{route('admin.deposit.report.list',['user_id' => $log->user->id])}}">
                                    {{$log->user->name}}
                                  </a>

                                @else
                                  {{translate("N/A")}}
                                @endif
                            
                            </td>


                            <td data-label="{{translate('Method')}}">
                            
                                @if($log->method)

                                  <a href="{{route('admin.deposit.report.list',['method_id' => $log->method->id])}}">
                                    {{$log->method->name}}
                                  </a>

                                @else
                                  {{translate("N/A")}}
                                @endif
                            
                            </td>


                            <td data-label="{{translate('Amount')}}">
                              {{$log->method->currency_symbol}} {{round($log->final_amount)}} 
                            </td>
                        
                            <td data-label="{{translate('Date')}}">
                                {{diff_for_humans($log->created_at)}}
                            </td>

                  
                          <td data-label="{{translate('Status')}}">
                              @if($log->status == '0')
                                <span class="i-badge capsuled warning">
                                  {{translate("Pending")}}
                                </span>
                
                              @elseif($log->status == '1')
                                  <span class="i-badge capsuled success">
                                      {{translate("Completed")}}
                                  </span>
                              @else
                                <span class="i-badge capsuled danger">
                                  {{translate("Cancel")}}
                                </span>
                              @endif
                          </td>

                          <td data-label="{{translate('Options')}}">
                              <div class="table-action">
                                  @if(check_permission('update_transaction')  ) 
                                      
                                  <a  href="" class="update fs-15 icon-btn info"><i class="las la-pen"></i></a>
                          
                                  @else
                                    {{translate("N/A")}}
                                  @endif
                              </div>
                          </td>

                        </tr>
                      
                          @empty 

                          <tr class="border-bottom-0">
                              <td class="border-bottom-0" colspan="100">
                                  @include('admin.partials.not_found')
                              </td>
                          </tr>
                      @endforelse
                  </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
    <div class="col-xxl-8 col-xl-7">
      <div class="i-card-md">
        <div class="card--header">
          <h4 class="card-title">
            {{translate("Visitors By Month In")}}  {{ \Carbon\Carbon::now()->year }}
          </h4>
        </div>
        <div class="card-body">
          <div class="row g-0 mb-4">
            <div class="col-sm-3">
              <div class="p-3 border text-center border-dashed border-start-0">
                <h5 class="mb-1">
                    <span>30</span>
                </h5>
                <p class="text-muted mb-0">Opened</p>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="p-3 border text-center border-dashed border-start-0">
                <h5 class="mb-1">
                    <span>30</span>
                </h5>
                <p class="text-muted mb-0">Opened</p>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="p-3 border text-center border-dashed border-start-0">
                <h5 class="mb-1">
                    <span>30</span>
                </h5>
                <p class="text-muted mb-0">Opened</p>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="p-3 border text-center border-dashed border-start-0">
                <h5 class="mb-1">
                    <span>30</span>
                </h5>
                <p class="text-muted mb-0">Opened</p>
              </div>
            </div>
          </div>
          <div id="visitor-chart" class="apex-chart"></div>
        </div>
      </div>
    </div>
    <div class="col-xxl-4 col-xl-5">
      <div class="i-card-md">
        <div class="card--header">
          <h4 class="card-title">
             {{translate("Activities")}} 
          </h4>
        </div>
        <div class="card-body">
          <ul class="activity-list">
            <li>
              <div class="d-flex align-items-start gap-2">
                <span class="list-dot"><i class="bi bi-dot"></i></span>
                <span class="activity-title">Replied to new support request through AI and added new project this week</span>
              </div>
              <span class="time">6.68PM</span>
            </li>
            <li>
              <div class="d-flex align-items-center gap-2">
                <span class="list-dot"><i class="bi bi-dot"></i></span>
                <span class="activity-title">New theme for <strong>website</strong></span>
              </div>
              <span class="time">2.68PM</span>
            </li>
            <li>
              <div class="d-flex align-items-center gap-2">
                <span class="list-dot"><i class="bi bi-dot"></i></span>
                <span class="activity-title">Replied to new support request</span>
              </div>
              <span class="time">6.68PM</span>
            </li>
            <li>
              <div class="d-flex align-items-center gap-2">
                <span class="list-dot"><i class="bi bi-dot"></i></span>
                <span class="activity-title">New theme for <strong>website</strong></span>
              </div>
              <span class="time">2.68PM</span>
            </li>
            <li>
              <div class="d-flex align-items-center gap-2">
                <span class="list-dot"><i class="bi bi-dot"></i></span>
                <span class="activity-title">Replied to new support request</span>
              </div>
              <span class="time">6.68PM</span>
            </li>
            <li>
              <div class="d-flex align-items-center gap-2">
                <span class="list-dot"><i class="bi bi-dot"></i></span>
                <span class="activity-title">New theme for <strong>website</strong></span>
              </div>
              <span class="time">2.68PM</span>
            </li>
            <li>
              <div class="d-flex align-items-center gap-2">
                <span class="list-dot"><i class="bi bi-dot"></i></span>
                <span class="activity-title">Replied to new support request</span>
              </div>
              <span class="time">6.68PM</span>
            </li>
            <li>
              <div class="d-flex align-items-center gap-2">
                <span class="list-dot"><i class="bi bi-dot"></i></span>
                <span class="activity-title">New theme for <strong>website</strong></span>
              </div>
              <span class="time">2.68PM</span>
            </li>
            <li>
              <div class="d-flex align-items-center gap-2">
                <span class="list-dot"><i class="bi bi-dot"></i></span>
                <span class="activity-title">Replied to new support request</span>
              </div>
              <span class="time">6.68PM</span>
            </li>
            <li>
              <div class="d-flex align-items-center gap-2">
                <span class="list-dot"><i class="bi bi-dot"></i></span>
                <span class="activity-title">New theme for <strong>website</strong></span>
              </div>
              <span class="time">2.68PM</span>
            </li>
            <li>
              <div class="d-flex align-items-center gap-2">
                <span class="list-dot"><i class="bi bi-dot"></i></span>
                <span class="activity-title">Replied to new support request</span>
              </div>
              <span class="time">6.68PM</span>
            </li>
            <li>
              <div class="d-flex align-items-center gap-2">
                <span class="list-dot"><i class="bi bi-dot"></i></span>
                <span class="activity-title">New theme for <strong>website</strong></span>
              </div>
              <span class="time">2.68PM</span>
            </li>
           
          </ul>
        </div>
      </div>
    </div>

  

  </div>

  <!-- table -->

  <div class="row">
    
  </div>


  @php
    $primaryRgba =  hexa_to_rgba(site_settings('primary_color'));
    $secondaryRgba =  hexa_to_rgba(site_settings('secondary_color'));
    $primary_light = "rgba(".$primaryRgba.",0.1)";
    $primary_light2 = "rgba(".$primaryRgba.",0.702)";
    $primary_light3 = "rgba(".$primaryRgba.",0.5)";
    $primary_light4 = "rgba(".$primaryRgba.",0.3)";
    $secondary_light = "rgba(".$secondaryRgba.",0.1)";
  @endphp 

@endsection

@push('script-include')
  <script  src="{{asset('assets/global/js/apexcharts.js')}}"></script>
  <script  src="{{asset('assets/global/js/chart-init.js')}}"></script>
@endpush


@push('script-push')
<script>
  "use strict";


    var vistiorLabel =  @json(array_keys($data['visitor_by_months']));
    var visitorValues =  @json(array_values($data['visitor_by_months']));
    var earningLabel =  @json(array_keys($data['earning_per_months']));
    var earningValues =  @json(array_values($data['earning_per_months']));
    var gatewayLabel =  @json(array_keys($data['gateways']));
    var gatewayValues =  @json(array_values($data['gateways']));

    var subscriptionLabel =  @json(array_keys($data['subscription']));
    var subscriptionValues =  @json(array_values($data['subscription']));

   /** visitors by months */
    var options = {
          series: [{
          name: "{{translate('Visitors')}}",
          data: visitorValues
        }],
          chart: {
          height: 350,
          type: 'line',
        },
        forecastDataPoints: {
          count: 7
        },
        colors:['{{ site_settings('primary_color') }}'],
        stroke: {
          width: 5,
          curve: 'smooth'
        },
        xaxis: {
       
          categories: vistiorLabel,

       
        },
        title: {
        
          align: 'left',
          style: {
            fontSize: "16px",
            color: '#666'
          }
        },
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'dark',
            gradientToColors: [ '#FDD835'],
            shadeIntensity: 1,
            type: 'horizontal',
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100]
          },
        },
        yaxis: {
          min: 0,
          max: 50
        }
    };

    var chart = new ApexCharts(document.querySelector("#visitor"), options);
    chart.render();


    /** earning by months */
    var earning = {
        series: [{
        data: earningValues
        }],
        chart: {
        type: 'bar',
        height: 350
      },
      annotations: {
        xaxis: [{
          x: 500,
          borderColor: '#00E396',
          label: {
            borderColor: '#00E396',
            style: {
              color: '#fff',
              background: '#00E396',
            },
        
          }
        }],
    
      },
      colors:['{{ site_settings('primary_color') }}'],

      plotOptions: {
        bar: {
          horizontal: true,
        }
      },
      dataLabels: {
        enabled: true
      },
      xaxis: {
        categories: earningLabel,
      },
      grid: {
        xaxis: {
          lines: {
            show: true
          }
        }
      },
      yaxis: {
        reversed: true,
        axisTicks: {
          show: true
        }
      }
    };

    var chart = new ApexCharts(document.querySelector("#earning"), earning);
    chart.render();


    /** gateway used by months */
    var options = {
          series: [44, 55, 41, 17, 15],
          chart: {
          width: 380,
          type: 'donut',
          dropShadow: {
            enabled: true,
            color: '#111',
            top: -1,
            left: 3,
            blur: 3,
            opacity: 0.2
          }
        },
        stroke: {
          width: 0,
        },
        plotOptions: {
          pie: {
            donut: {
              labels: {
                show: true,
                total: {
                  showAlways: true,
                  show: true
                }
              }
            }
          }
        },
        labels: ["Comedy", "Action", "SciFi", "Drama", "Horror"],
        dataLabels: {
          dropShadow: {
            blur: 3,
            opacity: 0.8
          }
        },
        fill: {
          opacity: 1,
          pattern: {
            enabled: true,
          },
        },
        states: {
          hover: {
            filter: 'none'
          }
        },

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

        var chart = new ApexCharts(document.querySelector("#paymentGateway"), options);
        chart.render();

  /** subscription used in total */
    var options = {
          series: subscriptionValues,
          chart: {
          type: 'donut',
          height: 360
        },
        labels: subscriptionLabel ,

        colors:['{{ site_settings('primary_color') }}',"{{site_settings('secondary_color')}}" , "{{ $primary_light}}" , "{{ $primary_light2}}" ,"{{$primary_light3}}","{{$secondary_light}}"],
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

      var chart = new ApexCharts(document.querySelector("#subscription"), options);
      chart.render();
      
      // m-chart-right-top
      var options = {
          series: [{
          name: 'Net Profit',
          data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
        }, {
          name: 'Revenue',
          data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        }, {
          name: 'Free Cash Flow',
          data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 3,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
          title: {
            text: '$ (thousands)'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands"
            }
          }
        },
        colors: ['{{ site_settings('primary_color') }}','{{  $primary_light3 }}','{{  $primary_light4 }}'],
        // colors: ['#F44336', '#E91E63', '#9C27B0']

        };

        var chart = new ApexCharts(document.querySelector("#perform-category"), options);
        chart.render();


        var options = {
          series: [{
          name: 'Income',
          type: 'column',
          data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6]
        }, {
          name: 'Cashflow',
          type: 'column',
          data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5]
        }, {
          name: 'Revenue',
          type: 'line',
          data: [20, 29, 37, 36, 44, 45, 50, 58]
        }],
          chart: {
          height: 350,
          type: 'line',
          stacked: false
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: [1, 1, 4]
        },

        xaxis: {
          categories: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016],
        },
        tooltip: {
          fixed: {
            enabled: true,
            position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
            offsetY: 20,
            offsetX: 50
          },
        },
        legend: {
          horizontalAlign: 'left',
          offsetX: 30
        }
        };

        var chart = new ApexCharts(document.querySelector("#visitor-chart"), options);
        chart.render();


        // datepicker

      
</script>
@endpush




