@extends('admin.layouts.master')

@push('style-include')
    <link href="{{asset('assets/global/css/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="row mb-4">
        <div class="col-lg-9">
            <div class="i-card-md mb-4">
                <div class="card-body">
                    <div id="affiliate-report"></div>
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
                        <li><span>Total Users</span><span>200</span></li>
                        <li><span>Reffered User</span><span>4534</span></li>
                        <li><span>Commission Rate</span><span>4%</span></li>
                        <li><span>Amount</span><span>$787565</span></li>
                        <li><span>Subscription Package</span><span>N/A</span></li>
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
                                    <input type="text"  name="search" value="{{request()->input('search')}}"  placeholder='{{translate("Search by transaction id")}}'>
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
                                {{translate('Trx Code')}}
                            </th>
                            <th scope="col">
                                {{translate('User')}}
                            </th>
                            <th scope="col">
                                {{translate('Reffered User')}}
                            </th>
                            <th scope="col">
                                {{translate('Subscription Package')}}
                            </th>
                            <th scope="col">
                                {{translate('Commission Rate')}}
                            </th>
                            <th scope="col">
                                {{translate('Amount')}}
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
                                <td data-label='{{translate("Trx Code ")}}'>
                                    {{ ($report->trx_code) }}
                                </td>
                                <td data-label='{{translate("User")}}'>
                                    <a href="{{route('admin.user.show',$report->user->uid)}}">
                                        {{$report->user->name}}
                                    </a>
                                </td>
                                <td data-label='{{translate("Reffered To")}}'>
                                    @if($report->referral)
                                        <a href="{{route('admin.user.show',$report->referral->uid)}}">
                                            {{$report->referral->name}}
                                        </a>
                                    @else
                                         {{translate('N/A')}}
                                    @endif
                                </td>
                                <td data-label='{{translate("Subscription Package")}}'>
                                      {{$report->subscription? @$report->subscription->package->title  : 'N/A'}}
                                </td>
                                <td data-label='{{translate("Commission Rate")}}'>
                                      {{$report->commission_rate}}%
                                </td>
                                <td data-label='{{translate("Amount")}}'>
                                    {{@num_format(
                                        number : $report->commission_amount??0,
                                        calC   : true
                                    )}}
                                </td>
                                <td data-label='{{translate("Options")}}'>
                                    <div class="table-action">
                                        <a title="{{translate('Info')}}" href="javascript:void(0);" data-report="{{$report}}" class="pointer show-info icon-btn info">
                                            <i class="las la-info"></i></a>
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

@section('modal')
    @include('modal.delete_modal')
    @include('modal.bulk_modal')
    <div class="modal fade" id="report-info" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="report-info"   aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{translate('Report Information')}}
                    </h5>
                    <button class="close-btn" data-bs-dismiss="modal">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="content">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-include')
  <script  src="{{asset('assets/global/js/apexcharts.js')}}"></script>
  <script src="{{asset('assets/global/js/flatpickr.js')}}"></script>
@endpush

@push('script-push')
<script>
	(function($){

        "use strict";

        $(".select2").select2({

        });
        $(".user").select2({

        });
        $(".type").select2({

        });

        flatpickr("#datePicker", {
            dateFormat: "Y-m-d",
            mode: "range",
        });


        $(document).on('click','.show-info',function(e){

            var modal = $('#report-info');

            var report = JSON.parse($(this).attr('data-report'))

            $('.content').html(report.note)

            modal.modal('show')

        });


        var dates = [
            { x: new Date('2024-01-01').getTime(), y: 1200000 },
            { x: new Date('2024-01-02').getTime(), y: 1250000 },
            { x: new Date('2024-01-03').getTime(), y: 1230000 },
            { x: new Date('2024-01-04').getTime(), y: 1270000 },
            { x: new Date('2024-01-05').getTime(), y: 1220000 },
            { x: new Date('2024-01-06').getTime(), y: 1280000 },
            { x: new Date('2024-01-07').getTime(), y: 1260000 },
            { x: new Date('2024-01-08').getTime(), y: 1300000 },
            { x: new Date('2024-01-09').getTime(), y: 1350000 },
            { x: new Date('2024-01-10').getTime(), y: 1370000 }
        ];

        var options = {
          series: [{
          name: 'XYZ MOTORS',
          data: dates
        }],
          chart: {
          type: 'area',
          stacked: false,
          height: 350,
          zoom: {
            type: 'x',
            enabled: true,
            autoScaleYaxis: true
          },
          toolbar: {
            autoSelected: 'zoom'
          }
        },
        dataLabels: {
          enabled: false
        },
        markers: {
          size: 0,
        },
        title: {
          text: 'Stock Price Movement',
          align: 'left'
        },
        fill: {
          type: 'gradient',
          gradient: {
            shadeIntensity: 1,
            inverseColors: false,
            opacityFrom: 0.5,
            opacityTo: 0,
            stops: [0, 90, 100]
          },
        },
        yaxis: {
          labels: {
            formatter: function (val) {
              return (val / 1000000).toFixed(0);
            },
          },
          title: {
            text: 'Price'
          },
        },
        xaxis: {
          type: 'datetime',
        },
        tooltip: {
          shared: false,
          y: {
            formatter: function (val) {
              return (val / 1000000).toFixed(0)
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#affiliate-report"), options);
        chart.render();

	})(jQuery);
</script>
@endpush





