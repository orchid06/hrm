
<div class="sidebar">
  <div class="sidebar-logo">
    <a href="{{route('admin.home')}}">
      <img
        src='{{imageUrl(@site_logo("site_logo")->file,"site_logo",true)}}'
        alt="{{@site_logo('site_logo')->file->name}}" />

    </a>
  </div>

  <div class="sidebar-menu-container" data-simplebar>
    <ul class="sidebar-menu">
      <li class="sidebar-menu-title">  {{trans('default.home')}}</li>

        @if(check_permission('view_dashboard'))
        
            <li class="sidebar-menu-item">
                <a
                    class="sidebar-menu-link {{sidebar_awake('admin.home')}}"
                    data-anim="ripple"
                    href='{{route("admin.home")}}'
                    aria-expanded="false">
                    <span><i class="las la-home"></i></span>
                    <p> {{translate("Dashboard")}}</p>
                </a>
            </li>

        @endif


        @if( check_permission('view_role') ||  check_permission('view_staff') )
       
          <li class="sidebar-menu-item">
              <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#role_staff" role="button"
                aria-expanded="false" aria-controls="role_staff">
                <span><i class="las la-universal-access"></i></span>
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
                <span><i class="las la-border-all"></i></span>
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



        <li class="sidebar-menu-title">
          {{translate('Accounts and Content')}}
        </li>

        @if(check_permission('view_platform'))

          <li class="sidebar-menu-item">
              <a class='sidebar-menu-link {{sidebar_awake("admin.platform.list")}}' data-anim="ripple" href="{{route('admin.platform.list')}}" aria-expanded="false">
                  <span><i class="lab la-buffer"></i></span>
                  <p>{{translate('Social Platforms')}}</p>
              </a>
          </li>

        @endif


        @if(check_permission('view_account'))

          <li class="sidebar-menu-item">
              <a class='sidebar-menu-link {{sidebar_awake("admin.social.account.list")}}' data-anim="ripple" href="{{route('admin.social.account.list')}}" aria-expanded="false">
                  <span><i class="las la-hashtag"></i></span>
                  <p>{{translate('Social Accounts')}}</p>
              </a>
          </li>

        @endif

        

        @if(check_permission('view_ai_template'))
          
            <li class="sidebar-menu-item">

              <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#aiTemplate" role="button"
                aria-expanded="false" aria-controls="aiTemplate">
                <span><i class="las la-money-bill"></i></span>
                  <p>
                    {{translate('Ai Templates')}}
                  </p>
                  <small >
                      <i class="las la-angle-down"></i>
                  </small>
              </a>

              <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.ai.template.*'],'drop_down')}} " id="aiTemplate">
                <ul class="sub-menu">

                      <li class="sub-menu-item">
                          <a  href='{{route("admin.ai.template.list")}}' class='sidebar-menu-link {{sidebar_awake(["admin.ai.template.list","admin.ai.template.edit","admin.ai.template.create","admin.ai.template.content"])}} '>
                            <span></span>
                            <p>
                              {{translate("Templates")}}
                            </p>
                          </a>
                      </li>

                      <li class="sub-menu-item">
                        <a  href='{{route("admin.ai.template.default")}}'  class='sidebar-menu-link {{sidebar_awake("admin.ai.template.default")}}'>
                            <span></span>
                            <p>
                              {{translate("Default Templates")}}
                            </p>
                        </a>
                      </li>


                
                      <li class="sub-menu-item">
                        <a  href='{{route("admin.ai.template.categories")}}' class='sidebar-menu-link {{sidebar_awake(["admin.ai.template.categories","admin.ai.template.category.create"])}}'>
                          <span></span>
                          <p>
                            {{translate("Categories")}}
                          </p>
                        </a>
                    </li>

                </ul>

              </div>
            </li>
        @endif

        @if(check_permission('view_content'))

          <li class="sidebar-menu-item">
              <a class='sidebar-menu-link {{sidebar_awake("admin.content.*")}}'  href='{{route("admin.content.list")}}'>
                <span><i class="las la-pager"></i></span>
                  <p>
                    {{translate('Ai Contents')}}
                  </p>
              </a>
          </li>
        
        @endif

        @if(check_permission('view_package'))

            <li class="sidebar-menu-item">
                <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#packages" role="button"
                  aria-expanded="false" aria-controls="packages">
                  <span><i class="las la-box"></i></span>
                    <p>
                      {{translate('Subscription Packages')}}
                    </p>
                    <small >
                      <i class="las la-angle-down"></i>
                    </small>
                </a>

              <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.subscription.package.*'],'drop_down')}} " id="packages">
                <ul class="sub-menu">

                    <li class="sub-menu-item">
                        <a class="sidebar-menu-link {{sidebar_awake(['admin.subscription.package.list' ,'admin.subscription.package.edit'])}}" href="{{route('admin.subscription.package.list')}}">
                          <span></span>
                            <p>
                              {{translate('Packages')}}
                            </p>
                        </a>
                    </li>

                    <li class="sub-menu-item">
                      <a class="sidebar-menu-link  {{sidebar_awake('admin.subscription.package.create')}}" href="{{route('admin.subscription.package.create')}}">
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
        

        <li class="sidebar-menu-title">
          {{translate('User , Reports & Support')}}
        </li>

        @if(check_permission('view_user'))

          <li class="sidebar-menu-item">
                <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#users" role="button"
                  aria-expanded="false" aria-controls="users">
                  <span><i class="las la-user-friends"></i></span>
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
                  <span><i class="las la-question-circle"></i></span>
                  <p> {{translate("Support Tickets")}}
                      @if($pending_tickets > 0)
                        <span class="i-badge danger">{{$pending_tickets}}</span>
                      @endif
                  </p>
                </a>
            </li>
        @endif

    
        <!-- reports  section -->
        @if(check_permission('view_report'))

          <li class="sidebar-menu-item">

            <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#report" role="button"
              aria-expanded="false" aria-controls="report">
              <span><i class="las la-file-alt"></i></span>
                <p>
                  {{translate('Reports')}}
                    @if($pending_deposits > 0 || $pending_withdraws > 0 || $pending_kycs > 0  )
                      <span class="i-badge danger">
                          <i class="las la-info"></i>
                      </span>
                    @endif
                </p>


                <small >
           
                  <i class="las la-angle-down"></i>
                </small>
            </a>

            <div class='side-menu-dropdown collapse {{sidebar_awake(["admin.template.report.*","admin.subscription.report.*","admin.payment.report.*","admin.transaction.report.*","admin.credit.report.*","admin.withdraw.report.*","admin.deposit.report.*" ,"admin.affiliate.report.*"],"drop_down")}}' id="report">
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
                    
                             <span class="i-badge danger">{{$pending_deposits}}</span>
  
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

                            <span class="i-badge danger">{{$pending_withdraws}}</span>
  
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
                          {{translate('Kyc Reports')}}

                            @if($pending_kycs > 0 )

                              <span class="i-badge danger">{{$pending_kycs}}</span>
  
                            @endif
                        </p>
                      </a>
                  </li>



              </ul>

            </div>
          </li>
        @endif


        <!-- Frontend section  start  -->
        <li class="sidebar-menu-title">
            {{translate('Website Appearance')}}
        </li>

        <li class="sidebar-menu-item">
            <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#frontend" role="button"
              aria-expanded="false" aria-controls="frontend">
              <span><i class="las la-globe-europe"></i></span>
                <p>
                  {{translate('Appearances')}}
                </p>
                <small >
                  <i class="las la-angle-down"></i>
                </small>
            </a>

          <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.appearance.*','admin.menu.*','admin.page.*'],'drop_down')}} " id="frontend">
            <ul class="sub-menu">

                @if(check_permission('view_frontend'))

                  @php
                      $appearanceSegment = collect(request()->segments())->last();
                  @endphp

                  @foreach (get_appearance(true) as $key => $appearance)
                      @if (isset($appearance['builder']) && $appearance['builder'])
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link @if ($key == $appearanceSegment) active @endif"  href='{{route("admin.appearance.list",$key)}}'>
                              <span></span>
                              <p>
                                {{translate(k2t($appearance['name']))}}
                              </p>
                            </a>
                        </li>
                      @endif
                  @endforeach


                @endif

                
                @if(check_permission('view_page'))

                  <li class="sub-menu-item">
                      <a class='sidebar-menu-link {{sidebar_awake("admin.page.*")}}'  href='{{route("admin.page.list")}}'>
                        <span></span>
                        <p>
                          {{translate('Pages')}}
                        </p>
                      </a>
                  </li>

                @endif

                @if(check_permission('view_menu'))

                  <li class="sub-menu-item">
                      <a class='sidebar-menu-link {{sidebar_awake("admin.menu.*")}}' href='{{route("admin.menu.list")}}'>
                        <span></span>
                        <p>
                          {{translate('Menu')}}
                        </p>
                      </a>
                  </li>

                @endif

            </ul>
          </div>
        </li>

        @if(check_permission('view_article'))
          <li class="sidebar-menu-item">
              <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#article" role="button"
                aria-expanded="false" aria-controls="article">
                <span><i class="las la-newspaper"> </i> </span>
                  <p>
                    {{translate('Article')}}
                  </p>
                  <small >
                    <i class="las la-angle-down"></i>
                  </small>
              </a>

            <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.article.*'],'drop_down')}} " id="article">
              <ul class="sub-menu">

                  <li class="sub-menu-item">
                      <a class='sidebar-menu-link {{sidebar_awake(["admin.article.list","admin.article.edit"])}}' href='{{route("admin.article.list")}}'>
                        <span></span>
                        <p>
                          {{translate('Articles')}}
                        </p>
                      </a>
                  </li>

                  <li class="sub-menu-item">
                    <a class="sidebar-menu-link  {{sidebar_awake('admin.article.create')}}" href="{{route('admin.article.create')}}">
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
       <!-- Frontend section  end -->

        @if(check_permission('view_frontend'))

            <li class="sidebar-menu-item">
              <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#marketing" role="button"
                aria-expanded="false" aria-controls="marketing">
                <span><i class="las la-ad"></i> </span>
                  <p>
                    {{translate('Manage Promotions')}}
                  </p>
                  <small >
                    <i class="las la-angle-down"></i>
                  </small>
              </a>

              <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.contact.*','admin.subscriber.*','admin.ad.*'],'drop_down')}} " id="marketing">
                <ul class="sub-menu">


                    <li class="sub-menu-item">
                        <a class='sidebar-menu-link {{sidebar_awake("admin.contact.*")}}'  href='{{route("admin.contact.list")}}'>
                          <span></span>
                            <p>
                              {{translate('Contacts')}}
                            </p>
                        </a>
                    </li>

                    <li class="sub-menu-item">
                      <a class='sidebar-menu-link {{sidebar_awake("admin.subscriber.*")}}'  href='{{route("admin.subscriber.list")}}'>
                        <span></span>
                          <p>
                            {{translate('Subscribers')}}
                          </p>
                      </a>
                    </li>

                </ul>
              </div>
            </li>
        @endif


       <!-- settings  section -->
       @if(check_permission('view_settings'))
          <li class="sidebar-menu-title">
              {{translate('System Configuration')}}
          </li>

          <li class="sidebar-menu-item">

            <a  class="sidebar-menu-link" data-bs-toggle="collapse" href="#setting" role="button"
              aria-expanded="false" aria-controls="setting">
              <span><i class="las la-cog"></i></span>
                <p>
                  {{translate('Applications Settings')}}

                </p>
                <small >
                  <i class="las la-angle-down"></i>
                </small>
            </a>

            <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.setting.*'],'drop_down')}} " id="setting">
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

                <li class="sub-menu-item">
                    <a class='sidebar-menu-link {{sidebar_awake("admin.setting.openAi")}}'  href='{{route("admin.setting.openAi")}}'>
                      <span></span>
                        <p>
                          {{translate('Ai Configuration')}}
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
                        {{translate('Kyc Configuration')}}
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
                           {{translate('Ip List')}}
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


       @if(check_permission('view_currency'))
          <li class="sidebar-menu-item">
              <a class='sidebar-menu-link {{sidebar_awake("admin.currency.list")}}' data-anim="ripple" href="{{route('admin.currency.list')}}" aria-expanded="false">
                  <span><i class="las la-euro-sign"></i></span>
                  <p>{{translate('Currencies')}}</p>
              </a>
          </li>
       @endif


       
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
                <a class='sidebar-menu-link {{sidebar_awake(["admin.withdraw.list","admin.withdraw.edit"])}}' data-anim="ripple" href="{{route('admin.withdraw.list')}}" aria-expanded="false">
                    <span><i class="las la-dolly-flatbed"></i></span>
                    <p>{{translate('Withdraw Method')}}</p>
                </a>
            </li>
        @endif

        @if(check_permission('view_template'))
            <li class="sidebar-menu-item">

              <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#templates" role="button"
                aria-expanded="false" aria-controls="templates">
                <span><i class="las la-bell"></i></span>
                  <p>
                    {{translate('Notification Templates')}}
                  </p>
                  <small >
                    <i class="las la-angle-down"></i>
                  </small>
              </a>

              <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.template.*'],'drop_down')}} " id="templates">
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
              <a class='sidebar-menu-link {{sidebar_awake("admin.mailGateway.*")}}'  href='{{route("admin.mailGateway.list")}}'>
                <span><i class="las la-at"></i></span>
                  <p>
                    {{translate('Mail Gateway')}}
                  </p>
              </a>
          </li>
          <li class="sidebar-menu-item">
              <a class='sidebar-menu-link {{sidebar_awake("admin.smsGateway.*")}}'  href='{{route("admin.smsGateway.list")}}'>
                <span><i class="las la-comment"></i></span>
                  <p>
                    {{translate('Sms Gateway')}}
                  </p>
              </a>
          </li>
        @endif

        @if(check_permission('view_language'))
          
          <li class="sidebar-menu-item">
              <a class='sidebar-menu-link {{sidebar_awake("admin.language.*")}}'  href='{{route("admin.language.list")}}'>
                <span><i class="las la-language"></i></span>
                <p>
                  {{translate('Languages')}}
                </p>
              </a>
          </li>

        @endif


        @if(check_permission('view_settings'))
          <li class="sidebar-menu-title">
              {{translate('Softwae Info')}}
          </li>

          <li class="sidebar-menu-item">
              <a class='sidebar-menu-link {{sidebar_awake("admin.setting.system.info")}}'  href='{{route("admin.setting.system.info")}}'>
                <span><i class="lab la-accusoft"></i></span>
                <p>
                  {{translate('Software Info')}}
                </p>
              </a>
          </li>
        @endif




    </ul>
  </div>
</div>
