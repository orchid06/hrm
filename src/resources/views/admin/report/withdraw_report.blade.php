@extends('admin.layouts.master')

@push('style-include')
    <link href="{{asset('assets/global/css/datepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')

    <div class="row mb-4">
        <div class="col-lg-9">
            <div class="i-card-md">
                <div class="card-body">
                    <div id="withdraw-report"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="i-card-md">
                <div class="card--header">
                    <h4 class="card-title">Summery</h4>
                </div>
                <div class="card-body">
                    <ul class="subcription-list">
                        <li><span>Total User</span><span>200</span></li>
                        <li><span>Final Amount</span><span>$3454534</span></li>
                        <li><span>Pending</span><span>350</span></li>
                        <li><span>Approved</span><span>234</span></li>
                        <li><span>Rejected</span><span>989</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="i-card-md">
        <div class="card-body">
            <div class="search-action-area">
                <div class="row g-3">
                    <div class="col-md-12 d-flex justify-content-end">
                        <div class="filter-wrapper">
                            <button class="i-btn btn--primary btn--sm filter-btn" type="button">
                                <i class="las la-filter"></i>
                            </button>
                            <div class="filter-dropdown">
                                <form action="{{route(Route::currentRouteName())}}" method="get">
                                    <div class="form-inner">
                                        <input type="text" id="datePicker" name="date" value="{{request()->input('date')}}"  placeholder='{{translate("Filter by date")}}'>
                                    </div>
                                    <div class="form-inner">
                                        <select name="status" id="status" class="status">
                                            <option value="">
                                                {{translate('Select status')}}
                                            </option>
                                            @foreach(App\Enums\WithdrawStatus::toArray() as $k => $v)
                                                <option  {{$v ==   request()->input('status') ? 'selected' :""}} value="{{$v}}">
                                                    {{ucfirst(t2k($k))}}
                                               </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-inner">
                                        <select name="user" id="user" class="user">
                                            <option value="">
                                                {{translate('Select User')}}
                                            </option>
                                            @foreach(system_users() as $user)
                                                <option  {{Arr::get($user,"username",null) ==   request()->input('user') ? 'selected' :""}} value="{{Arr::get($user,"username",null)}}"> {{Arr::get($user,"name",null)}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-inner">
                                        <input type="text"  name="search" value="{{request()->input('search')}}"  placeholder='{{translate("Search by transaction id or remarks")}}'>
                                    </div>
                                    <button class="i-btn btn--md info w-100">
                                        <i class="las la-sliders-h"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="ms-3">
                            <a href="{{route(Route::currentRouteName())}}"  class="i-btn btn--sm danger">
                                <i class="las la-sync"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-container position-relative">
                @include('admin.partials.loader')
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
                        @forelse($reports as $report)
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
                                      {{num_format($report->final_amount,@$report->currency)}}
                                </td>
                                <td  data-label='{{translate("Status")}}'>

                                    @php echo  withdraw_status($report->status)  @endphp
                                </td>
                                <td data-label='{{translate("Options")}}'>
                                    <div class="table-action">
                                        <a data-toggle="tooltip" data-placement="top" title='{{translate("Update")}}'  href="{{route('admin.withdraw.report.details',$report->id)}}"  class="fs-15 icon-btn info"><i class="las la-pen"></i></a>
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
            <div class="Paginations">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
@endsection

@push('script-include')
  <script  src="{{asset('assets/global/js/apexcharts.js')}}"></script>
   <script src="{{asset('assets/global/js/datepicker/moment.min.js')}}"></script>
  <script src="{{asset('assets/global/js/datepicker/daterangepicker.min.js')}}"></script>
    <script src="{{asset('assets/global/js/datepicker/init.js')}}"></script>
@endpush

@push('script-push')
<script>
	(function($){

        "use strict";

        $(".select2").select2({

        });
        $(".user").select2({

        });
        $(".status").select2({

        });

 

        var options = {
          series: [
          {
            name: 'Actual',
            data: [
              {
                x: '2011',
                y: 1292,
                goals: [
                  {
                    name: 'Expected',
                    value: 1400,
                    strokeHeight: 5,
                    strokeColor: '#775DD0'
                  }
                ]
              },
              {
                x: '2012',
                y: 4432,
                goals: [
                  {
                    name: 'Expected',
                    value: 5400,
                    strokeHeight: 5,
                    strokeColor: '#775DD0'
                  }
                ]
              },
              {
                x: '2013',
                y: 5423,
                goals: [
                  {
                    name: 'Expected',
                    value: 5200,
                    strokeHeight: 5,
                    strokeColor: '#775DD0'
                  }
                ]
              },
              {
                x: '2014',
                y: 6653,
                goals: [
                  {
                    name: 'Expected',
                    value: 6500,
                    strokeHeight: 5,
                    strokeColor: '#775DD0'
                  }
                ]
              },
              {
                x: '2015',
                y: 8133,
                goals: [
                  {
                    name: 'Expected',
                    value: 6600,
                    strokeHeight: 13,
                    strokeWidth: 0,
                    strokeLineCap: 'round',
                    strokeColor: '#775DD0'
                  }
                ]
              },
              {
                x: '2016',
                y: 7132,
                goals: [
                  {
                    name: 'Expected',
                    value: 7500,
                    strokeHeight: 5,
                    strokeColor: '#775DD0'
                  }
                ]
              },
              {
                x: '2017',
                y: 7332,
                goals: [
                  {
                    name: 'Expected',
                    value: 8700,
                    strokeHeight: 5,
                    strokeColor: '#775DD0'
                  }
                ]
              },
              {
                x: '2018',
                y: 6553,
                goals: [
                  {
                    name: 'Expected',
                    value: 7300,
                    strokeHeight: 2,
                    strokeDashArray: 2,
                    strokeColor: '#775DD0'
                  }
                ]
              }
            ]
          }
        ],
          chart: {
          height: 350,
          type: 'bar'
        },
        plotOptions: {
          bar: {
            columnWidth: '60%'
          }
        },
        colors: ['#00E396'],
        dataLabels: {
          enabled: false
        },
        legend: {
          show: true,
          showForSingleSeries: true,
          customLegendItems: ['Actual', 'Expected'],
          markers: {
            fillColors: ['#00E396', '#775DD0']
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#withdraw-report"), options);
        chart.render();

	})(jQuery);
</script>

@endpush





