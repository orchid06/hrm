@extends('install.layouts.master')
@section('content')

    <div class="progress-bar">
        <div class="db-setup">
            
        </div>
    </div>
    
    <div class="installer-section">
        <div class="container ">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="installer-wrapper bg--light">
                    <form action="{{route('install.db.store')}}" method="post">
                    @csrf
                        <div class="each-slide">
                            <div class="d-flex gap -2">
                                <h5 class="title">
                                    {{trans("default.dbsetup_title")}}
                                </h5>
                            </div>
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label for="db_host">
                                            Database Host
                                        </label>
                                        <input name="db_host" value="{{old('db_host')}}" type="text" id="db_host" placeholder="Ex:localhost">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label for="db_port">
                                            Database Port
                                        </label>
                                        <input name="db_port"  value="3306" type="number" id="db_port" placeholder="Database port">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-inner">
                                        <label for="db_port">
                                            Database name
                                        </label>
                                        <input name="db_database" value="{{old('db_database')}}"  type="text" id="db_database" placeholder="Database Name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label for="db_username">
                                            Database Username
                                        </label>
                                        <input name="db_username" value="{{old('db_username')}}" type="text" id="db_username" placeholder="Database Username">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label for="db_password">
                                            Database Password
                                        </label>
                                        <input name="db_password" value="{{old('db_password')}}" type="text" id="db_password" placeholder="Database Password">
                                    </div>
                                </div>
                            </div>
                        </div>
                
                        <div class="text-start mt-4">
                            <button  class="i-btn btn--lg btn--primary"> 
                                {{trans("default.btn_next")}} <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>

@endsection