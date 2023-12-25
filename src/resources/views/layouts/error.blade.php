<!DOCTYPE html>
<html lang="{{App::getLocale()}}" class="sr" data-sidebar="open">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>{{@site_settings("user_site_name",site_settings('site_name'))}} {{site_settings('title_separator')}} {{translate('Eroor')}}</title>


   <link rel="shortcut icon" href="{{imageUrl(@site_logo('favicon')->file,'favicon',true)}}" >

    <link href="{{asset('assets/global/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/bootstrap-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/root.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/custom.css')}}" rel="stylesheet" type="text/css" />

  </head>

  <body>

    <main class="main">
        <section class="d-flex justify-content-center align-items-center min-vh-100">
            <div class="error-wrapper pt-110 pb-110">
                <div class="container-fluid">
                    <div class="row g-5 justify-content-center align-items-center">

                        @yield('content')

                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="{{asset('assets/global/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('assets/global/js/toastify-js.js')}}"></script>
    <script src="{{asset('assets/global/js/helper.js')}}"></script>

    @include('partials.notify')

</body>
