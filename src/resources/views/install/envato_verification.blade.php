@extends('install.layouts.master')
@section('content')



    <div class="progress-bar">
        <div class="envato-verification">
            
        </div>
    </div>
    
    <div class="i-card-md mb-4">
        <div class="p-4 my-md-3 mx-xl-4 px-md-5">
          <form action="{{route('install.purchase.code.verification')}}" method="post">
            @csrf
                <div class="bg-light p-4 rounded mb-4">
                    <div class="d-flex gap -2">
                        <h6 class="me-2">
                            {{trans("default.envato_verification_title")}}
                        </h6>
                        <p class="text-center mb-4 top-info-text">
                            {{trans("default.envato_verification_note")}}
                    </p>
            
                    </div>

                    <div class="px-md-4 pb-sm-3">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="username">
                                        Envato Username
                                    </label>
                                    <input name="username" value="{{old('username')}}" type="text" id="username" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="purchase_code">Purchase Code</label>
                                    <input type="text" name="purchase_code" id="purchase_code" value="{{old('purchase_code')}}" placeholder="Purchase code">
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