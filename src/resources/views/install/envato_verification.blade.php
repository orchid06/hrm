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
                                            {{trans("default.envato_verification_title")}}
                                        </h5>
                                        <p class="text-center mb-4 top-info-text">
                                                {{trans("default.envato_verification_note")}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <form action="{{route('install.purchase.code.verification')}}" method="post">
                                    @csrf
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
                                    <div class="text-center mt-4">
                                        <button  class="i-btn btn--lg btn--primary"> 
                                            {{trans("default.btn_next")}}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>    
                    </div>    
                </div>    
            </div>    
        </div>    
    </div>    




@endsection