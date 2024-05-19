@extends('layouts.master')


@section('content')

@php

   $balance         = auth_user("web")->balance;
   $currencySymbol  = session('currency')?session('currency')->symbol : base_currency()->symbol;

@endphp

<div class="row">
    <div class="col-12">
      <div
        class="w-100 d-flex align-items-center justify-content-between gap-lg-5 gap-3 flex-md-nowrap flex-wrap mb-4">
        <div>
          <h4>
               {{translate(Arr::get($meta_data,'title'))}}
          </h4>

        </div>

        <div>
          <a href="{{route('user.withdraw.report.list')}}" class="i-btn btn--primary-outline btn--md capsuled">
                {{translate("Withdraw Reports")}}
            <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

      <div class="i-card-md">
        <div class="card-body">
          <form action="{{route('user.withdraw.request.process')}}" method="post">
             @csrf
            <div class="form-inner">
                <label for="id">
                     {{translate("Select Method")}}
                    <small class="text-danger">*</small>
                </label>

                <select name="id" class="form-select withdraw-method"
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
                <input placeholder="{{translate('Enter amount')}}" name="amount" type="number" class="form-control"id="amount" value="{{old('amount')}}"/>
                <span class="input-group-text text--primary">
                     {{ $currencySymbol}}
                </span>
              </div>
            </div>

            <ul class="payment-details withdraw-details list-group mt-4 d-none">


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

        $(".withdraw-method").select2({

        });

        $(document).on("change",'.withdraw-method',function(e){

            var method =  JSON.parse($(this).find(':selected').attr('data-method'));
            var amount = parseFloat($('#amount').val());

            if(method && amount){
                withdrawCalculation(method,amount)
            }


        });


        $(document).on("keyup",'#amount',function(e){

            var methodId = $(".withdraw-method").val()
            var amount = parseFloat($(this).val());
            if(methodId && amount){

                var method =  JSON.parse($('.withdraw-method').find(':selected').attr('data-method'));


                if({{$balance}} < amount){
                    toastr("{{translate('Insufficient balance')}}",'danger')
                    $(this).val('')
                    $('.withdraw-details').addClass('d-none');
                }
                else{

                    withdrawCalculation(method,amount)

                }
            }
            else{
                $('.withdraw-details').addClass('d-none');
                if(!methodId){

                    toastr("{{translate('Select a method first')}}",'danger')
                }

            }
        })



        function withdrawCalculation(method , amount){

                    var fixedCharge   =  parseFloat(method.fixed_charge);
                    var percentCharge =  parseFloat(method.percent_charge);

                    var netCharge     =  parseFloat(fixedCharge + (amount  * percentCharge / 100));
                    var netAmount     =  (amount + netCharge);

                    var list  =  `<li class="list-group-item active" aria-current="true">
                                            <h5>
                                                {{translate("Withdraw Details")}}
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

                    $('.withdraw-details').removeClass('d-none');
                    $('.withdraw-details').html(list)
        }



	})(jQuery);
</script>
@endpush
