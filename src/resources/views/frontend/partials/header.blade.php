<header class="header">
  @php
      $currencies = site_currencies()->where("code",'!=',session()->get('currency')->code);
  @endphp

    <div class="header-container">
        
        <div class="header-left d-flex justify-content-start align-items-center gap-5">
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
                                viewBox="0 0 426.667 426.667">
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

                    <div class="sidebar-wrapper">
                        <nav>
                            <ul class="menu-list">

                            @php
                                $megaMenu     = get_content("content_mega_menu")->first();

                                $menuImg      = $megaMenu->file->where("type",'image')->first();

                                $intregrationsContent   = get_content("content_integration")->first();


                                $platformContent  = get_content("content_platform")->first();
                                $platformElements = get_content("element_platform");

                            @endphp


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

                </div>

                <div class="sidebar-overlay"></div>
            </div>
        </div>    

        <div class="nav-right d-flex jsutify-content-end align-items-center gap-sm-3 gap-2">
            <div class="header-shape-one">
                <svg width="67" height="76" viewBox="0 0 67 76" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M47.4712 75.0976L66.9153 75.0977L66.8965 43.9984L66.7004 0.500002L37.5 8.5L0.714838 12.0024L0.706373 22.9731L0.663656 28.3705L32.3287 28.6211C41.3309 28.6224 47.6453 33.9783 47.4668 43.9986L47.4712 75.0976Z" fill="white"/>
                </svg>
            </div>
            <div class="header-shape-two">
            <svg width="69" height="123" viewBox="0 0 69 123" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M48.3018 122.096L68.0442 122.096L68.0454 90.9967L68.0454 58.0006L1.54537 58.0006L1.53691 69.9713L1.49419 75.3686L33.1593 75.6192C42.1614 75.6205 48.4759 80.9764 48.2974 90.9967L48.3018 122.096Z" fill="white"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M48.1811 1.12326L67.9235 1.07375L67.9973 31.8737L68.0744 64.5525L1.57458 64.7195L1.53816 52.8639L1.48284 47.5186L33.1472 47.1908C42.1494 47.167 48.4513 41.8467 48.2494 31.9233L48.1811 1.12326Z" fill="white"/>
            </svg>
            </div>
            <div class="currency">
                    <button class="dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{session()->get('currency')?->code}}
                    </button>

                    @if($currencies->count() > 0)
                        <ul class="dropdown-menu dropdown-menu-end">
                            @foreach($currencies as $currency)
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
                    </div>

                    <div class="dropdown-menu dropdown-menu-end">
                        <ul>

                            <li class="dropdown-menu-title">
                                <h6>
                                    {{translate('Welcome')}},
                                    <span class="user-name">
                                        {{auth_user('web')->name}}
                                    </span>
                                </h6>
                            </li>

                            <li>
                                <a href="{{route('user.home')}}" class="dropdown-item" >
                                    <i class="bi bi-house"></i> {{translate('Dashboard')}}
                                </a>
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
                    <a  href="{{route('auth.login')}}" class="i-btn btn--primary btn--lg capsuled">
                        {{translate("Login")}}
                    </a>
                </div>
            @endif
        </div>
    </div>

  </header>

