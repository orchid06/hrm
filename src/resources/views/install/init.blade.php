@extends('install.layouts.master')
@section('content')
    <div class="installer-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="installer-wrapper bg--light">
                        <div class="i-card-md">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="text-center mb-5">
                                        <h5 class="title">
                                            {{trans("default.init_title")}}
                                        </h5>
                                        <p class="text-center">{{trans("default.init_note")}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-md-4 g-3">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="icon">
                                            <i class="bi bi-database"></i>
                                        </div>
                                        <div class="content">
                                            <p>{{trans("default.init_dbname")}}</p>
                                            <i class="bi bi-shield-check text--success"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="icon">
                                            <i class="bi bi-database-lock"></i>
                                        </div>
                                        <div class="content">
                                            <p>{{trans("default.init_dbpassword")}}</p>
                                            <i class="bi bi-shield-check text--success"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="icon">
                                            <i class="bi bi-database-check"></i>
                                        </div>
                                        <div class="content">
                                            <p>{{trans("default.init_dbusername")}}</p>
                                            <i class="bi bi-shield-check text--success"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="icon">
                                            <i class="bi bi-database-gear"></i>
                                        </div>
                                        <div class="content">
                                            <p>{{trans("default.init_dbhost")}}</p>
                                            <i class="bi bi-shield-check text--success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="text-center mt-4">
                                <div>
                                    <a href="{{route('install.requirement.verification',['verify_token' => bcrypt(base64_decode('cmVxdWlyZW1lbnRz'))])}}"  class="i-btn btn--lg btn--primary"> 
                                        {{trans("default.btn_next")}} <i class="bi bi-chevron-right"></i>
                                    </a>
                                </div>
                            </div>        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection