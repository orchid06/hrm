<div class="sidebar">
    <div class="sidebar-logo">
        <a href="{{route('admin.home')}}">
            <img src='{{imageURL(@site_logo("site_logo")->file,"site_logo",true)}}' alt="site-logo.jpg" />
        </a>

    </div>

    <div class="sidebar-menu-container" data-simplebar>
        <ul class="sidebar-menu">
            @if(check_permission('view_dashboard'))
            <li class="sidebar-menu-title"> {{trans('default.home')}}</li>
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{sidebar_awake('admin.home')}}" data-anim="ripple"
                    href='{{route("user.home")}}' aria-expanded="false">
                    <span><i class="las la-chart-line"></i></span>
                    <p> {{translate("Dashboard")}}</p>
                </a>
            </li>
            @endif



            <li class="sidebar-menu-title">
                {{translate('Management')}}
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link " data-bs-toggle="collapse" href="#attendanceManagement" role="button"
                    aria-expanded="false" aria-controls="attendanceManagement">
                    <span><i class="las la-door-open"></i></span>
                    <p>
                        {{translate('Attendance')}}
                    </p>
                    <small>
                        <i class="las la-angle-down"></i>
                    </small>
                </a>
                <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.attendance.*' , 'admin.office.hour.*'],'drop_down')}} "
                    id="attendanceManagement">
                    <ul class="sub-menu">

                        @if(check_permission('view_office_hour'))
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{sidebar_awake(['admin.office.hour.view' ,'admin.office.hour.store' ])}}"
                                href="{{route('admin.office.hour.view')}}">
                                <span></span>
                                <p>
                                    {{translate('Take Leave')}}
                                </p>
                            </a>
                        </li>
                        @endif

                        @if(check_permission('view_attendance'))
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{sidebar_awake(['admin.attendance.list' ,'admin.attendance.edit' ])}}"
                                href="{{route('admin.attendance.list')}}">
                                <span></span>
                                <p>
                                    {{translate('Attendance sheet')}}
                                </p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>

            @if(check_permission('view_settings'))

            <li class="sidebar-menu-item">
                <a class='sidebar-menu-link {{sidebar_awake("admin.setting.server.info")}}'
                    href='{{route("admin.setting.server.info")}}'>
                    <span><i class="las la-server"></i></span>
                    <p>
                        {{translate('Payslips')}}
                    </p>
                </a>
            </li>
            @endif



            @if(check_permission('view_Security'))
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link" data-bs-toggle="collapse" href="#securitySetting" role="button"
                    aria-expanded="false" aria-controls="securitySetting">
                    <span><i class="las la-shield-alt"></i></span>
                    <p>
                        {{translate('Security Settings')}}

                    </p>
                    <small>
                        <i class="las la-angle-down"></i>
                    </small>
                </a>
                <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.security.*'],'drop_down')}} "
                    id="securitySetting">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a class='sidebar-menu-link {{sidebar_awake("admin.security.country.list")}}'
                                href='{{route("admin.security.country.list")}}'>
                                <span></span>
                                <p>
                                    {{translate('Countires')}}
                                </p>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a class='sidebar-menu-link {{sidebar_awake("admin.security.ip.list")}}'
                                href='{{route("admin.security.ip.list")}}'>
                                <span></span>
                                <p>
                                    {{translate('IP List')}}
                                </p>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a class='sidebar-menu-link {{sidebar_awake("admin.security.dos")}}'
                                href='{{route("admin.security.dos")}}'>
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
            @if(check_permission('view_currency'))
            <li class="sidebar-menu-item">
                <a class='sidebar-menu-link {{sidebar_awake("admin.currency.list")}}' data-anim="ripple"
                    href="{{route('admin.currency.list')}}" aria-expanded="false">
                    <span><i class="las la-euro-sign"></i></span>
                    <p>{{translate('Currencies')}}</p>
                </a>
            </li>
            @endif






            @if(check_permission('view_settings'))
            <li class="sidebar-menu-title">
                {{translate('Employee Info')}}
            </li>
            <li class="sidebar-menu-item">
                <a class='sidebar-menu-link {{sidebar_awake("admin.setting.server.info")}}'
                    href='{{route("admin.setting.server.info")}}'>
                    <span><i class="las la-server"></i></span>
                    <p>
                        {{translate('Profile')}}
                    </p>
                </a>
            </li>





            @endif

        </ul>
    </div>
</div>
