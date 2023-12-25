@extends('layouts.master')
@section('content')
    {{-- <section class="bg-light-1">
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
                                    src="{{imageUrl(config("settings")['file_path']['payment_method']['path']."/".@$log->method->file->name ,@$log->method->file->disk ) }}"
                                    class="card-img-top gateway-img rounded" >
                                </div>

                                <div class="col-md-7">
                                    <h4 class="mb-20">{{translate('Please Pay')}} {{round_amount($log->final_amount)}} {{$log->method->currency}}</h4>
                                    <button type="button" class="ig-btn btn--lg btn--primary w-100" id="btn-confirm"
                                            onClick="pay()">{{translate('Pay Now')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

@endsection


@push('script-push')
<script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
<script>
   "use strict";
    var btn = document.querySelector("#btn-confirm");
    btn.setAttribute("type", "button");
    const API_publicKey = "{{$data->API_publicKey ?? ''}}";

    function pay() {
        var x = getpaidSetup({
            PBFPubKey: API_publicKey,
            customer_email: "{{$data->customer_email ?? 'example@example.com'}}",
            amount: "{{ $data->amount ?? '0' }}",
            customer_phone: "{{ $data->customer_phone ?? '0123' }}",
            currency: "{{ $data->currency ?? 'USD' }}",
            txref: "{{ $data->txref ?? '' }}",
            onclose: function () {
            },
            callback: function (response) {
                let txref = response.tx.txRef;
                let status = response.tx.status;
                window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
            }
        });
    }
</script>
@endpush








