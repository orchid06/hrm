@extends('layouts.master')

@push('style-include')
    <link href="{{asset('assets/global/css/viewbox/viewbox.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="row g-4 mb-4">
    @php
        $leaveRequestDataArray = $leave->leave_request_data ? (array) $leave->leave_request_data : [];
        $leaveRequestCount = count($leaveRequestDataArray);
        $col = ($leaveRequestCount < 1) ? 12 : 6;
    @endphp

<div class="col-xl-{{$col}}">
    <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">
                {{ translate('Basic Information') }}
            </h4>
        </div>
        <div class="card-body">
            @php
            $startDate = new DateTime($leave->start_date);
            $endDate = new DateTime($leave->end_date);
            $formattedDate = $startDate->format('Y-m-d') === $endDate->format('Y-m-d')
                            ? $startDate->format('M j')
                            : $startDate->format('M j') . ' - ' . $endDate->format('M j');


            $lists  =  [

                        [
                                        "title"   =>  translate('Date'),
                                        "value"   =>  diff_for_humans($leave->created_at)
                        ],
                        [
                                        "title"     =>  translate('Status'),
                                        "is_html"   =>  true,
                                        "value"     =>  leave_status($leave->status)
                        ],
                        [
                                        "title"     =>  translate('Leave Date'),
                                        "value"     =>  $formattedDate
                        ],
                        [
                                        "title"     =>  translate('Total Days'),
                                        "value"     =>  $leave->total_days
                        ],
                        [
                                        "title"     =>  translate('Note'),
                                        "value"     =>  $leave->note ?? translate('N/A')
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
                    {{ translate('Custom  Information') }}
                </h4>
            </div>
            <div class="card-body">
                <ul class="custom-info-list list-group-flush">

                    @foreach ($leave->leave_request_data as $k => $v)
                        <li>
                            <span>{{  translate(k2t($k)) }}:</span>
                            <span>
                                {{ $v }}
                            </span>

                        </li>
                    @endforeach

                    @foreach ($leave->file as $file)
                        <li>
                            <span>{{ translate(k2t($file->type)) }} :</span>
                            <div class="custom-profile">
                                <a href="{{imageURL($file,'leave_request_data',true)}}" class="image-v-preview">
                                        <img class="image-v-preview" src='{{imageURL($file,"leave_request_data",true)}}'
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
