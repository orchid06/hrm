<!DOCTYPE html>
<html lang="{{App::getLocale()}}" class="sr">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{csrf_token()}}" />
   <title>{{@site_settings("user_site_name",site_settings('site_name'))}} {{site_settings('title_separator')}} {{Arr::get($meta_data,"title",trans("default.home"))}}</title>
    @include('partials.meta_content')
    <link rel="shortcut icon" href="{{imageURL(@site_logo('favicon')->file,'favicon',true)}}" >
    <link href="{{asset('assets/global/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/bootstrap-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/venobox.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/nice-select.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/aos.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/root.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/common.css')}}" rel="stylesheet" type="text/css" />
      @if(request()->routeIs('user.*'))
         <link href="{{asset('assets/frontend/css/dashboard.css')}}" rel="stylesheet" type="text/css" />
         <link href="{{asset('assets/global/css/remixicon.css')}}" rel="stylesheet" type="text/css" />
         <link href="{{asset('assets/frontend/css/simplebar.min.css')}}" rel="stylesheet" type="text/css" />
         <link href="{{asset('assets/frontend/css/all.min.css')}}" rel="stylesheet" type="text/css" />
      @else
         <link href="{{asset('assets/frontend/css/style.css')}}" rel="stylesheet" type="text/css" />
      @endif
    <link href="{{asset('assets/frontend/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/toastr.css')}}" rel="stylesheet" type="text/css" />
    @if (site_settings("google_analytics") == App\Enums\StatusEnum::true->status() )
       <script async src="https://www.googletagmanager.com/gtag/js?id={{site_settings('google_analytics_tracking_id')}}"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', '{{site_settings("google_analytics_tracking_id")}}');
        </script>
    @endif

    @if (site_settings("google_ads") == App\Enums\StatusEnum::true->status() )
      <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-{{site_settings('google_adsense_publisher_id')}}"
          crossorigin="anonymous"></script>
    @endif
    @include('partials.theme')
    @stack('styles')
    @stack('style-include')

    <style>
        .auth .auth-left::before {
          content: url("{{asset('assets/images/default/auth-bg.png')}}");
          display: block;
          width: 94%;
          z-index: 2;
          height: 94%;
          position: absolute;
          bottom: 0;
          right: 0;
        }
   </style>
  </head>
  <body>

      @if(!request()->routeIs("dos.security") && !request()->routeIs("*auth.*") && site_settings('frontend_preloader') == App\Enums\StatusEnum::true->status())
        <div class="preloader">
            <div class="preloader-content">
                <div class="preloader-logo">
                     <img src="{{imageURL(@site_logo('loader_icon')->file,'loader_icon',true)}}" alt="loader-icon.jpg">
                </div>
                <div class="loader">
                    <span></span>
                </div>

            </div>
        </div>
      @endif

    @if(!request()->routeIs("dos.security") && !request()->routeIs("*auth.*"))
        @if(!request()->routeIs('user.*'))
            @include('frontend.partials.header')
        @else
           @include('user.partials.header')
        @endif
    @endif
    <main class="main" id="main">
         @if(request()->routeIs('user.*'))
            <section class='main-wrapper {{request()->routeIs("user.plan") || request()->routeIs("user.profile") ? "px-25 pt-25" :"" }}'>
                @yield('content')
            </section>
         @else
            @yield('content')
         @endif
    </main>
    @if(!request()->routeIs("dos.security") && !request()->routeIs("*auth.*") && !request()->routeIs('user.*'))
      @include('frontend.partials.footer')
      @if(site_settings("cookie") ==  App\Enums\StatusEnum::true->status() && !session()->has('cookie_consent') )
          @include('frontend.partials.cookie')
      @endif
    @endif
    @yield("modal")

    <script src="{{asset('assets/global/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('assets/frontend/js/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/venobox.min.js')}}"></script>
    <script src="{{asset('assets/global/js/nice-select.min.js')}}"></script>
    <script src="{{asset('assets/global/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/global/js/aos.js')}}"></script>
    @if(request()->routeIs('user.*'))
      <script src="{{asset('assets/frontend/js/dashboard.js')}}"></script>
      <script src="{{asset('assets/frontend/js/simplebar.min.js')}}"></script>
      <script src="{{asset('assets/frontend/js/initiate.js')}}"></script>
    @else
      <script src="{{asset('assets/frontend/js/app.js')}}"></script>
    @endif
    <script src="{{asset('assets/global/js/toastify-js.js')}}"></script>
    <script src="{{asset('assets/global/js/helper.js')}}"></script>

    <script>
      "use strict";

      @if(request()->routeIs('user.*'))


         // update status event start
         $(document).on('click', '.status-update', function (e) {

            const id = $(this).attr('data-id')
            const key = $(this).attr('data-key')
            var column = ($(this).attr('data-column'))
            var route = ($(this).attr('data-route'))
            var modelName = ($(this).attr('data-model'))
            var status = ($(this).attr('data-status'))
            const data = {
                'id': id,
                'model': modelName,
                'column': column,
                'status': status,
                'key': key,
                "_token" :"{{csrf_token()}}",
            }
            updateStatus(route, data)
            })

            // update status method
            function updateStatus(route, data) {
            var responseStatus;
            $.ajax({
                method: 'POST',
                url: route,
                data: data,
                dataType: 'json',
                success: function (response) {

                    if (response) {
                        responseStatus = response.status? "success" :"danger"
                        toastr(response.message,responseStatus)
                        if(response.reload){
                            location.reload()
                        }
                    }
                },
                error: function (error) {
                    if(error && error.responseJSON){
                        if(error.responseJSON.errors){
                            for (let i in error.responseJSON.errors) {
                                toastr(error.responseJSON.errors[i][0],'danger')
                            }
                        }
                        else{
                            toastr( error.responseJSON.error,'danger')
                        }
                    }
                    else{
                        toastr(error.message,'danger')
                    }
                }
            })
            }
      @endif



      function social_share(url, title, w, h) {
          var dualScreenLeft =
            window.screenLeft != undefined ? window.screenLeft : screen.left;
          var dualScreenTop =
            window.screenTop != undefined ? window.screenTop : screen.top;

            var width = window.innerWidth
              ? window.innerWidth
              : document.documentElement.clientWidth
              ? document.documentElement.clientWidth
              : screen.width;
            var height = window.innerHeight
              ? window.innerHeight
              : document.documentElement.clientHeight
              ? document.documentElement.clientHeight
              : screen.height;

            var left = width / 2 - w / 2 + dualScreenLeft;
            var top = height / 2 - h / 2 + dualScreenTop;
            var newWindow = window.open(
              url,
              title,
              "scrollbars=yes, width=" +
                w +
                ", height=" +
                h +
                ", top=" +
                top +
                ", left=" +
                left
            );

            if (window.focus) {
              newWindow.focus();
            }
      }

      // read notification
      $(document).on('click','.read-notification',function(e){
          var href = $(this).attr('data-href')
          var id = $(this).attr('data-id')
          readNotification(href,id)
          e.preventDefault()
      })

      // read Notification
      function readNotification(href,id){
          $.ajax({
              method:'post',
              url: "{{route('user.read.notification')}}",
              data:{
                  "_token": "{{ csrf_token()}}",
                  'id':id
              },
              dataType: 'json'
              }).then(response =>{
              if(!response.status){
                  toastr(response.message,'danger')
              }
              else{
                  window.location.href = href
              }}).fail((jqXHR, textStatus, errorThrown) => {
                  toastr(jqXHR.statusText, 'danger');
              });
      }

      // cookie configuration
      $(document).on('click','.cookie-control',function(e){

          var route = $(this).attr('data-route')
          $.ajax({
                method:'get',
                url: route,
                dataType: 'json',

                success: function(response){

                     toastr(response.message,'success')

                },
                error: function (error){
                    if(error && error.responseJSON){
                        if(error.responseJSON.errors){
                            for (let i in error.responseJSON.errors) {
                                toastr(error.responseJSON.errors[i][0],'danger')
                            }
                        }
                        else{
                            if((error.responseJSON.message)){
                                toastr(error.responseJSON.message,'danger')
                            }
                            else{
                                toastr( error.responseJSON.error,'danger')
                            }
                        }
                    }
                    else{
                        toastr(error.message,'danger')
                    }
                }
            })
      })

      $(document).on('click','.toggle-password',function(e){
          var parentAuthInput = $(this).closest('.auth-input');
          var passwordField = parentAuthInput.find('.toggle-input');
          var fieldType = passwordField.attr('type') === 'password' ? 'text' : 'password';
          passwordField.attr('type', fieldType);
          var toggleIcon = parentAuthInput.find('.toggle-icon');
          toggleIcon.toggleClass('bi-eye bi-eye-slash');
      });

        $(document).on('click','#genarate-captcha',function(e){
            var url = "{{ route('captcha.genarate',[":randId"]) }}"
            url = (url.replace(':randId',Math.random()))
            document.getElementById('default-captcha').src = url;
            e.preventDefault()
        })

        //delete event start
        $(document).on('click', ".delete-item", function (e) {
            e.preventDefault();
            var href = $(this).attr('data-href');
            var message = "{{translate('Are you sure you want to remove these record ?')}}"
            if (($(this).attr('data-message'))) {
                message = $(this).attr('data-message')
            }
            var src = "{{asset('assets/images/default/trash-bin.gif')}}";
            $('.action-img').attr("src",src)
            $("#action-href").attr("href", href);
            $(".warning-message").html(message)
            $("#actionModal").modal("show");
        })


          $(document).on('click', ".subscribe-plan", function (e) {
                e.preventDefault();
                var href = $(this).attr('data-href');
                var message = "{{translate('Are you sure you want to subscribe in this plan?')}}"
                if (($(this).attr('data-message'))) {
                    message = $(this).attr('data-message')
                }

                $("#action-href").attr("href", href);
                $(".warning-message").html(message)
                $("#actionModal").modal("show");
         })


        // Summer note
        $(document).on("click", ".close", function (e) {
            $(this).closest(".modal").modal("hide");
        });
        $(document).on('click', '.note-btn.dropdown-toggle', function (e) {

            var $clickedDropdown = $(this).next();
            $('.note-dropdown-menu.show').not($clickedDropdown).removeClass('show');
            $clickedDropdown.toggleClass('show');
            e.stopPropagation();
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.note-btn.dropdown-toggle').length) {
                $(".note-dropdown-menu").removeClass("show");
            }
        });


    </script>

    @include('partials.notify')
    @stack('script-include')
    @stack('script-push')
  </body>
