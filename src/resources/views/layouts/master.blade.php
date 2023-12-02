<!DOCTYPE html>
<html lang="{{App::getLocale()}}" class="sr" data-sidebar="open">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{csrf_token()}}" />

    <title>
      {{@site_settings("user_site_name")}}-{{Arr::get($meta_data,"title","")}}
    </title>
    @include('partials.meta_content')

    {{-- <link rel="shortcut icon" href="{{ imageUrl(config("settings")['file_path']['favicon']['path']."/".@site_logo('site_favicon')->file->name ,@site_logo('site_favicon')->file->disk) }}" alt="{{@site_logo('site_favicon')->file->name}}"> --}}
    <link href="{{asset('assets/global/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/bootstrap-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/swiper.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/nice-select.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    @if(request()->routeIs('user.*'))
       <link href="{{asset('assets/backend/css/simplebar.css')}}" rel="stylesheet" type="text/css" />
    @endif
    <link href="{{asset('assets/frontend/css/root.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/media.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/toastr.css')}}" rel="stylesheet" type="text/css" />

    @if (!empty(site_settings("google_analytics_tracking_id")))
       <script async src="https://www.googletagmanager.com/gtag/js?id={{site_settings("google_analytics_tracking_id")}}"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', '{{site_settings("google_analytics_tracking_id")}}');
        </script>

    @endif

    @if (!empty(site_settings("google_adsense_publisher_id")) && site_settings("google_ads") == App\Enums\StatusEnum::true->status() )

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-{{site_settings("google_adsense_publisher_id")}}"
        crossorigin="anonymous"></script>
    @endif

    @include('partials.theme')
    @stack('style-include')
    @stack('styles')

    @php
          $banner_section = frontend_section()->where("slug",'banner_section')->first();
          $client_section = frontend_section()->where("slug",'client_section')->first();
          $authentication_section = frontend_section()->where("slug",'authentication_section')->first();

          $primaryRgba =  hexa_to_rgba(site_settings('primary_color'));
          $primary_light = "rgba(".$primaryRgba.",0.1)";

    @endphp



    <style>
       .banners{
        background-image: linear-gradient(
          125deg,
          rgba(0, 0, 0, 0.84),
          68%,
          <?php echo $primary_light?>
          30%
        ),
          /* url({{imageUrl(config("settings")['file_path']['frontend']['path']."/".@$banner_section->file->name,@$banner_section->file->disk ) }}); */
       }

       .testimonial-section{
        background-image: linear-gradient(
          125deg,
          rgba(0, 0, 0, 0.84),
          68%,
          <?php echo $primary_light?> 30%
        ),
          /* url({{imageUrl(config("settings")['file_path']['frontend']['path']."/".@$client_section->file->name,@$client_section->file->disk ) }}); */
       }
    </style>


  </head>

  <body>

    @php
      $preloader= frontend_section()->where("slug",'pre_loader')->first();
    @endphp

    @includeWhen($preloader->status == App\Enums\StatusEnum::true->status(),'frontend.partials.preloader',['preloader' => $preloader])

    <div class="back-to-top show">
        <button class="back-to-top-btn">
          <i class="fa-duotone fa-arrow-up"></i>
        </button>
    </div>

    @if(request()->routeIs('home') && site_settings("cookie") ==  App\Enums\StatusEnum::true->status())
       @include('cookie-consent::index')
    @endif

    @include('frontend.partials.header')

    <main id="main">
        @yield('content')
    </main>

    @yield("modal")

    @if(!request()->routeIs('user.*'))
      @include('frontend.partials.footer')
    @endif

    <script src="{{asset('assets/global/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/swiper.js')}}"></script>
    <script src="{{asset('assets/global/js/font_awesome.js')}}"></script>
    <script src="{{asset('assets/global/js/nice-select.min.js')}}"></script>
    <script src="{{asset('assets/global/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/fslightbox.js')}}"></script>

    @if(request()->routeIs('user.*'))
         <script src="{{asset('assets/global/js/simplebar.min.js')}}"></script>
    @endif

    <script src="{{asset('assets/frontend/js/script.js')}}"></script>
    <script src="{{asset('assets/global/js/toastify-js.js')}}"></script>
    <script src="{{asset('assets/global/js/helper.js')}}"></script>
    <script src="{{asset('assets/global/js/pusher.min.js')}}"></script>
    <script src="{{asset('assets/global/js/push.js')}}"></script>

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
