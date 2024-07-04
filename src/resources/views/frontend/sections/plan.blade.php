
@php
   $content  = get_content("content_plan")->first();
   $plans    = App\Models\Package::active()
                                        ->feature()
                                        ->get();

@endphp
<section class="pricing-plan pb-110">
  <div class="container">
  
      <div class="row justify-content-start align-items-center mb-60 g-4">
        <div class="col-lg-6">
            <div class="section-title-one text-start">
                <div class="subtitle">{{@$content->value->sub_title}}</div>
                <h2>
                  @php echo @$content->value->title @endphp
                </h2>
                <p>{{@$content->value->description}}</p>
            </div>
        </div>
        <div class="col-lg-6 d-flex justify-content-end align-items-center">
            <a href="{{url(@$content->value->button_URL)}}" class="i-btn btn--lg btn--white capsuled"> {{@$content->value->button_name}}  <span><i
                        class="bi bi-arrow-up-right"></i></span></a>
        </div>
    </div>

      <ul class="nav  plan-tab d-flex justify-content-center mx-auto mb-60"  role="tablist">

         @foreach (App\Enums\PlanDuration::toArray() as  $key => $value)
              <li class="nav-item" role="presentation">
                        <a href="javascript:void(0)"  class="nav-link {{$loop->index == 0 ? "active" :""}} " id="{{$value}}-tab" data-bs-toggle="tab" data-bs-target="#{{$value}}-tab-pane" role="tab" aria-controls="{{$value}}-tab-pane" aria-selected="true">

                            {{$key}}
                        </a>
              </li>
     
          @endforeach
       
       
      </ul>
      <div class="tab-content">
        @foreach (App\Enums\PlanDuration::toArray() as  $key => $value)
              <div class="tab-pane fade {{$loop->index == 0 ? "show active" :""}}" id="{{$value}}-tab-pane" role="tabpanel" aria-labelledby="{{$value}}-tab" tabindex="0">

                @php
                     $purchasePlans = $plans->where('duration',$value);
                @endphp
                  <div class="row g-4">

                      @forelse ($purchasePlans as  $plan)
                        <div class="col-lg-4 col-md-6">
                          <div class="pricing-item {{ $plan->is_recommended ==  App\Enums\StatusEnum::true->status() ? 'style-dark' :'' }} ">
                              <div class="radius-one">
                                  <img src="{{asset('assets/images/default/plan_shape.png')}}" alt="plan_shape.png">
                              </div>
                              <div class="radius-two">
                                  <img src="{{asset('assets/images/default/plan_shape_bread.png')}}" alt="plan_shape_bread.png">
                              </div>
                              <div class="icon">
                                  <i class="{{$plan->icon}}"></i>
                              </div>
                              <div class="pricing-header">
                                   @if($plan->is_recommended ==  App\Enums\StatusEnum::true->status())
                                            <span>
                                               {{translate('Recommended Plan')}}
                                            </span>
                                  @endif
                                  <h5>{{ $plan->title}}</h5>
                                  <p> {{ $plan->description}} </p>
                              </div>
                              <div class="price">
                                  <h3>@if($plan->discount_price > 0) <del>
                                    {{num_format( number : $plan->price,
                                        calC:true)}}</del> {{num_format( number : $plan->discount_price,
                                        calC:true)}} @else {{num_format( number : $plan->price,
                                        calC:true)}}@endif   <span>/{{$key}}</span></h3>
                              </div>
                              <div class="body">
                                  <h6>
                                     {{translate('What’s included')}}
                                  </h6>
                                  <ul>
                                    @foreach (plan_configuration( $plan) as $configKey => $configVal )
                                        <li>
                                              <span>
                                                  <i class="bi bi-check"></i>
                                              </span>
                                              {{!is_bool($configVal) ? $configVal : "" }} {{k2t($configKey)}}
                                        </li>
                                    @endforeach

                                  </ul>
                              </div>
                              <a href="{{route("user.plan.purchase",$plan->slug)}}" class="i-btn btn--lg btn--primary capsuled">{{translate("Subscribe")}}</a>
                          </div>
                        </div>
                      @empty

                        <div class="col-12">
                                @include("frontend.partials.not_found")
                        </div>
                          
                      @endforelse
                      

                  </div>
              </div>
        @endforeach
     
      </div>



  </div>
</section>

