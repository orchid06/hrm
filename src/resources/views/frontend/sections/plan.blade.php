
@php
   $content  = get_content("content_plan")->first();
   $plans    = App\Models\Package::active()
                                  ->feature()
                                  ->get();

@endphp


<section class="plan pt-110 pb-110">
    <div class="container">
      <div class="row gy-5">
        <div class="col-xl-5 col-lg-4">
          <div>
            <div class="section-title">
              <span>{{@$content->value->sub_title}}</span>

              <h3 class="title-anim">{{@$content->value->title}}</h3>

              <p>
                {{@$content->value->description}}
              </p>
            </div>

            <div class="d-flex align-items-center gap-4">
              <a href="{{url($content->value->button_url)}}" class="i-btn btn--secondary btn--lg capsuled">
                {{$content->value->button_name}}
              </a>
            </div>
          </div>
        </div>

        <div class="col-xl-7 col-lg-8">
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-4 mb-4">
            <div class="nav plan-tab" role="tablist">
              @foreach (App\Enums\PlanDuration::toArray() as  $key => $value)
                <button class='nav-link {{$loop->index  == 0 ? "active" :""}}' id="{{$key}}-tab" data-bs-toggle="pill" data-bs-target="#{{$key}}" type="button" role="tab" aria-controls="{{$key}}"
                   aria-selected="true">
                    {{
                      ucfirst(strtolower($key))
                    }}
                </button>
              @endforeach
            </div>

            <a href="{{route('plan')}}" class="learn-more">
                <span class="circle" aria-hidden="true">
                  <span class="icon arrow"> </span>
                </span>
              <span class="button-text">
                {{trans("default.explore_all")}}
              </span>
            </a>

          </div>

          <div class="tab-content" id="tab-plans">
            @foreach (App\Enums\PlanDuration::toArray() as  $key => $value)
                  <div class='tab-pane fade {{$loop->index == 0 ? "show active" : ""}}' id="{{$key}}" role="tabpanel" aria-labelledby="{{$key}}-tab" tabindex="0">

                     @php
                        $purchasePlans = $plans->where('duration',$value);
                     @endphp
                      <div class="row g-4">
                          <div class="col-xl-7 col-md-6 order-md-0 order-1">
                              <div class="tab-content" id="price-tabContent-{{$loop->index}}">

                                    @forelse ($purchasePlans as  $plan)
                                      <div class='tab-pane fade {{$loop->index == 0 ? "show active" :""}}' id="{{$key}}-{{$plan->slug}}" role="tabpanel" aria-labelledby="{{$key}}-{{$plan->slug}}-tab" >
                                        <div class="plan-card-detail">
                                            <p>
                                              {{ $plan->description}}
                                            </p>
                                          <ul>

                                            @foreach (plan_configuration( $plan) as $configKey => $configVal )
                                              <li>
                                                <span>
                                                  <i class="bi bi-patch-check"></i>
                                                </span>
                                                <p>
                                                   {{!is_bool($configVal) ? $configVal : "" }} {{k2t($configKey)}}
                                                </p>
                                              </li>
                                            @endforeach


                                          </ul>
                                          <div>
                                            <a href='{{route("user.plan.purchase",$plan->slug)}}'
                                              class="i-btn btn--secondary btn--lg capsuled">
                                                {{translate("Subscribe")}}
                                            </a>
                                          </div>
                                        </div>
                                      </div>

                                    @empty

                                      @include("frontend.partials.not_found")

                                    @endforelse

                              </div>
                          </div>

                          <div class="col-xl-5 col-md-6 order-md-1 order-0">
                            <div class="nav plan-card-list" role="tablist" aria-orientation="vertical">
                                @forelse ($purchasePlans as  $plan)

                                  <a class="nav-link plan-card-item {{$loop->index == 0 ? 'active' :''}}" id="{{$key}}-{{$plan->slug}}-tab" data-bs-toggle="pill" href="#{{$key}}-{{$plan->slug}}" role="tab" aria-controls="{{$key}}-{{$plan->slug}}"     aria-selected="true">
                                    <div class="plan-card-left">
                                      <span>
                                        {{$plan->title}}
                                      </span>
                                      @php

                                      @endphp

                                      <h4>  @if($plan->discount_price > 0) <del>
                                        {{num_format( number : $plan->price,
                                            calC:true)}}</del> {{num_format( number : $plan->discount_price,
                                            calC:true)}} @else {{num_format( number : $plan->price,
                                            calC:true)}}@endif
                                        </h4>

                                    </div>

                                    <div class="plan-card-right">
                                      <span> </span>
                                    </div>
                                  </a>

                                @empty

                                     @include("frontend.partials.not_found")

                                @endforelse

                            </div>
                          </div>
                      </div>
                  </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
</section>
