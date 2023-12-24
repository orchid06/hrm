@extends('layouts.master')
@section('content')


    @php
        $user      = auth_user('web');
        $content   = get_content("content_plan")->first();
    @endphp
    <div class="profile-wrapper">
      <div class="inner-banner">
        <div class="primary-shade"></div>
        <div class="banner-texture"></div>
      </div>

      <div class="profile-content">
        <div class="row gy-5">
          <div class="col-xl-3 col-lg-4">
            <div class="profile-info">
              <div class="profile-img">
                  <img src="{{imageUrl(@$user->file,'profile,user',true) }}" alt="{{@$user->file->name}}" />
              </div>

              <div class="profile-meta">
                <div class="profile-meta-content">
                  <h5>
                     {{$user->name}}
                  </h5>
                  <p>{{translate("Joined on")}} {{get_date_time($user->created_at)}}</p>

                  <ul class="profile-meta-list">
                    <li>
                      <span>  {{translate("Email")}}: </span>
                      <a href="mailto:{{$user->email}}"> {{$user->email}}</a>
                    </li>

                    <li>
                        <span>  {{translate("Phone")}}: </span>
                      <a href="tel:{{$user->phone}}">{{$user->phone}}</a>
                    </li>
                  </ul>
                </div>

                <div class="user-balance">
                  <p>
                     {{translate("Balance")}}
                  </p>
                  <h6> {{num_format(number:$user->balance,calC:true)}}</h6>

                  <div class="balance-action">
                    <a
                      href="{{route('user.deposit.create')}}"
                      class="i-btn btn--primary btn--sm capsuled">
                      {{translate("Deposit")}}
                    </a>

                    <a
                      href="{{route('user.withdraw.create')}}l"
                      class="i-btn btn--secondary btn--sm capsuled">
                      {{translate("Withdraw")}}
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div class="i-card-md plan-upgrade-card mt-4">
              <div class="card-body plan-upgrade-body">
                <h3>{{@$content->value->title}}</h3>

                <a
                  href="{{route("user.plan")}}"
                  class="i-btn btn--primary btn--lg capsuled">
                    {{translate("Upgrade Now")}}
                </a>

                <div class="plan-upgrade-img">
                  <img
                    src="{{asset('assets/images/plan.gif')}}"
                    alt="plan.gif"
                    class="img-fluid"/>
                </div>
              </div>

            </div>
          </div>

          <div class="col-xl-9 col-lg-8">
            <div class="profile-activity">
              <div class="profile-tabs">
                <ul class="nav" role="tablist">
                  <li class="nav-item" role="presentation">
                    <a
                      class="nav-link active"
                      data-bs-toggle="tab"
                      href="#personal-details"
                      role="tab"
                      aria-selected="true">
                      <i class="bi bi-person-gear"></i> 
                        {{translate("Account")}}
                    </a>
                  </li>

                  <li class="nav-item" role="presentation">
                    <a
                      class="nav-link"
                      data-bs-toggle="tab"
                      href="#change-password"
                      role="tab"
                      aria-selected="false"
                      tabindex="-1">
                      <i class="bi bi-shield-lock"></i> 
                       {{translate("Change Password")}}
                    </a>
                  </li>

                  @if($user->runningSubscription)
                    <li class="nav-item" role="presentation">
                        <a
                        class="nav-link"
                        data-bs-toggle="tab"
                        href="#plan-tab"
                        role="tab"
                        aria-selected="false"
                        tabindex="-1">
                        <i class="bi bi-tag"></i>
                        {{translate("Current Plan")}}
                        </a>
                    </li>
                  @endif
                   
                  <li class="nav-item" role="presentation">
                    <a
                      class="nav-link"
                      data-bs-toggle="tab"
                      href="#affiliate-configuration"
                      role="tab"
                      aria-selected="false"
                      tabindex="-1">
                      <i class="bi bi-share"></i>
                       {{translate("Affiliate Configuration")}}
                    </a>
                  </li>

                   
                </ul>
              </div>

              <div class="profile-tab-content">
                <div class="tab-content">
                    <div class="tab-pane active"
                        id="personal-details"
                        role="tabpanel">
                        <div class="i-card-md">
                        <div class="card-header">
                            <h4 class="card-title">
                                {{translate("Profile")}}
                            </h4>
                        </div>

                        <div class="card-body">
                            <form action="{{route('user.profile.update')}}" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="row g-4">
                                <div class="col-lg-6">
                                <div class="form-inner mb-0">
                                    <label for="name">
                                        {{translate("Name")}} 
                                    </label>
                                    <input type="text" name="name" value="{{$user->name}}" id="name" />
                                </div>
                                </div>

                                <div class="col-lg-6">
                                <div class="form-inner mb-0">
                                    <label for="Username">
                                        {{translate("Username")}} <small class="text-danger">*</small>
                                    </label>
                                    <input type="text" name="username" value="{{$user->username}}" id="Username" />
                                </div>
                                </div>

                                <div class="col-lg-12">
                                <div class="form-inner mb-0">
                                    <label for="email">
                                        {{translate("email")}} <small class="text-danger">*</small>
                                    </label>
                                    <input type="text" name="email" value="{{$user->email}}" id="email" />
                                </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-inner mb-0">
                        
                                    <label for="country">
                                        {{translate('Country')}}
                                    </label>

                                        <select name="country_id" id="country">
                                            <option value="">
                                                {{translate('Select Country')}}
                                            </option>
                                            @foreach (get_countries() as $country )
                                                <option {{$user->country_id == $country->id ? "selected" :""}} value="{{$country->id}}">
                                                    {{$country->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                <div class="form-inner mb-0">
                                    <label for="phone">
                                        {{translate("Phone")}}
                                    </label>
                                    <input type="text" value="{{$user->phone}}" name="phone" id="phone" />
                                </div>
                                </div>

                            
                                <div class="col-lg-12">
                                <div class="form-inner mb-0">
                                    <label for="image"> 
                                        {{translate("Image")}}
                                    </label>
                                    <input data-size = "100x100" type="file" name="image" id="image" class="preview" />

                                    <div class="image-preview-section">
                                    </div>

                                </div>
                                </div>

                                <div>
                                <button
                                    type="submit"
                                    class="i-btn btn--primary btn--lg capsuled">
                                    {{translate("Update")}}
                                </button>
                                </div>
                            </div>
                            </form>
                        </div>
                        </div>
                    </div>

                    <div
                        class="tab-pane"
                        id="change-password"
                        role="tabpanel">
                        <div class="i-card-md">
                            <div class="card-header">
                                <h4 class="card-title">
                                    {{translate("Change Password")}}
                                </h4>
                            </div>

                            <div class="card-body">
                                <form action="{{route('user.password.update')}}"  method="post">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div class="form-inner mb-0">
                                                <label for="current-password">
                                                    {{translate("Current Password")}} <small class="text-danger">*</small>
                                                </label>
                                                <input  placeholder="{{translate('current password')}}" type="password" name="current_password" id="current-password" />
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-inner mb-0">
                                                <label for="new-password"> 
                                                    {{translate("New Password")}} <small class="text-danger">*</small>
                                                </label>
                                                <input placeholder="{{translate('password')}}" name="password" type="password" id="new-password" />
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-inner mb-0">
                                                <label for="confirm-password">
                                                    {{translate("Confirm Password")}} <small class="text-danger">*</small>
                                                </label>
                                                <input placeholder="{{translate('Confirm password')}}" type="password" name="password_confirmation" id="confirm-password" />
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button
                                                type="submit"
                                                class="i-btn btn--primary btn--lg capsuled">
                                                
                                                {{translate(
                                                    "Update Password"
                                                )}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if($user->runningSubscription)
                        <div class="tab-pane" id="plan-tab" role="tabpanel">
                            <div class="i-card-md">
                                <div class="card-header">

                                    <h4 class="card-title">
                                        {{translate('Current Plan')}}
                                    </h4>

                                </div>

                                <div class="card-body">
                                    <div class="row align-items-center g-4">
                                        <div class="col-xl-6 col-lg-12 col-md-6">
                                            <div class="current-plan">
                                                <div class="current-plan-img">
                                                    <img
                                                    src="{{asset('assets/images/current-plan.gif')}}"
                                                    alt="current-plan.gif"/>
                                                </div>
                                                <h5>
                                                    {{@$user->runningSubscription->package->title}}
                                                </h5>
                                            
                                                <span>{{translate("Expire date")}}: 
                                                {{@$user->runningSubscription->expired_at ? get_date_time($user->runningSubscription->expired_at): ucfirst(strtolower(App\Enums\PlanDuration::UNLIMITED->name))}}
                                                    
                                                </span>
                                            </div>
                                        </div>


                                        <div class="col-xl-6 col-lg-12 col-md-6">
                                            <div class="permissions">
                                            <h6>
                                                {{translate("specification")}}
                                            </h6>
                                            <ul class="list-group">


                                                @foreach (plan_configuration( @$user->runningSubscription->package) as $configKey => $configVal )
                    
                                                    <li class="list-group-item">
                                                        <i class="fa fa-check text-success"></i>
                                                        {{!is_bool($configVal) ? $configVal : "" }} {{k2t($configKey)}}
                                                    </li>
                                                    
                                                    
                                                @endforeach

                                            
                                            </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                    <div class="tab-pane" id="affiliate-configuration" role="tabpanel">
                        <div class="i-card-md">
                            <div class="card-header">
                                    <h4 class="card-title">
                                        {{translate("Affiliate Configurations")}}
                                    </h4>
                            </div>

                            <div class="card-body">
                                <form action="{{route('user.affiliate.update')}}"  method="post">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="col-lg-6">

                                            <div class="form-inner">
                                                <label for="referral_code"
                                                class="form-label">{{ translate('Referral Code') }} 
                        
                                                    <small class="text-danger" >*</small>
                        
                                                </label>
                        
                                                <div class="input-group">
                                                    <input placeholder="{{translate("Referral Code")}}" id="referral_code" value="{{$user->referral_code}}" name="referral_code"  type="text" class="form-control" >
                                                    <span class="input-group-text  pointer code-generate"><i class="bi bi-arrow-repeat"></i>
                                                    </span>
                                                </div>
                                            </div>
                    
                                         </div>
                                         <div class="col-lg-6">
                    
                                            <div class="form-inner">
                                                <label for="ReferralURL"
                                                class="form-label">{{ translate('Referral URL') }} 
                        
                                                </label>
                        
                                                <div class="input-group">
                                                    <input readonly id="ReferralURL" value="{{route('auth.register',['referral_code' => $user->referral_code])}}"  type="text" class="form-control" >
                                                    <span data-text ="{{route('auth.register',['referral_code' => $user->referral_code])}}" class="input-group-text  pointer copy-text"><i class="bi bi-clipboard-check"></i></span>
                                                </div>
                                            </div>
                    
                                         </div>
                                        <div class="col-12">
                                            <button
                                                type="submit"
                                                class="i-btn btn--primary btn--lg capsuled">
                                                
                                                {{translate(
                                                    "Update"
                                                )}}
                                            </button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
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


	})(jQuery);
</script>
@endpush
