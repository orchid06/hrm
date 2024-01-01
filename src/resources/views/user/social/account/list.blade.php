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


    <div class="basic-setting">

        <div class="basic-setting-left">
            <div class="setting-tab sticky-side-div">
                <ul class="nav nav-tabs gap-4 social-account-list" role="tablist">
                    @forelse ($platforms as $platform )
                        @if($platform->status == App\Enums\StatusEnum::true->status()  && $platform->is_integrated == App\Enums\StatusEnum::true->status() )
                            <li class="d-flex justify-content-between align-items-center gap-3 px-3">
                                <a class="nav-link border-0 flex-grow-1 p-0 {{$platform->slug == request()->input("platform") ? "active" :""}}"  href="{{route('user.social.account.list',['platform' => $platform->slug])}}" >
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

        <div class="basic-setting-right">
             
               
            <div class="i-card-md">

                <div class="card-body">
                    @if(request()->input("platform"))
                        <div class="search-action-area">
                            <div class="row g-3">
                 
            
                                <div class="col-md-6 d-flex justify-content-start">
                      
                    
                                    <a href="{{route('user.social.account.create',['platform' => request()->input('platform')])}}" class="i-btn btn--sm success me-2 create">
                                        <i class="bi bi-plus me-1"></i>  {{translate('Add New')}}
                                    </a>
                            
                                    
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
                                                        <a data-account = "{{$account}}"; title="{{translate("Recnonect")}}"  href="{{$url}}" class=" {{$connectionClass ? "reconnect" : ""}}  fs-15 icon-btn danger"><i class="bi bi-plug"></i>
                                                        </a>
                                                     @endif
        
                                                    @if(isset($platformConfig['view_option']) && $account->is_official == App\Enums\ConnectionType::OFFICIAL->value  )
                                                            <a  title="{{translate("Show")}}"  href="{{route('user.social.account.show',["uid" => $account->uid])}}" class="fs-15 icon-btn success"><i class="bi bi-eye"></i>
                                                            </a>
                                                    @endif
                                                    @if(check_permission('delete_account') )

                                                        <a title="{{translate("Delete")}}" href="javascript:void(0);"    data-href="{{route('user.social.account.destroy',  $account->id)}}" class="pointer delete-item icon-btn danger">
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
