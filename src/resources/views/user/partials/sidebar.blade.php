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
                <a class="sidebar-menu-link {{sidebar_awake('user.home')}}" data-anim="ripple"
                    href='{{route("user.home")}}' aria-expanded="false">
                    <span><i class="las la-chalkboard"></i></span>
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
                    <span><i class="las la-calendar"></i></span>
                    <p>
                        {{translate('Attendance')}}
                    </p>
                    <small>
                        <i class="las la-angle-down"></i>
                    </small>
                </a>
                <div class="side-menu-dropdown collapse {{sidebar_awake(['user.attendance.*' ,'user.leave.*' ],'drop_down')}} "
                    id="attendanceManagement">
                    <ul class="sub-menu">

                        @if(check_permission('view_office_hour'))
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{sidebar_awake(['user.leave.index' ,'user.leave.request' ])}}"
                                href="{{route('user.leave.index')}}">
                                <span></span>
                                <p>
                                    {{translate('Take Leave')}}
                                </p>
                            </a>
                        </li>
                        @endif

                        @if(check_permission('view_attendance'))
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{sidebar_awake(['user.attendance.index' ])}}"
                                href="{{route('user.attendance.index')}}">
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
                <a class='sidebar-menu-link {{sidebar_awake("user.payslip.*")}}'
                    href='{{route("user.payslip.index")}}'>
                    <span><i class="las la-money-check-alt"></i></span>
                    <p>
                        {{translate('Payslips')}}
                    </p>
                </a>
            </li>
            @endif

            @if(check_permission('view_settings'))
            <li class="sidebar-menu-title">
                {{translate('Employee Info')}}
            </li>
            <li class="sidebar-menu-item">
                <a class='sidebar-menu-link {{sidebar_awake("user.profile")}}'
                    href='{{route("user.profile")}}'>
                    <span><i class="las la-user-circle"></i></span>
                    <p>
                        {{translate('Profile')}}
                    </p>
                </a>
            </li>
            @endif

        </ul>
    </div>
</div>
