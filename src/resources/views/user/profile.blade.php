@extends('layouts.master')
@section('content')

    @php
        $user                = auth_user('web');
        $content             = get_content("content_plan")->first();
        $subscription        = $user->runningSubscription;
        $webhookAccess       = @optional($user->runningSubscription->package->social_access)->webhook_access;

    @endphp

    <!-- <div class="profile-wrapper">
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
                      class="i-btn btn--primary btn--md capsuled">
                      {{translate("Deposit")}}
                    </a>

                    <a
                      href="{{route('user.withdraw.create')}}"
                      class="i-btn btn--secondary btn--md capsuled">
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
                  href="{{route('user.plan')}}"
                  class="i-btn btn--primary btn--lg capsuled">
                    {{translate("Upgrade Now")}}
                </a>

                <div class="plan-upgrade-img">
                  <img
                    src="{{asset('assets/images/default/plan.gif')}}"
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

                  @if(site_settings("affiliate_system") == App\Enums\StatusEnum::true->status())
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
                  @endif

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


                  @if($webhookAccess == App\Enums\StatusEnum::true->status())
                    <li class="nav-item" role="presentation">
                            <a
                            class="nav-link"
                            data-bs-toggle="tab"
                            href="#webhook-configuration"
                            role="tab"
                            aria-selected="false"
                            tabindex="-1">
                            <i class="bi bi-arrow-left-right"></i>
                            {{translate("Webhook Configuration")}}
                            </a>
                    </li>
                  @endif

                </ul>
                <div class="under-line"></div>
              </div>

              <div class="profile-tab-content">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="personal-details" role="tabpanel">
                        <div class="i-card-md">
                            <div class="card-header">
                                <h4 class="card-title">
                                    {{translate("User Info")}}
                                </h4>

                                <div class="capsuled-tab">
                                    <ul class="nav" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="account-details-tab" data-bs-toggle="tab" data-bs-target="#account-details" type="button" role="tab" aria-controls="account-details" aria-selected="true">
                                                {{translate("User Details")}}
                                            </button>
                                        </li>

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="false">
                                                 {{translate("Update Password")}}
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="account-details" role="tabpanel" aria-labelledby="account-details-tab" tabindex="0">
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

                                                <div class="col-12">
                                                    <div class="form-inner mb-0">
                                                        <label for="image">
                                                            {{translate("Image")}}
                                                        </label>

                                                        <div>
                                                            <label for="image" class="feedback-file">
                                                                <input hidden  data-size = "100x100" type="file" name="image" id="image" class="preview">
                                                                <span><i class="bi bi-image"></i>
                                                                    {{translate("Select image")}}
                                                                </span>
                                                            </label>

                                                            <div class="image-preview-section">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if(site_settings('auto_subscription') == App\Enums\StatusEnum::true->status())

                                                <div class="col-12">
                                                    <div class="form-inner">
                                                        <input id="auto_subscription" value="{{App\Enums\StatusEnum::true->status()}}" {{$user->auto_subscription ? "checked" :""}} class="form-check-input me-1" name="auto_subscription" type="checkbox"   >
                                                        <label for="auto_subscription" class="form-check-label me-3">
                                                            {{translate('Auto Subscription')}}
                                                        </label>
                                                    </div>
                                                </div>

                                                @endif

                                                <div class="col-12">
                                                    <button
                                                        type="submit"
                                                        class="i-btn btn--primary btn--lg capsuled">
                                                        {{translate("Update")}}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab" tabindex="0">
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
                        </div>

                    </div>

                    @if(site_settings("affiliate_system") == App\Enums\StatusEnum::true->status())
                        <div class="tab-pane fade" id="affiliate-configuration" role="tabpanel">
                            <div class="i-card-md">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        {{translate("Affiliate Configuration")}}
                                    </h4>
                                </div>

                                <div class="card-body">
                                    <form action="{{route('user.affiliate.update')}}"  method="post">
                                        @csrf
                                        <div class="row g-4">
                                            <div class="col-lg-6">
                                                <div class="form-inner mb-0">
                                                    <label for="referral_code"
                                                    class="form-label">{{ translate('Referral Code') }}
                                                        <small class="text-danger" >*</small>
                                                    </label>

                                                    <div class="input-group">
                                                        <input placeholder="{{translate('Referral Code')}}" id="referral_code" value="{{$user->referral_code}}" name="referral_code"  type="text" class="form-control" >
                                                        <span class="input-group-text danger pointer code-generate"><i class="bi bi-arrow-repeat"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-inner mb-0">
                                                    <label for="ReferralURL"
                                                    class="form-label">{{ translate('Referral URL') }}
                                                    </label>

                                                    <div class="input-group">
                                                        <input readonly id="ReferralURL" value="{{route('auth.register',['referral_code' => $user->referral_code])}}"  type="text" class="form-control" >
                                                        <span data-text ="{{route('auth.register',['referral_code' => $user->referral_code])}}" class="input-group-text success pointer copy-text"><i class="bi bi-clipboard-check"></i></span>
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
                    @endif

                    @if($user->runningSubscription)
                        <div class="tab-pane fade" id="plan-tab" role="tabpanel">
                            <div class="i-card-md">
                                <div class="card-header">
                                    <h4 class="card-title d-flex align-items-center gap-2">
                                        <span class="dot-spinner">
                                            <span class="dot-spinner__dot"></span>
                                            <span class="dot-spinner__dot"></span>
                                            <span class="dot-spinner__dot"></span>
                                            <span class="dot-spinner__dot"></span>
                                            <span class="dot-spinner__dot"></span>
                                            <span class="dot-spinner__dot"></span>
                                            <span class="dot-spinner__dot"></span>
                                            <span class="dot-spinner__dot"></span>
                                        </span>

                                        {{translate('Current Plan')}}
                                    </h4>
                                </div>

                                <div class="card-body">
                                    <div class="row align-items-center g-4">
                                        <div class="col-xl-6 col-lg-12 col-md-6">
                                            <div class="current-plan">
                                                <div class="current-plan-img">
                                                    <img
                                                    src="{{asset('assets/images/default/current-plan.gif')}}"
                                                    alt="current-plan.gif"/>
                                                </div>
                                                <h5 class="mb-2">
                                                    {{@$user->runningSubscription->package->title}}
                                                </h5>

                                                <small>{{translate("Expire date")}}:
                                                {{@$user->runningSubscription->expired_at ? get_date_time($user->runningSubscription->expired_at): ucfirst(strtolower(App\Enums\PlanDuration::UNLIMITED->name))}}

                                                </small>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-12 col-md-6">
                                            <div class="permissions">
                                            <h6>
                                                {{translate("specification")}}
                                            </h6>
                                            <ul class="list-group">


                                                @foreach (plan_configuration(@$user->runningSubscription->package) as $configKey => $configVal )

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

                    @if($webhookAccess == App\Enums\StatusEnum::true->status())
                        <div class="tab-pane fade" id="webhook-configuration" role="tabpanel">
                            <div class="i-card-md">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        {{translate("Webhook Configuration")}}
                                    </h4>
                                </div>

                                <div class="card-body">
                                    <form action="{{route('user.webhook.update')}}"  method="post">
                                        @csrf
                                        <div class="row g-4">
                                            <div class="col-lg-6">
                                                <div class="form-inner mb-0">
                                                    <label for="referral_code"
                                                    class="form-label">{{ translate('Api Key') }}
                                                        <small class="text-danger" >*</small>
                                                    </label>

                                                    <div class="input-group">
                                                        <input placeholder="{{translate('Webhook api key')}}" id="webhook_api_key" value="{{$user->webhook_api_key}}" name="webhook_api_key"  type="text" class="form-control" >
                                                        <span class="input-group-text danger pointer key-generate"><i class="bi bi-arrow-repeat"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-inner mb-0">
                                                    <label for="webhookUrl"
                                                    class="form-label">{{ translate('Webhook Url') }}
                                                    </label>

                                                    <div class="input-group">
                                                        <input readonly id="webhookUrl" value="{{route('webhook',['uid' => $user->uid])}}"  type="text" class="form-control" >
                                                        <span data-text ="{{route('webhook',['uid' => $user->uid])}}" class="input-group-text success pointer copy-text"><i class="bi bi-clipboard-check"></i></span>
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
                    @endif

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->

    <div class="i-card mb-4">
      <div class="row g-4">
        <div class="col-xl-9 col-lg-8">
          <div class="d-flex align-items-center justify-content-start flex-sm-nowrap flex-wrap gap-4">
              <div class="avatar-100 profile-picture">
              <div class="file-input">
                <input
                  type="file"
                  name="file-input"
                  id="file-input"
                  class="file-input__input"
                />
                <label class="file-input__label" for="file-input">
                  <span><i class="bi bi-camera-fill"></i></span></label>
              </div>
              <img src="https://i.ibb.co/GC7Q0M2/Ellipse-82.png" class="rounded-50" alt="Ellipse-82">
              </div>
              <div class="text-start">
                <h4>Olivia Clare</h4>
                <p>Joined On 12 Feb 2028 30:25 PM</p>
                <div class="mt-4">
                  <div class="fs-18"><span class="text--dark fw-bold">Email:</span> olivia@gmail.com</div>
                  <div class="fs-18"><span class="text--dark fw-bold">Phone:</span> 0123456789</div>
                </div>
              </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-4">
            <div class="p-gl-4 p-3 bg-light radius-16 border">
                <h5 class="mb-2 fw-normal">Balance</h5>
                <h3>$520.00</h3>
                <div class="d-flex justify-content-start gap-3 mt-3">
                  <a href="#" class="i-btn btn--lg btn--primary capsuled">Update</a>
                  <a href="#" class="i-btn btn--lg btn--primary capsuled">Deposite</a>
                </div>
            </div>
        </div>
      </div>
    </div>
    <div class="i-card">
      <div class="plan-detail">
          <div class="container-fluid px-0">
            <div class="i-card mb-4 border">
              <ul class="nav nav-tabs gap-lg-4 gap-3 style-2 mb-30" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab-one" data-bs-toggle="tab" data-bs-target="#tab-one-pane" type="button" role="tab" aria-controls="tab-one-pane" aria-selected="true">Edit Profile</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-two" data-bs-toggle="tab" data-bs-target="#tab-two-pane" type="button" role="tab" aria-controls="tab-two-pane" aria-selected="false">Password</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-three" data-bs-toggle="tab" data-bs-target="#tab-three-pane" type="button" role="tab" aria-controls="tab-three-pane" aria-selected="false">Affiliate Confiure</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-four" data-bs-toggle="tab" data-bs-target="#tab-four-pane" type="button" role="tab" aria-controls="tab-four-pane" aria-selected="false">Plans</button>
                  </li>
                </ul>
                <p>Pick the plan that works best for you</p>
                <p><span class="fw-bold text--dark">You are still in Solo Plans</span> You are still in solo plan and have decided to go ahead and start using the new plan?</p>
            </div>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="tab-one-pane" role="tabpanel" aria-labelledby="tab-one" tabindex="0">
                <form>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-inner">
                        <label for="name">First Name</label>
                        <input type="text" placeholder="First Name">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-inner">
                        <label for="name">Last Name</label>
                        <input type="text" placeholder="First Name">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-inner">
                        <label for="name">Email</label>
                        <input type="email" placeholder="Enter Email">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <label for="name">Phone Number</label>
                      <div class="form-inner select-with-input">
                          <select class="select2">
                            <option value="+880">+880</option>
                            <option value="+0092">+0092</option>
                            <option value="+0091">+0091</option>
                            <option value="+005">+005</option>
                          </select>
                          <input type="email" placeholder="92000000">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <button class="i-btn btn--lg btn--primary capsuled" type="submit">Update <span><i class="bi bi-arrow-up-right"></i></span></button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane fade" id="tab-two-pane" role="tabpanel" aria-labelledby="tab-two" tabindex="0">
              <form>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-inner">
                        <label for="name">Old Password</label>
                        <input type="text" placeholder="Old Password">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-inner">
                        <label for="name">New Password</label>
                        <input type="text" placeholder="New Password">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-inner">
                        <label for="name">Confirm Password</label>
                        <input type="email" placeholder="Confirm Password">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <button class="i-btn btn--lg btn--primary capsuled" type="submit">Update <span><i class="bi bi-arrow-up-right"></i></span></button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane fade" id="tab-three-pane" role="tabpanel" aria-labelledby="tab-three" tabindex="0">
                <form>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-inner">
                        <label for="name">Referral Code</label>
                        <div class="copy-input">
                          <input type="text" placeholder="Referral Code">
                          <div class="copy-icon">
                            <i class="bi bi-clipboard"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-inner">
                        <label for="name">Referral URL</label>
                        <div class="copy-input">
                          <input type="text" placeholder="Enter Value">
                          <div class="copy-icon">
                            <i class="bi bi-clipboard"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <button class="i-btn btn--lg btn--primary capsuled" type="submit">Update <span><i class="bi bi-arrow-up-right"></i></span></button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane fade" id="tab-four-pane" role="tabpanel" aria-labelledby="tab-four" tabindex="0">
                <div class="plan-detail-wrapper">
                  <div class="row gy-4 gx-4">
                    <div class="col-xl-4 col-md-6">
                      <div class="plan-detail-card">
                        <div class="plan-detail-top">
                          <p class="mb-0">For Mini Business</p>
                          <span>title</span>
                          <p>description</p>

                          <div class="price">
                            <h4>
                              $66
                              <span>$55</span>
                            </h4>
                          </div>
                        </div>
                        <div class="plan-detail-body">
                          <h5 class="mb-4">What’s included</h5>
                          <ul>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Social profile</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Social post</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Pre-built ai template</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Facebook platform access</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Schedule post</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Gpt-3.5-turbo Open ai model</p>
                            </li> 
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>20 Word token</p>
                            </li> 
                          </ul>
                        </div>
                        <a href="#" class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto">Subscribe</a>
                      </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                      <div class="plan-detail-card">
                        <div class="plan-detail-top">
                          <p class="mb-0">For Mini Business</p>
                          <span>title</span>
                          <p>description</p>

                          <div class="price">
                            <h4>
                              $66
                              <span>$55</span>
                            </h4>
                          </div>
                        </div>
                        <div class="plan-detail-body">
                          <h5 class="mb-4">What’s included</h5>
                          <ul>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Social profile</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Social post</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Pre-built ai template</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Facebook platform access</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Schedule post</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Gpt-3.5-turbo Open ai model</p>
                            </li> 
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>20 Word token</p>
                            </li> 
                          </ul>
                        </div>
                        <a href="#" class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto">Subscribe</a>
                      </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                      <div class="plan-detail-card">
                        <div class="plan-detail-top">
                          <p class="mb-0">For Mini Business</p>
                          <span>title</span>
                          <p>description</p>

                          <div class="price">
                            <h4>
                              $66
                              <span>$55</span>
                            </h4>
                          </div>
                        </div>
                        <div class="plan-detail-body">
                          <h5 class="mb-4">What’s included</h5>
                          <ul>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Social profile</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Social post</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>1 Pre-built ai template</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Facebook platform access</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Schedule post</p>
                            </li>
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>Gpt-3.5-turbo Open ai model</p>
                            </li> 
                            <li>
                              <span><i class="bi bi-check-circle-fill"></i></span>
                              <p>20 Word token</p>
                            </li> 
                          </ul>
                        </div>
                        <a href="#" class="i-btn btn--primary btn--lg capsuled text-uppercase mx-auto">Subscribe</a>
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

        "use strict";

        $(".select2").select2({
            placeholder:"{{translate('Select Item')}}",
        })

        $("#country").select2({
            placeholder:"{{translate('Select Country')}}",
        })


	})(jQuery);
</script>
@endpush
