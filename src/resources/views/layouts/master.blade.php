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

    @if(!request()->routeIs("dos.security") && !request()->routeIs("*auth.*"))
    
        @php
          $intregrationsContent  = get_content("content_integration")->first();  
          $intregrationsImg      = $intregrationsContent->file->where("type",'image')->first();
        @endphp

      <style>
          .integration .scrolling-presets{
              background-image: url({{imageUrl(@$intregrationsImg,"frontend",true,@get_appearance()->integration->content->images->image->size)}});
          }
      </style>
      
    @endif

    @stack('styles')
    @stack('style-include')
        

  </head>

  <body>


    @if(!request()->routeIs("dos.security") && !request()->routeIs("*auth.*"))
        @include('frontend.partials.header')
    @endif

    <main class="main" id="main">

         @yield('content')
    </main>

    @if(!request()->routeIs("dos.security") && !request()->routeIs("*auth.*"))
        @include('frontend.partials.footer')

        @if(site_settings("cookie") ==  App\Enums\StatusEnum::true->status() && !session()->has('cookie_consent') )
           @include('frontend.partials.cookie')
        @endif

    @endif

    @yield("modal")



    <script src="{{asset('assets/global/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>

   @if(!request()->routeIs("*auth.*") && !request()->routeIs("dos.security"))
      <script src="{{asset('assets/frontend/js/gsap.min.js')}}"></script>
      <script src="{{asset('assets/frontend/js/ScrollTrigger.min.js')}}"></script>
      <script src="{{asset('assets/frontend/js/SplitText.min.js')}}"></script>
      <script src="{{asset('assets/frontend/js/animation-init.js')}}"></script>
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



      // cookie configuration
      $(document).on('click','.cookie-control',function(e){
        
          var route = $(this).attr('data-route')

          console.log(route)

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


    </script>




    @include('partials.notify')
    @stack('script-include')
    @stack('script-push')
  </body>
