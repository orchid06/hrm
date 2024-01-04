@extends('install.layouts.master')
@section('content')



    <div class="progress-bar">
        <div class="init">
            
        </div>
    </div>
    
    <div class="i-card-md mb-4">
        <div class="p-4 my-md-3 mx-xl-4 px-md-5">
          
            <div class="bg-light p-4 rounded mb-4">
                <div class="d-flex gap -2">
      
                    <p class="text-center mb-4 top-info-text">
                        {{trans("default.finished_note")}}
                   </p>
           
                </div>

                <div class="px-md-4 pb-sm-3">
                    <div class="row g-4">
                       
                        <div class="col-sm-6">
                            <div class="d-flex ">
                                Username : {{$admin->username}}
                                <i class="bi bi-check-all"></i>
    
                            </div>
                        </div>
                      
                        <div class="col-sm-6">
                            <div class="d-flex ">
                                 password : {{session()->get('password')}}
                                <i class="bi bi-check-all"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="text-center">
    
                 <div>
                    <a href="{{route('admin.home')}}"  class="i-btn btn--lg btn--primary"> 
                        {{trans("Home")}}
                    </a>
                 </div>
            </div>
        </div>
    </div>

@endsection