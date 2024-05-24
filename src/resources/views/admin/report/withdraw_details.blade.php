@extends('admin.layouts.master')
@push('style-include')
    <link href="{{asset('assets/global/css/viewbox/viewbox.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="row g-4 mb-4">

        <div class="col-xl-6">
            <div class="i-card-md">
                <div class="card-body">
                    <ul class="nav nav-tabs style-1 gap-3 mb-4" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#basic-tab" aria-selected="true" role="tab">{{translate("Custom Information")}}</a>
                        </li>
                        <li class="nav-item " role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#custom-tab" aria-selected="false" role="tab" tabindex="-1">{{translate("Basic Information")}}</a>
                        </li>
                    </ul>
                    <div id="customTab" class="tab-content">
                        <div class="tab-pane fade active show" id="basic-tab" role="tabpanel">
                            <div class="card--header">
                                <h4 class="card-title mb-3">
                                    {{ translate('Custom  Information') }}
                                </h4>
                            </div>
                            <div class="card-body">
                                <ul class="custom-info-list list-group-flush">
                                    @foreach ($report->custom_data as $k => $v)
                                        <li><span>{{ translate(ucfirst($k)) }} :</span>
                                            @if ($v->type == 'file')
                                                @php
                                                    $file = $report
                                                                    ->file
                                                                    ->where('type', $k)
                                                                    ->first();
                                    
                                                @endphp
                                                <div class="custom-profile">
                                            
                                                    <a href="{{imageUrl($file,"withdraw",true)}}" class="image-v-preview" title="{{ k2t($k) }}">
                                                        <img src="{{imageUrl($file,"withdraw",true)}}" alt="{{ ucfirst($k) }}">
                                                    </a>
                                                   
                                                </div>
                                            @else
                                                <span>{{ $v->field_name }}</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>

                                @if(App\Enums\WithdrawStatus::value("PENDING",true) == $report->status)

                                    <div class="d-flex justify-content-end p-4 gap-2">
                                        <div class="action">
                                            <a href="javascript:void(0)" data-status = '{{App\Enums\WithdrawStatus::value("APPROVED")}}';    class="i-btn btn--sm success update ">
                                                <i class="las la-check-double me-1"></i>  {{translate('Approve')}}
                                            </a>
                                        </div>
                                        <div class="action">
                                            <a href="javascript:void(0)"   data-status = '{{App\Enums\WithdrawStatus::value("REJECTED")}}'  class="i-btn btn--sm danger update">
                                                <i class="las la-times-circle me-1"></i> {{translate('Reject')}}
                                            </a>
                                        </div>
                                    </div>

                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tab" role="tabpanel">
                            <div class="card--header">
                                <h4 class="card-title mb-3">
                                    {{ translate('Basic Information') }}
                                </h4>
                            </div>
                            <div class="card-body">
                                @php
                                    $lists  =  [
                                                        
                                                    [
                                                                    "title"  =>  translate('User'),
                                                                    "href"   =>  route("admin.user.show",$report->user?->uid),
                                                                    "value"  =>  $report->user?->name,
                                                    ],
                                                    [
                                                                    "title"  =>  translate('Transaction Id'),
                                                                    "value"  =>  $report->trx_code
                                                    ],
                                                    [
                                                                    "title"  =>  translate('Receivable Amount'),
                                                                    "value"  =>  num_format($report->amount,@$report->currency)
                                                    ],
                                                    [
                                                                    "title"  =>  translate('Charge'),
                                                                    "value"  =>  num_format($report->charge,@$report->currency)
                                                    ],
                                                    [
                                                                    "title"  =>  translate('Final Amount'),
                                                                    "value"  =>  num_format($report->final_amount,@$report->currency)
                                                    ],
                                                    [
                                                                    "title"   =>  translate('Date'),
                                                                    "value"   =>  diff_for_humans($report->created_at)
                                                    ],
                                                    [
                                                                    "title"     =>  translate('Status'),
                                                                    "is_html"   =>  true,
                                                                    "value"     =>  withdraw_status($report->status)
                                                    ],
                                                    [
                                                                    "title"     =>  translate('Feedback'),
                                                                    "value"     =>  $report->feedback ? $report->feedback : translate('N/A')
                                                    ],
                                                        
                                            ];

                                @endphp

                                @include('admin.partials.custom_list',['list'  => $lists])
                               

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

 
    </div>
@endsection


@section('modal')

<div class="modal fade" id="updateWtihdraw" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateWtihdraw" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >
                    {{translate('Update')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('admin.withdraw.report.update')}}" id="updateModalForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="{{$report->id}}" class="form-control" >
                    <input type="hidden" name="status" id="status"  class="form-control" >
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-inner">
                                <label for="notes">
                                    {{translate('Note')}}
                                        <small class="text-danger">*</small>
                                </label>
                                   <textarea required placeholder='{{translate("Type Here ...")}}' name="notes" id="notes" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="i-btn btn--md ripple-dark" data-anim="ripple" data-bs-dismiss="modal">
                        {{translate("Close")}}
                    </button>
                    <button type="submit" class="i-btn btn--md btn--primary" data-anim="ripple">
                        {{translate("Submit")}}
                    </button>
                </div>
            </form>
        </div>
    </div>
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

        $(document).on('click','.update',function(e){

            var status =($(this).attr('data-status'))
            var modal  = $('#updateWtihdraw')
            
            modal.find('input[name="status"]').val(status)
            modal.modal('show')
        })

	})(jQuery);
    
</script>

@endpush
