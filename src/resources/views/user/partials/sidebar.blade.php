<aside class="aside">

      @php

        $user = auth_user('web');
      @endphp
    <div class="side-content">
      <a href="{{route('user.home')}}" class="sidebar-logo d-block d-sm-none">
        <div class="site-logo">
              <img class="img-fluid"  src="{{imageUrl(@site_logo('user_site_logo')->file,'user_site_logo',true)}}" alt="{{@site_logo('user_site_logo')->file->name}}" />
        </div>
      </a>

      <div class="sidemenu-wrapper">
        <ul class="sidemenu-list">
          <li class="sidemenu-item">
            <a href="{{route("user.home")}}" class="sidemenu-link {{request()->routeIs('user.home') ? "active" :""}}">
              <div
                class="sidemenu-icon"
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="{{translate("Dashboard")}}">
                <i class="bi bi-grid-1x2"></i>
              </div>
              <span class="d-lg-none">
                 {{translate('Dashboard')}}
              </span>
            </a>
          </li>

            @php
                $lastSegment = collect(request()->segments())->last();
            @endphp

          <li class="sidemenu-item">
            <a href="javascript:void(0)" class="sidemenu-link
             @if($lastSegment == "reports")
                 active
             @endif">
              <div
                class="sidemenu-icon"
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="{{translate("Reports")}}">
                <i class="bi bi-graph-up"></i>
              </div>
              <span class="d-lg-none">
                 {{translate("Reports")}}
              </span>
            </a>

            <div class="side-menu-dropdown">
              <div class="menu-dropdown-header">
                <h6>
                   {{translate("Analytical Reports")}}
                </h6>
              </div>

              <ul class="sub-menu">

                  <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{request()->routeIs('user.template.report.*') ? "active" :""}}" href="{{route('user.template.report.list')}}">
                        <span>
                            <i class="bi bi-layers"></i>
                        </span>
                        <p>
                           {{translate('Template Reports')}}
                        </p>
                    </a>
                  </li>

                  <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{request()->routeIs('user.subscription.report.*') ? "active" :""}}" href="{{route('user.subscription.report.list')}}">
                        <span>
                           <i class="bi bi-bookmarks"></i>
                        </span>

                        <p>
                           {{translate('Subscription Reports')}}
                        </p>
                    </a>
                  </li>

                  <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{request()->routeIs('user.credit.report.*') ? "active" :""}}" href="{{route('user.credit.report.list')}}">
                      <span><i class="bi bi-credit-card-2-front"></i></span>
                        <p>
                           {{translate('Credit Reports')}}
                        </p>
                    </a>
                  </li>

                  <li class="sub-menu-item">
                    <a class="sidebar-menu-link  {{request()->routeIs('user.deposit.report.*') ? "active" :""}}" href="{{route('user.deposit.report.list')}}">
                      <span><i class="bi bi-wallet"></i></span>
                        <p>
                           {{translate('Deposit Reports')}}
                        </p>
                    </a>
                  </li>

                  <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{request()->routeIs('user.withdraw.report.*') ? "active" :""}}" href="{{route('user.withdraw.report.list')}}">
                      <span><i class="bi bi-box-arrow-in-up-left"></i></span>
                        <p>
                           {{translate('Withdraw Reports')}}
                        </p>
                    </a>
                  </li>

                  @if(site_settings("affiliate_system") == App\Enums\StatusEnum::true->status())
                    <li class="sub-menu-item">
                      <a class="sidebar-menu-link {{request()->routeIs('user.affiliate.report.*') ? "active" :""}}" href="{{route('user.affiliate.report.list')}}">
                        <span><i class="bi bi-share"></i></span>
                          <p>
                            {{translate('Affiliate Reports')}}
                          </p>
                      </a>
                    </li>
                  @endif

                  <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{request()->routeIs('user.transaction.report.*') ? "active" :""}}" href="{{route('user.transaction.report.list')}}">
                      <span><i class="bi bi-arrow-left-right"></i></span>
                        <p>
                           {{translate('Transaction Reports')}}
                        </p>
                    </a>
                  </li>

                  <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{request()->routeIs('user.kyc.report.*') ? "active" :""}}" href="{{route('user.kyc.report.list')}}">
                      <span><i class="bi bi-shield-lock"></i></span>
                        <p>
                           {{translate('Kyc Reports')}}
                        </p>
                    </a>
                  </li>

              </ul>
            </div>
          </li>

          <li class="sidemenu-item">
            <a href="{{route("user.profile")}}" class="sidemenu-link  {{request()->routeIs('user.profile') ? "active" :""}}">
              <div
                class="sidemenu-icon"
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="{{translate("Profile")}}">
                <i class="bi bi-person-check"></i>
              </div>

              <span class="d-lg-none">
                 {{translate("Profile")}}
              </span>
            </a>
          </li>

          <li class="sidemenu-item">
              <a href="{{route("user.plan")}}" class="sidemenu-link  {{request()->routeIs('user.plan') ? "active" :""}}">
                <div class="sidemenu-icon" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="{{translate("Plans")}}">
                  <i class="bi bi-box-seam"></i>
                </div>
                <span class="d-lg-none">
                  {{translate("Plans")}}
                </span>
              </a>
          </li>

          <li class="sidemenu-item">
                <a href="{{route("user.ticket.list")}}" class="sidemenu-link  {{request()->routeIs('user.ticket.*') ? "active" :""}}">
                <div
                    class="sidemenu-icon"
                    data-bs-toggle="tooltip"
                    data-bs-placement="right"
                    data-bs-custom-class="custom-tooltip"
                    data-bs-title="{{translate('Support Ticket')}}">
                    <i class="bi bi-patch-question"></i>
                </div>

                <span class="d-lg-none">
                    {{translate("Tickets")}}
                </span>
                </a>
          </li>


          <li class="sidemenu-item">
              <a href="{{route("user.ai.content.list")}}" class="sidemenu-link  {{request()->routeIs('user.ai.content.*') ? "active" :""}}">
                <div
                    class="sidemenu-icon"
                    data-bs-toggle="tooltip"
                    data-bs-placement="right"
                    data-bs-custom-class="custom-tooltip"
                    data-bs-title="{{translate('Ai Contents')}}">
                    <i class="bi bi-robot"></i>
                </div>

                <span class="d-lg-none">
                    {{translate("Ai Contents")}}
                </span>
              </a>
          </li>


        </ul>

        
        <!-- Sidebar Bottom  -->
        <div class="d-lg-none align-items-center justify-content-between w-100 d-flex">
           <!-- currency -->
            <div class="dropdown currency">
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

            <!-- Language -->
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
      </div>
    </div>
  </aside>
