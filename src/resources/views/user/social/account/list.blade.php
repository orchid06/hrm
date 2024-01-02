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
    <div class="row g-4">
        <div class="col-xxl-3 col-lg-4">
            <div class="i-card-md">
                <div class="card-body px-0">
                    <div class="basic-setting-left sticky-side-div">
                        <div class="setting-tab">
                            <ul class="nav nav-tabs social-account-list border-0" role="tablist">
                                @forelse ($platforms as $platform )
                                    @if($platform->status == App\Enums\StatusEnum::true->status()  && $platform->is_integrated == App\Enums\StatusEnum::true->status() )
                                        <li class="nav-item">
                                            <a class="nav-link {{$platform->slug == request()->input("platform") ? "active" :""}}"  href="{{route('user.social.account.list',['platform' => $platform->slug])}}" >
                                                <div class="user-meta-info d-flex align-items-center gap-2">
                                                    <img class="rounded-circle avatar-sm" src='{{imageUrl(@$platform->file,"platform",true)}}' alt="{{@$platform->file->name}}">

                                                    <p>	 {{$platform->name}}</p>
                                                </div>
                                            </a>
                                        </li>
                                    @endif
                                @empty
                                   <li class="text-center p-4">
                                      {{translate("No Active Platform found")}}
                                   </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-9 col-lg-8">
            <div class="basic-setting-right">
                <div class="i-card-md">
                    {{-- <div class="card-header">
                        <h4 class="card-title">
                            {{translate(Arr::get($meta_data, 'title'))}}
                        </h4>
                    </div> --}}

                    <div class="card-body px-0 pt-0">
                        @if(request()->input("platform"))
                            {{-- <div class="d-flex align-items-center justify-content-between px-4 pb-4">
                                    <a href="{{route('user.social.account.create',['platform' => request()->input('platform')])}}" class="i-btn primary btn--sm capsuled create">
                                        <i class="bi bi-plus-lg"></i>  {{translate('Add New')}}
                                    </a>

                                    <form action="">
                                        <div class="form-inner " >
                                            <input  id="" type="text"    placeholder='{{translate("Search")}}'
                                                >
                                        </div>
                                    </form>
                            </div> --}}

                            <div class="search-action-area mb-4">
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <a href="{{route('user.social.account.create',['platform' => request()->input('platform')])}}" class="i-btn primary btn--lg rounded create">
                                        <i class="bi bi-plus-lg"></i>  {{translate('Add New')}}
                                       </a>

                                    </div>

                                    <div class="col-xl-5 offset-xl-3 col-md-8">
                                        <div class="search-area">
                                            <form action="#" method="get">

                                                <div class="form-inner">
                                                    <input type="text" id="datePicker" name="date" value="" placeholder="Filter By Date" class="flatpickr-input" readonly="readonly">
                                                </div>

                                                <div class="d-flex gap-2">
                                                    <button class="i-btn primary btn--lg rounded">
                                                        <i class="bi bi-search"></i>
                                                    </button>
                                                    <a href="#" class="i-btn danger btn--lg rounded">
                                                        <i class="bi bi-arrow-repeat"></i>
                                                    </a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-container">
                                <table>
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                            #
                                            </th>
                                            <th scope="col">{{translate('Account Info')}}</th>

                                            <th scope="col">{{translate('Status')}}</th>

                                            <th scope="col">{{translate('Connection Status')}}</th>

                                            <th scope="col">{{translate('Connection Type')}}</th>

                                            <th scope="col">{{translate('Account Type')}}</th>


                                            <th scope="col">{{translate('Action')}}</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($accounts as $account)
                                            <tr>
                                                <td data-label="#">

                                                    {{$loop->iteration}}
                                                </td>

                                                <td data-label='{{translate("name")}}'>

                                                    <div class="user-meta-info d-flex align-items-center gap-2">
                                                        <img class="rounded-circle avatar-sm"  src='{{@$account->account_information->avatar }}' alt="{{@$account->account_information->avatar}}">

                                                        @if(@$account->account_information->link)
                                                            <a target="_blank" href="{{@$account->account_information->link}}">
                                                                <p>	{{ @$account->account_information->name}}</p>
                                                            </a>
                                                        @else
                                                            <p>	{{ @$account->account_information->name}}</p>
                                                        @endif

                                                    </div>
                                                </td>


                                                <td data-label='{{translate("Status")}}'>

                                                    <div class="form-check form-switch switch-center">
                                                        <input {{!check_permission('update_account') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                                            data-column="status"
                                                            data-route="{{ route('user.social.account.update.status') }}"
                                                            data-status="{{ $account->status == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                                            data-id="{{$account->uid}}" {{$account->status ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                                        id="status-switch-{{$account->id}}" >
                                                        <label class="form-check-label" for="status-switch-{{$account->id}}"> </label>

                                                    </div>

                                                </td>

                                                <td data-label='{{translate("Connection Status")}}'>

                                                    @php echo account_connection_status($account->is_connected) @endphp
                                               </td>

                                                <td data-label='{{translate("Connection Type")}}'>

                                                    @php echo account_connection($account->is_official) @endphp
                                               </td>

                                                <td data-label='{{translate("Account Type")}}'>

                                                    @php echo account_type($account->account_type) @endphp
                                               </td>

                                                <td data-label='{{translate("Action")}}'>
                                                    <div class="table-action">
                                                        @php
                                                                $platforms           = Arr::get(config('settings'),'platforms' ,[]);
                                                                $platformConfig      = Arr::get($platforms,$account->platform->slug ,null);

                                                        @endphp

                                                        @if($account->is_connected ==  App\Enums\StatusEnum::false->status() && $account->platform->slug != 'twitter' )
                                                            @php

                                                              $url          = 'javascript:void(0)';
                                                              $connectionClass  =   true;
                                                              if($account->platform->slug != 'facebook'){
                                                                  $url = route("account.connect",[ "guard"=>"web","medium" => $account->platform->slug ,"type" => t2k(App\Enums\AccountType::Profile->name) ]);
                                                                  $connectionClass  =   false;

                                                              }

                                                            @endphp
                                                            <a data-account = "{{$account}}"; title="{{translate("Recnonect")}}"  href="{{$url}}" class=" {{$connectionClass ? "reconnect" : ""}}  icon-btn icon-btn-sm danger"><i class="bi bi-plug"></i>
                                                            </a>
                                                         @endif

                                                        @if(isset($platformConfig['view_option']) && $account->is_official == App\Enums\ConnectionType::OFFICIAL->value  )
                                                                <a  title="{{translate("Show")}}"  href="{{route('user.social.account.show',["uid" => $account->uid])}}" class="icon-btn icon-btn-sm  success"><i class="bi bi-eye"></i>
                                                                </a>
                                                        @endif
                                                        @if(check_permission('delete_account') )

                                                            <a title="{{translate("Delete")}}" href="javascript:void(0);"    data-href="{{route('user.social.account.destroy',  $account->id)}}" class="icon-btn icon-btn-sm danger delete-item">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        @else
                                                            {{translate('N/A')}}
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="border-bottom-0" colspan="90">
                                                    @include('admin.partials.not_found')
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>


                                </table>
                            </div>

                            <div class="Paginations">
                                {{ $accounts->links() }}
                            </div>
                        @else
                            <div class="text-center">
                                {{translate("No Active Platform Selected")}}
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
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