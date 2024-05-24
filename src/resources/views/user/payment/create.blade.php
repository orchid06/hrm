@extends('layouts.master')

@section('content')

            @php

                        $balance         = auth_user("web")->balance;

                        $currency        = session('currency')??base_currency();

                        $currencySymbol  = $currency->symbol;
                        $currencyCode    = $currency->code;
                        $exchangeRate    = $currency->exchange_rate;

            @endphp

<div class="row">
    <div class="col-12">
      <div class="w-100 d-flex align-items-center justify-content-between gap-lg-5 gap-3 flex-md-nowrap flex-wrap mb-4">
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

                    <select name="method_id" class="form-select deposit-method"
                        id="method_id">

                        <option value="">
                            {{translate('Select Method')}}
                        </option>

                        @foreach ($methods as $method )

                            <option data-method ="{{$method}}" {{old("method_id")  ==  $method->id ? "selected" :""}} value="{{$method->id}}">
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
                        <input placeholder="{{translate('Enter amount')}}" name="amount" type="number" class="form-control"id="amount" value="{{old('amount')}}"/>
                        <span class="input-group-text">
                            {{ $currencySymbol}}
                        </span>
                    </div>
                </div>

                <ul class="payment-details deposit-details list-group mt-4 d-none">


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


@php
    $fromRate    = session()->get("currency") ? session()->get("currency")->exchange_rate : 0;
@endphp

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


                var rate                =  parseFloat('{{$fromRate}}')
                var fixedCharge         =  parseFloat(method.fixed_charge);
                var percentCharge       =  parseFloat(method.percentage_charge);

                var netCharge           =  parseFloat(fixedCharge + (amount  * percentCharge / 100));

                var netAmount           =  (amount + netCharge);
                var netAmountInBase     =  (netAmount/rate);

                var methodExchangeRate  = parseFloat(method.currency.exchange_rate)

                var finalAmount         =  netAmountInBase*methodExchangeRate;

                var exchangeRate        =  exchange_rate(method.currency)

                var list  =  `<li class="list-group-item active" aria-current="true">
                                        <h5>
                                            {{translate("Deposit Details")}}
                                        </h5>
                                </li>`;

                    list += `<li class="list-group-item">
                                <p>
                                    {{translate("Limit")}}
                                </p>
                                <h6>
                                    ${method.currency.symbol}${method.minimum_amount} -  ${method.currency.symbol}${method.maximum_amount}

                                </h6>
                            </li>
                            <li class="list-group-item">
                                <p> {{translate("Charge")}}</p>
                                <h6> {{$currencySymbol}}${netCharge.toFixed(3)}  (  {{$currencySymbol}}${fixedCharge} - ${percentCharge}% )</h6>
                            </li>

                            <li class="list-group-item">
                                <p> {{translate("Amount with charge")}}</p>
                                <h6> {{$currencySymbol}}${netAmount}</h6>
                            </li>

                            <li class="list-group-item">
                                <p> {{translate("Exchange rate")}}</p>
                                <h6> {{$currencySymbol}}1 = ${method.currency.symbol}${exchangeRate}</h6>
                            </li>



                            <li class="list-group-item">
                                <p> {{translate("Payable amount")}}</p>
                                <h6>
                                    ${method.currency.symbol}${finalAmount.toFixed(2)} ({{base_currency()->symbol}}${netAmountInBase.toFixed(2)})
                                </h6>
                            </li>


                            `;

                $('.deposit-details').removeClass('d-none');
                $('.deposit-details').html(list)
        }


        function exchange_rate(currency){
            var base    = "{{base_currency()}}";
            var amount  = parseFloat({{base_currency()->exchange_rate}});
            var  rate    = parseFloat({{$currency->exchange_rate}})

            var exchangeRate = rate / (currency?currency.exchange_rate : rate);
             amount       = 1 / exchangeRate;

            return  amount.toFixed(2);
        }



	})(jQuery);
</script>
@endpush
