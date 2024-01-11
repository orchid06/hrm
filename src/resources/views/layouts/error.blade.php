<!DOCTYPE html>
<html lang="{{App::getLocale()}}" class="sr" data-sidebar="open">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{translate('Error')}}-{{@$title}}</title>
    <link href="{{asset('assets/global/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/bootstrap-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/root.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <style>
      .invalid-license-title{
          font-size:60px !important;
      }
    </style>
  </head>

  <body>
    <main class="main">
        <section class="overflow-x-hidden d-flex justify-content-center align-items-center">
            <div class="error-wrapper pt-110 pb-110">
                <div class="container">
                    <div class="row g-5 justify-content-center align-items-center">
                        @yield('content')
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="{{asset('assets/global/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>

    @include('partials.notify')
  </body>
