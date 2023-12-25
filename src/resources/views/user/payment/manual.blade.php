@extends('layouts.master')
@section('content')


  @php
     $method = $log->method;
  @endphp


  <div class="row">
    <div class="col-xl-8 col-lg-10 mx-auto">
      <div class="i-card-md">
        <div class="card-body">
          <div class="manual-pay-card">
            <div class="manual-pay-top text-lg-center mb-4">
              <h2>{{translate('Please follow the instruction below')}}</h2>
     
            </div>

            <form action="{{route('user.deposit.manual')}}" method="POST" class="mt-5" enctype="multipart/form-data">

                @csrf

              <div class="row g-4">

                <div class="col-lg-12 text-center ">
                    <div>
                        <h6 class="mb-1">
                            {{translate("Note")}}
                        </h6>
                
                    </div>
                   {{@$method->payment_notes}}
                </div>


                <ul class="payment-details list-group mt-4">
                    <li class="list-group-item active" aria-current="true">
                      <h5>
                         {{translate("Deposit Details")}}
                      </h5>
                    </li>
                    <li class="list-group-item d-flex justify-content-between primary-bg ">
                        {{translate('You have to pay ')}}:
                        <strong>{{num_format($log->final_amount,$log->method->currency)}}  </strong>
                     </li>
                     <li class="list-group-item d-flex justify-content-between primary-bg ">
                        {{translate('You will get ')}}:
         
                         <strong>{{num_format($log->amount,$log->currency)}}</strong>
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



