@extends('install.layouts.master')
@section('content')

    <div class="progress-bar">
        <div class="db-setup">
            
        </div>
    </div>
    
    <div class="i-card-md mb-4">
        <div class="p-4 my-md-3 mx-xl-4 px-md-5">
            <form action="{{route('install.db.store')}}" method="post">
              @csrf
                <div class="bg-light p-4 rounded mb-4">
                    <div class="d-flex gap -2">
                        <h6 class="me-2">
                            {{trans("default.dbsetup_title")}}
                        </h6>
                     
                    </div>

                    <div class="px-md-4 pb-sm-3">
                        <div class="row g-4">
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
                </div>
        
                <div class="text-center">
                    <div>
                        <button  class="i-btn btn--lg btn--primary"> 
                            {{trans("default.btn_next")}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection