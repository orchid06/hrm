@extends('layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10">
            <div class="i-card-md">
                <div class="card-header">
                    <h4 class="card-title">
                        {{@$log->method->name}}
                   </h4>
                </div>

                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <ul class="payment-details list-group">
                                <li class="list-group-item">
                                    <p>
                                        {{translate('You have to pay ')}}:
                                    </p>

                                   <h6>{{num_format($log->final_amount,$log->method->currency)}}  </h6>
                                </li>
                                <li class="list-group-item">
                                    <p>
                                        {{translate('You will get ')}}:
                                    </p>

                                    <h6>{{num_format($log->amount,$log->currency)}}</h6>
                                </li>
                            </ul>

                            <form action="{{$data->url}}" method="{{$data->method}}" class="form">
                                @csrf
                                <script
                                    src="{{$data->src}}"
                                    class="stripe-button"
                                    @foreach( $data->val as $key => $value )
                                        data-{{$key}}="{{$value}}"
                                    @endforeach>
                                </script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('script-push')

<script>
    "use strict";
     $(document).ready(function () {
       $('button[type="submit"]').removeClass("stripe-button-el").addClass("i-btn btn--lg btn--primary w-100 mt-4").find('span').css('min-height', 'initial');
     })
</script>
@endpush
