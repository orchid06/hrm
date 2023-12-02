@extends('admin.layouts.master')

@push('style-include')
    <link href="{{asset('assets/global/css/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')

    <div class="i-card-md">

        <div class="card-body">
            <div class="search-action-area">
                <div class="row g-4">


                    <div class="col-md-12 d-flex justify-content-md-end justify-content-start">
                        <div class="search-area">
                            <form action="{{route(Route::currentRouteName())}}" method="get">

                        
                                <div class="form-inner">
                                    <input type="text" id="datePicker" name="date" value="{{request()->input('date')}}"  placeholder="{{translate("Filter by date")}}">
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
                                    <input type="text"  name="search" value="{{request()->input('search')}}"  placeholder="{{translate("Search by transaction id")}}">
                                </div>
                            

                                <button class="i-btn btn--sm info">
                                    <i class="las la-sliders-h"></i>
                                </button>
                                <a href="{{route(Route::currentRouteName())}}"  class="i-btn btn--sm danger">
                                    <i class="las la-sync"></i>
                                </a>
                            </form>
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
                                #
                            </th>

                            <th scope="col">
                                {{translate('Date')}}
                            </th>

                            <th scope="col">
                                {{translate('Trx Code')}}
                            </th>
                            <th scope="col">
                                {{translate('User')}}
                            </th>

                            <th scope="col">
                                {{translate('Reffer User')}}
                            </th>

                            <th scope="col">
                                {{translate('Subscription Package')}}
                            </th>

                            <th scope="col">
                                {{translate('Commission Rate')}}
                            </th>

                            <th scope="col">
                                {{translate('Amount')}}
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
                                        {{$loop->iteration}}
                                    </td>

                                    <td data-label="{{translate("Date")}}">
                                        {{ get_date_time($report->created_at) }}
                                    </td>
                                    <td data-label="{{translate("Trx Code ")}}">
                                        {{ ($report->trx_code) }}
                                    </td>

                                    <td data-label="{{translate("User")}}">
                                        <a href="{{route('admin.user.show',$report->user->uid)}}">
                                            {{$report->user->name}}
                                        </a>
                                    </td>


                                    <td data-label="{{translate("Reffered To")}}">
                                        @if($report->referral)
                                            <a href="{{route('admin.user.show',$report->referral->uid)}}">
                                                {{$report->referral->name}}
                                            </a>
                                        @else
                                             {{translate('N/A')}}
                                        @endif
                                    </td>
                                
                                    <td data-label="{{translate("Subscription Package")}}">
                                          {{$report->subscription? @$report->subscription->package->title  : 'N/a'}}
                                    </td>
                                    <td data-label="{{translate("Commission Rate")}}">
                                          {{$report->commission_rate}}%
                                    </td>
                                    <td data-label="{{translate("Amount")}}">
                                        {{@num_format(
                                            number : $report->commission_amount??0,
                                            calC   : true
                                        )}}
                                    </td>
                                
                                    <td data-label="{{translate("Options")}}">
                                        <div class="table-action">

                                            <a href="javascript:void(0);" data-report="{{$report}}" class="pointer show-info icon-btn info">
                                                <i class="las la-info"></i></a>
                                        </div>
                                    </td>
                               </tr>
                         
                            @empty

                            <tr>
                                <td class="border-bottom-0" colspan="100">
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

            $('.content').html(report.note)

            modal.modal('show')

        });

	})(jQuery);
</script>
@endpush





