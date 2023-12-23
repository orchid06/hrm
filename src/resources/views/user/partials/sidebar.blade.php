<aside class="aside">

      @php
          
        $user = auth_user('web');
      @endphp
    <div class="side-content">
      <a href="{{route('user.home')}}" class="sidebar-logo d-block d-sm-none">
        <div class="site-logo">
              <img alt="image" class="img-fluid"  src="{{imageUrl(@site_logo('user_site_logo')->file,'user_site_logo',true)}}" alt="{{@site_logo('user_site_logo')->file->name}}" />
        </div>
      </a>

      <div class="sidemenu-wrapper">
        <ul class="sidemenu-list">
          <li class="sidemenu-item">
            <a href="{{route("user.home")}}" class="sidemenu-link {{request()->routeIs('user.home') ? "active" :""}}">
              <div
                class="sidemenu-icon"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="Dashboard">
                <i class="bi bi-grid-1x2"></i>
              </div>
              <span class="d-lg-none">
                 {{translate('Dashboard')}}
              </span>
            </a>
          </li>

          {{-- <li class="sidemenu-item">
            <a href="#" class="sidemenu-link">
              <div
                class="sidemenu-icon"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="Analytics"
              >
                <i class="bi bi-bar-chart-line"></i>
              </div>
              <span class="d-lg-none">Analytics</span>
            </a>

            <div class="side-menu-dropdown">
              <div class="menu-dropdown-header">
                <h6>Analytics</h6>
              </div>

              <ul class="sub-menu">
                <li class="sub-menu-item">
                  <a class="sidebar-menu-link" href="#">
                    <span><i class="bi bi-facebook"></i></span>
                    <p>Facebook</p>
                  </a>
                </li>

                <li class="sub-menu-item">
                  <a class="sidebar-menu-link" href="#">
                    <span><i class="bi bi-instagram"></i></span>
                    <p>Instagram</p>
                  </a>
                </li>

                <li class="sub-menu-item">
                  <a class="sidebar-menu-link" href="#">
                    <span><i class="bi bi-twitter-x"></i></span>
                    <p>Twitter</p>
                  </a>
                </li>

                <li class="sub-menu-item">
                  <a class="sidebar-menu-link" href="#">
                    <span><i class="bi bi-linkedin"></i></span>
                    <p>Linkedin</p>
                  </a>
                </li>

                <li class="sub-menu-item">
                  <a class="sidebar-menu-link" href="#">
                    <span><i class="bi bi-youtube"></i></span>
                    <p>You Tube</p>
                  </a>
                </li>
              </ul>
            </div>
          </li> --}}

          {{-- <li class="sidemenu-item">
            <a href="./create-post.html" class="sidemenu-link">
              <div
                class="sidemenu-icon"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="Create Post"
              >
                <i class="bi bi-pencil-square"></i>
              </div>

              <span class="d-lg-none">Create Post</span>
            </a>
          </li> --}}

          {{-- <li class="sidemenu-item">
            <a href="./calendar.html" class="sidemenu-link">
              <div
                class="sidemenu-icon"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="Schedule"
              >
                <i class="bi bi-calendar4-event"></i>
              </div>
              <span class="d-lg-none">Schedule</span>
            </a>
          </li> --}}

          {{-- <li class="sidemenu-item">
            <a href="#" class="sidemenu-link">
              <div
                class="sidemenu-icon"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="Publishing"
              >
                <i class="bi bi-send"></i>
              </div>
              <span class="d-lg-none">Dashboard</span>
            </a>
          </li> --}}

          <li class="sidemenu-item">
            <a href="{{route("user.profile")}}" class="sidemenu-link  {{request()->routeIs('user.profile') ? "active" :""}}">
              <div
                class="sidemenu-icon"
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="Profile">
                <i class="bi bi-person-check"></i>
              </div>

              <span class="d-lg-none">
                 {{translate("Profile")}}
              </span>
            </a>
          </li>

 
        </ul>
      </div>
    </div>
  </aside>