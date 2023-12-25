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
