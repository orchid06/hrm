@extends('layouts.master')
@push('style-include')
    <link href="{{asset('assets/global/css/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')

   @php
       $user = auth_user('web');
       $subscription           = $user->runningSubscription;
       $remainingToken         = $subscription ? $subscription->remaining_word_balance : 0;
       $remainingProfile       = $subscription ? $subscription->total_profile : 0;
       $remainingPost          = $subscription ? $subscription->remaining_post_balance : 0;
       $totalPlatforms         = (array) ($subscription ? @$subscription->package->social_access->platform_access : []);


       $subscriptionDetails =  [
                                  'Remaining Word'    => $remainingToken,
                                  'Remaining Profile' => $remainingProfile,
                                  'Remaining Post'    => $remainingPost,
                                  'Total Platforms'   => count($totalPlatforms),
                                ];
       if( $remainingToken  ==  App\Enums\PlanDuration::value('UNLIMITED')){
          unset($subscriptionDetails['Remaining Word']);
       }
       if( $remainingPost  ==  App\Enums\PlanDuration::value('UNLIMITED')){
          unset($subscriptionDetails['Remaining Post']);
       }
   @endphp

    <div class="row g-4">
      <div class="col-12">
        <div class="dash-intro">
          <div class="row align-items-center gx-4 gy-5">
            <div class="col-xxl-3 col-xl-6">
              <div class="dash-intro-content">
                <h3>{{translate("Welcome")}}, {{$user->name }}</h3>
              </div>
            </div>

            <div class="col-xxl-9">
              <div class="posting-summary">
                <div class="row g-3">
                  <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                    <div class="summary-card">
                      <span class="text--info">
                        <i class="bi bi-border-all"></i>
                      </span>

                      <div>
                        <h6>
                           {{Arr::get($data,'total_post',0)}}
                        </h6>
                        <p>
                           {{translate("Total Post")}}
                        </p>
                      </div>
                    </div>
                  </div>

                  <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                    <div class="summary-card">
                      <span class="text--success">
                        <i class="bi bi-calendar-check"></i>
                      </span>

                      <div>
                        <h6>  {{Arr::get($data,'pending_post',0)}}</h6>
                        <p>   {{translate("Pending Post")}}</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                    <div class="summary-card">
                      <span class="text--warning">
                        <i class="bi bi-clock-history"></i>
                      </span>

                      <div>
                        <h6>  {{Arr::get($data,'schedule_post',0)}}</h6>
                        <p>   {{translate("Schedule Post")}}</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                    <div class="summary-card">
                      <span class="text--success">
                         <i class="bi bi-check-all"></i>
                      </span>

                      <div>
                        <h6>  {{Arr::get($data,'success_post',0)}}</h6>
                        <p>   {{translate("Success Post")}}</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                    <div class="summary-card">
                      <span class="text--danger">
                        <i class="bi bi-journal-x"></i>
                      </span>

                      <div>
                        <h6>  {{Arr::get($data,'failed_post',0)}}</h6>

                        <p>   {{translate("Failed Post")}}</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                    <div class="summary-card">
                      <span class="text--info">
                        <i class="bi bi-person-gear"></i>
                      </span>

                      <div>
                        <h6>  {{Arr::get($data['account_report'],'total_account',0)}}</h6>

                        <p>   {{translate("Total Account")}}</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                    <div class="summary-card">
                      <span class="text--success">
                        <i class="bi bi-person-check-fill"></i>
                      </span>

                      <div>
                        <h6>  {{Arr::get($data['account_report'],'active_account',0)}}</h6>

                        <p>   {{translate("Active Account")}}</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                    <div class="summary-card">
                      <span class="text--danger">
                        <i class="bi bi-person-exclamation"></i>
                      </span>

                      <div>
                        <h6>  {{Arr::get($data['account_report'],'inactive_account',0)}}</h6>

                        <p>   {{translate("Inactive Account")}}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xxl-3 col-md-6">
        <div class="i-card-md card-height-100 plan-upgrade-card">
          <div class="card-body plan-upgrade-body">

              <div class="existing-plan">
                <div class="dot-spinner">
                  <div class="dot-spinner__dot"></div>
                  <div class="dot-spinner__dot"></div>
                  <div class="dot-spinner__dot"></div>
                  <div class="dot-spinner__dot"></div>
                  <div class="dot-spinner__dot"></div>
                  <div class="dot-spinner__dot"></div>
                  <div class="dot-spinner__dot"></div>
                  <div class="dot-spinner__dot"></div>
                </div>
                @if($user->runningSubscription)
                  {{$user->runningSubscription->package->title}}
                 @else
                    {{translate('No subscription')}}
                @endif
              </div>

            <h3>
               {{trans('default.dashboard_plan_title')}}
            </h3>

            <a
              href="{{route('user.plan')}}"
              class="i-btn btn--primary btn--lg capsuled">
              @if($user->runningSubscription)
                {{translate('Upgrade Now')}}
              @else
                {{translate('Subscribe Now')}}
              @endif
            </a>

            <div class="plan-upgrade-img">
              <img
              src="{{asset('assets/images/default/plan.gif')}}"
              alt="plan.gif"
              class="img-fluid"/>
            </div>
          </div>

        </div>
      </div>

      <div class="col-xxl-3 col-md-6">
        <div class="i-card-md card-height-100">
          <div class="card-header">
            <h4 class="card-title">
               {{translate("Connected Account")}}
            </h4>
            <div>
              <a href="{{route('user.social.account.list')}}" class="i-btn info btn--sm capsuled">
                   {{translate('See all')}}
              </a>
            </div>
          </div>

          <div class="card-body">
            <ul class="channel-list">
               @forelse(Arr::get($data['account_report'] ,'accounts_by_platform',[]) as $platform)

                  <li>
                    <div class="channel-item">
                      <div class="channel-meta">
                        <span class="channel-img">
                          <img src="{{imageUrl(@$platform->file,'platform',true)}}" alt="{{imageUrl(@$platform->file,'platform',true)}}"/>
                        </span>

                        <div class="channel-info">
                          <h5>
                              {{$platform->name}}
                          </h5>
                        </div>
                      </div>

                      <div class="channel-action">
                        <span class="i-badge-solid success">
                          {{$platform->accounts_count}} {{translate("Profiles")}}
                        </span>
                      </div>
                    </div>
                  </li>
                @empty
                    @include('admin.partials.not_found')
                @endempty
            </ul>
          </div>
        </div>
      </div>

      <div class="col-xxl-6">
        <div class="i-card-md card-height-100">
          <div class="card-header">
            <h4 class="card-title">
               {{translate("Social Post")}}
            </h4>
          </div>
          <div class="card-body">
            <div id="postReport"></div>
          </div>
        </div>
      </div>

      <div class="col-xxl-4">
        <div class="i-card-md card-height-100">
          <div class="card-header">
            <h4 class="card-title">
               {{translate("Subscription Specification")}}
            </h4>

          </div>

          <div class="card-body">
            <div class="posts-wrap">

                <div class="row">
                    <div class="col-lg-12">
                       <div id="subscriptionChart">

                       </div>
                    </div>
                </div>

            </div>
          </div>
        </div>
      </div>

      <div class="col-xxl-8">
        <div class="i-card-md card-height-100">
          <div class="card-header">
            <h4 class="card-title">
               {{translate("Latest Transaction Log")}}
            </h4>
          </div>

          <div class="card-body px-0">
            <div class="table-accordion">
              @php
                $reports = Arr::get($data,'latest_transactiions',null);

              @endphp
              @if($reports &&    $reports->count() > 0)
                  <div class="accordion" id="wordReports">
                      @forelse(Arr::get($data,'latest_transactiions',[])  as $report)
                          <div class="accordion-item">
                              <div class="accordion-header">
                                  <div class="accordion-button collapsed" role="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$report->id}}"
                                      aria-expanded="false" aria-controls="collapse{{$report->id}}">
                                      <div class="row align-items-center w-100 gy-4 gx-sm-3 gx-0">
                                          <div class="col-lg-3 col-sm-4 col-12">
                                              <div class="table-accordion-header transfer-by">
                                                  <span class="icon-btn icon-btn-sm info circle">
                                                      <i class="bi bi-arrow-up-left"></i>
                                                  </span>
                                                  <div>
                                                      <h6>
                                                          {{translate("Trx Code")}}
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
                                                      {{translate("Balance")}}
                                                  </h6>

                                                  <p class='text--{{$report->trx_type == App\Models\Transaction::$PLUS ? "success" :"danger" }}'>
                                                      <i class='bi bi-{{$report->trx_type == App\Models\Transaction::$PLUS ? "plus" :"dash" }}'></i>

                                                      {{num_format($report->amount,$report->currency)}}

                                                  </p>

                                              </div>
                                          </div>

                                          <div class="col-lg-2 col-sm-4 col-6 text-lg-center text-start">
                                              <div class="table-accordion-header">
                                                  <h6>
                                                      {{translate("Post Balance")}}
                                                  </h6>

                                                  <p>
                                                      {{@num_format(
                                                          number : $report->post_balance??0,
                                                          calC   : true
                                                      )}}
                                                  </p>

                                              </div>
                                          </div>

                                          <div class="col-lg-2 col-sm-4 col-6 text-lg-end text-md-center text-end">
                                              <div class="table-accordion-header">
                                                  <h6>
                                                      {{translate("Remark")}}
                                                  </h6>
                                                  <p>
                                                      {{k2t($report->remarks)}}
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
      </div>

      <div class="col-12">
        <div class="i-card-md card-height-100">
          <div class="card-header">
            <h4 class="card-title">
               {{translate("Latest Subscription Log")}}
            </h4>

          </div>

          <div class="card-body px-0">
            <div class="table-accordion">
              @php
                $reports = Arr::get($data,'subscription_log',null);

              @endphp

              @if($reports && $reports->count() > 0)
                <div class="accordion" id="wordReports-2">
                @forelse($reports as $report)
                  <div class="accordion-item">
                      <div class="accordion-header">
                          <div class="accordion-button collapsed" role="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$report->id}}"
                              aria-expanded="false" aria-controls="collapse{{$report->id}}">
                              <div class="row align-items-center w-100 gy-4 gx-sm-3 gx-0">
                                  <div class="col-lg-2 col-sm-4 col-12">
                                      <div class="table-accordion-header transfer-by">
                                          <span class="icon-btn icon-btn-sm info circle">
                                              <i class="bi bi-arrow-up-left"></i>
                                          </span>
                                          <div>
                                              <h6>
                                                  {{translate("Trx Code")}}
                                              </h6>
                                              <p> {{$report->trx_code}}</p>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="col-lg-2 col-sm-4 col-6 text-lg-center text-sm-center text-start">
                                      <div class="table-accordion-header">
                                          <h6>
                                              {{translate("Expired In")}}
                                          </h6>

                                          <p>
                                              @if($report->expired_at)
                                              {{ get_date_time($report->expired_at,'d M, Y') }}
                                              @else
                                                  {{translate("N/A")}}
                                              @endif
                                          </p>
                                      </div>
                                  </div>

                                  <div class="col-lg-2 col-sm-4 col-6 text-lg-center text-sm-end text-end">
                                      <div class="table-accordion-header">
                                          <h6>
                                              {{translate("Package")}}
                                          </h6>

                                          <p>
                                              {{@$report->package->title}}
                                          </p>
                                      </div>
                                  </div>

                                  <div class="col-lg-2 col-sm-4 col-6 text-lg-center text-start">
                                      <div class="table-accordion-header">
                                          <h6>
                                              {{translate("Status")}}
                                          </h6>
                                          @php echo subscription_status($report->status) @endphp
                                      </div>
                                  </div>

                                  <div class="col-lg-2 col-sm-4 col-6 text-sm-center text-end">
                                      <div class="table-accordion-header">
                                          <h6>
                                              {{translate("Payment Amount")}}
                                          </h6>
                                          <p>
                                              {{@num_format(
                                                  number : $report->payment_amount??0,
                                                  calC   : true
                                              )}}
                                          </p>
                                      </div>
                                  </div>

                                  <div class="col-lg-2 col-sm-4 col-6 text-sm-end text-start">
                                      <div class="table-accordion-header">
                                          <h6>
                                              {{translate("Date")}}
                                          </h6>

                                          <p>
                                 
                                              @if($report->created_at)
                                                  {{ get_date_time($report->created_at) }}
                                              @else
                                                  {{translate("N/A")}}
                                              @endif
                                          </p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div id="collapse{{$report->id}}" class="accordion-collapse collapse" data-bs-parent="#wordReports-2">
                          <div class="accordion-body">
                              <ul class="list-group list-group-flush">
                                  @php
                                      $informations = [

                                          "Ai Word Balnace"          => $report->word_balance,
                                          "Remaining Word Balance"   => $report->remaining_word_balance,
                                          "Carried Word Balnace"     => $report->carried_word_balance,
                                          "Total Social Profile"     => $report->total_profile,
                                          "Carried Profile Balnace"  => $report->carried_profile,
                                          "Social Post Balnace"      => $report->post_balance,
                                          "Remaining Post Balance"   => $report->remaining_post_balance,
                                          "Carried Post Balnace"     => $report->carried_post_balance,
                                      ];
                                  @endphp

                                  @foreach ($informations  as  $key => $val)

                                      <li class="list-group-item">
                                          <h6 class="title">
                                              {{k2t($key)}}
                                          </h6>
                                          <p class="value">
                                              {{$val == App\Enums\PlanDuration::UNLIMITED->value ? App\Enums\PlanDuration::UNLIMITED->name : $val }}
                                          </p>
                                      </li>

                                  @endforeach
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
      </div>
    </div>

@endsection


@push('script-include')
  <script  src="{{asset('assets/global/js/apexcharts.js')}}"></script>
  <script src="{{asset('assets/global/js/flatpickr.js')}}"></script>
@endpush

@push('script-push')
<script>
  "use strict";

  var subscriptionValues =  @json(array_values($subscriptionDetails));
  var subscriptionLabel  =  @json(array_keys($subscriptionDetails));

  var options = {
          series:subscriptionValues,
            chart: {
                type: "donut",
                width: "100%",
            },
        colors: [
        "var(--color-primary)",
        "var(--color-secondary)",
        "var(--color-warning)",
        "var(--color-info)",
        "var(--color-danger)"],
        labels: subscriptionLabel,
        plotOptions: {
          pie: {
            startAngle: -90,
            endAngle: 270
          }
        },
        dataLabels: {
          enabled: false
        },


        legend: {
            position: 'bottom'
        }
        };

        var chart = new ApexCharts(document.querySelector("#subscriptionChart"), options);
        chart.render();



    var monthlyLabel = @json(array_keys($data['monthly_post_graph']));

    var accountValues = [];
    var totalPost =   @json(array_values($data['monthly_post_graph']));
    var pendigPost =   @json(array_values($data['monthly_pending_post']));
    var schedulePost =   @json(array_values($data['monthly_schedule_post']));
    var successPost =   @json(array_values($data['monthly_success_post']));
    var failedPost =   @json(array_values($data['monthly_failed_post']));



    var monthlyLabel = @json(array_keys($data['monthly_post_graph']));
    var options = {
      chart: {
        height: 380,
        type: "line",
      },
      dataLabels: {
        enabled: false,
      },
        colors: [
        "var(--color-primary)",
        "var(--color-secondary)",
        "var(--color-warning)",
        "var(--color-info)",
        "var(--color-danger)"],
      series: [
        {
          name: "{{ translate('Total Post') }}",
          data: totalPost,
        },
        {
          name: "{{ translate('Pending Post') }}",
          data: pendigPost,
        },
        {
          name: "{{ translate('Success Post') }}",
          data: successPost,
        },
        {
          name: "{{ translate('Schedule Post') }}",
          data: schedulePost,
        },
        {
          name: "{{ translate('Failed Post') }}",
          data: failedPost,
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
              return parseInt(value);
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
        horizontalAlign: "center",
        offsetY: 5,
      },
    };

    var chart = new ApexCharts(document.querySelector("#postReport"), options);
    chart.render();





</script>
@endpush
