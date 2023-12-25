@extends('layouts.master')


@section('content')

@php

   $balance         = auth_user("web")->balance;
   $currencySymbol  = session('currency')?session('currency')->symbol : base_currency()->symbol;
    
@endphp

<div class="row">
    <div class="col-xl-8 col-lg-10 mx-auto">
      <div class="i-card-md">
        <div class="card-body">
          <div class="manual-pay-card">
            <div class="manual-pay-top text-lg-center mb-4">
              <h2>{{translate('Please follow the instruction below')}}</h2>
     
            </div>

            <form action="{{route("user.withdraw.request.submit")}}" method="POST" class="mt-5" enctype="multipart/form-data">

                @csrf
              <input type="text" name="amount" value="{{($amount)}}">

              <div class="row g-4">

                <div class="col-lg-12 text-center ">
                    <div>
                        <h6 class="mb-1">
                            {{translate("Note")}}
                        </h6>
                
                    </div>
                   {{@$method->description}}
                </div>


                <ul class="payment-details list-group mt-4">
                    <li class="list-group-item active" aria-current="true">
                      <h5>
                         {{translate("Withdraw Details")}}
                      </h5>
                    </li>
                    <li class="list-group-item">
                      <p>
                         {{translate('Limit')}}
                      </p>
                      <h6>
                          {{num_format(number:$method->minimum_amount)}} -  {{num_format(number:$method->maximum_amount)}}
                      </h6>
                    </li>

                    <li class="list-group-item">
                        <p>
                           {{translate('Requested Amount')}}
                        </p>
                        <h6>
                            {{num_format($amount)}} 
                        </h6>
                    </li>

                    <li class="list-group-item">
                      <p>
                         {{translate("Charge")}}
                      </p>
                      <h6>
                        
                            @php
                               $charge  = ((float)$method->fixed_charge + ($amount  * (float)$method->percent_charge / 100));
                            @endphp
                            {{num_format(number:$charge)}}
                         
                      </h6>
                    </li>
                    <li class="list-group-item">
                      <p>
                        {{translate("Payable")}}
                      </p>
                      <h6>   {{num_format(number:$charge+$amount)}}</h6>
                    </li>

                    <li class="list-group-item">
                        <p>
                          {{translate("Duration")}}
                        </p>
                        <h6>  
                            @php
                            use Carbon\Carbon;

                                $durationInHours = (int)$method->duration;
                                $startTime = Carbon::now();
                                $endTime   =    $startTime->addHours($durationInHours)
                

                            @endphp
                             {{diff_for_humans($endTime)}}
                        
                        </h6>
                    </li>
                   
                </ul>
                

                @if(optional($method)->parameters)
                    @foreach(optional($method)->parameters as $k => $v)
                         @if($v->type == "text" || $v->type == "password"  )
                            <div class="col-md-6">
                                <div class="form-inner mb-0">
                                    <label for="{{$k}}">{{translate($v->field_label)}} @if($v->validation == 'required') <small class="text-danger">*</small>  @endif </label>
                                    <input value="{{old($k)}}" id="{{$k}}" placeholder="{{$k}}" type="{{$v->type}}" name="{{$k}}"   @if($v->validation == "required") required @endif>
                                </div>
                            </div>
                         @elseif($v->type == "textarea")

                            <div class="col-md-12">
                                <div class="form-inner mb-0">
                                    <label for="{{$k}}">{{translate($v->field_label)}} @if($v->validation == 'required') <small class="text-danger">*</small>  @endif </label>

                                    <textarea id="{{$k}}" placeholder="{{$k}}" name="{{$k}}"  rows="3" @if($v->validation == "required") required @endif>{{old($k)}}</textarea>
                                                            
                                </div>
                            </div>
                        
                        @elseif($v->type == "file")
                            <div class="col-6">
                                <div class="form-inner">
                                    <label id="{{$k}}">{{translate($v->field_label)}} @if($v->validation == 'required') <small class="text-danger">*</small>  @endif </label>
                                
                                        <input id="{{$k}}" type="file" name="{{$k}}" accept="image/*"
                                            @if($v->validation == "required") required @endif>
                             
                                </div>
                            </div>
                        @endif


                    @endforeach
                @endif

            

                <div class="col-12">
                  <button type="submit"
                    class="i-btn btn--primary btn--lg capsuled">
                        {{translate("Submit")}}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


@endsection