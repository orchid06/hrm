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
            <div class="row g-lg-4 g-3">
                @foreach (Arr::get($response['response'] ,'data', []) as  $data)
              
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="social-preview-body">

                            <div class="d-flex justify-content-between align-items-center">

        
                                <div class="social-auth">
            
                                        <div class="profile-img">
                                            <img onerror="this.onerror=null;this.src='{{ route('default.image', '200x200') }}';" src='{{@$account->account_information->avatar??get_default_img()}}' alt="{{translate('profile.jpg')}}">
                                        </div>
    
                                        <div class="profile-meta">
    
                                            @if(@$account->account_information->link)
                                                <h6>
                                                    <a target="_blank" href="{{@$account->account_information->link}}">
                                                            {{ @$account->account_information->name}}
                                                    </a>
                                                </h6>
                                            @else
                                                <h6>	{{ @$account->account_information->name}}</h6>
                                            @endif
    
                                    
                                            <div class="d-flex align-items-center gap-2">
                                                @php
                                                        $timestamp = Arr::get($data,'created_time',\Carbon\Carbon::now());
                                                        $postDate = \Carbon\Carbon::parse($timestamp);
                                                @endphp
                                
                                                <p>
                                                    {{diff_for_humans($postDate)}}
                                                </p>

                                                @php

                                                        $privicyIcons = [
                                                        'EVERYONE'    => 'bi bi-globe-americas',
                                                        'ALL_FRIENDS' => 'i bi-people',
                                                        'CUSTOM'      => 'bi bi-gear',
                                                        'SELF'        => 'bi bi-shield-lock',
                                                        ];
                                                        $privacy      = Arr::get($data,'privacy',[]);
                                                        $privacyText      = Arr::get($privacy,'value','EVERYONE');

                                                        

                                                @endphp
                                                
                                                @if(@$account->account_information->link)
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{k2t($privacyText)}}" href="{{@$account->account_information->link}}">
                                                        <i class="{{ Arr::get($privicyIcons, $privacyText,'bi bi-globe-americas') }} fs-12"></i>
                                                    </a>  
                                                @else
                                                    <i  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{k2t($privacyText)}}" class="{{ Arr::get($privicyIcons, $privacyText,'bi bi-globe-americas') }} fs-12"></i>
                                                @endif
                                    

                                            </div>
                                        </div>

                                </div>

                                <span class="status i-badge info">
                                    @php
                                        $postTypeKey = $account->account_type == App\Enums\AccountType::PAGE->value ? 'status_type' :'type';
                                    @endphp
                                    {{k2t(Arr::get($data,$postTypeKey,'status'))}}
                                </span>
                            </div>


                            <div class="social-caption">
                                
                                @if(isset($data['message']))
                                    <div class="caption-text">
                                        {{$data['message']}}
                                    </div>
                                @endif
                            
                                <div class="caption-imgs">
                                    <img src="{{Arr::get($data,'full_picture',get_default_img())}}" alt="feed.jpg">
                                </div>

                                <div class="action-count d-flex justify-content-between align-items-center">
                                    <div class="emoji d-flex align-items-center gap-1">
                                        <ul class="d-flex gap-0 react-icon-list">
                                            <li><img src="{{asset('assets/images/default/like.png')}}" alt="like.png"></li>
                                            <li><img src="{{asset('assets/images/default/love.png')}}" alt="love.png"></li>
                                            <li><img src="{{asset('assets/images/default/care.png')}}" alt="care.png"></li>
                                        </ul>
                                        <span class="fs-13">
                                            @php
                                                $reactions = Arr::get($data,'reactions',[]);
                                                $summary = Arr::get($reactions,'summary',[]);
                                                
                                            @endphp

                                            {{ Arr::get($summary,'total_count',0) }}

                                        </span>
                                    </div>
                                    <div class="comment-count py-2 px-0">
                                        <ul class="d-flex align-items-center gap-3">
                                            @php
                                                $comments = Arr::get($data,'comments',[]);
                                                $commentsSummary = Arr::get($comments,'summary',[]);
                                                $shares = Arr::get($data,'shares',[]);
                                            @endphp
                                            <li>
                                                    {{ Arr::get($commentsSummary,'total_count',0) }} {{translate('Comments')}}
                                            </li>
                                            <li>{{ Arr::get($shares,'count',0) }} {{translate('Shares')}} </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="post-link d-flex gap-3 mt-2">
                                    @if(isset($data['permalink_url']))
                                        <a class="permalink" target="_blank" href="{{$data['permalink_url']}}">
                                            {{translate('Peramlink URL')}}
                                        </a>
                                    @endif
                                    @if(isset($data['link']))
                                        ,<a target="_blank" class="permalink" href="{{$data['link']}}">
                                            {{k2t('link')}}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                       
                @endforeach
                
            </div>
        </div>
     </div>


     @if( $account->account_type == App\Enums\AccountType::PAGE->value)

        <div class="i-card-md mt-4">
            <div class="card-header">
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
                            $graphLabel  =  $dailyInsightValues->pluck("end_time")->toArray();
                            $graphValue  =  $dailyInsightValues->pluck("value")->toArray();
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
   <script src="{{asset('assets/global/js/datepicker/moment.min.js')}}"></script>
  <script src="{{asset('assets/global/js/datepicker/daterangepicker.min.js')}}"></script>
    <script src="{{asset('assets/global/js/datepicker/init.js')}}"></script>
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
