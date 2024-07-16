<!DOCTYPE html>
<html lang="{{App::getLocale()}}" class="sr" data-sidebar="open">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{@site_settings("site_name")}} {{site_settings('title_separator')}} {{@translate($title)}}</title>
    <link rel="shortcut icon" href="{{imageURL(@site_logo('favicon')->file,'favicon',true)}}">
    <link href="{{asset('assets/global/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/bootstrap-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/root.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/frontend/css/custom.css')}}" rel="stylesheet" type="text/css" />

    <style>
        .maintenance-title{
            font-size:60px !important;
        }
    </style>
  </head>

  <body>
    <main class="main">
        <section class="d-flex justify-content-center align-items-center min-vh-100">
            <div class="error-wrapper pt-110 pb-110">
                <div class="container-fluid">
                    <div class="row g-5 justify-content-center align-items-center">

                         
                        <div class="col-lg-5">
                            <div class="error-content">
                                <h1 class="maintenance-title  mb-2">
                                    {{site_settings('maintenance_title')}}
                                </h1>
                                <p>
                                   {{site_settings('maintenance_description')}}
                                </p>

                                <div class="mt-lg-5 mt-4 d-flex align-items-center justify-content-center">
                                    <a href="{{route('home')}}" class="i-btn btn--primary btn--lg capsuled">
                                       {{@translate('Back To Home Page')}}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="error-image">
                                <img src="{{asset('assets/images/default/maintenance.png')}}" alt="maintenance.png" class="img-fluid">
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="{{asset('assets/global/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>

    @include('partials.notify')
  </body>
  

