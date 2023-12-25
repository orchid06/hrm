@extends('layouts.master')


@section('content')

@php

   $balance         = auth_user("web")->balance;
   $currencySymbol  = session('currency')?session('currency')->symbol : base_currency()->symbol;
    
@endphp

<div class="row">
    <div class="col-xl-7 col-lg-10 mx-auto">
      <div
        class="w-100 d-flex align-items-end justify-content-between gap-lg-5 gap-3 flex-md-nowrap flex-wrap mb-4">
        <div>
          <h4>
               {{translate(Arr::get($meta_data,'title'))}}
          </h4>
       
        </div>

        <div>
          <a href="{{route('user.deposit.report.list')}}" class="i-btn btn--primary-outline btn--md capsuled">
                {{translate("Deposit Reports")}}
            <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

      <div class="i-card-md">
        <div class="card-body">
          <form action="{{route('user.deposit.process')}}" method="post">
             @csrf
                <div class="form-inner">
                    <label for="id">
                        {{translate("Select Method")}}
                        <small class="text-danger">*</small>
                    </label>

                    <select name="id" class="form-select deposit-method" 
                        id="id">

                        <option value="">
                            {{translate('Select Method')}}
                        </option>

                        @foreach ($methods as $method )

                        <option data-method ="{{$method}}" {{old("id")  ==  $method->id ? "selected" :""}} value="{{$method->id}}">
                            {{$method->name}}
                        </option>
                            
                        @endforeach

                    </select>
                </div>

                <div class="form-inner mb-0">
                    <label for="amount">
                        {{translate("Amount")}}
                        <small class="text-danger">*</small></label>
                    <div class="input-group">
                        <input placeholder="{{translate('Enter amount')}}" name="amount" type="number" class="form-control"id="amount" value="{{old("amount")}}"/>
                        <span class="input-group-text">
                            {{ $currencySymbol}}
                        </span>
                    </div>
                </div>

                <ul class="payment-details list-group mt-4 d-none">

                
                </ul>

                <div class="mt-4">
                    <button class="i-btn btn--primary btn--lg capsuled">
                        {{translate("Submit")}}
                    </button>
                </div>
          </form>
        </div>
      </div>
    </div>
</div>

@endsection


@push('script-push')
<script>
	(function($){

        "use strict";

        $(".deposit-method").select2({
           
        });

        $(document).on("change",'.deposit-method',function(e){

            var method =  JSON.parse($(this).find(':selected').attr('data-method'));
            var amount = parseFloat($('#amount').val());

            if(method && amount){
                deopositCal(method,amount)
            }


        });


        $(document).on("keyup",'#amount',function(e){
            
     
            var methodId = $(".deposit-method").val()
            var amount = parseFloat($(this).val());
            if(methodId && amount){

                var method =  JSON.parse($('.deposit-method').find(':selected').attr('data-method'));
              
                deopositCal(method,amount)
            }
            else{
                $('.deposit-details').addClass('d-none');
                if(!methodId){
        
                    toastr("{{translate('Select a method first')}}",'danger')
                }

            }
        })



        function deopositCal(method , amount){
                  
               console.log(method)

                var fixedCharge   =  parseFloat(method.fixed_charge);
                var percentCharge =  parseFloat(method.percentage_charge);

                var netCharge     =  parseFloat(fixedCharge + (amount  * percentCharge / 100));
                var netAmount     =  (amount + netCharge).toFixed(2);

                var list  =  `<li class="list-group-item" aria-current="true">
                                        <h5>
                                            {{translate("Deposit Details")}}
                                        </h5>
                                </li>`;
                
                    list += `<li class="list-group-item">
                                <p>
                                    {{translate("Limit")}}
                                </p>
                                <h6>
                                    {{$currencySymbol}}${method.minimum_amount} - {{$currencySymbol}}${method.maximum_amount}

                                </h6>
                            </li>
                            <li class="list-group-item">
                                <p> {{translate("Charge")}}</p>
                                <h6>{{$currencySymbol}}${netCharge}  ( {{$currencySymbol}}${fixedCharge} - ${percentCharge}% )</h6>
                            </li>

                            <li class="list-group-item">
                                <p> {{translate("Final amount")}}</p>
                                <h6>
                                    {{$currencySymbol}}${netAmount}
                                </h6>
                            </li>
                            
                            `;

                $('.deposit-details').removeClass('d-none');
                $('.deposit-details').html(list)
        }
 
       

	})(jQuery);
</script>
@endpush
