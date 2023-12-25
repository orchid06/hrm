@extends('layouts.master')
@section('content')
    {{-- <section class="bg-light-1">
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
                                        <img src="{{imageUrl(config("settings")['file_path']['payment_method']['path']."/".@$log->method->file->name ,@$log->method->file->disk ) }}"
                                        class="card-img-top gateway-img rounded" >
                                </div>

                                <div class="col-md-7">
                                    <h4 class="mb-20">{{translate('Please Pay')}} {{round_amount($log->final_amount)}} {{$log->method->currency}}</h4>
                                    <form action="{{$data->url}}" method="{{$data->method}}" class="form">
                                        @csrf
                                        <script src="{{$data->checkout_js}}"
                                                @foreach($data->val as $key=>$value)
                                                    data-{{$key}}="{{$value}}"
                                            @endforeach >
                                        </script>
                                        <input type="hidden" custom="{{$data->custom}}" name="hidden">
                                    </form>
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

<script>
    "use strict";
    $(document).ready(function () {

        $('input[type="submit"]').addClass(" btn-custom");
    })
</script>

@endpush
