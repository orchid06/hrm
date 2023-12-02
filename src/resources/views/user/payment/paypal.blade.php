@extends('layouts.master')
@section('content')
    <section class="bg-light-1">
        <div class="container">
            <div class="dashboard-content">
                <div class="row pt-110">
                    <div class="col-lg-7 mx-auto">
                        <div class="box secbg">
                            <div class="box-body text-center">
                                <div id="paypal-button-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('script-push')

<script src="https://www.paypal.com/sdk/js?client-id={{$data->cleint_id}}">
</script>
<script>
    paypal.Buttons({
        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [
                    {
                        description: "{{ $data->description }}",
                        custom_id: "{{$data->custom_id}}",
                        amount: {
                            currency_code: "{{$data->currency}}",
                            value: "{{$data->amount}}",
                            breakdown: {
                                item_total: {
                                    currency_code: "{{$data->currency}}",
                                    value: "{{$data->amount}}"
                                }
                            }
                        }
                    }
                ]
            });
        },
        onApprove: function (data, actions) {
            return actions.order.capture().then(function (details) {
                var trx = "{{$data->custom_id}}";
                window.location = '{{ url('ipn/paypal')}}/' + trx + '/' + details.id

            });
        }
    }).render('#paypal-button-container');
</script>
@endpush
