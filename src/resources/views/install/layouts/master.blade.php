<!DOCTYPE html>
<html lang="{{App::getLocale()}}" class="sr" data-sidebar="open">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{csrf_token()}}" />
   <title>
         {{@trans('default.insaller_title')}}
   </title>

    <link href="{{asset('assets/global/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/install/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/bootstrap-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/select2.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('assets/global/css/toastr.css')}}" rel="stylesheet" type="text/css" />
  
    @stack('styles')
    @stack('style-include')
  </head>
  <body>


    <main class="main" id="main">

      <div class="text-center text-white mb-4">
        <h2>
            {{@trans('default.insaller_title')}}
        </h2>
        <p>
          {{trans("default.insaller_subtitle")}}
        </p>
      </div>
       @yield('content')
             
    </main>


    <script src="{{asset('assets/global/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/global/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/global/js/toastify-js.js')}}"></script>
    <script src="{{asset('assets/global/js/helper.js')}}"></script>


    @include('partials.notify')
    @stack('script-include')
    @stack('script-push')
  </body>
