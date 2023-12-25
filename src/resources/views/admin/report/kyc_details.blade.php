@extends('admin.layouts.master')
@section('content')
    <div class="row g-4 mb-4">
        @php
           $col    = 6;
           if(is_array($report->kyc_data) && count($report->kyc_data) < 1){
              $col = 12;
           }
        @endphp

        <div class="col-xl-{{$col}}">
            <div class="i-card-md">
                <div class="card--header">
                    <h4 class="card-title">
                        {{ translate('Basic Information') }}
                    </h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item">{{ translate('User') }} : <a href='{{route("admin.user.show",$report->user->uid)}}'>
                        {{$report->user->name}}</a></li>
                        <li class="list-group-item">{{ translate('Date') }} : {{ diff_for_humans($report->created_at) }}
                        </li>
                        <li class="list-group-item">{{ translate('Status') }} :     @php echo   withdraw_status($report->status)  @endphp
                        </li>

                        <li class="list-group-item">{{ translate('Note') }} :
                            {{ $report->note ? $report->note : translate('N/A') }}</li>

                    </ul>
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
                            <ul class="list-group list-group-flush">

                                @foreach ($report->kyc_data as $k => $v)
                                    <li class="list-group-item">{{ translate(k2t($k)) }} :
                                        {{ $v }}
                                    </li>
                                @endforeach

                                @foreach ($report->file as $file)
                                    <li class="list-group-item">{{ translate(k2t($file->type)) }} :
                                        <img src='{{imageUrl($file,"kyc",true)}}'
                                        alt="{{ @$file->name }}">
                                    </li>
                                @endforeach

                            </ul>


                            @if(App\Enums\WithdrawStatus::value("PENDING",true) == $report->status)
                            
                                <div class="d-flex justify-content-center p-4 gap-2">

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


                 
                </div>

             
            @endif

    
    </div>
@endsection


@section('modal')

<div class="modal fade" id="updateKyc" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateKyc" aria-hidden="true">
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

            <form action="{{route('admin.kyc.report.update')}}" id="updateModalForm" method="post" enctype="multipart/form-data">
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


@push('script-push')
<script>
	(function($){

        $(document).on('click','.update',function(e){

            var status =($(this).attr('data-status'))
            var modal  = $('#updateKyc')
            
            modal.find('input[name="status"]').val(status)
            modal.modal('show')
        })

	})(jQuery);
</script>
@endpush
