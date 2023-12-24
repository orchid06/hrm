<header class="header">
  @php
      $lang = $languages->where('code',session()->get('locale'));
      $code = count($lang)!=0 ? $lang->first()->code:"en";
      $languages = $languages->where('code','!=',$code)->where('status',App\Enums\StatusEnum::true->status());
  @endphp

      <div class="header-container">
        <div class="d-flex align-items-center gap-3">
            <div class="d-lg-none">
                <div class="mobile-menu-btn sidebar-trigger">
                <i class="bi bi-list"></i>
                </div>
            </div>

            <div class="header-logo d-none d-sm-block">
                <a href="{{route('home')}}">
                    <img src="{{imageUrl(@site_logo('user_site_logo')->file,'user_site_logo',true)}}" alt="{{@site_logo('user_site_logo')->file->name}}">
                </a>
            </div>
        </div>

        <div class="sidebar">
          <div class="sidebar-body">
            <div class="mobile-logo-area d-lg-none mb-5">
              <div class="mobile-logo-wrap">
                <a href="{{route('home')}}">

                  <img src="{{imageUrl(@site_logo('user_site_logo')->file,'user_site_logo',true)}}" alt="{{@site_logo('user_site_logo')->file->name}}">

                </a>
              </div>

              <div class="closer-sidebar">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  version="1.1"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  x="0"
                  y="0"
                  viewBox="0 0 426.667 426.667"
                >
                  <g>
                    <path
                      d="M426.667 59.733 366.933 0l-153.6 153.6L59.733 0 0 59.733l153.6 153.6L0 366.933l59.733 59.734 153.6-153.6 153.6 153.6 59.734-59.734-153.6-153.6z"
                      opacity="1"
                      data-original="#000000"
                    ></path>
                  </g>
                </svg>
              </div>
            </div>

            <nav>
              <ul class="menu-list">

                <li class="menu-item">
                  <a href="javascript:void(0)" class="menu-link"
                    >Platform
                    <div class="menu-link-icon">
                      <i class="bi bi-chevron-down"></i>
                    </div>
                  </a>

                  <div class="mega-menu container-lg px-0">
                    <div class="mega-menu-wrapper">
                      <div class="row g-0 h-100">
                        <div class="col-lg-3">
                          <div class="mega-menu-left">
                            <div class="maga-menu-item menu-feature">
                              <h5>Capability</h5>
                              <ul>
                                <li>
                                  <a href="javascript:void(0)">
                                    <span
                                      ><i class="bi bi-person-check"></i
                                    ></span>
                                    <div>
                                      <h6>Profile manage</h6>
                                      <p>
                                        Lorem ipsum dolor sit amet consectetur
                                        adipisicing elit. Numquam, sapiente.
                                      </p>
                                    </div>
                                  </a>

                                  <div class="sub-mega-menu">
                                    <div class="sub-menu-content">
                                      <h6>
                                        Manage All Your Social Media Channels
                                        with EngageHub
                                      </h6>

                                      <p>
                                        Create, schedule, and post content
                                        across several social media accounts
                                        from one place.
                                      </p>

                                      <ul>
                                        <li>
                                          <span
                                            ><i class="bi bi-activity"></i
                                          ></span>
                                          <p>Multiple Profile</p>
                                        </li>
                                        <li>
                                          <span
                                            ><i class="bi bi-activity"></i
                                          ></span>
                                          <p>Multiple Profile</p>
                                        </li>
                                        <li>
                                          <span
                                            ><i class="bi bi-activity"></i
                                          ></span>
                                          <p>Multiple Profile</p>
                                        </li>
                                        <li>
                                          <span
                                            ><i class="bi bi-activity"></i
                                          ></span>
                                          <p>Multiple Profile</p>
                                        </li>
                                      </ul>
                                    </div>

                                    <div class="sub-mega-menu-img">
                                      <img
                                        src="./assets/images/3184215.png"
                                        alt=""
                                      />
                                    </div>
                                  </div>
                                </li>

                                <li>
                                  <a href="javascript:void(0)">
                                    <span
                                      ><i class="bi bi-pencil-square"></i
                                    ></span>
                                    <div>
                                      <h6>Create Caption</h6>
                                      <p>
                                        Lorem ipsum dolor sit amet consectetur
                                        adipisicing elit. Numquam, sapiente.
                                      </p>
                                    </div>
                                  </a>

                                  <div class="sub-mega-menu">
                                    <div class="sub-menu-content">
                                      <h6>
                                        Manage All Your Social Media Channels
                                        with EngageHub
                                      </h6>

                                      <p>
                                        Create, schedule, and post content
                                        across several social media accounts
                                        from one place.
                                      </p>

                                      <ul>
                                        <li>
                                          <span
                                            ><i class="bi bi-activity"></i
                                          ></span>
                                          <p>Multiple Profile</p>
                                        </li>
                                        <li>
                                          <span
                                            ><i class="bi bi-activity"></i
                                          ></span>
                                          <p>Multiple Profile</p>
                                        </li>
                                        <li>
                                          <span
                                            ><i class="bi bi-activity"></i
                                          ></span>
                                          <p>Multiple Profile</p>
                                        </li>
                                        <li>
                                          <span
                                            ><i class="bi bi-activity"></i
                                          ></span>
                                          <p>Multiple Profile</p>
                                        </li>
                                      </ul>
                                    </div>

                                    <div class="sub-mega-menu-img">
                                      <img
                                        src="./assets/images/3184215.png"
                                        alt=""
                                      />
                                    </div>
                                  </div>
                                </li>

                                <li>
                                  <a href="javascript:void(0)">
                                    <span
                                      ><i class="bi bi-hourglass-split"></i
                                    ></span>
                                    <div>
                                      <h6>Schedule Post</h6>
                                      <p>
                                        Lorem ipsum dolor sit amet consectetur
                                        adipisicing elit. Numquam, sapiente.
                                      </p>
                                    </div>
                                  </a>
                                </li>

                                <li>
                                  <a href="javascript:void(0)">
                                    <span><i class="bi bi-inboxes"></i></span>
                                    <div>
                                      <h6>Engagement</h6>
                                      <p>
                                        Lorem ipsum dolor sit amet consectetur
                                        adipisicing elit. Numquam, sapiente.
                                      </p>
                                    </div>
                                  </a>
                                </li>

                                <li>
                                  <a href="javascript:void(0)">
                                    <span
                                      ><i class="bi bi-bar-chart-line"></i
                                    ></span>
                                    <div>
                                      <h6>Analytics & Reports</h6>
                                      <p>
                                        Lorem ipsum dolor sit amet consectetur
                                        adipisicing elit. Numquam, sapiente.
                                      </p>
                                    </div>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>

                        <div class="col-lg-9">

                            <div class="mega-menu-right">
                              <div class="row g-0 h-100">
                                <div class="col-lg-8">
                                  <div class="social-integra">
                                    <h5>Top Integrations</h5>
                                    <div class="mega-menu-integra">
                                      <a href="#" class="menu-social-item">
                                        <div class="social-item-img">
                                          <img
                                            src="./assets/images/social-logo/facebook.png"
                                            alt=""
                                          />
                                        </div>
                                        <div>
                                          <h6>Facebook</h6>
                                          <p>Profile,Pages & Groups</p>
                                        </div>
                                      </a>

                                      <a href="#" class="menu-social-item">
                                        <div class="social-item-img">
                                          <img
                                            src="./assets/images/social-logo/instagram.png"
                                            alt=""
                                          />
                                        </div>
                                        <div>
                                          <h6>Instagram</h6>
                                          <p>Profile,Pages & Groups</p>
                                        </div>
                                      </a>

                                      <a href="#" class="menu-social-item">
                                        <div class="social-item-img">
                                          <img
                                            src="./assets/images/social-logo/twitter.png"
                                            alt=""
                                          />
                                        </div>
                                        <div>
                                          <h6>Twitter</h6>
                                          <p>Profile,Pages & Groups</p>
                                        </div>
                                      </a>

                                      <a href="#" class="menu-social-item">
                                        <div class="social-item-img">
                                          <img
                                            src="./assets/images/social-logo/linkedin.png"
                                            alt=""
                                          />
                                        </div>
                                        <div>
                                          <h6>Linkedin</h6>
                                          <p>Profile,Pages & Groups</p>
                                        </div>
                                      </a>

                                      <a href="#" class="menu-social-item">
                                        <div class="social-item-img">
                                          <img
                                            src="./assets/images/social-logo/tik-tok.png"
                                            alt=""
                                          />
                                        </div>
                                        <div>
                                          <h6>TikTok</h6>
                                          <p>Profile,Pages & Groups</p>
                                        </div>
                                      </a>

                                      <a href="#" class="menu-social-item">
                                        <div class="social-item-img">
                                          <img
                                            src="./assets/images/social-logo/youtube.png"
                                            alt=""
                                          />
                                        </div>
                                        <div>
                                          <h6>youtube</h6>
                                          <p>Profile,Pages & Groups</p>
                                        </div>
                                      </a>

                                      <a href="#" class="menu-social-item">
                                        <div class="social-item-img">
                                          <img
                                            src="./assets/images/social-logo/vk.png"
                                            alt=""
                                          />
                                        </div>
                                        <div>
                                          <h6>VK</h6>
                                          <p>Profile,Pages & Groups</p>
                                        </div>
                                      </a>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-lg-4">
                                  <div class="mega-menu-banner">
                                    <img
                                      src="./assets/images/menu-banner.jpg"
                                      alt=""
                                    />
                                  </div>
                                </div>
                              </div>
                            </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </li>

                @foreach ($menus as  $menu)
                    <li class="menu-item">
                        <a href="{{url($menu->url)}}" class="menu-link @if(!request()->routeIs('home') && URL::current() == url($menu->url)) active @endif ">
                          {{$menu->name}}
                        </a>
                    </li>
                @endforeach
                @php
                       $lastSegment = collect(request()->segments())->last();
                @endphp
                @foreach ($pages as  $page)
                    <li class="menu-item">
                        <a href="{{route('page',$page->slug)}}" class="menu-link @if($lastSegment == $page->slug) active @endif ">
                          {{$page->title}}
                        </a>
                    </li>
                @endforeach

              </ul>
            </nav>

            <div class="sidebar-action d-lg-none">
              <div
                class="d-flex align-items-center justify-content-between gap-3">
                  <a href='{{route("plan")}}' class="i-btn btn--primary-outline btn--lg capsuled">
                    {{translate("Get Started")}}
                  </a>

                  @if(!auth_user('web'))
                    <a href='{{route("auth.login")}}' class="i-btn btn--secondary btn--lg capsuled">
                        {{translate('Login')}}
                    </a>
                  @endif
              </div>
            </div>
          </div>

          <div class="sidebar-overlay"></div>
        </div>

        <div class="nav-right d-flex jsutify-content-end align-items-center gap-sm-3 gap-2">

          <div class="lang">
            <div class="dropdown">
              <button class="lang-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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

        @if(auth_user('web'))
            <div class="dropdown profile-dropdown">
                <div class="profile-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true" role="button">
                <span class="profile-img">
                    <img src="{{imageUrl(@auth_user('web')->file,'profile,user',true) }}" alt="{{@auth_user('web')->file->name}}" />
                </span>

                <div class="balance">
                    <p>Balance</p>
                    <h6>$3,000.00</h6>
                </div>
                </div>

                <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 44px);">
                <ul>
                    <li class="dropdown-menu-title">
                    <h6>
                        Welcome, <span class="user-name">Scott Warner</span>!
                    </h6>
                    </li>

                    <li>
                        <a href="{{route('user.profile')}}" class="dropdown-item" >
                            <i class="bi bi-person"></i> {{translate('Profile')}}
                        </a>
                    </li>

                    <li>
                    <a class="dropdown-item" href="/deposit"><i class="bi bi-wallet"></i> Deposit</a>
                    </li>

                    <li>
                    <a class="dropdown-item" href="/withdraw"><i class="bi bi-layer-backward"></i> Withdraw</a>
                    </li>

                    <li>
                    <a href="#" class="dropdown-item"><i class="bi bi-gear"></i> Settings</a>
                    </li>

                    <li class="dropdown-menu-footer">
                        <a href="{{route('user.logout')}}">
                            <i class="bi bi-box-arrow-left"></i> {{translate('Logout')}}
                        </a>
                    </li>
                </ul>
                </div>
            </div>
        @endif

        @if(!auth_user('web'))
            <div class="d-lg-block d-none">
                <a  href="{{route('auth.login')}}" class="i-btn btn--secondary btn--lg capsuled">
                    {{translate("Login")}}
                </a>
            </div>
        @endif
        </div>
      </div>

  </header>
