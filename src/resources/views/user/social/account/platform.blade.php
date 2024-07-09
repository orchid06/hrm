@extends('layouts.master')
@section('content')

    @php
        $user                   = auth_user('web');
        $subscription           = $user->runningSubscription;
        $accessPlatforms         = (array) ($subscription ? @$subscription->package->social_access->platform_access : []);

        $platforms = get_platform()
                        ->whereIn('id', $accessPlatforms )
                        ->where("status",App\Enums\StatusEnum::true->status())
                        ->where("is_integrated",App\Enums\StatusEnum::true->status());

    @endphp

        <div class="i-card mb-4 border mt-5">
            <h4 class="card--title mb-4">
                 {{translate('Platform List')}}
            </h4>
            <ul class="account-connect-list">
                @forelse ($platforms as $platform )
                        <li>
                            <button>
                                <span><img  src='{{imageUrl(@$platform->file,"platform",true)}}' alt="{{@$platform->file->name."jpg"}}"></span>{{$platform->name}}
                            </button>
                            <div class="button-group">
                                <a   href="{{route('user.social.account.create',['platform' => $platform->slug])}}" class="i-btn primary btn--sm capsuled">
                                    <i class="bi bi-plus-lg"></i>
                                    {{translate('Connect Account')}}
                                </a>
                            </div>
                        </li>
                @empty
                        <li class="text-center p-4">
                             <div class="no--access">
                               <P class="fs-20 text-danger">{{translate("You dont have any platform access")}}</P>
                             </div>
                        </li>
                @endforelse
            </ul>
        </div>

@endsection




@section('modal')
    @include('modal.delete_modal')

    <div class="modal fade" id="reconnect-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reconnect-modal"   aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{translate('Reconnect Account')}}
                    </h5>
                    <button class="close-btn" data-bs-dismiss="modal">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{route('user.social.account.reconnect')}}" id="platformForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input   hidden name="id" type="text">
                            <div class="col-lg-12" id ="accountConfig">
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
  "use strict";
   $(".user").select2({

    });


    $(document).on('click','.reconnect',function(e){

        var account        = JSON.parse($(this).attr('data-account'));
        var id             = account.id;

        var modal          = $('#reconnect-modal')
        modal.find('input[name="id"]').val(id)
        var html = "";

        html+= `<div class="form-inner">
                    <label for="token" class="form-label" >
                        {{translate('Access Token')}}  <span  class="text-danger">*</span>
                    </label>

                   <input value="${account.account_information.token}" required type="text" name="access_token">
                </div>`;
        $("#accountConfig").html(html)
        modal.modal('show')
    })

</script>
@endpush
