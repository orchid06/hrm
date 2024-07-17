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
                <div class="row">
            
                        <div class="col-lg-8">
                            <h6 class="mb-3">
                                {{translate('Payment methods')}}
                            </h6>
                            <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-2 g-3">

                                @foreach ($methods as  $method)

                                    <div class="col">
                                        <label class="payment-card-item">
                                            <input name="method_id" data-method="{{$method}}" , data-img="{{imageURL(@$method->file,'payment_method',true)}}" value="{{$method->id}}" class="radio deposit-method" type="radio" >
                                            <span class="image">
                                                <img src='{{imageURL(@$method->file,"payment_method",true)}}' alt="{{@$method->file->name ?? $method->name.'.jpg'}}" >
                                            </span>
                                            <span class="title">
                                                {{$method->name}}
                                            </span>
                                        </label>
                                    </div>
                                    
                                @endforeach
                                
                                
                            </div>
                        </div>

                        <div class="col-lg-4 ps-lg-5">
                            <div class="payment-flip-card">
                                <div class="balance-info-card" id="balanceCard">  
                                    <span class="balance-icon">
                                        <i class="bi bi-wallet2"></i>
                                    </span>

                                    <p>
                                        {{translate('Your Balance')}}
                                    </p>
                                    <h4>
                                        {{num_format(number:$balance,calC:true)}}
                                    </h4>

                                    <span class="balance-shape">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 64 64" xml:space="preserve"><g><g fill="none" stroke="#0a1c28" stroke-linejoin="round" data-name="cradit card"><g stroke-width="2"><path d="M38 34a2 2 0 1 0-2-2 2 2 0 1 1-2-2M30 32h2M40 32h2M35 57h5"  opacity="1"></path><path d="M49 48V10a3 3 0 0 1-3-3H26a3 3 0 0 1-3 3v27"  opacity="1"></path><path d="M19 37V3h34v45M40 61H19M53 48 40 61V50a2 2 0 0 1 2-2z"  opacity="1"></path><path d="M46 55h8a3 3 0 0 1 3-3V12a3 3 0 0 1-3-3h-1"  opacity="1"></path><path d="M53 5h8v54H42M28.52 37A9 9 0 1 1 36 41h-1" opacity="1"></path><rect width="32" height="24" x="3" y="37" rx="2"  opacity="1"></rect></g><path stroke-width="4" d="M3 44h32"  opacity="1"></path><circle cx="29" cy="55" r="2" stroke-width="2"  opacity="1"></circle><path stroke-width="2" d="M6 57h2M10 57h2"  opacity="1"></path></g></g></svg>
                                    </span>
                                </div>
            
                                <div class="payment-card-form mt-4" id="formStepOne">

                                    <div class="d-flex align-items-center justify-content-between bg-light payment-form-top d-none payment-header">
                                       
                                    </div>
                        
                                        <div class="payment-details-wrapper">
                                            <div class="p-3 mb-4 bg-danger-soft rounded-2 d-none payment-note-section">
                                            
                                            </div>
                                            <ul class="payment-details deposit-details list-group mb-4 d-none">

                                            </ul>
                                        </div>
                                        <div class="p-4">

                                                <div class="form-inner">

                                                    <label for="amount">
                                                        {{translate("Amount")}} <span class="text--danger">*</span></label>
                                                    <div class="input-group">
                                                        <input required placeholder="{{translate('Enter amount')}}" name="amount" type="number" class="form-control"id="amount" value="{{old('amount')}}"/>
                                                        <span class="input-group-text">
                                                            {{ $currencySymbol}}
                                                        </span>
                                                    </div>
                                                </div>

                                                <button type="submit" class="i-btn btn--lg btn--primary capsuled">
                                                    {{translate('Submit')}} 
                                                </button>  
                        
                                        </div>
                                </div> 
                                
                            </div>
                        </div>
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

        $(document).on("click",'.deposit-method',function(e){

            var method =  JSON.parse($(this).attr('data-method'));
            var img =  ($(this).attr('data-img'));
            var amount = ($('#amount').val());

            amount    = amount? parseFloat(amount) : 0;

            if(method && amount){
                deopositCal(method,img,amount)
            }

        });


        $(document).on("keyup",'#amount',function(e){
            var methodId =  $('input[name="method_id"]:checked').val();
            var amount = parseFloat($(this).val());
            if(methodId && amount){
                var img =  ($('input[name="method_id"]:checked').attr('data-img'));
                var method =  JSON.parse($('input[name="method_id"]:checked').attr('data-method'));
                deopositCal(method,img,amount)
            }
            else{
                $('.deposit-details').addClass('d-none');
                $('.payment-note-section').addClass('d-none');
                $('.payment-header').addClass('d-none');

            }
        })



        function deopositCal(method ,img, amount){


                var paymentNote = method.note?? "{{translate('Payment with')}} "+method.name ;

                $('.payment-note-section').removeClass('d-none');
                $('.payment-header').removeClass('d-none');
                
                $('.payment-note-section').html(`<p class="text--dark"><span class="bg-danger text-white py-0 px-2 d-inline-block me-2 rounded-1">Note  :</span>  
                                                
                                                    ${paymentNote}
                                                
                                                </p>`)
                $('.payment-header').html(` <h5 class="payment-method-title">

                                             ${method.name}
                                        </h5>
                                        <span class="payment-img">
                                            <img src="${img}" alt="payment.jpg">
                                        </span>`)



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
                                <h6> {{$currencySymbol}}${netCharge.toFixed(3)}  (  {{$currencySymbol}}${fixedCharge} + ${percentCharge}% )</h6>
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
