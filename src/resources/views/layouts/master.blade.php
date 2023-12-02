<!DOCTYPE html>
<html lang="{{App::getLocale()}}" class="sr" data-sidebar="open">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{csrf_token()}}" />

   <title>{{@site_settings("site_name")}} {{site_settings('title_separator')}} {{Arr::get($meta_data,"title",trans("default.home"))}}</title>


    @include('partials.meta_content')

    <link rel="shortcut icon" href="{{imageUrl(@site_logo('favicon')->file,"favicon",true)}}" alt="{{@site_logo('site_favicon')->file?->name}}">


    <link href="{{asset('assets/global/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/bootstrap-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/swiper.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/nice-select.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/select2.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('assets/frontend/css/root.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/toastr.css')}}" rel="stylesheet" type="text/css" />

    @if (site_settings("google_analytics") == App\Enums\StatusEnum::true->status() )
       <script async src="https://www.googletagmanager.com/gtag/js?id={{site_settings("google_analytics_tracking_id")}}"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', '{{site_settings("google_analytics_tracking_id")}}');
        </script>

    @endif
    
    @if (site_settings("google_ads") == App\Enums\StatusEnum::true->status() )
      <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-{{site_settings("google_adsense_publisher_id")}}"
          crossorigin="anonymous"></script>
    @endif

    @include('partials.theme')
    @stack('style-include')
    @stack('styles')

  </head>

  <body>


    @include('frontend.partials.header')
    <main class="main" id="main">
         @yield('content')
    </main>


    @include('frontend.partials.footer')

    @if(site_settings("cookie") ==  App\Enums\StatusEnum::true->status())
       @include('frontend.partials.cookie')
    @endif

    @yield("modal")



    <script src="{{asset('assets/global/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>

   @if(!request()->routeIs("auth.*"))
      <script src="{{asset('assets/frontend/js/gsap.min.js')}}"></script>
      <script src="{{asset('assets/frontend/js/ScrollTrigger.min.js')}}"></script>
      <script src="{{asset('assets/frontend/js/SplitText.min.js')}}"></script>
      <script src="{{asset('assets/frontend/js/Sanimation-init.js')}}"></script>
  @endif
      
    <script src="{{asset('assets/frontend/js/swiper-bundle.min.js')}}"></script>

    <script src="{{asset('assets/global/js/nice-select.min.js')}}"></script>
    <script src="{{asset('assets/global/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/app.js')}}"></script>
    <script src="{{asset('assets/global/js/toastify-js.js')}}"></script>
    <script src="{{asset('assets/global/js/helper.js')}}"></script>



    <script>

      "use strict";


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





    </script>




    @include('partials.notify')
    @stack('script-include')
    @stack('script-push')
  </body>
