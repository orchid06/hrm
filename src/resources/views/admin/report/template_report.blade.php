@extends('admin.layouts.master')

@push('style-include')
    <link href="{{asset('assets/global/css/datepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')

    <div class="row mb-4">

        <div class="col-lg-3">

            @include('admin.partials.summary')
            
        </div>

        <div class="col-lg-9">
            <div class="i-card-md">
                <div class="card--header text-end">
                    <h4 class="card-title">
                        {{ translate('Word Generation (Current Year)')}}
                    </h4>
                </div>
                <div class="card-body">
                    <div id="template-report"></div>
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
                                        <select name="template" id="template" class="select2">
                                            <option value="">
                                                {{translate('Select Template')}}
                                            </option>
                                            @foreach($templates as $template)
                                            <option  {{$template->slug ==   request()->input('template') ? 'selected' :""}} value="{{$template->slug}}"> {{$template->name}}
                                            </option>
                                            @endforeach
                                        </select>
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
                                    {{translate('Template')}}
                                </th>
                                <th scope="col">
                                    {{translate('Genarated By')}}
                                </th>
                                <th scope="col">
                                    {{translate('Generated On')}}
                                </th>
                                <th scope="col">
                                    {{translate('Words')}}
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
                                        <td data-label='{{translate("Template")}}'>
                                            <p>{{$report->template?->name}}</p>
                                        </td>
                                        <td data-label='{{translate("Genarated By")}}'>
                                            @php
                                                    $name  = $report->user?  $report->user->name : @$report->admin->name;
                                                    $role  = $report->user? translate('System User') :translate('admin') ;
                                            @endphp
                                            <span class="i-badge capsuled success">
                                                {{ $name }} ({{   $role }})
                                            </span>
                                        </td>
                                        <td data-label='{{translate("Generated On")}}'>
                                            {{ get_date_time($report->created_at) }}
                                            <div>
                                                {{ diff_for_humans($report->created_at) }}
                                            </div>
                                        </td>

                                        <td  data-label='{{translate("Words")}}'>
                                            <span class="i-badge capsuled success">
                                                {{$report->total_words}}
                                            </span>
                                        </td>

                                        <td data-label='{{translate("Options")}}'>

                                            <div class="table-action">
                                                <a data-bs-toggle="tooltip" data-bs-placement="top"    data-bs-title="{{translate("Info")}}" href="javascript:void(0);" data-report="{{$report}}" class="pointer show-info icon-btn info">
                                                    <i class="las la-info"></i></a>

                                                @if(check_permission('delete_report') )
                                                    <a  href="javascript:void(0);" data-href="{{route('admin.template.report.destroy',$report->id)}}"  data-bs-toggle="tooltip" data-bs-placement="top"    data-bs-title="{{translate("Delete")}}" href="javascript:void(0);" class="pointer delete-item icon-btn danger">
                                                    <i class="las la-trash-alt"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="border-bottom-0" colspan="6">
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
    @include('admin.partials.modal.template_report')
@endsection

@push('script-include')
    <script src="{{asset('assets/global/js/datepicker/moment.min.js')}}"></script>
    <script src="{{asset('assets/global/js/datepicker/daterangepicker.min.js')}}"></script>
    <script src="{{asset('assets/global/js/datepicker/init.js')}}"></script>
    <script src="{{asset('assets/global/js/apexcharts.js')}}"></script>
@endpush

@push('script-push')
<script>
	(function($){

        "use strict";

        $(".select2").select2({});
        $(".user").select2({});

        $(document).on('click','.show-info',function(e){

            var modal = $('#report-info');

            var report = JSON.parse($(this).attr('data-report'))

            modal.find('textarea[name="content"]').html(report.content)

            var lists = "";

            for(var i in report.open_ai_usage ){
                lists +=`<li class="list-group-item">${i.charAt(0).toUpperCase() + i.slice(1).replace('_', ' ')} : ${report.open_ai_usage[i]}</li>`
            }
            $("#additionalInfo").html(lists);

            modal.modal('show')
        });


        var  colors = ['var(--color-danger)','var(--color-danger-light)','var(--color-success)','var(--color-success-light)','var(--color-info)','var(--color-success)',  'var(--color-warning)' ,"var(--color-danger)"];

        
        var labels = @json(array_keys($graph_data));
        var data   = @json(array_values($graph_data));

        var options = {
            series: [{
                name: "{{ translate('Total word') }}",
                data: data
            }],
            chart: {
                height: 365,
                type: 'bar',
                events: {
                    click: function(chart, w, e) {
                    }
                }
            },
            colors: colors,
            plotOptions: {
                bar: {
                    columnWidth: '45%',
                    distributed: true,
                }
            },
            dataLabels: {
                enabled: false
            },
  
            legend: {
                show: false
            },
            xaxis: {
                categories: labels,
                labels: {
                    style: {
                        colors: colors,
                        fontSize: '12px'
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#template-report"), options);
        chart.render();



	})(jQuery);
</script>
@endpush





