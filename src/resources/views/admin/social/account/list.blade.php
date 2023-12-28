@extends('admin.layouts.master')

@section('content')


   
    @php
        
        $platforms = get_platform()
                        ->where("status",App\Enums\StatusEnum::true->status())
                        ->where("is_integrated",App\Enums\StatusEnum::true->status());
    
    @endphp


    <div class="basic-setting">

        <div class="basic-setting-left">
            <div class="setting-tab sticky-side-div">

                <ul class="nav nav-tabs" role="tablist">
        
                    @forelse ($platforms as $platform )

                        @if($platform->status == App\Enums\StatusEnum::true->status()  && $platform->is_integrated == App\Enums\StatusEnum::true->status() )
                         

                            <li class="alert border fade show alert-with-icon pointer  moveable-section">
                                <a class="nav-link {{$platform->slug == request()->input("platform") ? "active" :""}}"  href="{{route('admin.social.account.list',['platform' => $platform->slug])}}" >
                                 
                                    <div class="user-meta-info d-flex align-items-center gap-2">
                                        <img class="rounded-circle avatar-sm" src='{{imageUrl(@$platform->file,"platform",true)}}' alt="{{@$platform->file->name}}">

                                        <p>	 {{$platform->name}}</p>
                                    </div>
                                </a>
                             
                                <a  data-callback="{{route('account.callback',$platform->slug)}}" href="javascript:void(0);" data-id="{{$platform->id}}"  data-config = "{{collect($platform->configuration)}}" class="update-config fs-15 icon-btn danger"><i class="las la-tools"></i>
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
                            <div class="row g-4">
                                <form hidden id="bulkActionForm" action='{{route("admin.social.account.bulk")}}' method="post">
                                    @csrf
                                    <input type="hidden" name="bulk_id" id="bulkid">
                                    <input type="hidden" name="value" id="value">
                                    <input type="hidden" name="type" id="type">
                                </form>
                                @if(check_permission('create_account') || check_permission('update_account') || check_permission('delete_account') )
                                <div class="col-md-6 d-flex justify-content-start">
                                    @if(check_permission('update_account'))
                                        <div class="i-dropdown bulk-action d-none">
                                            <button class="dropdown-toggle bulk-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="las la-cogs fs-15"></i>
                                            </button>
                                                <ul class="dropdown-menu">
                                                  
                                                    @if(check_permission('update_account'))
                                                    
                                                        @foreach(App\Enums\StatusEnum::toArray() as $k => $v)
                                                            <li>
                                                                <button type="button" name="bulk_status" data-type ="status" value="{{$v}}" class="dropdown-item bulk-action-btn" > {{translate($k)}}</button>
                                                            </li>
                                                        @endforeach
                                                        
                                                    @endif

                                                </ul>
                                            
                                        </div>
                                        @endif
                                
                                    @if(check_permission('create_account'))
                                        <a href="{{route('admin.social.account.create',['platform' => request()->input('platform')])}}" class="i-btn btn--sm success me-2 create">
                                            <i class="las la-plus me-1"></i>  {{translate('Add New')}}
                                        </a>
                                    @endif
                                    
                                
                                </div>
                                @endif
                                <div class="col-md-6 d-flex justify-content-end">
                                    <div class="search-area">
                                        <form action="{{route(Route::currentRouteName())}}" method="get">

                                            <input type="hidden" name="platform" value="{{request()->input('platform')}}">
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
                                            <button class="i-btn btn--sm info">
                                                <i class="las la-sliders-h"></i>
                                            </button>
                                            <a href="{{route('admin.social.account.list',['platform' => request()->input('platform')])}}"  class="i-btn btn--sm danger">
                                                <i class="las la-sync"></i>
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="table-container position-relative">
                            @include('admin.partials.loader')
        
                            <table>
                                <thead>
                                <tr>
                                    <th scope="col">
                                        @if(check_permission('update_account') || check_permission('delete_account'))
                                            <input class="check-all  form-check-input me-1" id="checkAll" type="checkbox">
                                        @endif#
                                    </th>
                                    <th scope="col">{{translate('Account Info')}}</th>
                                    <th scope="col">{{translate('User')}}</th>

                                    <th scope="col">{{translate('Status')}}</th>

                                    <th scope="col">{{translate('Connection Status')}}</th>

                                    <th scope="col">{{translate('Account Type')}}</th>
                      
    
                                    <th scope="col">{{translate('Action')}}</th>
                                </tr>
                                </thead>
                            
                                <tbody>
                                    @forelse ($accounts as $account)
                                        <tr>
                                            <td data-label="#">
                                                @if( check_permission('update_account') || check_permission('delete_account'))
                                                    <input  type="checkbox" value="{{$account->id}}" name="ids[]" class="data-checkbox form-check-input" id="{{$account->id}}" />
                                                @endif
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


                                            <td data-label='{{translate("User")}}'>
                                                @if($account->user)
                                                    <a href="{{route('admin.user.show',$account->user->uid)}}">
                                                        {{$account->user->name}}
                                                    </a>
                                                @else
                                                  
                                                   {{translate('N/A')}}

                                                @endif
                                                
                                            </td>


                                            <td data-label='{{translate("Status")}}'>

                                                @if(!$account->user_id)
                                                    <div class="form-check form-switch switch-center">
                                                        <input {{!check_permission('update_account') ? "disabled" :"" }} type="checkbox" class="status-update form-check-input"
                                                            data-column="status"
                                                            data-route="{{ route('admin.social.account.update.status') }}"
                                                            data-status="{{ $account->status == App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}"
                                                            data-id="{{$account->uid}}" {{$account->status ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                                        id="status-switch-{{$account->id}}" >
                                                        <label class="form-check-label" for="status-switch-{{$account->id}}"> </label>
                                            
                                                    </div>
                                                @else

                                                  {{translate('N/A')}}
                                                @endif

                                            </td>
        
                                            <td data-label='{{translate("Connection Status")}}'>

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
        
                                                    @if(isset($platformConfig['view_option']))
                                                        <a  href="{{route('admin.social.account.show',["uid" => $account->uid])}}" class="fs-15 icon-btn success"><i class="las la-eye"></i>
                                                        </a>
                                                    @endif
                                                    @if(check_permission('delete_account') )

                                                        <a href="javascript:void(0);"    data-href="{{route('admin.social.account.destroy',  $account->id)}}" class="pointer delete-item icon-btn danger">
                                                            <i class="las la-trash-alt"></i>
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


    <div class="modal fade" id="config-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="config-modal"   aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{translate('Update Configuration')}}
                    </h5>
                    <button class="close-btn" data-bs-dismiss="modal">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{route('admin.platform.configuration.update')}}" id="platformForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input   hidden name="id" type="text">
                            <div class="col-lg-12" id ="configuration">
                            </div>
                            <div class="col-xl-12">
                                <div class="form-inner">
                                    <label for="callbackUrl">
                                        {{translate('Callback Url')}}
                                    </label>
                                    <div class="input-group">
                                        <input id="callbackUrl"  readonly  type="text" class="form-control" >
                                        <span class="input-group-text pointer copy-text pointer" data-type="modal"  data-text ='' ><i class="las la-copy"></i></span>
                                    </div>
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
  "use strict";
   $(".user").select2({
           
    });

    $(document).on('click','.update-config',function(e){

        var config         = JSON.parse($(this).attr('data-config'));
        var id             = JSON.parse($(this).attr('data-id'));
        var callbackUrl    = ($(this).attr('data-callback'));
        var modal          = $('#config-modal')
        modal.find('input[name="id"]').val(id)
        var html = "";
        for(let i in config){
            var withoutUnderscores =  i.replace(/_/g, ' ');
            var convertedString = withoutUnderscores.replace(/\b\w/g, function (match) {
                return match.toUpperCase();
            });

            html+= `<div class="form-inner">
                                <label for="client_secret" class="form-label" >
                                    ${convertedString}  <span  class="text-danger">*</span>
                                </label>

                            <input value="${config[i]}" required type="text" name="configuration[${i}]">
                            </div>`;

        }

        $("#configuration").html(html)
        $('#callbackUrl').val(callbackUrl)
        $('.copy-text').attr('data-text',callbackUrl)
        modal.modal('show')
    })


</script>
@endpush
