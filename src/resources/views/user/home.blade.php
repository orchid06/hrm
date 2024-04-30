@extends('layouts.master')
@push('style-include')
    <link href="{{asset('assets/global/css/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" integrity="sha512-OQDNdI5rpnZ0BRhhJc+btbbtnxaj+LdQFeh0V9/igiEPDiWE2fG+ZsXl0JEH+bjXKPJ3zcXqNyP4/F/NegVdZg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

    <!-- updated start -->

    <div id="overlay" class="overlay"></div>

    <button id="right-sidebar-btn" class="right-sidebar-btn fs-20">
        <i class="bi bi-activity"></i>
    </button>

    <div class="row g-4 mb-4">
      <div class="col">
        <div class="row g-4">
          <div class="col-xxl-4 col-xl-5">
              <div class="i-card h-550">
                <h4 class="card--title mb-4">Connected Social Accounts</h4>
                <div class="row g-3">
                @forelse(Arr::get($data['account_report'] ,'accounts_by_platform',[]) as $platform)
                  <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="i-card no-border p-0 border position-relative bg--light">
                        <div class="shape-one">
                          <svg width="65" height="65" viewBox="0 0 65 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M52.3006 64.8958L64.4805 64.9922L64.9908 0.510364L0.508992 1.7845e-05L0.412593 12.1799L35.5193 12.4578C45.016 12.533 52.6536 20.2924 52.5784 29.789L52.3006 64.8958Z" fill="white"/>
                          </svg>
                        </div>
                        <div class="shape-two">
                          <svg width="65" height="65" viewBox="0 0 65 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M52.3006 64.8958L64.4805 64.9922L64.9908 0.510364L0.508992 1.7845e-05L0.412593 12.1799L35.5193 12.4578C45.016 12.533 52.6536 20.2924 52.5784 29.789L52.3006 64.8958Z" fill="white"/>
                          </svg>
                        </div>
                        <span class="icon-image position-absolute top-0 end-0">
                          <img src="{{imageUrl(@$platform->file,'platform',true)}}" alt="{{imageUrl(@$platform->file,'platform',true)}}"/>
                        </span>
                        <div class="p-20">
                          <h5 class="card--title-sm">
                              {{$platform->name}}
                          </h5>
                        </div>
                        <div class="p-20 border-top">
                          <p class="card--title-sm mb-1">00</p>
                          <p class="mb-4 fs-15">Total Posts</p>
                          <a href="#" class="i-btn btn--md btn--outline capsuled"><i class="ri-add-line"></i>Create post</a>
                        </div>
                      </div>
                    </div>
                  @empty
                      @include('admin.partials.not_found')
                  @endempty
                </div>
              </div>
          </div>
          <div class="col-xxl-8 col-xl-7">
             <div class="i-card h-550">
                <div class="row align-items-center g-2 mb-4">
                  <div class="col-md-9">
                    <h4 class="card--title">
                        Post Activity
                    </h4>
                  </div>
                  <div class="col-md-3">
                    <select name="content-category" class="select2">
                      <option>Category One</option>
                      <option>Category Two</option>
                      <option>Category Three</option>
                    </select>
                  </div>
                </div>
              <div class="row g-3">
                <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                  <div class="i-card border p-0">
                      <div class="p-20">
                        <div class="icon text--primary mb-30">
                          <i class="ri-line-chart-line fs-30"></i>
                        </div>
                        <div class="content">
                          <p class="card--title-sm mb-1">
                              {{translate("Total Post")}}
                          </p>
                          <h6>
                              {{Arr::get($data,'total_post',0)}}
                          </h6>
                        </div>
                      </div>
                      <div class="footer border-top d-flex justify-content-between">
                        <div class="text--success">
                          <i class="bi bi-arrow-up"></i>
                          <span class="fs-14">+12%</span>
                        </div>
                        <p class="mb-0 fs-14">This week</p>
                      </div>
                  </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                  <div class="i-card border p-0">
                      <div class="p-20">
                        <div class="icon text--primary mb-30">
                          <i class="ri-calendar-2-line fs-28"></i>
                        </div>
                        <div class="content">
                          <p class="card--title-sm mb-1">{{translate("Pending Post")}}</p>
                          <h6>{{Arr::get($data,'pending_post',0)}}</h6>
                        </div>
                      </div>
                      <div class="footer border-top d-flex justify-content-between">
                        <div class="text--success">
                          <i class="bi bi-arrow-up"></i>
                          <span class="fs-14">+12%</span>
                        </div>
                        <p class="mb-0 fs-14">This week</p>
                      </div>
                  </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                  <div class="i-card border p-0">
                      <div class="p-20">
                        <div class="icon text--primary mb-30">
                          <i class="ri-time-line fs-30"></i>
                        </div>
                        <div class="content">
                          <p class="card--title-sm mb-1">{{translate("Schedule Post")}}</p>
                          <h6>{{Arr::get($data,'schedule_post',0)}}</h6>
                        </div>
                      </div>
                      <div class="footer border-top d-flex justify-content-between">
                        <div class="text--success">
                          <i class="bi bi-arrow-up"></i>
                          <span class="fs-14">+12%</span>
                        </div>
                        <p class="mb-0 fs-14">This week</p>
                      </div>
                  </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                  <div class="i-card border p-0">
                      <div class="p-20">
                        <div class="icon text--primary mb-30">
                          <i class="ri-checkbox-circle-line fs-30"></i>
                        </div>
                        <div class="content">
                          <p class="card--title-sm mb-1">{{translate("Success Post")}}</p>
                          <h6>{{Arr::get($data,'success_post',0)}}</h6>
                        </div>
                      </div>
                      <div class="footer border-top d-flex justify-content-between">
                        <div class="text--success">
                          <i class="bi bi-arrow-up"></i>
                          <span class="fs-14">+12%</span>
                        </div>
                        <p class="mb-0 fs-14">This week</p>
                      </div>
                  </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                  <div class="i-card border p-0">
                      <div class="p-20">
                        <div class="icon text--primary mb-30">
                          <i class="ri-close-circle-line fs-30"></i>
                        </div>
                        <div class="content">
                          <p class="card--title-sm mb-1">{{translate("Failed Post")}}</p>
                          <h6>{{Arr::get($data,'failed_post',0)}}</h6>
                        </div>
                      </div>
                      <div class="footer border-top d-flex justify-content-between">
                        <div class="text--success">
                          <i class="bi bi-arrow-up"></i>
                          <span class="fs-14">+12%</span>
                        </div>
                        <p class="mb-0 fs-14">This week</p>
                      </div>
                  </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                  <div class="i-card border p-0">
                      <div class="p-20">
                        <div class="icon text--primary mb-30">
                          <i class="ri-account-circle-line fs-30"></i>
                        </div>
                        <div class="content">
                          <p class="card--title-sm mb-1">{{translate("Total Account")}}</p>
                          <h6>{{Arr::get($data['account_report'],'total_account',0)}}</h6>
                        </div>
                      </div>
                      <div class="footer border-top d-flex justify-content-between">
                        <div class="text--success">
                          <i class="bi bi-arrow-up"></i>
                          <span class="fs-14">+12%</span>
                        </div>
                        <p class="mb-0 fs-14">This week</p>
                      </div>
                  </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                  <div class="i-card border p-0">
                      <div class="p-20">
                        <div class="icon text--primary mb-30">
                          <i class="ri-user-follow-line fs-30"></i>
                        </div>
                        <div class="content">
                          <p class="card--title-sm mb-1">{{translate("Active Account")}}</p>
                          <h6>{{Arr::get($data['account_report'],'active_account',0)}}</h6>
                        </div>
                      </div>
                      <div class="footer border-top d-flex justify-content-between">
                        <div class="text--success">
                          <i class="bi bi-arrow-up"></i>
                          <span class="fs-14">+12%</span>
                        </div>
                        <p class="mb-0 fs-14">This week</p>
                      </div>
                  </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-lg-4 col-sm-6">
                  <div class="i-card border p-0">
                      <div class="p-20">
                        <div class="icon text--primary mb-30">
                          <i class="ri-user-unfollow-line fs-30"></i>
                        </div>
                        <div class="content">
                          <p class="card--title-sm mb-1">{{translate("Inactive Account")}}</p>
                          <h6>{{Arr::get($data['account_report'],'inactive_account',0)}}</h6>
                        </div>
                      </div>
                      <div class="footer border-top d-flex justify-content-between">
                        <div class="text--success">
                          <i class="bi bi-arrow-up"></i>
                          <span class="fs-14">+12%</span>
                        </div>
                        <p class="mb-0 fs-14">This week</p>
                      </div>
                  </div>
                </div>
              </div>
             </div>
          </div>
          <div class="col-12">
            <div class="i-card">
              <ul class="nav nav-tabs style-1 d-flex justify-content-start  mb-30" role="tablist">
                  <li class="nav-item" role="presentation">
                      <a class="nav-link active" data-bs-toggle="tab" href="#tab-one" aria-selected="false" role="tab" tabindex="-1">All</a>
                  </li>
                  <li class="nav-item" role="presentation">
                      <a class="nav-link" data-bs-toggle="tab" href="#tab-two" aria-selected="true" role="tab">Facebook</a>
                  </li>
                  <li class="nav-item" role="presentation">
                      <a class="nav-link" data-bs-toggle="tab" href="#tab-three" aria-selected="true" role="tab">Instagram</a>
                  </li>
                  <li class="nav-item" role="presentation">
                      <a class="nav-link" data-bs-toggle="tab" href="#tab-four" aria-selected="true" role="tab">Twitter</a>
                  </li>
                  <li class="nav-item" role="presentation">
                      <a class="nav-link" data-bs-toggle="tab" href="#tab-five" aria-selected="true" role="tab">Linkedin</a>
                  </li>
              </ul>
              <div id="myTabContent3" class="tab-content">
                  <div class="tab-pane fade active show" id="tab-one" role="tabpanel">
                    <div id="postReport"></div>
                  </div>
                  <div class="tab-pane fade" id="tab-two" role="tabpanel">
                    
                  </div>
                  <div class="tab-pane fade" id="tab-three" role="tabpanel">
                    
                  </div>
                  <div class="tab-pane fade" id="tab-four" role="tabpanel">
                    
                  </div>
                  <div class="tab-pane fade" id="tab-five" role="tabpanel">
                    
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-auto right-side-col">
          <div class="swiper latest-post-slider">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="i-card shadow-one mb-4">
                  <h4 class="card--title mb-20">Latest Post</h4>
                  <img src="https://i.ibb.co/j3VTprj/blog.jpg" class="radius-8 mb-3" alt="blog">
                  <h6 class="card--title-sm mb-1">Important things on holiday</h6>
                  <div class="d-flex mb-1">
                    <a href="#">#miami</a>
                    <a href="#">#holiday</a>
                  </div>
                  <div class="date mb-3">
                    <span class="fs-15 text--light">February 1, 2024</span> <span class="fs-15 text--light">8:85 PM</span>
                  </div>
                  <ul class="meta-list d-flex gap-4 text-dark mb-4">
                    <li class="fs-15"><i class="ri-heart-3-line me-1"></i>3k likes</li>
                    <li class="fs-15"><i class="ri-eye-line me-1"></i>10k views</li>
                  </ul>
                  <a href="#" class="i-btn btn--primary btn--lg capsuled w-100">View Post</a>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="i-card shadow-one mb-4">
                  <h4 class="card--title mb-20">Latest Post</h4>
                  <img src="https://i.ibb.co/j3VTprj/blog.jpg" class="radius-8 mb-3" alt="blog">
                  <h6 class="card--title-sm mb-1">Important things on holiday</h6>
                  <div class="d-flex mb-1">
                    <a href="#">#miami</a>
                    <a href="#">#holiday</a>
                  </div>
                  <div class="date mb-3">
                    <span class="fs-15 text--light">February 1, 2024</span> <span class="fs-15 text--light">8:85 PM</span>
                  </div>
                  <ul class="meta-list d-flex gap-4 text-dark mb-4">
                    <li class="fs-15"><i class="ri-heart-3-line me-1"></i>3k likes</li>
                    <li class="fs-15"><i class="ri-eye-line me-1"></i>10k views</li>
                  </ul>
                  <a href="#" class="i-btn btn--primary btn--lg capsuled w-100">View Post</a>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="i-card shadow-one mb-4">
                  <h4 class="card--title mb-20">Latest Post</h4>
                  <img src="https://i.ibb.co/j3VTprj/blog.jpg" class="radius-8 mb-3" alt="blog">
                  <h6 class="card--title-sm mb-1">Important things on holiday</h6>
                  <div class="d-flex mb-1">
                    <a href="#">#miami</a>
                    <a href="#">#holiday</a>
                  </div>
                  <div class="date mb-3">
                    <span class="fs-15 text--light">February 1, 2024</span> <span class="fs-15 text--light">8:85 PM</span>
                  </div>
                  <ul class="meta-list d-flex gap-4 text-dark mb-4">
                    <li class="fs-15"><i class="ri-heart-3-line me-1"></i>3k likes</li>
                    <li class="fs-15"><i class="ri-eye-line me-1"></i>10k views</li>
                  </ul>
                  <a href="#" class="i-btn btn--primary btn--lg capsuled w-100">View Post</a>
                </div>
              </div>
            </div>
          </div>
 
          <div class="i-card upgrade-card mb-4">
            <h4 class="card--title text-white">Upgrade Premium to Get More Space</h4>
            <p>
            3 Social account and and Enjoy all new environments with pro plan
            </p>
            <a
              href="{{route('user.plan')}}"
              class="i-btn btn--md btn--white capsuled mx-auto">
              @if($user->runningSubscription)
                {{translate('Upgrade Now')}}
              @else
                {{translate('Subscribe Now')}}
              @endif
              <span><i class="bi bi-arrow-up-right"></i></span>
            </a>
          </div>
          <div class="i-card-md share-card">
            <h4 class="card-title mb-3">
               Shared Files
            </h4>
            <ul>
              <li class="mb-3 fs-15"><span class="me-1 text--primary"><i class="bi bi-card-text"></i></span> One of the largest social media platforms.</li>
              <li class="mb-3 fs-15"><span class="me-1 text--primary"><i class="bi bi-card-text"></i></span>The largest video-sharing platform.</li>
              <li class="mb-3 fs-15"><span class="me-1 text--primary"><i class="bi bi-card-text"></i></span>A visual discovery and bookmarking platform.</li>
              <li class="mb-3 fs-15"><span class="me-1 text--primary"><i class="bi bi-card-text"></i></span>A visual discovery and bookmarking platform.</li>
              <li class="mb-0 fs-15"><span class="me-1 text--primary"><i class="bi bi-card-text"></i></span>A visual discovery and bookmarking platform.</li>
            </ul>
          </div>
        
      </div>
    </div>
    <!-- updated end -->

    <div class="row g-4">
      <div class="col-xxl-9">
        
      </div>
      <div class="col-xxl-3 col-md-6">
        
      </div>

      <div class="col-xxl-4 col-md-6">
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
               
            </ul>
          </div>
        </div>
      </div>

      <div class="col-xxl-8">
        <div class="i-card-md card-height-100">
          <div class="card-header">
            <h4 class="card-title">
               {{translate("Social Post")}}
            </h4>
          </div>
          <div class="card-body">
           
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
                                                  <span class="icon-btn icon-btn-sm primary circle">
                                                      <i class="bi bi-file-text"></i>
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
                                          <span class="icon-btn icon-btn-sm primary circle">
                                              <i class="bi bi-file-text"></i>
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

    var swiper = new Swiper(".latest-post-slider", {
      autoplay: {
      delay: 1500,
    },
    });

    $(".select2").select2({

});

</script>
@endpush
