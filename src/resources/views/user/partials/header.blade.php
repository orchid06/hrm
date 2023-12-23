  <header class="header">
    @php
        
        $lang = $languages->where('code',session()->get('locale'));
        $code = count($lang)!=0 ? $lang->first()->code:"en";
        $languages = $languages->where('code','!=',$code)->where('status',App\Enums\StatusEnum::true->status());
        $user = auth_user('web');
    @endphp
    <div class="container-fluid px-0">
      <div class="header-container">
        <div class="d-flex align-items-center gap-3">
          <div class="d-lg-none">
            <div class="mobile-menu-btn sidebar-trigger">
              <i class="bi bi-list"></i>
            </div>
          </div>
          <a href="{{route('user.home')}}" class="header-logo d-none d-sm-block">
        
            <img  class="img-fluid"  src="{{imageUrl(@site_logo('user_site_logo')->file,'user_site_logo',true)}}" alt="{{@site_logo('user_site_logo')->file->name}}">

          </a>
        </div>

        <nav class="nav-bar">
          <ul class="menu-list">
           
            <li class="menu-item">
              <a href="{{route('user.home')}}" class="menu-link"> 
                {{translate("Home")}}
              </a>
            </li>

            <li class="menu-item">
              <a href="{{route('user.plan')}}" class="menu-link"> 
                {{translate("Plans")}}
              </a>
            </li>

            <li class="menu-item">
              <a href="{{route('user.subscription.report.list')}}" class="menu-link">
                  {{translate("Subscriptions")}}
              </a>
            </li>

            <li class="menu-item">
              <a href="{{route("user.transaction.report.list")}}" class="menu-link">
                   {{translate("Transactions")}}
               </a>
            </li>
          </ul>
        </nav>

        <div class="header-right">

          <div class="header-right-item">
            <a href="{{route("home")}}">
              <i class="bi bi-globe-americas"></i>
            </a>


          </div>
           <!-- languages -->
          <div class="header-right-item">
            <div class="dropdown lang">
                <button
                  class="lang-btn dropdown-toggle"
                  type="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false" >
                  <span class="flag">
                     <img src="{{asset('assets/images/global/flags/'.strtoupper($code).'.png') }}" alt="{{$code}}" />

                  </span>
                </button>
                @if(!$languages->isEmpty())
                  <ul class="dropdown-menu dropdown-menu-end">
                  
                    @foreach($languages as $language)
                      <li>
                        <a href="{{route('language.change',$language->code)}}" class="dropdown-item" >
                            <span class="flag">
                                  <img src="{{asset('assets/images/global/flags/'.strtoupper($language->code ).'.png') }}" alt="{{$language->code}}" >
                            </span>
                            {{$language->name}}
                        </a>
                      </li>
                    @endforeach
              
                  </ul>
                @endif
            </div>
          </div>

           <!-- currency -->
          <div class="header-right-item">
            <div class="currency">
                <button
                    class="dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    >
                    {{session()->get('currency')?->code}}
                </button>

                @if(site_currencies() && !site_currencies()->isEmpty())
                    <ul class="dropdown-menu dropdown-menu-end">

                    @foreach(site_currencies()->where("code",'!=',session()->get('currency')->code) as $currency)

                        <li>
                            <a class="dropdown-item" href="{{route('currency.change',$currency->code)}}"> {{$currency->code}}</a>
                        </li>
                    @endforeach

                    </ul>
                @endif
            </div>
          </div>

           <!-- notifications -->

           @php
             
             $notifications = \App\Models\Notification::where('notificationable_type','App\Models\User')
                              ->where("notificationable_id",$user->id)
                              ->unread()
                              ->latest()
                              ->take(8)
                              ->get();
              $notificationCount = $notifications->count();
           @endphp
          <div class="header-right-item">
            <div class="dropdown noti-dropdown">

              @if($notificationCount > 0)
                  <a
                  class="noti-dropdown-btn dropdown-toggle"
                  href="javascript:void(0)"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="bi bi-bell"></i>
                  <span>{{$notificationCount}}</span>
                </a>

             @endif
             

              <ul class="dropdown-menu dropdown-menu-end">
                <li class="dropdown-menu-title">
                  <h6>
                     {{translate("Notifications")}}
                  </h6>
   
                     <span class="i-badge danger">{{$notificationCount}} {{translate('New')}} </span>
            
                </li>

                <li>
                  <div class="notification-items" data-simplebar>
                    <div class="notification-item">
                    
                      <ul>
                        @forelse($notifications as $notification)
                            <li>
                              <a href="javascript:void(0)" class="read-notification" data-id="{{$notification->id}}" data-href="{{$notification->url}}">
                                <div class="notify-icon">
                                  <img src="{{imageUrl(@$user->file,'profile,user',true) }}" alt="{{@$user->file->name}}"/>

                                </div>

                                <div class="notification-item-content">
                                  <h5> {{$user->name}} <small>
                                    {{diff_for_humans($notification->created_at)}}
                                  </small></h5>
                                  <p>
                                    {{
                                      limit_words(strip_tags($notification->message),50)
                                    }}
                                  </p>
                                </div>
                                <span><i class="las la-times"></i></span>
                              </a>
                            </li>
                            @empty
                            <li class="text-center mx-auto mb-2">
                              <p>
                                {{translate("Nothing Found !!")}}
                              </p>
                            </li>
                          @endforelse

                      </ul>
                    </div>
                  </div>
                </li>

                <li>
                  <div class="dropdown-menu-footer">
                      <a href='{{route("user.notifications")}}'>
                        {{translate("View All")}}
                    </a>
                  </div>
                </li>
              </ul>
            </div>
          </div>

          <div class="header-right-item">
            <div class="dropdown profile-dropdown">
              <div
                class="profile-btn dropdown-toggle"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                role="button">
                <span class="profile-img">
                  <img src="{{imageUrl(@$user->file,'profile,user',true) }}" alt="{{@$user->file->name}}"/>
                </span>

                <div class="balance">
                  <p>
                     {{translate("Balance")}}
                  </p>
                  <h6>
                     {{num_format(number:$user->balance,calC:true)}}
                  </h6>
                </div>
              </div>

              <div class="dropdown-menu dropdown-menu-end">
                <ul>
                  <li class="dropdown-menu-title">
                    <h6>
                        {{translate("Welcome")}}, <span class="user-name">
                            {{$user->name}}
                          </span>!
                    </h6>
                  </li>

                  <li>
                    <a href="{{route('user.profile')}}" class="dropdown-item"
                      ><i class="bi bi-person"></i> {{translate("My Account")}}</a>
                  </li>

                  <li>
                     <a href="{{route('user.deposit.create')}}" class="dropdown-item"><i class="bi bi-wallet"></i>

                         {{translate("Deposit")}}
                      </a>
                  </li>

                  <li>
                    <a href="{{route('user.withdraw.create')}}" class="dropdown-item"><i class="bi bi-layer-backward"></i> 
                        {{translate("Withdraw")}}
                    </a>
                  </li>

              

                  <li class="dropdown-menu-footer">
                    <a href="{{route("user.logout")}}">
                      <i class="bi bi-box-arrow-left"></i> 
                        {{translate('Logout')}}
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  @include('user.partials.sidebar')
