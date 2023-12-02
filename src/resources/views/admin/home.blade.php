@extends('admin.layouts.master')
@section('content')

<div class="page-title-box">
    <h4 class="page-title">
       {{translate($title)}}
    </h4>
    <div class="page-title-right">
      <ol class="breadcrumb m-0">
        <li class="breadcrumb-item">
             <div class="cron">
              {{translate("Last Cron Run")}} : {{session()->has("last_corn_run") ?  diff_for_humans(session()->get("last_corn_run")) : translate("N/A")  }}
             </div>
        </li>
      </ol>
    </div>
  </div>

  <!-- card -->

  <div class="row g-3 mb-4">
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
      <div class="i-card-sm style-2 success">
        <div class="icon">
          <i class="las la-user-friends"></i>
        </div>
        <div class="card-info">
          <h5 class="title">
             {{translate("Total Users")}}
          </h5>
          <h3>
             {{Arr::get($data,"total_user",0)}}
          </h3>
        </div>
      </div>
    </div>

   
   
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <div class="i-card-sm style-2 success">
            <div class="icon">
              <i class="las la-cube"></i>
            </div>
            <div class="card-info">
              <h5 class="title">
                {{translate("Total Package")}}
              </h5>
              <h3>
                {{Arr::get($data,"total_package",0)}}
              </h3>
            </div>
        </div>
    </div>


    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <div class="i-card-sm style-2 info">
            <div class="icon">
              <i class="las la-users"></i>
            </div>
            <div class="card-info">
              <h5 class="title">
                {{translate("Total Visitors")}}
              </h5>
              <h3>{{$data['total_visitor']}}
                {{Arr::get($data,"total_visitor",0)}}
              </h3>
            </div>
        </div>
    </div>


   <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
      <div class="i-card-sm style-2 success">
          <div class="icon">
            <i class="lar la-newspaper"></i>
          </div>
          <div class="card-info">
            <h5 class="title">
              {{translate("Total Article")}}
            </h5>
            <h3>
              {{Arr::get($data,"total_article",0)}}
            </h3>
          </div>
      </div>
  </div>

    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <div class="i-card-sm style-2 info">
            <div class="icon">
              <i class="las la-dollar-sign"></i>
            </div>
            <div class="card-info">
              <h5 class="title">
                 {{translate('Total Earning')}}
              </h5>
              <h3>
                {{site_settings("currency_symbol")}}  {{truncate_price(Arr::get($data,"total_earning",0))}}
              </h3>
            </div>
        </div>
    </div>


    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
      <div class="i-card-sm style-2 danger">
        <div class="icon">
         <i class="las la-exchange-alt"></i>
        </div>
        <div class="card-info">
          <h5 class="title">{{translate('Total Category')}}</h5>
          <h3>{{Arr::get($data,"total_category",0)}} </h3>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
      <div class="i-card-sm style-2 primary">
          <div class="icon">
            <i class="las la-hand-holding-usd"></i>
          </div>
          <div class="card-info">
            <h5 class="title">
              {{translate("Total Withdraw Method")}}
            </h5>
            <h3>
              {{Arr::get($data,"total_withdraw_method",0)}}
            </h3>
          </div>
      </div>
  </div>

  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="i-card-sm style-2 warning">
        <div class="icon">
          <i class="lar las la-money-bill"></i>
        </div>
        <div class="card-info">
          <h5 class="title">
            {{translate("Total Payment Method")}}
          </h5>
          <h3>
            {{Arr::get($data,"total_payment_method",0)}}
          </h3>
        </div>
    </div>
</div>


  </div>

  <!-- charts -->

  <div class="row g-3 mb-4">
    <div class="col-lg-6">
      <div class="i-card-md">
        <div class="card--header">
          <h4 class="card-title">
             {{translate("Payment Gateway Used in")}} {{ \Carbon\Carbon::now()->year }}
          </h4>
        </div>
        <div class="card-body">
          <div id="paymentGateway" class="apex-chart"></div>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="i-card-md">
        <div class="card--header">
          <h4 class="card-title">
            {{translate("Visitors By Month In")}}  {{ \Carbon\Carbon::now()->year }}
          </h4>
        </div>
        <div class="card-body">
          <div id="visitor" class="apex-chart"></div>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="i-card-md">
        <div class="card--header">
          <h4 class="card-title">
             {{translate("Earnings Per Month In")}} {{ \Carbon\Carbon::now()->year }}
          </h4>
        </div>
        <div class="card-body">
          <div id="earning" class="apex-chart"></div>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="i-card-md">
        <div class="card--header">
          <h4 class="card-title">
             {{translate("Subscription Plan Used In")}} {{ \Carbon\Carbon::now()->year }}
          </h4>
        </div>
        <div class="card-body">
          <div id="subscription" class="apex-chart"></div>
        </div>
      </div>
    </div>

  </div>

  <!-- table -->

  <div class="row">
    <div class="col-lg-12">
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
                          <td data-label="{{translate("Transaction Id")}}">{{$log->transaction}}</td>

                
                            <td data-label="{{translate("User")}}">
                            
                                @if($log->user)

                                  <a href="{{route('admin.deposit.report.list',['user_id' => $log->user->id])}}">
                                    {{$log->user->name}}
                                  </a>

                                @else
                                  {{translate("N/A")}}
                                @endif
                            
                            </td>


                            <td data-label="{{translate("Method")}}">
                            
                                @if($log->method)

                                  <a href="{{route('admin.deposit.report.list',['method_id' => $log->method->id])}}">
                                    {{$log->method->name}}
                                  </a>

                                @else
                                  {{translate("N/A")}}
                                @endif
                            
                            </td>


                            <td data-label="{{translate("Amount")}}">
                              {{$log->method->currency_symbol}} {{round($log->final_amount)}} 
                            </td>
                        
                            <td data-label="{{translate("Date")}}">
                                {{diff_for_humans($log->created_at)}}
                            </td>

                  
                          <td data-label="{{translate("Status")}}">
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

                          <td data-label="{{translate("Options")}}">
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
  </div>


  @php
    $primaryRgba =  hexa_to_rgba(site_settings('primary_color'));
    $secondaryRgba =  hexa_to_rgba(site_settings('secondary_color'));
    $primary_light = "rgba(".$primaryRgba.",0.1)";
    $primary_light2 = "rgba(".$primaryRgba.",0.702)";
    $primary_light3 = "rgba(".$primaryRgba.",0.03)";
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
          series: gatewayValues,
          chart: {
          type: 'polarArea',
          height: 365
        },
        labels: gatewayLabel ,
        stroke: {
          colors: ['#fff']
        },
        fill: {
          opacity: 0.8
        },

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
      
 
      
      
      
</script>
@endpush




