<!-- <header class="header">
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

            <a href="#" class="i-btn btn--md btn--dark capsuled">Get Started <span><i class="bi bi-arrow-up-right"></i></span></a>
        </div>
    </div>

  </header>
 -->

<header class="header">
    @php
    $currencies = site_currencies()->where("code",'!=',session()->get('currency')->code);
    @endphp

    <div class="header-container">
        <div class="d-flex align-items-center gap-3">

            <div class="header-logo">
                <a href="{{route('home')}}">
                    <img src="{{imageUrl(@site_logo('user_site_logo')->file,'user_site_logo',true)}}"
                        alt="{{@site_logo('user_site_logo')->file->name}}">
                </a>
            </div>
        </div>

        <div class="sidebar">
            <div class="sidebar-body">
                <div class="mobile-logo-area d-lg-none mb-5">
                    <div class="mobile-logo-wrap">
                        <a href="{{route('home')}}">

                            <img src="{{imageUrl(@site_logo('user_site_logo')->file,'user_site_logo',true)}}"
                                alt="{{@site_logo('user_site_logo')->file->name}}">

                        </a>
                    </div>

                    <div class="closer-sidebar">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                            x="0" y="0" viewBox="0 0 426.667 426.667">
                            <g>
                                <path
                                    d="M426.667 59.733 366.933 0l-153.6 153.6L59.733 0 0 59.733l153.6 153.6L0 366.933l59.733 59.734 153.6-153.6 153.6 153.6 59.734-59.734-153.6-153.6z"
                                    opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                    </div>
                </div>

                <div class="sidebar-wrapper">
                    <nav>
                        <ul class="menu-list">

                            @php
                            $megaMenu = get_content("content_mega_menu")->first();

                            $menuImg = $megaMenu->file->where("type",'image')->first();

                            $intregrationsContent = get_content("content_integration")->first();


                            $platformContent = get_content("content_platform")->first();
                            $platformElements = get_content("element_platform");

                            @endphp

                            @if($megaMenu->value->select_input->status == App\Enums\StatusEnum::true->status() )
                            <li class="menu-item">
                                <a href="javascript:void(0)" class="menu-link">
                                    {{@$megaMenu->value->title}}
                                    <div class="menu-link-icon">
                                        <i class="bi bi-chevron-down"></i>
                                    </div>
                                </a>

                                <!-- <div class="mega-menu container-lg px-0">
                                    <div class="mega-menu-wrapper">
                                        <div class="row g-0 h-100">
                                            <div class="col-lg-12">
                                                <div class="mega-menu-right">
                                                    <div class="row g-0 h-100">
                                                        <div class="col-lg-8">
                                                            <div class="social-integra">
                                                                <h5>    {{$intregrationsContent->value->sub_title }}</h5>

                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="mega-menu-integra">
                                                                            @forelse ($platforms->where('is_integrated',App\Enums\StatusEnum::true->status())   as  $platform)
                                                                                <a href="{{$platform->url}}" class="menu-social-item">
                                                                                    <div class="social-item-img">
                                                                                        <img src='{{imageUrl(@$platform->file,"platform",true)}}'
                                                                                        alt="{{@$platform->file->name}}" loading="lazy"/>
                                                                                    </div>

                                                                                    <div class="content">
                                                                                        <h6 class="mb-1"> {{$platform->name}}</h6>
                                                                                        <p>     {{$platform->description}}</p>
                                                                                    </div>
                                                                                </a>
                                                                            @empty

                                                                                <div class="text-center">
                                                                                    {{translate('No data found')}}
                                                                                </div>

                                                                            @endforelse
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="mega-menu-banner">
                                                                <img src='{{imageUrl(@$menuImg,"frontend",true,@get_appearance()->mega_menu->content->images->image->size)}}' alt="{{@$menuImg->name}}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="mega-menu container-lg px-0">
                                    <div class="mega-menu-wrapper">
                                        <div class="row g-4 h-100">
                                            <div class="col-lg-12">
                                                <div class="mega-menu-right">
                                                    <div class="row g-0 h-100">
                                                        <div class="col-lg-8">
                                                            <div class="social-integra">
                                                                <h5> Our Integrations</h5>

                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="mega-menu-integra">
                                                                            <ul class="nav nav-tabs gap-3" id="customTab" role="tablist">
                                                                                <li class="nav-item" role="presentation">
                                                                                    <a href="http://localhost/engageHub/pages/cookies-policy" class="nav-link active menu-social-item"
                                                                                        id="tab-one-tab"
                                                                                        data-bs-toggle="tab"
                                                                                        data-bs-target="#tab-one"
                                                                                        role="tab"
                                                                                        aria-controls="tab-one"
                                                                                        aria-selected="true">
                                                                                        <div class="social-item-img">
                                                                                            <img src="http://localhost/EngageHub/default/image/50x50"
                                                                                                alt="659fe0b52c9ac1704976565.png"
                                                                                                loading="lazy">
                                                                                        </div>

                                                                                        <div class="content">
                                                                                            <h6 class="mb-1"> Facebook
                                                                                            </h6>
                                                                                            <p> Seamlessly execute
                                                                                                social media
                                                                                                management and social
                                                                                                customer
                                                                                                care on Facebook from a
                                                                                                single,
                                                                                                scalable platform</p>
                                                                                        </div>
                                                                                    </a>
                                                                                </li>
                                                                                <li class="nav-item" role="presentation">
                                                                                    <a class="nav-link menu-social-item"
                                                                                        id="tab-two-tab"
                                                                                        data-bs-toggle="tab"
                                                                                        data-bs-target="#tab-two"
                                                                                        type="button" role="tab"
                                                                                        aria-controls="tab-two"
                                                                                        aria-selected="false">
                                                                                        <div class="social-item-img">
                                                                                            <img src="http://localhost/EngageHub/default/image/50x50"
                                                                                                alt="659fe0bd0df891704976573.png"
                                                                                                loading="lazy">
                                                                                        </div>

                                                                                        <div class="content">
                                                                                            <h6 class="mb-1"> Instagram</h6>
                                                                                            <p> Seamlessly execute social media
                                                                                                management and social customer
                                                                                                care on Instagram from a single,
                                                                                                scalable platform</p>
                                                                                        </div>
                                                                                    </a>
                                                                                </li>
                                                                                <li class="nav-item"
                                                                                    role="presentation">
                                                                                    <a class="nav-link menu-social-item"
                                                                                        id="tab-three-tab"
                                                                                        data-bs-toggle="tab"
                                                                                        data-bs-target="#tab-three"
                                                                                        type="button" role="tab"
                                                                                        aria-controls="tab-three"
                                                                                        aria-selected="false">
                                                                                        <div class="social-item-img">
                                                                                            <img src="http://localhost/EngageHub/default/image/50x50"
                                                                                                alt="659fe0dc967521704976604.png"
                                                                                                loading="lazy">
                                                                                        </div>

                                                                                        <div class="content">
                                                                                            <h6 class="mb-1"> Twitter</h6>
                                                                                            <p> Seamlessly execute social media
                                                                                                management and social customer
                                                                                                care on Twitter from a single,
                                                                                                scalable platform</p>
                                                                                        </div>
                                                                                    </a>
                                                                                </li>
                                                                                <li class="nav-item"
                                                                                    role="presentation">
                                                                                    <a class="nav-link menu-social-item"
                                                                                        id="tab-four-tab"
                                                                                        data-bs-toggle="tab"
                                                                                        data-bs-target="#tab-four"
                                                                                        type="button" role="tab"
                                                                                        aria-controls="tab-four"
                                                                                        aria-selected="false">
                                                                                        <div class="social-item-img">
                                                                                            <img src="http://localhost/EngageHub/default/image/50x50"
                                                                                                alt="659fe10a6dbe71704976650.png"
                                                                                                loading="lazy">
                                                                                        </div>

                                                                                        <div class="content">
                                                                                            <h6 class="mb-1"> Linkedin</h6>
                                                                                            <p> Seamlessly execute social media
                                                                                                management and social customer
                                                                                                care on Linkedin from a single,
                                                                                                scalable platform</p>
                                                                                        </div>
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="tab-content" id="customTabContent">
                                                                <div class="tab-pane fade show active" id="tab-one"
                                                                    role="tabpanel" aria-labelledby="tab-one-tab">
                                                                    <img src="http://localhost/EngageHub/default/image/600x760"
                                                                    alt="658909058249c1703479557.jpg">
                                                                </div>
                                                                <div class="tab-pane fade" id="tab-two" role="tabpanel"
                                                                    aria-labelledby="tab-two-tab">
                                                                    <img src="http://localhost/EngageHub/default/image/600x760"
                                                                    alt="658909058249c1703479557.jpg">
                                                                </div>
                                                                <div class="tab-pane fade" id="tab-three"
                                                                    role="tabpanel" aria-labelledby="tab-three-tab">
                                                                    <img src="http://localhost/EngageHub/default/image/600x760"
                                                                    alt="658909058249c1703479557.jpg">
                                                                </div>
                                                                <div class="tab-pane fade" id="tab-four" role="tabpanel"
                                                                    aria-labelledby="tab-four-tab">
                                                                    <img src="http://localhost/EngageHub/default/image/600x760"
                                                                    alt="658909058249c1703479557.jpg">
                                                                </div>
                                                            </div>
                                                            <!-- <div class="mega-menu-banner">
                                                                <img src="http://localhost/EngageHub/default/image/600x760"
                                                                    alt="658909058249c1703479557.jpg">
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif

                            @foreach ($menus as $menu)
                            <li class="menu-item">
                                <a href="{{url($menu->url)}}"
                                    class="menu-link @if(!request()->routeIs('home') && URL::current() == url($menu->url)) active @endif ">
                                    {{$menu->name}}
                                </a>
                            </li>
                            @endforeach
                            @php
                            $lastSegment = collect(request()->segments())->last();
                            @endphp
                            @foreach ($pages as $page)
                            <li class="menu-item">
                                <a href="{{route('page',$page->slug)}}"
                                    class="menu-link @if($lastSegment == $page->slug) active @endif ">
                                    {{$page->title}}
                                </a>
                            </li>
                            @endforeach

                        </ul>
                    </nav>

                    <div class="sidebar-action d-lg-none">
                        <div class="d-flex align-items-center justify-content-between gap-3">
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

        <div class="nav-right d-flex jsutify-content-end align-items-center gap-sm-3 gap-2">

            <div class="d-lg-none">
                <div class="mobile-menu-btn sidebar-trigger">
                    <i class="bi bi-list"></i>
                </div>
            </div>
            <div class="currency">
                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{session()->get('currency')?->code}}
                </button>

                @if($currencies->count() > 0)
                <ul class="dropdown-menu dropdown-menu-end">
                    @foreach($currencies as $currency)
                    <li>
                        <a class="dropdown-item" href="{{route('currency.change',$currency->code)}}">
                            {{$currency->code}}</a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>

            @if(auth_user('web'))
            <div class="dropdown profile-dropdown">
                <div class="profile-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true" role="button">
                    <span class="profile-img">
                        <img src="{{imageUrl(@auth_user('web')->file,'profile,user',true) }}"
                            alt="{{@auth_user('web')->file->name}}" />
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
                            <a href="{{route('user.home')}}" class="dropdown-item">
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
                <a href="{{route('auth.login')}}" class="i-btn btn--secondary btn--lg capsuled">
                    {{translate("Login")}}
                </a>
            </div>
            @endif
        </div>
    </div>

</header>