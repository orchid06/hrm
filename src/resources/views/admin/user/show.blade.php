@extends('admin.layouts.master')
@section('content')
<div class="row g-4 mb-4">
    
    @if(request()->routeIs("admin.user.show"))
        <div class="col-xl-3">
            <div class="i-card-md h-440 mb-4">
                <div class="card--header">
                    <h4 class="card-title">
                        {{ translate('User Information') }}
                    </h4>
                </div>
                <div class="card-body">

                    <div class="d-flex flex-column align-items-center justify-content-start border--bottom mb-4 gap-2 bg--light rounded-3 gap-3 p-3">
                        <div class="user-profile-image bg--light">
                            <img src="{{ imageURL($user->file,'profile,user',true) }}" alt="profile.jpg">
                        </div>
                        <div class="text-center">
                            <h6 class="mb-1">
                                {{$user->name}}
                            </h6>
                            <p class="mb-0"> {{$user->email}}</p>
                        </div>
                    </div>

                    <ul class="admin-info-list">

                        <li><span>{{ translate('Balance') }} : </span>  
                            <span class="i-badge-solid info"> {{num_format($user->balance,base_currency())}} @if(session('currency') && base_currency()->code != session('currency')?->code) -
                                {{num_format(
                                    number : $user->balance,
                                    calC   : true
                                )}} @endif</span>
                        </li>

                        @if($user->affiliates->count() > 0)
                            <li><span>{{ translate('Affiliate Earnings') }} :</span>   
                                @php
                                      $earnings =  $user->affiliates->sum("commission_amount");
                                @endphp
                                <a href="{{route('admin.affiliate.report.list',['user' => $user->username])}}">

                                    <span class="i-badge-solid success"> {{num_format($earnings,base_currency())}} @if(session('currency') && base_currency()->code != session('currency')?->code) -
                                        {{num_format(
                                            number :$earnings,
                                            calC   : true
                                        )}} @endif
                                    </span>
                                </a>
                            </li>
                        @endif

                        @if($user->referral)
                            <li><span>{{ translate('Refferd By') }} :</span> 
                                <a href="{{route('admin.user.show',$user->referral->uid)}}">{{ $user->referral?->name }}
                               </a>
                            </li>
                        @endif
                        
                        <li><span>{{ translate('Name') }} :</span> {{ $user->name }}</li>
                        <li><span>{{ translate('Username') }} :</span> {{ $user->user_name ?? 'N/A' }}</li>
                        <li><span>{{ translate('Phone') }} :</span> {{ $user->phone }}</li>
                        <li><span>{{ translate('Email') }} :</span> {{ $user->email }}</li>
                        <li><span>{{ translate('Country') }} :</span> {{ @$user->country->name  }}</li>

                    </ul>

                    <a href="{{route("admin.user.edit",$user->uid)}}" class="i-btn btn--md btn--primary w-100 update-profile" ><i class="bi bi-person-gear fs-18 me-3"></i>
                            {{translate("Update Profile")}}
                    </a>
                </div>
            </div>
    
            <div class="subscription-card i-card-sm">
                <div class="d-flex justify-content-between mb-40 ">

                    @if(!$user->runningSubscription)
                        <div class="text-center w-100">
                                <h5 class="text-white">
                                    {{translate("No subscription")}}
                                </h5>
                        </div>
                    @else

                        @php
                            $package  =  optional($user->runningSubscription)->package ;
                            $duration =  ucfirst(t2k(Arr::get(array_flip(App\Enums\PlanDuration::toArray()),$package->duration , 'Pending')));
                        @endphp

                        <div class="content text-start">
                            <span>
                                {{ $duration }}
                            </span>
                            <h5>
                                {{$package?->title}}
                            </h5>
                            <p>{{translate("Commision")}} - {{($package->affiliate_commission)}}%  </p>
                            <p>{{translate("Earning")}} -  {{@num_format(
                                number : $package->total_subscription_income??0,
                                calC   : true
                            )}}</p>
                        </div>
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M7.477 481.55c.057.065.102.138.164.201.027.028.063.047.092.075a29.58 29.58 0 0 0 21.974 9.795h377a29.535 29.535 0 0 0 21.979-9.83c.036-.035.079-.06.114-.097.068-.07.115-.152.178-.227a29.443 29.443 0 0 0 7.432-19.554v-136.79a61.672 61.672 0 0 0 3.176-8.504c42.82-7.514 70.662-21.769 72.321-31.568.423-2.507-.549-5.729-4.55-7.252-10.006-3.81-28.926-19.144-28.926-49.91v-78.597c0-42.088-27.857-77.791-66.102-89.643-5.18-23.216-17.982-39.27-33.336-39.27-15.355 0-28.158 16.055-33.34 39.271-21.691 6.723-40.037 21.122-51.857 40.004h-38.267l-34.855-27.299a4 4 0 0 0-4.934 0l-34.856 27.299H76.793a4 4 0 0 0-4 4v80.655L8.227 234.878c-.025.017-.045.04-.07.058-.055.04-.107.082-.161.125a4.455 4.455 0 0 0-.43.398c-.024.027-.055.046-.079.074C2.658 240.989 0 247.976 0 255.204v206.71c0 7.276 2.664 14.259 7.477 19.636zm186.38-381.896 24.349-19.069 24.347 19.069zm95.457 8a93.167 93.167 0 0 0-8.328 25.251H116.895a4 4 0 0 0-4 4v38.187a4 4 0 0 0 4 4h162.658v48.797c0 30.765-18.922 46.1-28.928 49.91-4 1.524-4.973 4.745-4.549 7.251 1.658 9.8 29.501 24.054 72.32 31.568.055.189.106.38.164.569l-36.581 28.656-61.132-54.233a4.002 4.002 0 0 0-5.311 0l-61.109 54.232-73.634-57.672V107.654zm89.678-79.275c10.41 0 19.703 11.901 24.459 28.99a93.875 93.875 0 0 0-18.846-1.902h-11.229c-6.453 0-12.758.655-18.848 1.902 4.758-17.088 14.052-28.99 24.464-28.99zm-5.615 35.089h11.229c47.323 0 85.824 38.5 85.824 85.824v78.597c0 33.947 20.088 51.441 32.854 56.891-2.584 2.952-11.625 9.112-30.051 15.293-16.475 5.527-44.314 12.35-83.387 13.47a5.056 5.056 0 0 0-.123.005 86.307 86.307 0 0 1-5.117.168h-11.229c-1.541 0-3.214-.055-5.116-.168a5.138 5.138 0 0 0-.124-.005c-39.074-1.12-66.914-7.943-83.387-13.47-18.428-6.182-27.468-12.342-30.052-15.294 12.766-5.45 32.854-22.944 32.854-56.891v-78.597c.001-47.323 38.501-85.823 85.825-85.823zm-252.482 77.437h159.037a94.557 94.557 0 0 0-.379 8.387v21.8H120.895zm258.097 212.889c-23.719 0-43.982-14.908-51.721-35.748 12.5 1.829 26.104 3.075 40.576 3.493a93.8 93.8 0 0 0 5.529.178h11.229c1.681 0 3.49-.058 5.529-.178 14.472-.417 28.075-1.664 40.574-3.492-7.736 20.84-27.999 35.747-51.716 35.747zm-221.76.257c.063-.057.135-.1.196-.161.016-.016.024-.034.04-.05l60.725-53.89 60.744 53.889c.016.016.026.035.042.05.06.06.13.102.192.157L419.99 479.011a21.53 21.53 0 0 1-13.284 4.609h-377a21.57 21.57 0 0 1-13.31-4.612zm268.065 118.974L288.063 351.241l33.465-26.215c9.916 21.658 31.936 36.769 57.465 36.769 20.006 0 37.854-9.286 49.416-23.723v123.843a21.403 21.403 0 0 1-3.112 11.11zM72.793 281.905l-55.817-43.717 55.817-43.716zM8 255.204c0-4.021 1.137-7.94 3.24-11.347l137.105 107.384L11.088 473.025A21.472 21.472 0 0 1 8 461.914z"  opacity="1" data-original="#000000"></path><path d="M116.895 213.382h37.693a4 4 0 0 0 0-8h-37.693a4 4 0 0 0 0 8zM112.895 235.099a4 4 0 0 0 4 4h96.636a4 4 0 0 0 0-8h-96.636a4 4 0 0 0-4 4z"  opacity="1" data-original="#000000" ></path></g></svg>
                        </div> 

                    @endif
            
                </div>
        
                <a  href="javascript:void(0)"  class="i-btn btn--md btn--white mx-auto d-block plan-upgrade">
                        <i class="bi bi-arrow-repeat me-3"></i>
                        {{translate("Update Subscription")}}
                </a>
            
            </div>
        </div>

        <div class="col-xl-9">
            <div class="row row-cols-xxl-3 row-cols-xl-3 row-cols-lg-4 row-cols-md-2 row-cols-sm-2 row-cols-1 g-3 mb-4">

                @php
                    $cards =  [
                                [         
                                    "title"  => translate("Total Subscription"),
                                    "class"  => 'col',
                                    "total"  => $user->subscriptions->count(),
                                    "icon"   => '<i class="las la-subscript"></i>',
                                    "bg"     => 'primary',
                                    "url"    => route('admin.subscription.report.list',['user' => $user->username])
                                ],
                                [         
                                    "title"  => translate("Total Tickets"),
                                    "class"  => 'col',
                                    "total"  => $user->tickets->count(),
                                    "icon"   => '<i class="las la-sms"></i>',
                                    "bg"     => 'info',
                                    "url"    => route('admin.ticket.list',['user' => $user->username])
                                ],
                                [         
                                    "title"  => translate("Deposit logs"),
                                    "class"  => 'col',
                                    "total"  => $user->paymentLogs->count(),
                                    "icon"   => '<i class="las la-hryvnia"></i>',
                                    "bg"     => 'success',
                                    "url"    => route('admin.deposit.report.list',['user' => $user->username])
                                ],
                                [         
                                    "title"  => translate("Withdraw logs"),
                                    "class"  => 'col',
                                    "total"  => $user->withdraws->count(),
                                    "icon"   => '<i class="las la-hryvnia"></i>',
                                    "bg"     => 'warning',
                                    "url"    => route('admin.withdraw.report.list',['user' => $user->username])
                                ],
                                [         
                                    "title"  => translate("Credit logs"),
                                    "class"  => 'col',
                                    "total"  => $user->creditLogs->count(),
                                    "icon"   => '<i class="las la-bars"></i>',
                                    "bg"     => 'danger',
                                    "url"    => route('admin.credit.report.list',['user' => $user->username])
                                ],
                                [         
                                    "title"  => translate("Transaction logs"),
                                    "class"  => 'col',
                                    "total"  => $user->transactions->count(),
                                    "icon"   => '<i class="las la-bars"></i>',
                                    "bg"     => 'danger',
                                    "url"    => route('admin.transaction.report.list',['user' => $user->username])
                                ]
                            ];
                @endphp

                @include("admin.partials.report_card")


            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="i-card-md mb-4">
                        <div class="card--header text-end">
                            <h4 class="card-title">
                                 {{ translate('Social post statistics (Current Year)')}}
                            </h4>
                       </div>
                        <div class="card-body">
                            <div id="postReport"></div>
                        </div>
                    </div>
                    <div class="i-card-md">
                        <div class="card-body">
                            <div class="d-flex gap-2">
                                <button type="button"   class="i-btn btn--md success deposit-balance flex-grow-1">
                                    <i class="las la-plus me-1"></i>  {{translate('Deposit')}}
                                </button>
                                <button type="button"   class="i-btn btn--md danger withdraw-balance flex-grow-1">
                                    <i class="las la-minus me-1"></i>  {{translate('Withdraw')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif

 


    @if(request()->routeIs("admin.user.edit"))
        <div class="col-12">
            <div class="i-card-md">
                <div class="card--header">
                    <h4 class="card-title">{{ translate('Profile Update') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.user.update')}}"  method="post" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" value="{{$user->id}}" name="id" id="id" class="form-control" >
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label for="name">
                                            {{translate('Name')}} <span class="text-danger">*</span>
                                        </label>
                                        <input required type="text" name="name" value="{{$user->name}}" id="name"  placeholder="{{translate('Enter Name')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label for="username">
                                            {{translate('Username')}}
                                            <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" value="{{$user->username}}" name="username" id="username" placeholder="{{translate('Enter Username')}}" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label for="email">
                                            {{translate('Email')}}
                                            <small class="text-danger">*</small>
                                        </label>
                                        <input type="email"  value="{{$user->email}}" name="email" id="email"  placeholder="{{translate('Enter Email')}}" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label for="phone">
                                            {{translate('Phone')}}
                                        </label>
                                        <input type="text"  value="{{$user->phone}}" name="phone" id="phone"  placeholder="{{translate('Enter Phone')}}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label for="country">
                                            {{translate('Country')}}
                                        </label>
                                        <select name="country_id" id="country">
                                            <option value="">
                                                {{translate('Select Country')}}
                                            </option>
                                            @foreach ($countries as $country )
                                                <option {{$user->country_id == $country->id ? "selected" :""}} value="{{$country->id}}">
                                                    {{$country->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @foreach (['city','state','postal_code','address'] as $address_key )
                                        <div class="col-lg-6">
                                            <div class="form-inner">
                                                <label for="{{$address_key}}">
                                                        {{k2t($address_key)}}
                                                </label>
                                                <input placeholder=" {{k2t($address_key)}} " id="{{$address_key}}" name="address[{{$address_key}}]" value="{{@$user->address->$address_key}}" type="text">
                                            </div>
                                        </div> 
                                @endforeach

                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label for="image">
                                            {{translate('Profile Image')}}
                                        </label>
                                        <input data-size = "{{config('settings')['file_path']['profile']['user']['size']}}" id="image" name="image" type="file" class="preview">
                                        <div class="mt-2 payment-preview image-preview-section">
                                            <img src="{{imageURL($user->file,'profile,user',true) }}" alt="{{@$user->file->name}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label for="password">
                                            {{translate('Password')}}
                                        </label>
                                        <input  type="text" name="password" id="password"   placeholder="{{translate('Enter Password')}}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label for="password_confirmation">
                                            {{translate('Confirm Password')}}

                                        </label>
                                        <input type="text" id="password_confirmation" name="password_confirmation"   placeholder="{{translate('Enter Confrim Password')}}" >
                                    </div>
                                </div>

                                <div class="col-xl-7 col-lg-12">
                                    <div class="form-inner">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input id="email_verified" value="{{App\Enums\StatusEnum::true->status()}}" {{$user->email_verified_at ? "checked" :""}} class="form-check-input me-1" name="email_verified" type="checkbox">
                                                <label for="email_verified" class="form-check-label me-3">
                                                    {{translate('Email Verified')}}
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input id="auto_subscription" value="{{App\Enums\StatusEnum::true->status()}}" {{$user->auto_subscription ? "checked" :""}} class="form-check-input me-1" name="auto_subscription" type="checkbox"   >
                                                <label for="auto_subscription" class="form-check-label me-3">
                                                    {{translate('Auto Subscription')}}
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input id="is_kyc_verified" value="{{App\Enums\StatusEnum::true->status()}}" {{$user->is_kyc_verified ? "checked" :""}} class="form-check-input me-1" name="is_kyc_verified" type="checkbox"   >
                                                <label for="is_kyc_verified" class="form-check-label me-3">
                                                    {{translate('KYC Verified')}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="i-btn btn--md btn--primary" data-anim="ripple">
                                        {{translate("Submit")}}
                                    </button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

@endsection


@section('modal')
    @include('admin.partials.modal.balance_update');
    @include('admin.partials.modal.plan_update');
@endsection

@push('script-include')
    <script  src="{{asset('assets/global/js/apexcharts.js')}}"></script>
@endpush

@push('script-push')
<script>
	(function($){

        "use strict";

        $(".select2").select2({
            placeholder:"{{translate('Select Item')}}",
            dropdownParent: $("#planUpdate")
        })

        $("#country").select2({
            placeholder:"{{translate('Select Country')}}",
        })

        $(".select-method").select2({
			dropdownParent: $("#balanceModal")
		})

        var modal = $('#balanceModal')
        
        $(document).on('click','.withdraw-balance',function(e){
            $('.modal-title').html("Withdraw Balance");
            $('#type').val("{{App\Enums\BalanceTransferType::WITHDRAW->value}}");
            $('.deposit-method').addClass('d-none');
            $('.withdraw-method').removeClass('d-none');
            modal.modal('show')
        });

        $(document).on('click','.deposit-balance',function(e){
            $('.modal-title').html("Deposit Balance")
            $('#type').val("{{App\Enums\BalanceTransferType::DEPOSIT->value}}");
            $('.deposit-method').removeClass('d-none');
            $('.withdraw-method').addClass('d-none');
            $('#balanceModal').modal('show')
        })


        $(document).on('click','.plan-upgrade',function(e){
            $('#planUpdate').modal('show')
            e.preventDefault()

        })

 
        var options = {
            chart: {
              height: 300,
              type: "line",
            },
          dataLabels: {
            enabled: false,
          },
          colors: ['var(--color-info)','var(--color-primary)','var(--color-success)' ,"var(--color-danger)"],
          series: [
            {
              name: "{{ translate('Total Post') }}",
              data: @json(array_column($graph_data , 'total')),
            },
            {
              name: "{{ translate('Success Post') }}",
              data: @json(array_column($graph_data , 'success')),
            },
            {
              name: "{{ translate('Pending Post') }}",
              data: @json(array_column($graph_data , 'pending')),
            },
            {
              name: "{{ translate('Schedule Post') }}",
              data: @json(array_column($graph_data , 'schedule')),
            },
            {
              name: "{{ translate('Failed Post') }}",
              data: @json(array_column($graph_data , 'failed')),
            }
          
          ],
          xaxis: {
            categories: @json(array_keys($graph_data)),
          },

          tooltip: {
                shared: false,
                intersect: true,
      
            },
          markers: {
            size: 6,
          },
          stroke: {
            width: [4, 4],
          },
          legend: {
            horizontalAlign: "left",
            offsetX: 40,
          },
        };

        var chart = new ApexCharts(document.querySelector("#postReport"), options);
        chart.render();


	})(jQuery);
</script>
@endpush
