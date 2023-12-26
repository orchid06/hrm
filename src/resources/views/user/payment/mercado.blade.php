@extends('layouts.master')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="i-card-md ">
                <div class="card-header">
                    <h4 class="card-title">
                        {{@$log->method->name}}
                   </h4>
                
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                       
                        <div class="col-md-7">
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
                            <form action="{{ route('ipn', [$log->trx_code]) }}"
                                method="POST">
                                @csrf
                                <script
                                    src="https://www.mercadopago.com.co/integrations/v1/web-payment-checkout.js"
                                    data-preference-id="{{ $data->preference }}">
                                </script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



