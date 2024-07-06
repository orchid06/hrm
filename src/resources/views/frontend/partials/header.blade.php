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
                        <img src="{{imageURL(@site_logo('user_site_logo')->file,'user_site_logo',true)}}" alt="{{@site_logo('user_site_logo')->file->name}}">
                    </a>
                </div>
            </div>

            <div class="sidebar">
                <div class="sidebar-body">
                    <div class="mobile-logo-area d-lg-none mb-5">
                        <div class="mobile-logo-wrap">
                            <a href="{{route('home')}}">

                                <img src="{{imageURL(@site_logo('user_site_logo')->file,'user_site_logo',true)}}" alt="{{@site_logo('user_site_logo')->file->name}}">

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
                        <img src="{{imageURL(@auth_user('web')->file,'profile,user',true) }}" alt="{{@auth_user('web')->file->name}}" />
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
                                    $megaMenu              = get_content("content_mega_menu")->first();
                                    $intregrationsContent  = get_content("content_integration")->first();
                                    $intregrationsElements = get_content("element_integration");

                                    $hoverImageSize        = get_appearance_img_size('integration','element','hover_image');
                                    $featureImageSize      = get_appearance_img_size('integration','element','feature_image');


                            @endphp

                            @if($megaMenu->value->select_input->status == App\Enums\StatusEnum::true->status() )
                                <li class="menu-item">
                                    <a href="javascript:void(0)" class="menu-link">
                                        {{@$megaMenu->value->title}}
                                        <div class="menu-link-icon">
                                            <i class="bi bi-chevron-down"></i>
                                        </div>
                                    </a>

                                    <div class="mega-menu container-lg px-0">
                                        <div class="mega-menu-wrapper">
                                            <div class="row g-4 h-100">
                                                <div class="col-lg-12">
                                                    <div class="mega-menu-right">
                                                        <div class="row g-0 h-100">
                                                            <div class="col-lg-8">
                                                                <div class="social-integra">
                                                                    <h5> 
                                                                        {{@$intregrationsContent->value->title}}
                                                                    </h5>

                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            @if($intregrationsElements->count() > 0)
                                                                                <div class="mega-menu-integra">
                                                                                    <ul class="nav nav-tabs gap-3" id="customTab" role="tablist">

                                                                                        @forelse ($intregrationsElements as $element)

                                                                                            @php $file = $element->file->where('type',"feature_image")->first(); @endphp

                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a href="{{route('integration',['slug' =>  make_slug($element->value->title) , 'uid' => $element->uid])}}" class="nav-link mega-menu-tab {{$loop->index == 0 ? "active" :""}} menu-social-item"
                                                                                                    id="tab-{{$loop->index}}-tab"
                                                                                                    data-bs-toggle="tab"
                                                                                                    data-bs-target="#tab-{{$loop->index}}"
                                                                                                    role="tab"
                                                                                                    aria-controls="tab-{{$loop->index}}"
                                                                                                    aria-selected="true">
                                                                                                    <div class="social-item-img">
                                                                                                        <img src="{{imageURL($file,'frontend',true,$featureImageSize)}}"
                                                                                                            alt="{{@$file->name ?? @$element->value->title."jpg" }}"
                                                                                                            loading="lazy">
                                                                                                    </div>

                                                                                                    <div class="content">
                                                                                                        <h6 class="mb-1">
                                                                                                            {{$element->value->title}}
                                                                                                        </h6>
                                                                                                        <p> 
                                                                                                            {{$element->value->short_description}}
                                                                                                        </p>
                                                                                                    </div>
                                                                                                </a>
                                                                                            </li>
                                                                                            
                                                                                        @empty
                                                                                            <li class="nav-item" role="presentation">
                                                                                                @include("frontend.partials.not_found")
                                                                                            </li>
                                                                                            
                                                                                        @endforelse
                                                                                        
                                                                                    
                                                                                    </ul>
                                                                                </div>
                                                                            @else
                                                                               @include("frontend.partials.not_found")
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">

                                                                @if($intregrationsElements->count() > 0)
                                                                    <div class="tab-content" id="customTabContent">

                                                                        @foreach ($intregrationsElements as $element)
                                                                            @php 
                                                                                           $file = $element->file->where('type',"hover_image")->first(); 
                                                                            @endphp
                                                                            <div class="tab-pane fade {{$loop->index == 0 ? 
                                                                                "show active" :""}}  " id="tab-{{$loop->index}}"
                                                                                role="tabpanel" aria-labelledby="tab-{{$loop->index}}-tab">
                                                                                <img src="{{imageURL($file,'frontend',true,$hoverImageSize)}}"
                                                                                alt="{{@$file->name?? "preview.jpg"}}">
                                                                            </div>
                                                                         
                                                                        @endforeach
                                                                    </div>
                                                                @else
                                                                    @include("frontend.partials.not_found")
                                                                 @endif
                                                                
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