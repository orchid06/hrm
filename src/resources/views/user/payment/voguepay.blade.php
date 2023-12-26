@extends('layouts.master')
@section('content')
   
   @php
       
       $user = $log->user;
   
   @endphp

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="i-card-md ">
                <div class="card-header">
                    <h4 class="card-title">
                         {{@$log->method->name}}
                    </h4>
                </div>
                <div class="card-body">
                    <ul class="list-group text-center">
                        <li class="list-group-item d-flex justify-content-between primary-bg ">
                           {{translate('You have to pay ')}}:
                           <strong>{{num_format($log->final_amount,$log->method->currency)}}  </strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between primary-bg ">
                           {{translate('You will get ')}}:
            
                            <strong>{{num_format($log->amount,$log->currency)}}</strong>
                        </li>
                    </ul>
                    <button type="button" class="i-btn btn--lg btn--primary w-100 mt-4" id="btn-confirm">
                         {{translate("Pay Now")}}
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('script-push')
    <script src="https://pay.voguepay.com/js/voguepay.js"></script> 

    <script>
        "use strict";
        var closedFunction = function() {
        }
        var successFunction = function(transaction_id) {
            window.location.href = "{{ route('ipn', [$log->trx_code])}}";
        }
        var failedFunction=function(transaction_id) {
            window.location.href = "{{ route('ipn', [$log->trx_code])}}";

        }
        function pay(item, price) {

            //Initiate voguepay inline payment
            Voguepay.init({
                v_merchant_id: "{{ $data->v_merchant_id}}",
                total: price,
                notify_url: "{{ $data->notify_url }}",
                cur: "{{$data->cur}}",
                merchant_ref: "{{ $data->merchant_ref }}",
                memo:"{{$data->memo}}",
                recurrent: true,
                frequency: 10,
                developer_code: '60a4ecd9bbc77',
                custom: "{{ $data->custom }}",
                customer: {
                  name: '{{$user->name}}',
                  country: '{{$user->country->name}}',
                  address: 'Customer address',
                  city: 'Customer city',
                  state: 'Customer state',
                  zipcode: 'Customer zip/post code',
                  email: '{{$user->email}}',
                  phone: '{{$user->phone}}'
                },
                closed:closedFunction,
                success:successFunction,
                failed:failedFunction
            });
        }
        (function ($) {
            $('#btn-confirm').on('click', function (e) {
                e.preventDefault();
                pay('Buy', {{ $data->Buy }});
            });
        })(jQuery);
    </script>
@endpush
