@extends('layouts.master')
@section('content')
     <div class="i-card-md">
        <div class="card-header">
            <h4 class="card-title">
                {{translate('Latest Feed of ')}}
                {{@$account->account_information->name}}
            </h4>
        </div>

        @php
                         
            $graphValue = [];
            $graphLabel = [];
        @endphp

        <div class="card-body">
            <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1 g-3 post-card-container">
                @foreach (Arr::get($response['response'] ,'data', []) as  $data)
      
                        <div class="col post-card-wrap">
                            <div class="i-card-sm post-card">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                    <div class="post-meta d-flex justify-content-start align-items-center gap-2">
                                        <div class="user-meta-info d-flex align-items-center gap-2">
                                            <div class="image">
                                      
                                                <img src='{{@$account->account_information->avatar??get_default_img()}}' alt="{{@$account->account_information->avatar}}">
                                            </div>
                                            <div class="content">
                                                @if(@$account->account_information->link)
                                                        <a target="_blank" href="{{@$account->account_information->link}}">
                                                            <p>	{{ @$account->account_information->name}}</p>
                                                        </a>
                                                    @else
                                                        <p>	{{ @$account->account_information->name}}</p>
                                                    @endif

                                                    <span>
                                                        @php
                                                            $timestamp = Arr::get($data,'created_time',\Carbon\Carbon::now());
                                                            $postDate = \Carbon\Carbon::parse($timestamp);
                                                        @endphp
                                                        {{diff_for_humans($postDate)}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <span class="status i-badge info">
                                        @php
                                           $postTypeKey = $account->account_type == App\Enums\AccountType::Page->value ? 'status_type' :'type';
                                        @endphp
                                       {{k2t(Arr::get($data,$postTypeKey,'status'))}}
                                    </span>
                                </div>
                                <div class="post-details">
                                    @if(isset($data['message']))
                                        <p class="mb-2">
                                            {{$data['message']}}
                                        </p>
                                    @endif
                                    <div class="post-image">
               
                                        <img src="{{Arr::get($data,'full_picture',get_default_img())}}" alt="feed.jpg">
                                    </div>
                                </div>

                                <div class="post-link d-flex gap-2">
                                    @if(isset($data['permalink_url']))
                                        <a class="permalink" target="_blank" href="{{$data['permalink_url']}}">
                                            {{k2t('permalink_url')}} 
                                        </a>
                                    @endif
                                    @if(isset($data['link']))
                                       <a target="_blank" class="permalink" href="{{$data['link']}}">
                                          {{k2t('link')}}
                                       </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
        </div>

     </div>


     @if( $account->account_type == App\Enums\AccountType::Page->value)

        <div class="i-card-md">
            <div class="card--header">
                <h4 class="card-title">
                    {{translate('Page Insight Of')}}
                    {{@$account->account_information->name}} <small>({{translate("Last 30 days")}})</small>
                </h4>
            </div>

            @php
               $insightData         = Arr::get($response ,'page_insights', []);
               $dailyInsight        = (Arr::get($insightData ,0, []));
               $dailyInsightValues  = collect(Arr::get($dailyInsight,'values',[]));



            @endphp
            <div class="card-body">
                <div class="row g-2">
   

                        @php
                            $graphLabel =  $dailyInsightValues->pluck("end_time")->toArray();
                            $graphValue =  $dailyInsightValues->pluck("value")->toArray();
                        @endphp
                        <div class="col-12">
                            <div id="engagementReport" class="apex-chart"></div>
                        </div>
            
                </div>
        
            </div>

        </div>
     @endif
@endsection



@push('script-include')
  <script  src="{{asset('assets/global/js/apexcharts.js')}}"></script>
  <script src="{{asset('assets/global/js/flatpickr.js')}}"></script>
@endpush

@push('script-push')
<script>
  "use strict";

    var accountValues =  @json( $graphValue );
    var accountLabel =  @json($graphLabel);
    var options = {
        chart: {
            height: 350,
            type: "line",
        },
        dataLabels: {
            enabled: false,
        },
        colors: ["{{site_settings('primary_color')}}"], 
        series: [
            {
            name: "{{ translate('Total Engagement ') }}",
            data: accountValues,
            },
        
        ],
        xaxis: {
            categories: accountLabel,
        },
    
        tooltip: {
            shared: false,
            intersect: true,
            
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

    var chart = new ApexCharts(document.querySelector("#engagementReport"), options);
    chart.render();

</script>
@endpush