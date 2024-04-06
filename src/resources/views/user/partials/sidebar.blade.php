<aside class="aside">
      @php
        $user = auth_user('web');
        $subscription           = $user->runningSubscription;
        $webhookAccess          = @optional($subscription->package->social_access)
                                                 ->webhook_access;

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
                    <a href="{{route('user.home')}}" class="sidemenu-link {{request()->routeIs('user.home') ? 'active' :''}}">
                    <div
                        class="sidemenu-icon"
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="{{translate('Dashboard')}}">
                        <i class="bi bi-grid-1x2"></i>
                    </div>
                    <span>
                        {{translate('Dashboard')}}
                    </span>
                    </a>
                </li>

                @php
                    $lastSegment = collect(request()->segments())->last();
                @endphp

                <li class="sidemenu-item">
                    <a href="javascript:void(0)" class="sidemenu-link
                    @if(request()->routeIs('user.social.post.*'))
                        active
                    @endif">
                    <div
                        class="sidemenu-icon"
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="{{translate('Post Feed')}}">
                        <i class="bi bi-stickies"></i>

                    </div>
                    <span>
                        {{translate("Post Feed")}}

                        <small><i class="bi bi-chevron-down"></i></small>
                    </span>
                    </a>

                    <div class="side-menu-dropdown">
                        <ul class="sub-menu">
                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link {{request()->routeIs('user.social.post.create') ? 'active' :''}}" href="{{route('user.social.post.create')}}">
                                    <span>
                                        <i class="bi bi-pencil-square"></i>
                                    </span>
                                    <p>
                                    {{translate('Create Post')}}
                                    </p>
                                </a>
                            </li>

                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link {{request()->routeIs('user.social.post.show') || request()->routeIs('user.social.post.list')  ? 'active' :''}}" href="{{route('user.social.post.list')}}">
                                    <span>
                                    <i class="bi bi-newspaper"></i>
                                    </span>
                                    <p>
                                    {{translate('All Post')}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidemenu-item">
                    <a href="{{route('user.ai.content.list')}}" class="sidemenu-link  {{request()->routeIs('user.ai.content.*') ? 'active' :''}}">
                        <div
                            class="sidemenu-icon"
                            data-bs-toggle="tooltip"
                            data-bs-placement="right"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="{{translate('Ai Contents')}}">
                            <i class="bi bi-robot"></i>
                        </div>

                        <span>
                            {{translate("Ai Contents")}}
                        </span>
                    </a>
                </li>

                <li class="sidemenu-item">
                    <a href="{{route('user.social.account.list')}}" class="sidemenu-link  {{request()->routeIs('user.social.account.*') ? 'active' :''}}">
                    <div
                        class="sidemenu-icon"
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="{{translate('Social Accounts')}}">
                        <i class="bi bi-person-gear"></i>
                    </div>

                    <span>
                        {{translate("Social Accounts")}}
                    </span>
                    </a>
                </li>

                <li class="sidemenu-item">
                    <a href="{{route('user.plan')}}" class="sidemenu-link  {{request()->routeIs('user.plan') ? 'active' :''}}">
                        <div class="sidemenu-icon" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="{{translate('Plans')}}">
                        <i class="bi bi-box-seam"></i>
                        </div>
                        <span>
                        {{translate("Plans")}}
                        </span>
                    </a>
                </li>

                <li class="sidemenu-item">
                    <a href="javascript:void(0)" class='sidemenu-link
                    @if($lastSegment == "reports")
                        active
                    @endif'>
                    <div
                        class="sidemenu-icon"
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="{{translate('Analytical Reports')}}">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <span>
                        {{translate("Reports")}}  <small><i class="bi bi-chevron-down"></i></small>
                    </span>
                    </a>

                    <div class="side-menu-dropdown">
                        <ul class="sub-menu">
                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link {{request()->routeIs('user.template.report.*') ? 'active' :''}}" href="{{route('user.template.report.list')}}">
                                    <span>
                                        <i class="bi bi-layers"></i>
                                    </span>
                                    <p>
                                    {{translate('Template Reports')}}
                                    </p>
                                </a>
                            </li>

                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link {{request()->routeIs('user.subscription.report.*') ? 'active' :''}}" href="{{route('user.subscription.report.list')}}">
                                    <span>
                                    <i class="bi bi-bookmarks"></i>
                                    </span>

                                    <p>
                                    {{translate('Subscription Reports')}}
                                    </p>
                                </a>
                            </li>

                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link {{request()->routeIs('user.credit.report.*') ? 'active' :''}}" href="{{route('user.credit.report.list')}}">
                                <span><i class="bi bi-credit-card-2-front"></i></span>
                                    <p>
                                    {{translate('Credit Reports')}}
                                    </p>
                                </a>
                            </li>

                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link  {{request()->routeIs('user.deposit.report.*') ? 'active' :''}}" href="{{route('user.deposit.report.list')}}">
                                <span><i class="bi bi-wallet"></i></span>
                                    <p>
                                    {{translate('Deposit Reports')}}
                                    </p>
                                </a>
                            </li>

                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link {{request()->routeIs('user.withdraw.report.*') ? 'active' :''}}" href="{{route('user.withdraw.report.list')}}">
                                <span><i class="bi bi-box-arrow-in-up-left"></i></span>
                                    <p>
                                    {{translate('Withdraw Reports')}}
                                    </p>
                                </a>
                            </li>

                            @if(site_settings("affiliate_system") == App\Enums\StatusEnum::true->status())
                                <li class="sub-menu-item">
                                    <a class="sidebar-menu-link {{request()->routeIs('user.affiliate.report.*') ? 'active' :''}}" href="{{route('user.affiliate.report.list')}}">
                                        <span><i class="bi bi-share"></i></span>
                                        <p>
                                            {{translate('Affiliate Reports')}}
                                        </p>
                                    </a>
                                </li>

                                <li class="sub-menu-item">
                                    <a class="sidebar-menu-link {{request()->routeIs('user.affiliate.user.*') ? 'active' :''}}" href="{{route('user.affiliate.user.list')}}">
                                        <span><i class="bi bi-people"></i></span>
                                        <p>
                                            {{translate('Affiliate Users')}}
                                        </p>
                                    </a>
                                </li>
                            @endif

                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link {{request()->routeIs('user.transaction.report.*') ? 'active' :''}}" href="{{route('user.transaction.report.list')}}">
                                <span><i class="bi bi-arrow-left-right"></i></span>
                                    <p>
                                    {{translate('Transaction Reports')}}
                                    </p>
                                </a>
                            </li>

                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link {{request()->routeIs('user.kyc.report.*') ? 'active' :''}}" href="{{route('user.kyc.report.list')}}">
                                <span><i class="bi bi-shield-lock"></i></span>
                                    <p>
                                    {{translate('Kyc Reports')}}
                                    </p>
                                </a>
                            </li>
                            @if($webhookAccess == App\Enums\StatusEnum::true->status())
                                <li class="sub-menu-item">
                                    <a class="sidebar-menu-link {{request()->routeIs('user.webhook.report.*') ? 'active' :''}}" href="{{route('user.webhook.report.list')}}">
                                    <span><i class="bi bi-bell"></i></span>
                                        <p>
                                           {{translate('Webhook Reports')}}
                                        </p>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </li>

                <li class="sidemenu-item">
                        <a href="{{route('user.ticket.list')}}" class="sidemenu-link  {{request()->routeIs('user.ticket.*') ? 'active' :''}}">
                        <div
                            class="sidemenu-icon"
                            data-bs-toggle="tooltip"
                            data-bs-placement="right"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="{{translate('Support Ticket')}}">
                            <i class="bi bi-patch-question"></i>
                        </div>

                        <span>
                            {{translate("Tickets")}}
                        </span>
                        </a>
                </li>

                <li class="sidemenu-item">
                    <a href="{{route('user.profile')}}" class="sidemenu-link  {{request()->routeIs('user.profile') ? 'active' :''}}">
                    <div
                        class="sidemenu-icon"
                        data-bs-toggle="tooltip"
                        data-bs-placement="right"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="{{translate('Profile')}}">
                        <i class="bi bi-gear"></i>
                    </div>

                    <span>
                        {{translate("Profile")}}
                    </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
  </aside>
