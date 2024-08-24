@extends('admin.layouts.master')
@push('style-include')
    <link href="{{asset('assets/global/css/datepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
@php
     $currency       = session()->get('currency');
@endphp

<div class="container-fluid ps-lg-0">
    {{-- Cards --}}
  <div class="row mb-3 g-3">
    <div class="col">
        <div class="page-title-box">
          <h4 class="page-title">
            {{translate($title)}}
          </h4>
          <div class="page-title-right d-flex justify-content-end align-items-center flex-wrap gap-2">
              <ol class="breadcrumb m-0">
                <li class="breadcrumb-item">
                    @php
                        $last_cron_run = App\Models\Core\Setting::where('key','last_cron_run')->first();
                    @endphp
                    <div class="cron">
                      {{translate("Last Cron Run")}} : {{$last_cron_run && $last_cron_run->value ?  diff_for_humans($last_cron_run->value) : translate("N/A")  }}
                    </div>
                </li>
              </ol>
            <form action="{{route('admin.home')}}" method="get">
              <div class="date-search">
                  <input type="text" id="datePicker" name="date" value="{{request()->input('date')}}"  placeholder="{{translate('Filter by date')}}">
                  <button type="submit" class="me-2"><i class="bi bi-search"></i></button>
                  <a href="{{route(Route::currentRouteName())}}"  class="i-btn btn--sm danger-transparent">
                    <i class="las la-sync"></i>
                  </a>
              </div>
            </form>
            <button type="button" class="right-menu-btn layout-rightsidebar-btn waves ripple-light">
              <i class="las la-wave-square"></i>
            </button>
          </div>
        </div>
      <div class="row g-3 mb-3">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="i-card-sm style-2 primary">
              <div class="card-info">
                <h3>
                    {{Arr::get($data,"total_employees",0)}}
                </h3>
                <h5 class="title">
                  {{translate("Total Employee")}}
                </h5>
                <a href="{{route('admin.user.list')}}" class="i-btn btn--sm btn--primary-outline">
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
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
          <div class="i-card-sm style-2 success">
            <div class="card-info">
              <h3>
                {{Arr::get($data,"active_employees",0)}}
              </h3>
              <h5 class="title">
                {{translate("Active Employees")}}
              </h5>
              <a href="{{route('admin.user.list')}}" class="i-btn btn--sm btn--primary-outline">
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
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="i-card-sm style-2 info">
                <div class="card-info">
                  <h3>
                    {{(Arr::get($data,"inactive_employees",0))}}
                  </h3>
                  <h5 class="title">
                      {{translate('Inactive Employees')}}
                  </h5>
                  <a href="{{route('admin.user.list')}}" class="i-btn btn--sm btn--primary-outline">
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
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
          <div class="i-card-sm style-2 danger">
            <div class="card-info">
              <h3>{{num_format(Arr::get($data,"total_payroll_processed",0) , $currency)}} </h3>
              <h5 class="title">{{translate('Total Payroll Processed')}}</h5>
              <a href="{{route('admin.category.list')}}" class="i-btn btn--sm btn--primary-outline">{{translate("View All")}}</a>
            </div>
            <div class="d-flex flex-column align-items-end gap-4">

              <div class="icon">
                <i class="las la-exchange-alt"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
          <div class="i-card-sm style-2 success">
            <div class="card-info">
            <h3>
                {{Arr::get($data,"pending_payroll",0)}}
              </h3>
              <h5 class="title">
                {{translate("Pending payroll")}}
              </h5>
              <a href="{{route('admin.payroll.list')}}" class="i-btn btn--sm btn--primary-outline">{{translate("View All")}}</a>
            </div>
            <div class="d-flex flex-column align-items-end gap-4">
              <div class="icon">
                <i class="las la-user-friends"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="i-card-sm style-2 warning">
                <div class="card-info">
                  <h3>
                    {{num_format(Arr::get($data,"net_expense",0) , $currency)}}
                  </h3>
                  <h5 class="title">
                    {{translate("Net expense")}}
                  </h5>
                  <a href="{{route('admin.expense.list')}}" class="i-btn btn--sm btn--primary-outline">{{translate("View All")}}</a>
                </div>
                <div class="d-flex flex-column align-items-end gap-4">

                  <div class="icon">
                      <i class="las la-share-alt"></i>
                  </div>
                </div>
            </div>
        </div>

      </div>

    </div>

    <div class="col-auto layout-rightside-col d-block">
      <div class="overlay"></div>
      <div class="layout-rightside">
          <div class="sidebar-widget">
              <h6 class="widget-title">
                 {{
                     translate("Latest credit activity")
                 }}
              </h6>

              @php
                 $creditLogs = Arr::get($data,'credit_logs', collect([]));
              @endphp

              <div class="widget-body" >

                  @if($creditLogs->count() > 0)
                    <ul class="activity-list">

                       @foreach ($creditLogs as $log)

                           @if($log->user)
                             @php $user = $log->user; @endphp
                              <li class="mb-0">
                                  <div class="acitivity-item align-items-start d-flex">
                                      <div class="flex-shrink-0">
                                          <div class="avatar-sm acitivity-avatar">
                                              <div class="avatar-title rounded-circle bg-secondary">

                                                  <img class="rounded-circle avatar-sm"  src='{{imageURL($user->file,"profile,user",true) }}' alt="{{@$user->file->name?? 'profile.jpg'}}">


                                              </div>
                                          </div>
                                      </div>
                                      <div class="flex-grow-1 ms-2">


                                          <h6 class="fs-14 fw-500">

                                              <a href="{{route('admin.user.show', $user->uid)}}" class="link-secondary">
                                                    {{$log->user->name}}
                                              </a>
                                          </h6>
                                          <p class="mb-0 fs-14">
                                              {{$log->details}}
                                          </p>
                                          <small class="mb-0 text-muted fs-12">
                                              {{diff_for_humans($log->created_at)}}
                                          </small>
                                      </div>
                                  </div>
                              </li>
                            @endif

                       @endforeach

                    </ul>
                  @else
                    <div>
                          @include('admin.partials.not_found')
                    </div>
                  @endif
              </div>
          </div>

          <div class="sidebar-widget">
              <h6 class="widget-title">
                  {{translate('Top user with subscription')}}
              </h6>
              <div class="widget-body" >

                 @php
                   $customers = Arr::get($data,'top_customers', collect([]));
                 @endphp

                  @if($customers->count() > 0)
                    <ul class="top-user-list">
                        @foreach ($customers as $customer)
                          <li>
                              <div class="d-flex align-items-center gap-2 flex-grow-1">
                                <div class="avatar-sm acitivity-avatar">
                                    <div class="avatar-title rounded-5 bg-secondary">
                                      <img class="rounded-circle avatar-sm"  src='{{imageURL($customer->file,"profile,user",true) }}' alt="{{@$customer->file->name?? 'profile.jpg'}}">
                                    </div>
                                </div>
                                <h6 class="fs-15 fw-500">

                                    <a href="{{route('admin.user.show', $customer->uid)}}" class="link-secondary">
                                      {{$customer->name}}
                                  </a>

                                </h6>
                              </div>
                              <div class="flex-shrink-0">
                                  <h6 class="fs-14 fw-500 mb-0">
                                      {{$customer->subscriptions_count}}
                                  </h6>
                              </div>
                          </li>
                        @endforeach
                    </ul>
                  @else
                    <div>
                          @include('admin.partials.not_found')
                    </div>
                  @endif
              </div>
          </div>

          <div class="sidebar-widget">
            <h6 class="widget-title">
                 {{translate('Latest reviews')}}
            </h6>

              @php
                 $testimonials          = get_content("element_testimonial");
                 $featureImageSize      = get_appearance_img_size('testimonial','element','image');
              @endphp

              @if($testimonials->count() > 0)
                <div class="swiper testi-slider">
                    <div class="swiper-wrapper">
                        @foreach ($testimonials->take(5) as $testimonial )

                          <div class="swiper-slide">
                            <div class="testi-single">
                                <div class="flex-shrink-0">
                                  @php $file = $testimonial->file?->first(); @endphp
                                  <img  class="avatar-sm rounded material-shadow" src="{{imageURL($file,'frontend',true,$featureImageSize)}}" alt="{{@$file->name?? 'author.jpg'}}">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div>
                                        <p class="text-muted mb-1 fst-italic text-truncate-two-lines">"{{$testimonial->value->quote}}"</p>

                                    </div>
                                    <div class="text-end mb-0 text-muted">
                                        - {{ translate('by')}} <cite title="Source Title">
                                          {{$testimonial->value->author}}
                                        </cite>
                                    </div>
                                </div>
                            </div>
                          </div>

                        @endforeach
                    </div>
                </div>
              @else
                  <div>
                      @include('admin.partials.not_found')
                  </div>
              @endif
        </div>

          <div class="sidebar-widget">
              <h6 class="widget-title">
                 {{translate('Reviews')}}
              </h6>
              <div class="widget-body" >

                    @php


                       $formatedRatings =   $testimonials->map(fn(App\Models\Admin\Frontend $testimonial) : object =>
                                               (object)['rating'=>$testimonial->value->rating]);

                       $avgRatings      =   $formatedRatings->avg('rating');





                    @endphp
                  <h6 class="text-muted mb-3 text-uppercase fw-semibold"></h6>
                  <div class="bg--primary-light px-3 py-2 rounded-2 mb-2">
                      <div class="d-flex align-items-center">
                          <div class="flex-grow-1">
                              <div class="fs-16 align-middle text-warning">

                                   @for($i = 0 ; $i<5 ; $i++)
                                       @if( $i < round($avgRatings))
                                           <i class="bi bi-star-fill fs-14"></i>
                                       @else
                                           <i class="bi bi-star"></i>
                                       @endif
                                   @endfor

                              </div>
                          </div>
                          <div class="flex-shrink-0">
                              <h6 class="mb-0 fs-15 text--primary">{{round($avgRatings) }} {{translate('out of 5')}} </h6>
                          </div>
                      </div>
                  </div>
                  <div class="text-center">
                      <div class="text-muted"> {{translate('Total')}}  <span class="fw-medium text-dark"> {{ $testimonials->count()}} </span>
                           {{translate('reviews')}}
                      </div>
                  </div>


                    @for( $i = 5 ; $i>0 ; $i-- )

                        <div class="row align-items-center g-2">
                            <div class="col-auto">
                                <div class="p-2">
                                    <h6 class="mb-0 fs-14">{{$i}} {{translate('star')}}</h6>
                                </div>
                            </div>

                            <div class="col">
                                <div class="p-2">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar ratting-progres-{{$i}}" role="progressbar" aria-valuenow="50.16" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="p-2">
                                    <span class="mb-0 text-muted fs-14">
                                       {{$formatedRatings->where('rating',$i)->count()}}
                                    </span>
                                </div>
                            </div>
                        </div>

                    @endfor


              </div>
          </div>
      </div>
    </div>
  </div>
    {{-- Charts --}}
  <div class="row g-3 mb-3">
    <div class="col-lg-12">
      <div class="i-card-md home home">
        <div class="card--header">
          <h4 class="card-title">
              {{translate("Yearly Expense")}}
          </h4>

        </div>
        <div class="card-body">
            <div class="row g-2 text-center mb-5">
              <div class="col-sm-6">
                  <div class="p-3 border border-dashed border-start-0 rounded-2">
                      <h5 class="mb-1">
                          <span>
                            {{num_format(Arr::get($data,"yearly_total_salary",0) , $currency)}}
                          </span>
                      </h5>
                      <p class="text-muted mb-0">
                          {{translate("Total Payroll")}}
                      </p>
                  </div>
              </div>

              <div class="col-sm-6">
                  <div class="p-3 border border-dashed border-start-0 rounded-2">
                      <h5 class="mb-1"><span>
                        {{num_format(Arr::get($data,"yearly_total_officeExpenses",0) , $currency)}}
                      </span></h5>
                      <p class="text-muted mb-0">
                          {{translate("Total office Expense")}}
                      </p>
                  </div>
              </div>
            </div>
          <div id="netExpenseChart" class="apex-chart"></div>
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
        $symbol = @session()->get('currency')?->symbol ?? base_currency()->symbol;
  @endphp
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



    /** net expense chart */
    var options = {
            chart: {
                height: 300,
                type: 'line',
            },
            dataLabels: {
                enabled: false,
            },
            series: @json($data['net_expense_chart_data']),
            xaxis: {
                categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            },
            colors: ['var(--color-info)', 'var(--color-primary)', 'var(--color-success)', 'var(--color-danger)'],
            markers: {
                size: 6,
            },
            stroke: {
                width: 2,
            },
            tooltip: {
                shared: false,
                intersect: true,
            },
            legend: {
                horizontalAlign: 'left',
                offsetX: 40,
            },
        };

        var chart = new ApexCharts(document.querySelector("#netExpenseChart"), options);
        chart.render();

   

    function formatCurrency(value) {
        var symbol =  "{{  $symbol }}" ;
        var suffixes = ["", "K", "M", "B", "T"];
        var order = Math.floor(Math.log10(value) / 3);
        var suffix = suffixes[order];
        if(value < 1)
        {return symbol+value}
        var scaledValue = value / Math.pow(10, order * 3);
        return symbol + scaledValue.toFixed(2) + suffix;
    }




    var swiper = new Swiper(".testi-slider", {
      direction: 'vertical',
      slidesPerView: 2,
      spaceBetween: 10,
      grabCursor: true,
      loop: true,
      mousewheel: {
        eventsTarged: ".swiper-slide",
        sensitivity: 5
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });

</script>
@endpush




