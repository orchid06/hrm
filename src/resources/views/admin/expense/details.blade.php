@extends('admin.layouts.master')
@push('style-include')
    <link href="{{asset('assets/global/css/viewbox/viewbox.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<div class="row g-4 mb-4">
    @php

        $col      = $expense->file->isEmpty() ? 12 : 6;
        $currency = session()->get('currency');

    @endphp
    <div class="col-xl-{{$col}}">
        <div class="i-card-md">
            <div class="card--header">
                <h4 class="card-title">
                    {{ translate('Expense Information') }}
                </h4>
            </div>
            <div class="card-body">
                @php

                    $lists  =  [

                                [
                                                "title"   =>  translate('Date'),
                                                "value"   =>  $expense->created_at->format('d F Y'),
                                ],
                                [
                                                "title"  =>  translate('Category'),
                                                "value"  =>  $expense->category?->name,
                                ],

                                [
                                                "title"     =>  translate('Amount'),
                                                "value"     =>  num_format($expense->amount, $currency),
                                ],

                                [
                                                "title"     =>  translate('Details'),
                                                "value"     =>  $expense->description ?? translate('N/A')
                                ],

                    ];

                @endphp
                @include('admin.partials.custom_list',['list'  => $lists])
            </div>

        </div>
    </div>

    @if ($col == 6)
    <div class="col-xl-6 col-lg-6 col-md-6">
        <div class="i-card-md">
            <div class="card--header">
                <h4 class="card-title">
                    {{ translate('Images') }}
                </h4>
            </div>
            <div class="card-body">
                <ul class="custom-info-list list-group-flush">

                    @foreach ($expense->file as $file)
                        <li>
                            <span></span>
                            <div class="custom-profile">
                                <a href="{{imageURL($file,'expense_data',true)}}" class="image-v-preview">
                                        <img class="image-v-preview" src='{{imageURL($file,"expense_data",true)}}'
                                        alt="{{ @$file->name }}">
                                </a>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

@section('modal')
@include('modal.delete_modal')
@include('modal.bulk_modal')
@endsection

@push('script-include')
<script src="{{asset('assets/global/js/viewbox/jquery.viewbox.min.js')}}"></script>
@endpush

@push('script-push')
<script>
    (function($){

    "use strict";

    $('.image-v-preview').viewbox();

    })(jQuery);
</script>
@endpush
