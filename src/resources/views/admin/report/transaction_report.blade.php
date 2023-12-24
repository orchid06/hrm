@extends('admin.layouts.master')

@push('style-include')
    <link href="{{asset('assets/global/css/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')

    <div class="i-card-md">
        <div class="card-body">
            <div class="search-action-area">
                <div class="row g-4">

                    <form hidden id="bulkActionForm" action='{{route("admin.transaction.report.bulk")}}' method="post">
                        @csrf
                         <input type="hidden" name="bulk_id" id="bulkid">
                         <input type="hidden" name="value" id="value">
                         <input type="hidden" name="type" id="type">
                    </form>
             
                    @if(check_permission('delete_report') )
                        <div class="col-md-6 d-flex justify-content-start">
                     
                            <div class="i-dropdown bulk-action d-none">
                                <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="las la-cogs fs-15"></i>
                                </button>

                                <ul class="dropdown-menu">
                                    
                                    <li>
                                        <button data-message='{{translate("Are you sure you want to remove these record permanently?")}}' data-type ='{{request()->routeIs("admin.staff.recycle.list") ? "force_delete" :"delete"}}'   class="dropdown-item bulk-action-modal">
                                            {{translate("Delete")}}
                                        </button>
                                    </li>

                                </ul>

                            </div>
                
                        </div>
                    @endif
            
                    <div class="col-md-6 d-flex justify-content-end">

                    <div class="filter-wrapper">
                        <button class="i-btn btn--primary btn--sm filter-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="las la-filter"></i>
                        </button>
                        <div class="filter-dropdown">
                        <form action="{{route(Route::currentRouteName())}}" method="get">                        
                                <div class="form-inner">
                                    <input type="text" id="datePicker" name="date" value="{{request()->input('date')}}"  placeholder='{{translate("Filter by date")}}'>
                                </div>

                                <div class="form-inner">
                                    <select name="user" id="user" class="user">
                                        <option value="">
                                            {{translate('Select User')}}
                                        </option>
                                        @foreach(system_users() as $user)
                                            <option  {{Arr::get($user,"username",null) ==   request()->input('user') ? 'selected' :""}} value="{{Arr::get($user,"username",null)}}"> {{Arr::get($user,"name",null)}}
                                           </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-inner">
                                    <select name="trx_type" id="type" class="type">
                                        <option value="">
                                            {{translate('Select Trx type')}}
                                        </option>
                                        <option {{ App\Models\Transaction::$PLUS == request()->input('trx_type') ? 'selected' :""  }} value="{{App\Models\Transaction::$PLUS}}">{{translate("Plus")}}</option>
                                        <option {{ App\Models\Transaction::$MINUS == request()->input('trx_type') ? 'selected' :""  }} value="{{App\Models\Transaction::$MINUS}}">{{translate("Minus")}}</option>
                         
                                    </select>
                                </div>

                                <div class="form-inner">
                                    <input type="text"  name="search" value="{{request()->input('search')}}"  placeholder='{{translate("Search by transaction id or remarks")}}'>
                                </div>
                            

                                <button class="i-btn btn--sm info w-100">
                                    <i class="las la-sliders-h"></i>
                                </button>
                            </form>
                        </div>  
                    </div>
                    <div class="ms-3">
                        <a href="{{route(Route::currentRouteName())}}"  class="i-btn btn--sm danger">
                            <i class="las la-sync"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

            <div class="table-container position-relative">

                @include('admin.partials.loader')

                <table >
                    <thead>
                        <tr>
                            <th scope="col">
                                @if(check_permission('delete_report'))
                                   <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                                @endif#
                            </th>

                            <th scope="col">
                                {{translate('Date')}}
                            </th>

                            <th scope="col">
                                {{translate('User')}}
                            </th>

                            <th scope="col">
                                {{translate('Trx Code')}}
                            </th>

                            <th scope="col">
                                {{translate('Balance')}}
                            </th>

                            <th scope="col">
                                {{translate('Post Balance')}}
                            </th>

                            <th scope="col">
                                {{translate('Remark')}}
                            </th>
                
                            <th scope="col">
                                {{translate('Options')}}
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($reports as $report)
  
                                <tr>
                                    <td data-label="#">
                                        @if( check_permission('delete_report'))
                                          <input type="checkbox" value="{{$report->id}}" name="ids[]" class="data-checkbox form-check-input" id="{{$report->id}}" />
                                        @endif
                                        {{$loop->iteration}}
                                    </td>

                                    <td data-label='{{translate("Date")}}'>
                                        {{ get_date_time($report->created_at) }}
                                    </td>

                                    <td data-label='{{translate("User")}}'>
                                        <a href="{{route('admin.user.show',$report->user->uid)}}">
                                            {{$report->user->name}}
                                        </a>
                                    </td>
                                    
                                    <td  data-label='{{translate("Trx Code")}}'>
                                          {{$report->trx_code}}
                                    </td>

                                    <td  data-label='{{translate("Balance")}}'>
                                        <span class='text--{{$report->trx_type == App\Models\Transaction::$PLUS ? "success" :"danger" }}'>
                                            <i class='las la-{{$report->trx_type == App\Models\Transaction::$PLUS ? "plus" :"minus" }}'></i>

                                              {{num_format($report->amount,$report->currency)}}
                                          
                                        </span>
                                    </td>

                                    <td  data-label='{{translate("Post Balance")}}'>

                                        {{@num_format(
                                            number : $report->post_balance??0,
                                            calC   : true
                                        )}}
                               
                                    </td>

                                    <td  data-label='{{translate("Remark")}}'>
                                 
                                        {{k2t($report->remarks)}}
                         
                                    </td>

                                    <td data-label='{{translate("Options")}}'>
                                        <div class="table-action">

                                            <a href="javascript:void(0);" data-report="{{$report}}" class="pointer show-info icon-btn info">
                                                <i class="las la-info"></i></a>
                                            @if(check_permission('delete_report') )
                                                <a href="javascript:void(0);" data-href="{{route('admin.transaction.report.destroy',$report->id)}}" class="pointer delete-item icon-btn danger">
                                                <i class="las la-trash-alt"></i></a>
                                                   
                                            @else
                                                {{translate('N/A')}}
                                            @endif

                                        </div>
                                    </td>
                               </tr>
                         
                            @empty

                            <tr>
                                <td class="border-bottom-0" colspan="90">
                                    @include('admin.partials.not_found',['custom_message' => "No Reports found!!"])
                                </td>
                            </tr>
                        @endforelse
                 
                    </tbody>
                </table>
            </div>
            
      

            <div class="Paginations">

                    {{ $reports->links() }}
                
            </div>
        </div>
    </div>

@endsection
@section('modal')
    @include('modal.delete_modal')
    @include('modal.bulk_modal')

    <div class="modal fade" id="report-info" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="report-info"   aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{translate('Report Information')}}
                    </h5>
                    <button class="close-btn" data-bs-dismiss="modal">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="content">
                             
                            </div>

                        </div>

                    </div>
                </div>
                
            </div>
        </div>
    </div>

@endsection


@push('script-include')
   <script src="{{asset('assets/global/js/flatpickr.js')}}"></script>
@endpush

@push('script-push')
<script>
	(function($){

        "use strict";

        $(".select2").select2({
           
        });
        $(".user").select2({
           
        });
        $(".type").select2({
           
        });

        flatpickr("#datePicker", {
            dateFormat: "Y-m-d",
            mode: "range",
        });


        $(document).on('click','.show-info',function(e){

            var modal = $('#report-info');
           
            var report = JSON.parse($(this).attr('data-report'))

            $('.content').html(report.details)

            modal.modal('show')

        });

	})(jQuery);
</script>
@endpush





