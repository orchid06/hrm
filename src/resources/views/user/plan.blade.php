@extends('layouts.master')
@section('content')

      @php

          $planSection   = get_content("content_plan")->first();
      @endphp

    <div class="inner-banner">
        <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-8 mx-auto">
            <div class="inner-banner-content text-center">
                <h2>{{@$planSection->value->title}}</h2>
                <p>
                    {{@$planSection->value->description}}
                </p>
                <div class="mt-5 d-flex justify-content-center">
                    <div class="nav plan-tab" role="tablist">
                            @foreach (App\Enums\PlanDuration::toArray() as  $key => $value)
                                <button
                                    class="nav-link {{$loop->index  == 0 ? 'active' :''}}"
                                    id="{{$key}}-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#{{$key}}"
                                    type="button"
                                    role="tab"
                                    aria-controls="{{$key}}"
                                    aria-selected="true">
                                    {{
                                        ucfirst(strtolower($key))
                                    }}
                                </button>

                        @endforeach
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>

        <div class="primary-shade"></div>
        <div class="banner-texture"></div>
    </div>

    <div class="plan-detail pb-5">
        <div class="container">
            <div class="tab-content" id="tab-plans">
                @foreach (App\Enums\PlanDuration::toArray() as  $key => $value)
                    <div class="tab-pane fade  {{$loop->index == 0 ? 'show active' : ''}}" id="{{$key}}" role="tabpanel" aria-labelledby="{{$key}}-tab" tabindex="0">
      
                      @php
                        $purchasePlans = $plans->where('duration',$value);
                      @endphp
      
      
                      <div class="plan-detail-wrapper">
                        <div class="row gy-4 gx-4">
                          @forelse ($purchasePlans as  $plan)
                              <div class="col-xl-4 col-md-6">
                                <div class="plan-detail-card @if($plan->is_recommended == App\Enums\StatusEnum::true->status()) recommend @endif">
                                  @if($plan->is_recommended == App\Enums\StatusEnum::true->status())
                                      <div class="recommend-content"><p>
                                          {{translate("Recommended")}}
                                      </p></div>
                                  @endif
      
                                  <div class="plan-detail-top">
                                    <span>
                                        {{$plan->title}}
                                    </span>
      
                                    <h4>  @if($plan->discount_price > 0) <del>
                                      {{num_format( number : $plan->price,decimal:0,
                                                  calC:true)}}</del> {{num_format( number : $plan->discount_price,decimal:0,
                                                  calC:true)}} @else {{num_format( number : $plan->price,decimal:0,
                                                  calC:true)}}@endif<span>/{{ucfirst(strtolower($key))}}</span></h4>
                                    <p>
                                      {{$plan->description}}
                                    </p>
      
                                    <a href="{{route('user.plan.purchase',$plan->slug)}}" class="i-btn btn--secondary btn--lg capsuled w-100">
                                      {{translate("Subscribe")}}
                                    </a>
                                  </div>
      
                                  <div class="plan-detail-body">
                                      <ul>
      
                                        @foreach (plan_configuration( $plan) as $configKey => $configVal )
                                            <li>
                                              <span>
                                                <i class="bi bi-patch-check"></i>
                                              </span>
                                              <p> {{!is_bool($configVal) ? $configVal : "" }} {{k2t($configKey)}}</p>
                                            </li>
                                        @endforeach
      
                                      </ul>
                                  </div>
                                </div>
                              </div>
                          @empty
      
                            <div class="col-12 justify-content-center text-center">
                                @include("frontend.partials.not_found")
                            </div>
      
                          @endforelse
      
                        </div>
                      </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>


@endsection


