@extends('layouts.master')
@section('content')

    <section class="bg-light-1">
        <div class="dashboard-content">
            <div class="container">
                <div class="row mt-110">
                    <div class="col-md-6 mx-auto">
                        <div class="box secbg border">
                            <div class="box-header">
                                <h4 >{{ 'Pay with '.optional($log->method)->name ?? '' }}</h4>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <img
                                    {{-- src="{{imageUrl(config("settings")['file_path']['payment_method']['path']."/".@$log->method->file->name ,@$log->method->file->disk ) }}" --}}
                                    class="card-img-top gateway-img rounded" >
                                </div>

                                <div class="col-md-7">
                                    <h4 class="mb-20">{{translate('Please Pay')}} {{round_amount($log->final_amount)}} {{$log->method->currency}}</h4>
                                    <form action="{{ route('ipn', [optional($log->method)->code ?? 'mercadopago', $log->transaction]) }}"
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
        </div>
    </section>

@endsection



