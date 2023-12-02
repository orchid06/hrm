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
                                    <select name="package" id="package" class="package">
                                        <option value="">
                                            {{translate('Select Package')}}
                                        </option>
                                        @foreach($packages as $package)
                                           <option  {{$package->slug ==  request()->input('package') ? 'selected' :""}}
                                             value="{{$package->slug}}"> {{$package->title}}
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
                                {{translate('Trx Code')}}
                            </th>

                            <th scope="col">
                                {{translate('Expired In')}}
                            </th>

                            <th scope="col">
                                {{translate('User')}}
                            </th>

                            <th scope="col">
                                {{translate('Package')}}
                            </th>

                            <th scope="col">
                                {{translate('Status')}}
                            </th>
                            <th scope="col">
                                {{translate('Paid Amount')}}
                            </th>
                            <th scope="col">
                                {{translate('Date')}}
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

                                    <td  data-label="{{translate("Trx Code")}}">
                                        {{$report->trx_code}}
                                    </td>

                                    <td data-label="{{translate("Expired In")}}">
                                        @if($report->expired_at)
                                           {{ get_date_time($report->expired_at) }}
                                        @else
                                            {{translate("N/A")}}
                                        @endif
                                    </td>

                                    <td data-label="{{translate("User")}}">
                                        <a href="{{route('admin.user.show',$report->user->uid)}}">
                                            {{$report->user->name}}
                                        </a>
                                    </td>

                                    <td data-label="{{translate("Package")}}">
                                         {{@$report->package->title}}
                                    </td>

                                    <td data-label="{{translate("Status")}}">
                                         @php echo subscription_status($report->status) @endphp
                                    </td>

                                    <td data-label="{{translate("Payment Info")}}">
                                        {{@num_format(
                                            number : $report->payment_amount??0,
                                            calC   : true
                                        )}}
                                    </td>

                                    <td data-label="{{translate("Date")}}">
                                        @if($report->created_at)
                                           {{ get_date_time($report->created_at) }}
                                        @else
                                            {{translate("N/A")}}
                                        @endif
                                    </td>

                                    <td data-label="{{translate("Options")}}">
                                        <div class="table-action">

                                            @php
                                                $informations = [

                                                    "Ai Word Balnace"          => $report->word_balance,
                                                    "Remaining Word Balance"   => $report->remaining_word_balance,
                                                    "Carried Word Balnace"     => $report->carried_word_balance,

                                                    "Total Social Profile"     => $report->total_profile,
                                                    "Carried Profile Balnace"  => $report->carried_profile,

                                                    "Social Post Balnace"      => $report->post_balance,
                                                    "Remaining Post Balance"   => $report->carried_post_balance,
                                                    "Carried Post Balnace"     => $report->remaining_post_balance,
                                                ];
                                            @endphp

                                            <a href="javascript:void(0);" data-remarks="{{$report->remarks}}" data-info ="{{collect($informations)}}"  class="pointer show-info icon-btn info">
                                                <i class="las la-info"></i></a>

                                            <a data-toggle="tooltip" data-placement="top" title="{{translate("Update")}}"  href="javascript:void(0);" data-report ="{{$report}}" class="update fs-15 icon-btn warning"><i class="las la-pen"></i></a>
                                    
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


    <div class="modal fade" id="report-info" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="report-info"   aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{translate('Subscription Information')}}
                    </h5>
                    <button class="close-btn" data-bs-dismiss="modal">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="form-inner">
                                <label for="content" class="form-label" >
                                    {{translate('Note')}} 
                                </label>

                                <textarea disabled name="content" id="content" cols="30" rows="4"></textarea>
                                
                            </div>

                        </div>
                        <div class="col-lg-12">

                            <ul class="list-group list-group-flush" id="additionalInfo">
                                
                            </ul>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="i-btn btn--md ripple-dark btn--danger" anim="ripple" data-bs-dismiss="modal">
                        {{translate("Close")}}
                    </button>
                    
                </div>
                
            </div>
        </div>
    </div>



    <div class="modal fade" id="updatesubscription" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updatesubscription" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >
                        {{translate('Update Subscription')}}
                    </h5>
                    <button class="close-btn" data-bs-dismiss="modal">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form action="{{route('admin.subscription.report.update')}}" id="updateModalForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id" class="form-control" >

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="Status">
                                        {{translate('Status')}}   <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" name="status"  id="Status">

                                        @foreach ( App\Enums\SubscriptionStatus::toArray() as $k => $v )

                                           <option value="{{$v}}">{{$k}}</option>
                                            
                                        @endforeach

                                    </select>

                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="expired_at">
                                        {{translate('Expire Date')}} <span class="text-danger">*
                                            </span>
                                    </label>
                                    <input type="date" required name="expired_at" id="expired_at" placeholder="{{translate("Enter Date")}}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-inner">
                                    <label for="remarks">
                                        {{translate('Remarks')}}
                                            <small class="text-danger">*</small>
                                    </label>
                                       <textarea required placeholder="{{translate("Type Here ...")}}" name="remarks" id="remarks" cols="30" rows="5"></textarea>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="i-btn btn--md ripple-dark" anim="ripple" data-bs-dismiss="modal">
                            {{translate("Close")}}
                        </button>
                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                            {{translate("Submit")}}
                        </button>
                    </div>
                </form>
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
        $(".package").select2({
           
        });

        flatpickr("#datePicker", {
            dateFormat: "Y-m-d",
            mode: "range",
        });

        flatpickr("#expired_at", {
            dateFormat: "Y-m-d",

        });


        $(document).on('click','.show-info',function(e){

            var modal = $('#report-info');
           
            var remark = ($(this).attr('data-remarks'))
            var infos  = JSON.parse($(this).attr('data-info'));
            console.log(infos)

            $('#content').html(remark)
            var lists = "";
            for(var i in infos ){
                lists +=`<li class="list-group-item">${i.charAt(0).toUpperCase() + i.slice(1).replace('_', ' ')} : ${infos[i]}</li>`
            }
            $("#additionalInfo").html(lists);

            modal.modal('show')

        });


        $(document).on('click','.update',function(e){

            var subscription = JSON.parse($(this).attr('data-report'))
            var modal = $('#updatesubscription')
            modal.find('input[name="id"]').val(subscription.id)
            modal.find('input[name="expired_at"]').val(subscription.expired_at)
            modal.find('textarea[name="remarks"]').html(subscription.remarks)
            modal.find('select[name="status"]').val(subscription.status)
            modal.modal('show')
        })

	})(jQuery);
</script>
@endpush





