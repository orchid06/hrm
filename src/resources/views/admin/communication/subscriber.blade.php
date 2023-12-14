
@extends('admin.layouts.master')
@section('content')
    <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">
                {{translate('Subscriber List')}}
            </h4>
        </div>
        <div class="card-body">
            <div class="search-action-area">
                <div class="row g-4">
                    <form hidden id="bulkActionForm" action="{{route("admin.subscriber.bulk")}}" method="post">
                        @csrf
                         <input type="hidden" name="bulk_id" id="bulkid">
                         <input type="hidden" name="value" id="value">
                         <input type="hidden" name="type" id="type">
                    </form>
                    @if(check_permission('create_subscriber') || check_permission('update_subscriber') || check_permission('delete_subscriber'))
                        <div class="col-md-4 d-flex justify-content-start">
                            @if(check_permission('update_subscriber') || check_permission('delete_subscriber'))
                                <div class="i-dropdown bulk-action d-none">
                                    <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="las la-cogs fs-15"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if(check_permission('update_subscriber'))
                                            <li>
                                                <button  id="deleteModal" class="dropdown-item">
                                                    {{translate("Delete")}}
                                                </button>
                                            </li>
                                        @endif
                                        @if(request()->routeIs('admin.subscriber.archive'))
                                            <li>
                                                <button class="dropdown-item" id="bulkActionBtn" data-type ="restore">
                                                    {{translate("Restore")}}
                                                </button>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endif
                    @if(request()->routeIs('admin.subscriber.list'))
                        <div class="action ms-3">
                            <a href="{{route('admin.subscriber.archive')}}" class="i-btn btn--sm btn--success">
                                {{translate('Show Archive subscriber')}}
                            </a>
                        </div>
                    @else
                        <div class="action ms-3">
                            <a href="{{route('admin.subscriber.list')}}" class="i-btn btn--sm btn--success">
                                {{translate('Show subscriber List')}}
                            </a>
                        </div>
                    @endif
                </div>
                <div class=" d-flex justify-content-md-end justify-content-start">
                    <div class="search-area">
                        <form action="{{route(Route::currentRouteName())}}" method="get">

                            <div class="form-inner">
                                    <input name="email" value="{{request()->email}}" type="search" placeholder="{{translate('Search By Email')}}">

                            </div>

                            <button class="i-btn btn--sm info">
                                <i class="las la-sliders-h"></i>
                            </button>
                            <a href="{{route('admin.subscriber.list')}}"  class="i-btn btn--sm danger">
                                <i class="las la-sync"></i>
                            </a>
                        </form>
                    </div>
                </div>
            </div>


            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">
                                @if(check_permission('create_subscriber') || check_permission('update_subscriber') || check_permission('delete_subscriber'))
                                    <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                                @endif#
                            </th>
                            <th scope="col">
                                {{translate('Email')}}
                            </th>
                            <th scope="col">
                                {{translate('Subscribe At')}}
                            </th>

                            <th scope="col">
                                {{translate('Options')}}
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($subscribers->chunk(site_settings('chunk_value')) as $chunkSubscribers)
                            @foreach($subscribers as $subscriber)
                                <tr>
                                <td data-label="#">
                                    @if(check_permission('create_subscriber') || check_permission('update_subscriber') || check_permission('delete_subscriber'))
                                        <input type="checkbox" value="{{$subscriber->id}}" name="ids[]" class="data-checkbox form-check-input" id="{{$subscriber->id}}" />
                                    @endif
                                    {{$loop->iteration}}
                                </td>
                                <td data-label="{{translate("Email")}}">
                                     {{$subscriber->email}}
                                </td>
                                <td data-label="{{translate("Subscribe At")}}">
                                    {{diff_for_humans($subscriber->created_at)}}
                                </td>


                                <td data-label="{{translate("Options")}}">
                                    <div class="table-action">

                                        @if(check_permission('update_frontend'))

                                            <a  href="javascript:void(0);" data-email="{{$subscriber->email}}"  class="sendMail fs-15 icon-btn info"><i class="las la-paper-plane"></i></a>
                                            @if(request()->routeIs('admin.subscriber.list'))
                                                <a href="javascript:void(0);" data-href="{{route('admin.subscriber.destroy',$subscriber->uid)}}" class="delete-item icon-btn danger">
                                                    <i class="las la-trash-alt"></i></a>
                                            @else
                                                <form action="{{route('admin.subscriber.force.destroy',$subscriber->id)}}" method="get" enctype="multipart/form-data">
                                                    @csrf
                                                    <button class=" pointer icon-btn danger" id="deleteModal"><i class="las la-trash-alt"></i></button>
                                                </form>
                                                <form action="{{route('admin.subscriber.restore',$subscriber->id)}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <button class="pointer icon-btn success"><i class="las la-trash-restore-alt"></i></button>
                                                </form>
                                            @endif


                                        @else
                                            {{translate('N/A')}}
                                        @endif

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td class="border-bottom-0" colspan="100">
                                    @include('admin.partials.not_found')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="Paginations">
            
                {{ $subscribers->links() }}
                
            </div>
        </div>
    </div>

@endsection

@section('modal')

    <!-- send mail modal -->
    <div class="modal fade" id="sendMailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-icon" >
                        {{translate('Send Mail')}}
                    </h5>
                    <button class="close-btn" data-bs-dismiss="modal">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form action="{{route('admin.send.mail')}}" id="updateModalForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="email" id="email" class="form-control" >
                        <div class="row">

                            <div class="col-12">
                                <div class="form-inner">
                                    <label for="message">
                                        {{translate('Message')}}
                                            <small class="text-danger">*</small>
                                    </label>
                                    <textarea required placeholder="{{translate('Type Here')}}" name="message"  cols="30" rows="5">{{old("message")}}</textarea>
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
    "use strict";

    $(document).on('click','.sendMail',function(e){
        var email = $(this).attr('data-email')
        var modal = $('#sendMailModal')
        modal.find('input[name="email"]').val(email)
        modal.modal('show')
    })

	})(jQuery);
</script>
@endpush





