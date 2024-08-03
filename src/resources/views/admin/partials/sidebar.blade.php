
<div class="sidebar">
  <div class="sidebar-logo">
    <a href="{{route('admin.home')}}">
      <img
        src='{{imageURL(@site_logo("site_logo")->file,"site_logo",true)}}'
        alt="site-logo.jpg" />
    </a>

  </div>

  <div class="sidebar-menu-container" data-simplebar>
    <ul class="sidebar-menu">
        @if(check_permission('view_dashboard'))
          <li class="sidebar-menu-title">  {{trans('default.home')}}</li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{sidebar_awake('admin.home')}}" data-anim="ripple" href='{{route("admin.home")}}' aria-expanded="false">
                    <span><i class="las la-chart-line"></i></span>
                    <p> {{translate("Dashboard")}}</p>
                </a>
            </li>
        @endif

        @if( check_permission('view_role') ||  check_permission('view_staff') )
          <li class="sidebar-menu-item">
              <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#role_staff" role="button"
                aria-expanded="false" aria-controls="role_staff">
                <span><i class="las la-user-lock"></i></span>
                  <p>
                    {{translate('Access Control')}}
                  </p>
                  <small >
                    <i class="las la-angle-down"></i>
                  </small>
              </a>
            <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.role.*','admin.staff.*'],'drop_down')}} " id="role_staff">
              <ul class="sub-menu">
                @if(check_permission('view_role'))
                  <li class="sub-menu-item">
                      <a class="sidebar-menu-link {{sidebar_awake('admin.role.*')}}" href="{{route('admin.role.list')}}">
                        <span></span>
                          <p>
                            {{translate('Roles & Permissions')}}
                          </p>
                      </a>
                  </li>
                @endif

                @if(check_permission('view_staff'))
                  <li class="sub-menu-item">
                      <a class="sidebar-menu-link  {{sidebar_awake('admin.staff.*')}}" href="{{route('admin.staff.list')}}">
                          <span></span>
                          <p>
                            {{translate('Staffs')}}
                          </p>
                      </a>
                  </li>
                @endif
              </ul>
            </div>
          </li>
        @endif

        @if(check_permission('view_category'))
          <li class="sidebar-menu-item">
            <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#Category" role="button"
              aria-expanded="false" aria-controls="Category">
              <span><i class="las la-door-open"></i></span>
              <p>
                {{translate('Category')}}
              </p>
              <small >
                <i class="las la-angle-down"></i>
              </small>
            </a>
            <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.category.*'],'drop_down')}} " id="Category">
              <ul class="sub-menu">
                <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{sidebar_awake(['admin.category.list' ,'admin.category.edit' ,'admin.category.subcategories'])}}" href="{{route('admin.category.list')}}">
                      <span></span>
                        <p>
                          {{translate('Categories')}}
                        </p>
                    </a>
                </li>
                <li class="sub-menu-item">
                  <a class="sidebar-menu-link  {{sidebar_awake('admin.category.create')}}" href="{{route('admin.category.create')}}">
                      <span></span>
                      <p>
                        {{translate('Add New')}}
                      </p>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif


        @if(check_permission('view_user'))
            <li class="sidebar-menu-title">
              {{translate('User Statistics & Support')}}
            </li>
            <li class="sidebar-menu-item">
              <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#users" role="button" aria-expanded="false" aria-controls="users">
                <span><i class="las la-users-cog"></i></span>
                <p>
                    {{translate('Manage Users')}}
                </p>
                <small >
                    <i class="las la-angle-down"></i>
                </small>
              </a>
              <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.user.*'],'drop_down')}} " id="users">
                <ul class="sub-menu">

                  <li class="sub-menu-item">
                    <a class='sidebar-menu-link {{sidebar_awake(["admin.user.statistics"])}}'  href='{{route("admin.user.statistics")}}'>
                      <span></span>
                      <p>
                          {{translate('Statistics')}}
                      </p>
                    </a>
                  </li>


                  <li class="sub-menu-item">
                    <a class='sidebar-menu-link {{sidebar_awake(["admin.user.list","admin.user.show"])}}'  href='{{route("admin.user.list")}}'>
                      <span></span>
                      <p>
                          {{translate('All Users')}}
                      </p>
                    </a>
                  </li>
                  <li class="sub-menu-item">
                    <a class='sidebar-menu-link {{sidebar_awake("admin.user.active")}}'  href='{{route("admin.user.active")}}'>
                      <span></span>
                      <p>
                          {{translate('Active Users')}}
                      </p>
                    </a>
                  </li>
                  <li class="sub-menu-item">
                    <a class='sidebar-menu-link {{sidebar_awake("admin.user.banned")}}'  href='{{route("admin.user.banned")}}'>
                      <span></span>
                      <p>
                          {{translate('Banned Users')}}
                      </p>
                    </a>
                  </li>

                  <li class="sub-menu-item">
                    <a class='sidebar-menu-link {{sidebar_awake("admin.user.kyc.verfied")}}'  href='{{route("admin.user.kyc.verfied")}}'>
                      <span></span>
                      <p>
                          {{translate('KYC Verified')}}
                      </p>
                    </a>
                  </li>

                  <li class="sub-menu-item">
                    <a class='sidebar-menu-link {{sidebar_awake("admin.user.kyc.banned")}}'  href='{{route("admin.user.kyc.banned")}}'>
                      <span></span>
                      <p>
                          {{translate('KYC Banned')}}
                      </p>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
        @endif

        @if(check_permission('view_ticket'))
            <li class="sidebar-menu-item">
              <a
                class='sidebar-menu-link {{sidebar_awake("admin.ticket.*")}}'
                data-anim="ripple"
                href='{{route("admin.ticket.list")}}'
                aria-expanded="false">
                <span><i class="las la-question"></i></span>
                <p> {{translate("Support Tickets")}}
                    @if($pending_tickets > 0)
                      <span  data-bs-toggle="tooltip" data-bs-placement="top"    data-bs-title="{{translate('Pending tickets')}}" class="i-badge danger">{{$pending_tickets}}</span>
                    @endif
                </p>
              </a>
            </li>
        @endif

        @if(check_permission('view_report'))
          <li class="sidebar-menu-item">
            <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#report" role="button"
              aria-expanded="false" aria-controls="report">
              <span><i class="las la-stream"></i></span>
                <p>
                  {{translate('Report')}}
                    @if($pending_deposits > 0 || $pending_withdraws > 0 || $pending_kycs > 0  )
                      <span  data-bs-toggle="tooltip" data-bs-placement="top"    data-bs-title="{{translate('Pending reports')}}"  class="i-badge danger">
                          <i class="las la-info"></i>
                      </span>
                    @endif
                </p>
                <small >
                  <i class="las la-angle-down"></i>
                </small>
            </a>
            <div class='side-menu-dropdown collapse {{sidebar_awake(["admin.template.report.*","admin.subscription.report.*","admin.payment.report.*","admin.transaction.report.*","admin.credit.report.*","admin.withdraw.report.*","admin.deposit.report.*" ,"admin.affiliate.report.*","admin.kyc.report.*","admin.webhook.*"],"drop_down")}}' id="report">
              <ul class="sub-menu">
                <li class="sub-menu-item">
                  <a  href='{{route("admin.template.report.list")}}'  class='sidebar-menu-link {{sidebar_awake("admin.template.report.list")}}'>
                      <span></span>
                      <p>
                        {{translate("Template Reports")}}
                      </p>
                  </a>
                </li>
                <li class="sub-menu-item">
                  <a class='sidebar-menu-link {{sidebar_awake("admin.subscription.report.*")}}'  href='{{route("admin.subscription.report.list")}}'>
                    <span></span>
                    <p>
                      {{translate('Subscription Reports')}}
                    </p>
                  </a>
                </li>
                <li class="sub-menu-item">
                  <a class='sidebar-menu-link {{sidebar_awake("admin.credit.report.*")}}'  href='{{route("admin.credit.report.list")}}'>
                    <span></span>
                    <p>
                      {{translate('Credit Reports')}}
                    </p>
                  </a>
                </li>
                <li class="sub-menu-item">
                  <a class='sidebar-menu-link {{sidebar_awake("admin.deposit.report.*")}}'  href='{{route("admin.deposit.report.list")}}'>
                    <span></span>
                    <p>
                      {{translate('Deposit Reports')}}

                      @if($pending_deposits > 0 )
                         <span  data-bs-toggle="tooltip" data-bs-placement="top"    data-bs-title="{{translate('Pending deposit')}}" class="i-badge danger">{{$pending_deposits}}</span>
                      @endif
                    </p>
                  </a>
                </li>
                <li class="sub-menu-item">
                  <a class='sidebar-menu-link {{sidebar_awake("admin.withdraw.report.*")}}'  href='{{route("admin.withdraw.report.list")}}'>
                    <span></span>
                    <p>
                      {{translate('Withdraw Reports')}}

                      @if($pending_withdraws > 0 )
                          <span   data-bs-toggle="tooltip" data-bs-placement="top"    data-bs-title="{{translate('Pending withdraws')}}" class="i-badge danger">{{$pending_withdraws}}</span>
                      @endif
                    </p>
                  </a>
                </li>
                <li class="sub-menu-item">
                  <a class='sidebar-menu-link {{sidebar_awake("admin.affiliate.report.*")}}'  href='{{route("admin.affiliate.report.list")}}'>
                    <span></span>
                    <p>
                      {{translate('Affiliate Reports')}}
                    </p>
                  </a>
                </li>
                <li class="sub-menu-item">
                  <a class='sidebar-menu-link {{sidebar_awake("admin.transaction.report.*")}}'  href='{{route("admin.transaction.report.list")}}'>
                    <span></span>
                    <p>
                      {{translate('Transaction Reports')}}
                    </p>
                  </a>
                </li>
                <li class="sub-menu-item">
                  <a class='sidebar-menu-link {{sidebar_awake("admin.kyc.report.*")}}'  href='{{route("admin.kyc.report.list")}}'>
                    <span></span>
                    <p>
                      {{translate('KYC Reports')}}

                        @if($pending_kycs > 0 )
                            <span  data-bs-toggle="tooltip" data-bs-placement="top"    data-bs-title="{{translate('Pending KYC logs')}}" class="i-badge danger">{{$pending_kycs}}</span>
                        @endif
                    </p>
                  </a>
                </li>

                <li class="sub-menu-item">
                    <a class='sidebar-menu-link {{sidebar_awake("admin.webhook.report.*")}}'  href='{{route("admin.webhook.report.list")}}'>
                      <span></span>
                      <p>
                        {{translate('Webhook Reports')}}
                      </p>
                    </a>
                </li>

              </ul>
            </div>
          </li>
        @endif


       @if(check_permission('view_settings'))
          <li class="sidebar-menu-title">
              {{translate('System Configuration')}}
          </li>
          <li class="sidebar-menu-item">
            <a  class="sidebar-menu-link" data-bs-toggle="collapse" href="#setting" role="button"
              aria-expanded="false" aria-controls="setting">
              <span><i class="las la-cog"></i></span>
                <p>
                  {{translate('System Settings')}}

                </p>
                <small >
                  <i class="las la-angle-down"></i>
                </small>
            </a>
            <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.setting.*','admin.language.*'],'drop_down')}} " id="setting">
              <ul class="sub-menu">
                <li class="sub-menu-item">
                    <a class='sidebar-menu-link {{sidebar_awake("admin.setting.list")}}'  href='{{route("admin.setting.list")}}'>
                      <span></span>
                      <p>
                        {{translate('App Settings')}}
                      </p>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a class='sidebar-menu-link {{sidebar_awake("admin.setting.configuration.*")}}'  href='{{route("admin.setting.configuration.index")}}'>
                      <span></span>
                      <p>
                        {{translate('System Preferences')}}
                      </p>
                    </a>
                </li>

                @if(check_permission('view_language'))
                  <li class="sub-menu-item">
                      <a class='sidebar-menu-link {{sidebar_awake("admin.language.*")}}'  href='{{route("admin.language.list")}}'>
                        <span></span>
                        <p>
                          {{translate('Languages')}}
                        </p>
                      </a>
                  </li>
                @endif

                <li class="sub-menu-item">
                    <a class='sidebar-menu-link {{sidebar_awake("admin.setting.openAi")}}'  href='{{route("admin.setting.openAi")}}'>
                      <span></span>
                        <p>
                          {{translate('AI Configuration')}}
                        </p>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a class='sidebar-menu-link {{sidebar_awake("admin.setting.webhook")}}'  href='{{route("admin.setting.webhook")}}'>
                      <span></span>
                        <p>
                          {{translate('Webhook Configuration')}}
                        </p>
                    </a>
                </li>
                <li class="sub-menu-item">
                  <a class='sidebar-menu-link {{sidebar_awake("admin.setting.affiliate")}}'  href='{{route("admin.setting.affiliate")}}'>
                    <span></span>
                      <p>
                        {{translate('Affiliate Configuration')}}
                      </p>
                  </a>
                </li>
                <li class="sub-menu-item">
                  <a class='sidebar-menu-link {{sidebar_awake("admin.setting.kyc")}}'  href='{{route("admin.setting.kyc")}}'>
                    <span></span>
                      <p>
                        {{translate('KYC Configuration')}}
                      </p>
                  </a>
                </li>
              </ul>
            </div>
          </li>
       @endif

       @if(check_permission('view_Security'))
          <li class="sidebar-menu-item">
            <a  class="sidebar-menu-link" data-bs-toggle="collapse" href="#securitySetting" role="button"
              aria-expanded="false" aria-controls="securitySetting">
              <span><i class="las la-shield-alt"></i></span>
                <p>
                  {{translate('Security Settings')}}

                </p>
                <small >
                  <i class="las la-angle-down"></i>
                </small>
            </a>
            <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.security.*'],'drop_down')}} " id="securitySetting">
              <ul class="sub-menu">
                  <li class="sub-menu-item">
                      <a class='sidebar-menu-link {{sidebar_awake("admin.security.country.list")}}'  href='{{route("admin.security.country.list")}}'>
                        <span></span>
                        <p>
                          {{translate('Countires')}}
                        </p>
                      </a>
                  </li>
                  <li class="sub-menu-item">
                      <a class='sidebar-menu-link {{sidebar_awake("admin.security.ip.list")}}'  href='{{route("admin.security.ip.list")}}'>
                        <span></span>
                        <p>
                           {{translate('IP List')}}
                        </p>
                      </a>
                  </li>
                  <li class="sub-menu-item">
                    <a class='sidebar-menu-link {{sidebar_awake("admin.security.dos")}}'  href='{{route("admin.security.dos")}}'>
                      <span></span>
                      <p>
                         {{translate('Dos Security')}}
                      </p>
                    </a>
                </li>
              </ul>
            </div>
          </li>
       @endif

       {{-- disabled for later user --}}
       {{-- @if(check_permission('view_currency'))
          <li class="sidebar-menu-item">
              <a class='sidebar-menu-link {{sidebar_awake("admin.currency.list")}}' data-anim="ripple" href="{{route('admin.currency.list')}}" aria-expanded="false">
                  <span><i class="las la-euro-sign"></i></span>
                  <p>{{translate('Currencies')}}</p>
              </a>
          </li>
       @endif --}}

       @if(check_permission('view_method'))
        <li class="sidebar-menu-item">
          <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#payment" role="button"
            aria-expanded="false" aria-controls="payment">
            <span><i class="las la-money-bill"></i></span>
              <p>
                {{translate('Payment Gateway')}}
              </p>
              <small >
                  <i class="las la-angle-down"></i>
              </small>
          </a>
          <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.paymentMethod.*'],'drop_down')}} " id="payment">
            <ul class="sub-menu">
                @foreach (['automatic','manual'] as $type)
                  <li class="sub-menu-item">
                      <a class="sidebar-menu-link @if(request()->route('type') == $type )  active @endif"  href='{{route("admin.paymentMethod.list",$type)}}'>
                        <span></span>
                        <p>
                          {{ ucfirst($type).translate(' Method')}}
                        </p>
                      </a>
                  </li>
                @endforeach
            </ul>
          </div>
        </li>
       @endif

      @if(check_permission('view_withdraw'))
        <li class="sidebar-menu-item">
            <a class='sidebar-menu-link {{sidebar_awake(["admin.withdraw.list","admin.withdraw.edit","admin.withdraw.create"])}}' data-anim="ripple" href="{{route('admin.withdraw.list')}}" aria-expanded="false">
                <span><i class="las la-dolly-flatbed"></i></span>
                <p>{{translate('Withdraw Method')}}</p>
            </a>
        </li>
      @endif

      @if(check_permission('view_template'))
          <li class="sidebar-menu-item">
            <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#notificationTemplates" role="button"
              aria-expanded="false" aria-controls="notificationTemplates">
              <span><i class="las la-bell"></i></span>
                <p>
                  {{translate('Notification Templates')}}
                </p>
                <small >
                  <i class="las la-angle-down"></i>
                </small>
            </a>
            <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.template.*'],'drop_down')}} " id="notificationTemplates">
              <ul class="sub-menu">
                <li class="sub-menu-item">
                    <a class='sidebar-menu-link {{sidebar_awake(["admin.template.list","admin.template.edit"])}}' href="{{route('admin.template.list')}}">
                      <span></span>
                        <p>
                            {{translate('Notification Template')}}
                        </p>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{sidebar_awake('admin.template.global')}}" href="{{route('admin.template.global')}}">
                      <span></span>
                        <p>
                            {{translate('Global Template')}}
                        </p>
                    </a>
                </li>
              </ul>
            </div>
          </li>
      @endif


      @if(check_permission('view_gateway'))
          <li class="sidebar-menu-item">
            <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#notificationGateway" role="button"
              aria-expanded="false" aria-controls="notificationGateway">
              <span><i class="las la-cogs"></i></span>
                <p>
                  {{translate('Notification Gateway')}}
                </p>
                <small >
                  <i class="las la-angle-down"></i>
                </small>
            </a>
            <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.mailGateway.*','admin.smsGateway.*'],'drop_down')}} " id="notificationGateway">
              <ul class="sub-menu">
                <li class="sub-menu-item">
                    <a class='sidebar-menu-link {{sidebar_awake("admin.mailGateway.*")}}' href='{{route("admin.mailGateway.list")}}'>
                      <span></span>
                        <p>
                          {{translate('Mail Gateway')}}
                        </p>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{sidebar_awake('admin.smsGateway.*')}}" href="{{route('admin.smsGateway.list')}}">
                      <span></span>
                        <p>
                          {{translate('SMS Gateway')}}
                        </p>
                    </a>
                </li>
              </ul>
            </div>
          </li>
      @endif


      @if(check_permission('view_settings'))
        <li class="sidebar-menu-title">
            {{translate('Server Info')}}
        </li>
        <li class="sidebar-menu-item">
            <a class='sidebar-menu-link {{sidebar_awake("admin.setting.server.info")}}'  href='{{route("admin.setting.server.info")}}'>
              <span><i class="las la-server"></i></span>
              <p>
                {{translate('Server Info')}}
              </p>
            </a>
        </li>


        <li class="sidebar-menu-item">
          <a class='sidebar-menu-link {{sidebar_awake("admin.system.update.init")}}'  href='{{route("admin.system.update.init")}}'>
            <span><i class="las la-ellipsis-h"></i></span>
            <p>
              {{translate('System Update')}}


              <span data-bs-toggle="tooltip" data-bs-placement="top"    data-bs-title="{{translate('APP Version')}}"  class="i-badge danger">

                   {{translate('V')}}{{site_settings("app_version",1.1)}}

              </span>
            </p>
          </a>
      </li>


      @endif

    </ul>
  </div>
</div>
