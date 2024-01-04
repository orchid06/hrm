@extends('install.layouts.master')
@section('content')

    <div class="progress-bar">
        <div class="acount-setup">
            
        </div>
    </div>
    
    <div class="i-card-md mb-4">
        <div class="p-4 my-md-3 mx-xl-4 px-md-5">

                <div class="bg-light p-4 rounded mb-4">
                    
                    <div class="p-4 my-md-3 mx-xl-4 px-md-5">
                        <form action="{{route('install.account.setup')}}" method="post">
                          @csrf
                            <div class="bg-light p-4 rounded mb-4">
                                <div class="d-flex gap -2">
                                    <h6 class="me-2">
                                        {{trans("default.account_setup_title")}}
                                    </h6>
                                </div>
            
                                <div class="px-md-4 pb-sm-3">
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-inner">
                                                <label for="username">
                                                   Username
                                                </label>
                                                <input name="username" value="{{old('username')}}" type="text" id="username" placeholder="Enter your username">
                                            </div>
                                        </div>
            
                                        <div class="col-lg-6">
                                            <div class="form-inner">
                                                <label for="email">
                                                   Email
                                                </label>
                                                <input name="email"   value="{{old('email')}}" type="email" id="email" placeholder="Enter your email">
                                            </div>
                                        </div>
            
                                        <div class="col-lg-12">
                                            <div class="form-inner">
                                                <label for="password">
                                                    Password <span class="text-danger">Min :5</span>
                                                </label>
                                                <input name="password" value="{{old('password')}}"  type="text" id="password" placeholder="Enter your password">
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

        </div>
    </div>

@endsection