@extends('admin.layouts.master')
@push('style-include')
    <link href="{{asset('assets/global/css/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush
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
      <form action="{{route('admin.home')}}" method="get">
        <div class="date-search">
            <input type="text" id="datePicker" name="date" value="{{request()->input('date')}}"  placeholder="{{translate('Filter by date')}}">
            <button type="submit" class="me-2"><i class="bi bi-search"></i></button>
            <a href="{{route(Route::currentRouteName())}}"  class="i-btn btn--sm danger">
              <i class="las la-sync"></i>
            </a>
        </div>
      </form>

    </div>
</div>


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
                    {{translate("Subscription Packages")}}
                  </h5>
                  <a href="{{route("admin.subscription.package.list")}}" class="i-btn btn--sm btn--outline">
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
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="i-card-sm style-2 success">
            <div class="card-info">
              <h3>
                {{Arr::get($data,"total_user",0)}}
              </h3>
              <h5 class="title">
                {{translate("Total Users")}}
              </h5>
              <a href="{{route("admin.user.list")}}" class="i-btn btn--sm btn--outline">
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
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="i-card-sm style-2 info">
                <div class="card-info">
                  <h3>
                    {{(Arr::get($data,"total_earning",0))}}
                  </h3>
                  <h5 class="title">
                      {{translate('Total Earning')}}
                  </h5>
                  <a href="{{route('admin.subscription.report.list')}}" class="i-btn btn--sm btn--outline">
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
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="i-card-sm style-2 danger">
            <div class="card-info">
              <h3>{{Arr::get($data,"total_category",0)}} </h3> 
              <h5 class="title">{{translate('Total Category')}}</h5>
              <a href="{{route('admin.category.list')}}" class="i-btn btn--sm btn--outline">{{translate("View All")}}</a>
            </div>
            <div class="d-flex flex-column align-items-end gap-4">

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
                {{Arr::get($data,"total_visitor",0)}}
              </h3>
              <h5 class="title">
                {{translate("Total Visitors")}}
              </h5>
              <a href="{{route("admin.security.ip.list")}}" class="i-btn btn--sm btn--outline">{{translate("View All")}}</a>
            </div>
            <div class="d-flex flex-column align-items-end gap-4">
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
                    {{Arr::get($data,"total_platform",0)}}
                  </h3>
                  <h5 class="title">
                    {{translate("Social Platform")}}
                  </h5>
                  <a href="{{route('admin.platform.list')}}" class="i-btn btn--sm btn--outline">{{translate("View All")}}</a>
                </div>
                <div class="d-flex flex-column align-items-end gap-4">
                
                  <div class="icon">
                      <i class="las la-share-alt"></i>
                  </div>
                </div>
            </div>
        </div>


        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="i-card-sm style-2 info">
              <div class="card-info">
                <h3>
                  {{Arr::get($data,"total_template",0)}}
                </h3>
                <h5 class="title">
                  {{translate("Ai Templates")}}
                </h5>
                <a href="{{route('admin.ai.template.list')}}" class="i-btn btn--sm btn--outline">{{translate("View All")}}</a>
              </div>
              <div class="d-flex flex-column align-items-end gap-4">
              
                <div class="icon">
                  <i class="las la-robot"></i>
                </div>
              </div>
          </div>
        </div>


        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="i-card-sm style-2 success">
              <div class="card-info">
                <h3>
                  {{Arr::get($data['account_repot'],"total_account",0)}}
                </h3>
                <h5 class="title">
                  {{translate("Social Accounts")}}
                </h5>
                <a href="{{route('admin.social.account.list')}}" class="i-btn btn--sm btn--outline">{{translate("View All")}}</a>
              </div>
              <div class="d-flex flex-column align-items-end gap-4">
              
                <div class="icon">
                  <i class="las la-user-tie"></i>
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
              {{translate("Subscriptions & Income")}}
          </h4>
        </div>
        <div class="card-body">
            <div class="row g-0 text-center mb-2">
            
              <div class="col-6 col-sm-6">
                  <div class="p-3 border border-dashed border-start-0">
                      <h5 class="mb-1">
                          <span>
                            {{Arr::get($data['subscription_reports'],"total_subscriptions",0)}}
                          </span>
                      </h5>
                      <p class="text-muted mb-0">
                          {{translate("Total Subscriptions")}}
                      </p>
                  </div>
              </div>
              <!--end col-->
              <div class="col-6 col-sm-6">
                  <div class="p-3 border border-dashed border-start-0">
                      <h5 class="mb-1"><span>
                        {{Arr::get($data['subscription_reports'],"total_income",0)}}
                      </span></h5>
                      <p class="text-muted mb-0">
                          {{translate("Total Income")}}
                      </p>
                  </div>
              </div>
            </div>
          <div id="subscriptionReport" class="apex-chart"></div>
        </div>
      </div>
    </div>
  </div>



  <div class="row g-3 mb-4">
    <div class="col-xxl-4 col-xl-5">
      <div class="i-card-md">
        <div class="card--header">
          <h4 class="card-title">
             {{translate("Social Accounts")}} 
          </h4>

          <a href="{{route('admin.social.account.list')}}" class="i-btn btn--sm btn--success btn--outline">
             {{translate("View All")}}
          </a>
        </div>
        <div class="card-body">
          <div id="accountReport" class="apex-chart"></div>
          <div class="row g-0 text-center">
            
            <!--end col-->
            <div class="col-6 col-sm-6">
                <div class="p-3 border border-dashed border-start-0">
                    <h5 class="mb-1">
                        <span>
                          {{Arr::get($data['account_repot'],"active_account",0)}}
                        </span>
                    </h5>
                    <p class="text-muted mb-0">
                        {{translate("Active")}}
                    </p>
                </div>
            </div>
            <!--end col-->
            <div class="col-6 col-sm-6">
                <div class="p-3 border border-dashed border-start-0">
                    <h5 class="mb-1"><span>
                      {{Arr::get($data['account_repot'],"inactive_account",0)}}
                    </span></h5>
                    <p class="text-muted mb-0">
                         {{translate("Inactive")}}
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
             {{translate("Latest Deposits")}}
          </h4>

          <a href="{{route('admin.deposit.report.list')}}" class="i-btn btn--sm btn--success btn--outline">
            {{translate("View All")}}
         </a>
        </div>

        <div class="card-body">
            <div class="table-container">
              <table >
                <thead>
                    <tr>
                        <th scope="col">
                            #
                        </th>

                        <th scope="col">
                            {{translate('Date')}}
                        </th>
                       

                        <th scope="col">
                            {{translate('User')}}
                        </th>

                        <th scope="col">
                            {{translate('Method')}}
                        </th>

                        <th scope="col">
                            {{translate('Trx Code')}}
                        </th>
                        <th scope="col">
                            {{translate('Final Amount')}}
                        </th>
                        <th scope="col">
                            {{translate('Status')}}
                        </th>
            
                        <th scope="col">
                            {{translate('Options')}}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse(Arr::get($data,'latest_log',[]) as $report)

                            <tr>
                                <td data-label="#">
                                   
                                    {{$loop->iteration}}
                                </td>

                                <td data-label='{{translate("Date")}}'>
                                    {{ get_date_time($report->created_at) }}
                                </td>
                       

                                <td data-label='{{translate("User")}}'>
                                    <a href="{{route('admin.user.show',$report->user->uid)}}">
                                        {{$report->user->name}}
                                    </a>
                                </td>

                                <td data-label='{{translate("Payment Method")}}'>
                                 
                                    {{$report->method->name}}
                                    
                                </td>
                                
                                <td  data-label='{{translate("Trx Code")}}'>
                                      {{$report->trx_code}}
                                </td>

                                <td  data-label='{{translate("Final Amount")}}'>
                                      {{num_format($report->final_amount,@$report->method->currency)}}
                                </td>
                                <td  data-label='{{translate("Status")}}'>
                                     
                                    @php echo  payment_status($report->status)  @endphp
                                </td>

                   
                                <td data-label='{{translate("Options")}}'>
                                    <div class="table-action">

                                        <a data-toggle="tooltip" data-placement="top" title='{{translate("Update")}}'  href="{{route('admin.deposit.report.details',$report->id)}}"  class=" fs-15 icon-btn info"><i class="las la-pen"></i></a>

                                    </div>
                                </td>
                           </tr>
                     
                        @empty

                        <tr>
                            <td class="border-bottom-0" colspan="90">
                                @include('admin.partials.not_found',['custom_message' => "No Reports found!!"])
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
            {{translate("Revenue With Charge")}} 
          </h4>
        </div>
        <div class="card-body">
          <div class="row g-0 mb-4">
            <div class="col-sm-4">
              <div class="p-3 border text-center border-dashed border-start-0">
                <h5 class="mb-1">
                    <span>
                        {{Arr::get($data['subscription_reports'],"total_income",0)}}
                    </span>
                </h5>
                <p class="text-muted mb-0">
                   {{translate("Income")}}
                </p>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="p-3 border text-center border-dashed border-start-0">
                <h5 class="mb-1">
                    <span>
                        {{Arr::get($data,"payment_charge",0)}}
                    </span>
                </h5>
                <p class="text-muted mb-0">
                   {{translate("Payment Charge")}}
                </p>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="p-3 border text-center border-dashed border-start-0">
                <h5 class="mb-1">
                    <span>{{Arr::get($data,"withdraw_charge",0)}}</span>
                </h5>
                <p class="text-muted mb-0">
                  {{translate("Withdraw Charge")}}
               </p>
              </div>
            </div>
           
          </div>
          <div id="income" class="apex-chart"></div>
        </div>
      </div>
    </div>
    <div class="col-xxl-4 col-xl-5">
      <div class="i-card-md">
        <div class="card--header">
          <h4 class="card-title">
             {{translate("Latest Subscriptions")}} 
          </h4>
        </div>
        <div class="card-body">
          <ul class="activity-list">

             @forelse(Arr::get($data,'latest_subscriptions',[]) as $subscription)

              <li>
                  <div class="d-flex align-items-start gap-2">
                    <span class="list-dot"><i class="bi bi-dot"></i></span>
                    <span class="activity-title">
                          {{@$subscription->user->name}} {{translate(" has successfully acquired a new package, completing the payment of")}}
                          {{num_format(number:$subscription->payment_amount,calC:true)}}
                    </span>
                  </div>
                  <span class="time">
                      {{diff_for_humans($subscription->created_at)}}
                  </span>
              </li>

             @empty

              <li class="d-flex justify-content-center">
                 
                @include('admin.partials.not_found',['custom_message' => "No data found!!"])


              </li>

             @endforelse
         
          

          </ul>
        </div>
      </div>
    </div>
  </div>


  <div class="row g-3 mb-4">

    <div class="col-xxl-4 col-xl-5">
      <div class="i-card-md">
        <div class="card--header">
          <h4 class="card-title">
             {{translate("Plan In Subscription")}} 
          </h4>

          <a href="{{route('admin.subscription.package.list')}}" class="i-btn btn--sm btn--success btn--outline">
             {{translate("View All")}}
          </a>
        </div>
        <div class="card-body">
          <div id="planReport" class="apex-chart"></div>

        </div>
      </div>
    </div>
    <div class="col-xxl-8 col-xl-7">
      <div class="i-card-md">
        <div class="card--header">
          <h4 class="card-title">
             {{translate("Latest Transaction")}}
          </h4>

          <a href="{{route('admin.transaction.report.list')}}" class="i-btn btn--sm btn--success btn--outline">
            {{translate("View All")}}
         </a>
        </div>

        <div class="card-body">
            <div class="table-container">

              <table >
                <thead>
                    <tr>
                        <th scope="col">
                          #
                        </th>

                        <th scope="col">
                            {{translate('Date')}}
                        </th>

                        <th scope="col">
                            {{translate('User')}}
                        </th>

                        <th scope="col">
                            {{translate('Trx Code')}}
                        </th>

                        <th scope="col">
                            {{translate('Balance')}}
                        </th>

                        <th scope="col">
                            {{translate('Post Balance')}}
                        </th>

                        <th scope="col">
                            {{translate('Remark')}}
                        </th>
            
                    </tr>
                </thead>

                <tbody>
                    @forelse(Arr::get($data,'latest_transactiions',[]) as $report)

                            <tr>
                                <td data-label="#">
                        
                                    {{$loop->iteration}}
                                </td>

                                <td data-label='{{translate("Date")}}'>
                                    {{ get_date_time($report->created_at) }}
                                </td>

                                <td data-label='{{translate("User")}}'>
                                    <a href="{{route('admin.user.show',$report->user->uid)}}">
                                        {{$report->user->name}}
                                    </a>
                                </td>
                                
                                <td  data-label='{{translate("Trx Code")}}'>
                                      {{$report->trx_code}}
                                </td>

                                <td  data-label='{{translate("Credit")}}'>
                                    <span class='text--{{$report->trx_type == App\Models\Transaction::$PLUS ? "success" :"danger" }}'>
                                        <i class='las la-{{$report->trx_type == App\Models\Transaction::$PLUS ? "plus" :"minus" }}'></i>

                                          {{num_format($report->amount,$report->currency)}}
                                      
                                    </span>
                                </td>

                                <td  data-label='{{translate("Post Credit")}}'>

                                    {{@num_format(
                                        number : $report->post_balance??0,
                                        calC   : true
                                    )}}
                           
                                </td>

                                <td  data-label='{{translate("Remark")}}'>
                             
                                    {{k2t($report->remarks)}}
                     
                                </td>

                             
                           </tr>
                     
                        @empty

                        <tr>
                            <td class="border-bottom-0" colspan="90">
                                @include('admin.partials.not_found',['custom_message' => "No Reports found!!"])
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
    $primary_light3 = "rgba(".$primaryRgba.",0.5)";
    $primary_light4 = "rgba(".$primaryRgba.",0.3)";
    $secondary_light = "rgba(".$secondaryRgba.",0.1)";
  @endphp 

@endsection

@push('script-include')
  <script  src="{{asset('assets/global/js/apexcharts.js')}}"></script>
  <script src="{{asset('assets/global/js/flatpickr.js')}}"></script>

@endpush


@push('script-push')
<script>
  "use strict";

    /** account repots */
    var monthlyLabel = @json(array_keys($data['subscription_reports']['monthly_subscriptions']));
    var accountValues =  @json(array_values($data['account_repot']['accounts_by_platform']));
    var accountLabel =  @json(array_keys($data['account_repot']['accounts_by_platform']));
    var options = {
          series: accountValues,
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
        labels: accountLabel,

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
    var chart = new ApexCharts(document.querySelector("#accountReport"), options);
    chart.render();



    /** subscription and income */
    var subscriptionIncome = @json(array_values($data['subscription_reports']['monthly_income']));
    var subscriptions = @json(array_values($data['subscription_reports']['monthly_subscriptions']));

    var options = {
      chart: {
        height: 350,
        type: "line",
      },
      dataLabels: {
        enabled: false,
      },
      colors: ["{{site_settings('primary_color')}}", "{{site_settings('secondary_color')}}"], 
      series: [
        {
          name: "{{ translate('Subscriptions') }}",
          data: subscriptions,
        },
        {
          name: "{{ translate('Profit') }}",
          data: subscriptionIncome, 
        },

        
      ],
      xaxis: {
        categories: monthlyLabel,
      },
      yaxis: [
        {
          title: {
            text: "{{ translate('Subscription') }}",
          },
        },
        {
          opposite: true,
          title: {
            text: "{{ translate('Income') }}",
          }
      
        },
      ],
      tooltip: {
          shared: false,
          intersect: true,
          y: {
            formatter: function (value, { series, seriesIndex, dataPointIndex, w }) {
              return formatCurrency(value); 
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

    var chart = new ApexCharts(document.querySelector("#subscriptionReport"), options);
    chart.render();



    function formatCurrency(value) {
        var suffixes = ["", "K", "M", "B", "T"];
        var order = Math.floor(Math.log10(value) / 3);
        var suffix = suffixes[order];
        if(value < 1)
        {return "$"+value}
        var scaledValue = value / Math.pow(10, order * 3);
        return "$" + scaledValue.toFixed(2) + suffix;
    }


 /**  income and charge */

  var paymentCharge = @json(array_values($data['monthly_payment_charge']));
  var withdrawCharge = @json(array_values($data['monthly_withdraw_charge']));


  var options = {
      chart: {
        height: 350,
        type: "line",
      },
      dataLabels: {
        enabled: false,
      },
      colors: ["{{site_settings('primary_color')}}", "{{site_settings('secondary_color')}}","#029768"], 
      series: [
        {
          name: "{{ translate('Subscriptions Income') }}",
          data: subscriptions,
        },
        {
          name: "{{ translate('Payment Charge') }}",
          data: paymentCharge, 
        },

        {
          name: "{{ translate('Withdraw Charge') }}",
          data: withdrawCharge, 
        },

        
      ],
      xaxis: {
        categories: monthlyLabel,
      },
   
      tooltip: {
          shared: false,
          intersect: true,
          y: {
            formatter: function (value, { series, seriesIndex, dataPointIndex, w }) {
              return formatCurrency(value); 
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

  var chart = new ApexCharts(document.querySelector("#income"), options);
  chart.render();

  

  /** plan report */

  var planValues =  @json(array_values($data['subscription_by_plan']));
  var planLabel =  @json(array_keys($data['subscription_by_plan']));
  var options = {
        series: planValues,
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
      labels: planLabel,

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
  var chart = new ApexCharts(document.querySelector("#planReport"), options);
  chart.render();



  flatpickr("#datePicker", {
            dateFormat: "Y-m-d",
            mode: "range",
        });

  
</script>
@endpush




