@extends('admin.layouts.master')
@section('content')
     <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">
                {{translate('Latest Feed of ')}}
                {{@$account->account_information->name}}
            </h4>
        </div>

        <div class="card-body">
            <div class="row g-2">
                @foreach (Arr::get($response['response'] ,'data', []) as  $data)
      
                        <div class="col-lg-3">
                            <div class="i-card-sm post-card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="post-meta d-flex justify-content-start align-items-center gap-2 mb-3">
                    
                                        <div class="designation">
                                                <div class="user-meta-info d-flex align-items-center gap-2">
                                                        <img class="rounded-circle avatar-sm"  src='{{@$account->account_information->avatar }}' alt="{{@$account->account_information->avatar}}">

                                                        @if(@$account->account_information->link)
                                                            <a target="_blank" href="{{@$account->account_information->link}}">
                                                                <p>	{{ @$account->account_information->name}}</p>
                                                            </a>
                                                        @else
                                                            <p>	{{ @$account->account_information->name}}</p>
                                                        @endif
                                                </div>
                                                        
                                                <span>
                                                    @php
                                                        $timestamp = Arr::get($data,'created_time',\Carbon\Carbon::now());
                                                        $postDate = \Carbon\Carbon::parse($timestamp);
                                                    @endphp
                                                    {{diff_for_humans($postDate)}}
                                                </span>
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
                                            <p>
                                                {{$data['message']}}
                                            </p>
                                        @endif
                                        <div>
                                            <img src="{{Arr::get($data,'full_picture',get_default_img())}}" alt="feed.jpg">
                                        </div>
                                  
                                </div>

                                <div class="post-link d-flex gap-2">

                                    @if(isset($data['permalink_url']))
                                        <a class="icon-btn info" target="_blank" href="{{$data['permalink_url']}}">
                                            {{k2t('permalink_url')}}
                                        </a>
                                    @endif

                                    @if(isset($data['link']))
                                       <a target="_blank" class="icon-btn success" href="{{$data['link']}}">
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

       {{-- @php
          $datas =  [[
                            "name" => "page_post_engagements",
                            "period" => "day",
                            "values" => [
                                [
                                    "value" => 0,
                                    "end_time" => "2023-12-24T08:00:00+0000"
                                ],
                                [
                                    "value" => 0,
                                    "end_time" => "2023-12-25T08:00:00+0000"
                                ]
                            ],
                            "title" => "Daily Post Engagements",
                            "description" => "Daily: The number of times people have engaged with your posts through like, comments and shares and more.",
                            "id" => "108324407609611/insights/page_post_engagements/day"
                        ],
                        [
                            "name" => "page_post_engagements",
                            "period" => "week",
                            "values" => [
                                [
                                    "value" => 0,
                                    "end_time" => "2023-12-24T08:00:00+0000"
                                ],
                                [
                                    "value" => 0,
                                    "end_time" => "2023-12-25T08:00:00+0000"
                                ]
                            ],
                            "title" => "Weekly Post Engagements",
                            "description" => "Weekly: The number of times people have engaged with your posts through like, comments and shares and more.",
                            "id" => "108324407609611/insights/page_post_engagements/week"
                        ]];
       @endphp --}}
     @if( $account->account_type == App\Enums\AccountType::Page->value)
        <div class="i-card-md">
            <div class="card--header">
                <h4 class="card-title">
                    {{translate('Page Insight Of')}}
                    {{@$account->account_information->name}}
                </h4>
            </div>

            <div class="card-body">
                <div class="row g-2">
                    @forelse (Arr::get($response['response'] ,'page_insights', []) as  $data) 
                            <div class="col-lg-3">
                                <div class="i-card-sm post-card">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="post-meta d-flex justify-content-start align-items-center gap-2 mb-3">
                        
                                            <div class="insight-title">
                                                   {{Arr::get($data ,'title', '')}}
                                            </div>
                                            <div class="insight-details">

                                                <p>
                                                    {{Arr::get($data ,'description', '')}} 
                                                </p>

                                            </div>

                                        </div>
                                        <span class="status i-badge info">
                                            {{k2t(Arr::get($data ,'period', ''))}}   
                                        </span>
                                    </div>
                                    <div class="post-details">
                                        @foreach (Arr::get($data,'values',[]) as $engagement)

                                            <p>
                                                {{translate('Total Engagements')}} :: {{Arr::get( $engagement,'value',0)}}
                                            </p>
                                            <span>
                                                @php
                                                    $timestamp = Arr::get($engagement,'end_time',\Carbon\Carbon::now());
                                                    $postDate = \Carbon\Carbon::parse($timestamp);
                                                @endphp
                                                {{translate('Date')}} : {{get_date_time($postDate)}}
                                            </span>

                                        @endforeach
                                       
                                    </div>


                                </div>
                            </div>
                    @empty
                       @include('admin.partials.not_found')
                    @endforelse
                </div>
        
            </div>

        </div>
     @endif
@endsection



