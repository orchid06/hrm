@extends('admin.layouts.master')
@section('content')

<div class="row row-cols-xxl-5 row-cols-xl-4 row-cols-lg-4 row-cols-md-2 row-cols-sm-2 row-cols-1 g-3 mb-4">
    <div class="col">
      <div class="i-card-sm style-2 primary">
            <div class="card-info">
                <h5 class="title">
                    {{translate("Total Subscription")}}
                </h5>
                <h3> {{$user->subscriptions->count()}}</h3>
                <a href="{{route('admin.subscription.report.list',['user' => $user->username])}}" class="mt-3 i-btn btn--outline btn--sm">
                    {{translate("View All")}}
                </a>
            </div>
            <div class="icon">
                <i class="las la-subscript"></i>
            </div>
      </div>
    </div>
    <div class="col">
        <div class="i-card-sm style-2 info">
            <div class="card-info">
                <h5 class="title">
                    {{translate("Total Tickets")}}
                </h5>
                <h3>{{$user->tickets->count()}}</h3>

                <a href="{{route('admin.ticket.list',['user' => $user->username])}}" class="mt-3 i-btn btn--outline btn--sm">
                {{translate("View All")}}
                </a>
            </div>
            <div class="icon">
                <i class="las la-sms"></i>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="i-card-sm style-2 success">
            <div class="card-info">
                <h5 class="title">
                    {{translate("Deposit logs")}}
                </h5>
                <h3>{{$user->paymentLogs->count()}}</h3>

                <a href="{{route('admin.deposit.report.list',['user' => $user->username])}}" class="mt-3 i-btn btn--outline btn--sm">
                    {{translate("View All")}}
                </a>
            </div>
            <div class="icon">
                <i class="las la-hryvnia"></i>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="i-card-sm style-2 warning">
          <div class="card-info">
            <h5 class="title">
               {{translate("Withdraw logs")}}
            </h5>
            <h3>{{$user->withdraws->count()}}</h3>
  
            <a href="{{route('admin.withdraw.report.list',['user' => $user->username])}}" class="mt-3 i-btn btn--outline btn--sm">
               {{translate("View All")}}
            </a>
          </div>
          <div class="icon">
              <i class="las la-hryvnia"></i>
          </div>
        </div>
    </div>
    <div class="col">
        <div class="i-card-sm style-2 danger">
            <div class="card-info">
                <h5 class="title">
                {{translate("Transaction logs")}}
                </h5>
                <h3>{{$user->transactions->count()}}</h3>

                <a href="{{route('admin.transaction.report.list',['user' => $user->username])}}" class="mt-3 i-btn btn--outline btn--sm">
                {{translate("View All")}}
                </a>
            </div>
            <div class="icon">
                <i class="las la-bars"></i>
            </div>
        </div>
    </div>
</div>
<div class="row g-4 mb-4">
    <div class="col-6">
        <button type="button"   class="i-btn btn--sm success deposit-balance">
            <i class="las la-plus me-1"></i>  {{translate('Deposit')}}
        </button>
        <button type="button"   class="i-btn btn--sm danger withdraw-balance">
            <i class="las la-minus me-1"></i>  {{translate('Withdraw')}}
        </button>
    </div>
</div>
<div class="row g-4 mb-4">
    <div class="col-xl-6">
        <div class="i-card-md h-440">
            <div class="card--header">
                <h4 class="card-title">
                    {{ translate('Details') }}
                </h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{ translate('Balance') }} :   
                        <span class="i-badge-solid info"> {{num_format($user->balance,base_currency())}} @if(session('currency') && base_currency()->code != session('currency')?->code) -
                            {{num_format(
                                number : $user->balance,
                                calC   : true
                            )}} @endif</span>
                    </li>
                    @if($user->affiliates->count() > 0)
                        <li class="list-group-item">{{ translate('Affiliate Earnings') }} :   
                            @php
                               $earnings =  $user->affiliates->sum("commission_amount");
                            @endphp
                            <a href="{{route('admin.affiliate.report.list',['user' => $user->username])}}">

                                <span class="i-badge-solid info"> {{num_format($earnings,base_currency())}} @if(session('currency') && base_currency()->code != session('currency')?->code) -
                                    {{num_format(
                                        number :$earnings,
                                        calC   : true
                                    )}} @endif
                                </span>
                            </a>
                        </li>
                    @endif

                    @if($user->referral)
                       <li class="list-group-item">{{ translate('RefferdbBy') }} : <a href="{{route('admin.user.show',$user->referral->uid)}}">{{ $user->referral?->name }}</a></li>
                    @endif
                    
                    <li class="list-group-item">{{ translate('Name') }} : {{ $user->name }}</li>
                    <li class="list-group-item">{{ translate('Username') }} : {{ $user->user_name }}</li>
                    <li class="list-group-item">{{ translate('Phone') }} : {{ $user->phone }}</li>
                    <li class="list-group-item">{{ translate('Email') }} : {{ $user->email }}</li>
                    <li class="list-group-item">{{ translate('Country') }} : {{ $user->country->name }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="i-card-md h-440">
            <div class="card--header">
                <h4 class="card-title">{{ translate('Update Subscriptions') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.user.subscription')}}"  method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="form-inner mb-2">
                        <label for="Subscription"  class="mb-2">
                            {{ translate('Running Subscription') }} <span class="text-danger">*</span>
                        </label>
                        <select required class="select2" name="package_id" id="Subscription" >
                             <option value="">
                                 {{translate("Select Package")}}
                             </option>
                             @foreach ($packages as $package)
                                <option {{$subscription?->package_id == $package->id ? "selected" :"" }} value="{{$package->id}}">
                                    {{$package->title}}
                                </option>
                             @endforeach
                        </select>
                    </div>
                    <div class="form-inner">
                        <label for="remarks">
                            {{ translate('Remarks') }}
                            <small class="text-danger">*</small>
                        </label>
                        <textarea required placeholder="{{ translate('Type Here ...') }}" name="remarks" id="remarks" cols="30"
                            rows="10"></textarea>
                    </div>
                    <button type="submit" class="i-btn btn--md btn--primary" data-anim="ripple">
                        {{ translate('Submit') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 ">
        <div class="i-card-md">
            <div class="card--header">
                <h4 class="card-title">{{ translate('Information update') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.user.update')}}"  method="post" enctype="multipart/form-data">
                    @csrf
                        <input type="hidden" value="{{$user->id}}" name="id" id="id" class="form-control" >
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label  for="Name">
                                        {{translate('Name')}} <span class="text-danger">*</span>
                                    </label>
                                    <input required type="text" name="name" value="{{$user->name}}" id="Name"  placeholder="{{translate('Enter Name')}}">
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
                                    <label for="Email">
                                        {{translate('Email')}}
                                        <small class="text-danger">*</small>
                                    </label>
                                    <input type="email"  value="{{$user->email}}" name="email" id="Email"  placeholder="{{translate('Enter Email')}}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="phoneNumber">
                                        {{translate('Phone')}}
                                    </label>
                                    <input type="text"  value="{{$user->phone}}" name="phone" id="phoneNumber"  placeholder="{{translate('Enter Phone')}}" required>
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
                                <div class="col-6">
                                    <div class="form-inner">
                                        <label for="{{$address_key}}">
                                            {{k2t($address_key)}}
                                        </label>
                                        <input placeholder=" {{k2t($address_key)}} " id="{{$address_key}}" name="address[{{$address_key}}]" value="{{@$user->address->$address_key}}" type="text">
                                    </div>
                                </div> 
                            @endforeach

                            <div class="col-6">
                                <div class="form-inner">
                                    <label for="image">
                                        {{translate('Profile Image')}}
                                    </label>
                                    <input data-size = "{{config('settings')['file_path']['profile']['user']['size']}}" id="image" name="image" type="file" class="preview" >
                                    <div class="mt-2 payment-preview image-preview-section">
                                        <img src="{{imageUrl($user->file,'profile,user',true) }}" alt="{{@$user->file->name}}">
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
                            <div class="col-lg-12">
                                <div class="form-inner">
                                    <input id="email_verified" value="{{App\Enums\StatusEnum::true->status()}}" {{$user->email_verified_at ? "checked" :""}} class="form-check-input me-1" name="email_verified" type="checkbox"   >
                                    <label for="email_verified" class="form-check-label me-3">
                                         {{translate('Email Verified')}}
                                    </label>
                                    <input id="auto_subscription" value="{{App\Enums\StatusEnum::true->status()}}" {{$user->auto_subscription ? "checked" :""}} class="form-check-input me-1" name="auto_subscription" type="checkbox"   >
                                    <label for="auto_subscription" class="form-check-label me-3">
                                         {{translate('Auto Subscription')}}
                                    </label>
                                    <input id="is_kyc_verified" value="{{App\Enums\StatusEnum::true->status()}}" {{$user->is_kyc_verified ? "checked" :""}} class="form-check-input me-1" name="is_kyc_verified" type="checkbox"   >
                                    <label for="is_kyc_verified" class="form-check-label me-3">
                                         {{translate('Kyc Verified')}}
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <button type="submit" class="i-btn btn--md btn--primary" data-anim="ripple">
                                    {{translate("Submit")}}
                                </button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@section('modal')
    <div class="modal fade" id="balanceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="balanceModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >
                        {{translate('Deposit Balance')}}
                    </h5>
                    <button class="close-btn" data-bs-dismiss="modal">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{route('admin.user.balance')}}" method="post" enctype="multipart/form-data">
                    <input value="{{$user->id}}" hidden name="id"  type="text">
                    <input  hidden name="type" id="type"  type="text">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="amount">
                                    {{translate('Amount')}}
                                        <small class="text-danger">*</small>
                                </label>
                                <input placeholder="{{translate('Enter amount')}}" min='1' required type="number" name="amount" id="amount" value="{{old('amount')}}">
                            </div>
                            <div class="col-lg-6 deposit-method d-none">
                                <label for="payment_id">
                                    {{translate('Deposit Method')}}
                                        <small class="text-danger">*</small>
                                </label>
                                <select class="select-method" name="payment_id" id="payment_id">
                                    <option value="">
                                        {{translate('Select method')}}
                                    </option>
                                    @foreach ($methods as $method )
                                        <option {{old("payment_id") == $method->id ? "selected" : "" }} value="{{$method->id}}">
                                             {{$method->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 withdraw-method d-none">
                                <label for="method">
                                    {{translate('Withdraw Method')}}
                                        <small class="text-danger">*</small>
                                </label>
                                <select class="select-method" name="method_id" id="method_id">
                                    <option value="">
                                        {{translate('Select method')}}
                                    </option>
                                    @foreach ($withdraw_methods as $withdrawMethod )
                                        <option {{old("method_id") == $withdrawMethod->id ? "selected" : "" }} value="{{$withdrawMethod->id}}">
                                             {{$withdrawMethod->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="remarks">
                                    {{translate('Remarks')}}
                                        <small class="text-danger">*</small>
                                </label>
                                <textarea placeholder="{{translate('Remarks')}}" name="remarks" id="remarks" cols="30" rows="10">{{old("remarks")}}</textarea>
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

        $(".select2").select2({
            placeholder:"{{translate('Select Item')}}",
        })

        $("#country").select2({
            placeholder:"{{translate('Select Country')}}",
        })

        $(".select-method").select2({

			dropdownParent: $("#balanceModal"),
		})

        var modal = $('#balanceModal')
        
        $(document).on('click','.withdraw-balance',function(e){

            $('.modal-title').html("Withdraw Balance");
            $('#type').val("withdraw");
            $('.deposit-method').addClass('d-none');
            $('.withdraw-method').removeClass('d-none');
            modal.modal('show')
        });

        $(document).on('click','.deposit-balance',function(e){

            $('.modal-title').html("Deposit Balance")
            $('#type').val("deposit");
            $('.deposit-method').removeClass('d-none');
            $('.withdraw-method').addClass('d-none');
            modal.modal('show')
        })


	})(jQuery);
</script>
@endpush
