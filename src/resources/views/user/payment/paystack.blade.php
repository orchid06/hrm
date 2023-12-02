@extends('layouts.master')
@section('content')
    <section class="bg-light-1">
        <div class="dashboard-content">
            <div class="container">
                <div class="row mt-110">
                    <div class="col-md-6 mx-auto">
                        <div class="box secbg border">
                            <div class="box-header">
                                <h4 > {{ 'Pay with '.optional($log->method)->name ?? '' }}</h4>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-md-5">
                                        {{-- <img src="{{imageUrl(config("settings")['file_path']['payment_method']['path']."/".@$log->method->file->name ,@$log->method->file->disk ) }}"
                                            class="card-img-top gateway-img rounded" > --}}
                                </div>

                                <div class="col-md-7">
                                        <h4 class="mb-20">{{translate('Please Pay')}} {{round_amount($log->final_amount)}} {{$log->method->currency}}</h4>
                                        <button type="button"
                                                class="btn-custom ig-btn btn--lg btn--primary w-100"
                                                id="btn-confirm">{{translate('Pay Now')}}
                                        </button>
                                        <form action="{{ route('ipn', [optional($log->method)->code, $log->transaction]) }}" method="POST" class="form">
                                            @csrf
                                            <script
                                                src="//js.paystack.co/v1/inline.js"
                                                data-key="{{ $data->key }}"
                                                data-email="{{ $data->email }}"
                                                data-amount="{{$data->amount}}"
                                                data-currency="{{$data->currency}}"
                                                data-ref="{{ $data->ref }}"
                                                data-custom-button="btn-confirm">
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


