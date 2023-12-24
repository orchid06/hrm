@extends('layouts.master')
@section('content')

<section class="main-wrapper p-0">
    @php
        $user     = auth_user('web');

        $content  = get_content("content_plan")->first();
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
                    src="{{asset('assets/images/paln.gif')}}"
                    alt="paln.gif"
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
                </ul>
              </div>

              <div class="profile-tab-content">
                <div class="tab-content">
                  <div
                    class="tab-pane active"
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
                                    src="./assets/images/current-plan.gif"
                                    alt=""
                                    />
                                </div>
                                <h5>Free & Trial</h5>
                                <span>Expire date: Unlimited</span>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-12 col-md-6">
                                <div class="permissions">
                                <h6>Planning and Scheduling</h6>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                    <i class="fa fa-check text-success"></i
                                    >Facebook scheduling &amp; report
                                    </li>

                                    <li class="list-group-item">
                                    <i class="fa fa-check text-success"></i>
                                    Instagram scheduling &amp; report
                                    </li>

                                    <li class="list-group-item">
                                    <i class="fa fa-check text-success"></i
                                    >Twitter scheduling &amp; report
                                    </li>

                                    <li class="list-group-item">
                                    <i class="fa fa-check text-success"></i
                                    >Bulk post
                                    </li>

                                    <li class="list-group-item">
                                    <i class="fa fa-check text-success"></i
                                    >Draft posts
                                    </li>

                                    <li class="list-group-item">
                                    <i class="fa fa-check text-success"></i
                                    >OpenAI Generate Content
                                    </li>
                                </ul>
                                </div>
                            </div>
                            </div>
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
    </div>
  </section>

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
