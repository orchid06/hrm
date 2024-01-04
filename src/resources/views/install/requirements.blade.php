@extends('install.layouts.master')
@section('content')



    <div class="progress-bar">
        <div class="requirement">
            
        </div>
    </div>
    
    <div class="i-card-md mb-4">

        <div class="p-4 my-md-3 mx-xl-4 px-md-5">
            <div class="bg-light p-4 rounded mb-4">

                <div class="d-flex mb-2">
                    <h6>
                        {{trans("default.requirments_title")}}
                    </h6>
                </div>

                <div class="app-info-box p-0">
                     <h2>
                        Requirements
                     </h2>
                    <ul class="permission-list">
                        @foreach(Arr::get($requirements,'requirements',[]) as $type => $requirement)

                                <li class="list {{ @$phpSupportInfo['supported'] ? 'list-success' : 'list-error' }}">
                                    <strong>{{ ucfirst($type) }}</strong>
                                    @if($type == 'php')
                                    <span>(minimum version {{ $phpSupportInfo['minimum'] }} required)</span><span> {{ $phpSupportInfo['current'] }}</span>

                                        @if(@$phpSupportInfo['supported'])
                                           <i class="bi bi-check-circle-fill"></i>
                                        @else
                                           <i class="bi bi-exclamation-lg"></i>
                                        @endif

                                    @endif
                                </li>
                                @foreach($requirements['requirements'][$type] as $extention => $enabled)
                                    <li class="list {{ $enabled ? 'list-success' : 'list-error' }}">
                                        {{ $extention }}

                                        @if($enabled)
                                           <i class="bi bi-check-circle-fill"></i>
                                        @else
                                          <i class="bi bi-exclamation-lg"></i>
                                        @endif
 
                                    </li>
                                @endforeach
                    
                        @endforeach
                    </ul>
                </div>
                <div class="app-info-box p-0">
                     <h2>
                        File Permissions
                     </h2>

                    <ul class="permission-list">
                        @foreach($permissions as $permission)

                            <li class="list {{Arr::get($permission ,'isSet' ,false) ? 'list-success' : 'list-error' }}">
                                {{ Arr::get($permission ,'folder' ,null) }}

                                @if(@$permission['isSet'])
                                  <i class="bi bi-check-circle-fill"></i>
                                @else
                                  <i class="bi bi-exclamation-lg"></i>
                                @endif
                            </li>

                        @endforeach
                    </ul>
                </div>
      

            </div>
    
            <div class="text-center">
    
                 <div>
                    <a href="{{route('install.envato.verification',['verify_token' => bcrypt(base64_decode('ZW52YXRvX3ZlcmlmaWNhdGlvbg=='))])}}"  class="i-btn btn--lg btn--primary"> 
                        {{trans("default.btn_next")}}
                    </a>
           
                 </div>
            </div>
        </div>
    </div>




    {{-- <div class="i-card-md mb-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-11 col-md-11 col-lg-10 col-xl-8 col-xxl-7 text-center p-0 mt-3 mb-2">
                <div class="installer-wrapper">
                    <h2 id="heading">Application Installer</h2>
                    <p>Fill all form field to go to next step</p>
                    <form id="msform">
                        <ul id="progressbar">
                            <li class="active" id="account">Home</li>
                            <li id="personal">Server</li>
                            <li id="payment">Permission</li>
                            <li id="payment2" data-multi='multistep'>Settings</li>
                            <li id="confirm">Finished</li>
                        </ul>
                        <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                        </div> <br> 
                        <fieldset>
                        <div class="row">
                                    <div class="col-12">
                                        <h2 class="steps">Step 1 - 5</h2>
                                    </div>
                                    <div class="col-12 text-center">
                                        <div class="app-info-box">
                                            <p>Application Easy Installation and setup wizard</p>
                                            <p>Please follow the instructions step by step</p>
                                        </div>
                                    </div>
                                </div>  
                            <input type="button" name="next" class="next action-button" value="Next" />
                        </fieldset>
                        <fieldset>
                        <div class="row">
                                    <div class="col-12">
                                        <h2 class="steps">Step 2 - 5</h2>
                                    </div>
                                    <div class="col-12">
                                        <div class="app-info-box p-0">
                                            <ul class="permission-list">
                                                <li><span>Php (minimum version 8.1 required)</span><span>8.1.4</span></li>
                                                <li><span>Openssi</span><span><i class="bi bi-check-circle-fill"></i></span></li>
                                                <li><span>Pdo</span><span><i class="bi bi-check-circle-fill"></i></span></li>
                                                <li><span>Mbstring</span><span><i class="bi bi-check-circle-fill"></i></span></li>
                                                <li><span>Tokenizer</span><span><i class="bi bi-check-circle-fill"></i></span></li>
                                                <li><span>JSON</span><span><i class="bi bi-check-circle-fill"></i></span></li>
                                                <li><span>CURL</span><span><i class="bi bi-check-circle-fill"></i></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div> 
                            <input type="button" name="next" class="next action-button" value="Next" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                        </fieldset>
                        <fieldset>
                        <div class="row">
                                    <div class="col-12">
                                        <h2 class="steps">Step 3 - 5</h2>
                                    </div>
                                    <div class="col-12">
                                        <div class="app-info-box p-0">
                                            <ul class="permission-list-two">
                                                <li><span>.env</span><span><i class="bi bi-check-circle-fill me-2"></i>666</span></li>
                                                <li><span>storage/framwork/</span><span><i class="bi bi-check-circle-fill me-2"></i>775</span></li>
                                                <li><span>stoege/logs/</span><span><i class="bi bi-check-circle-fill me-2"></i>775</span></li>
                                                <li><span>Tokenizer</span><span><i class="bi bi-check-circle-fill me-2"></i>775</span></li>
                                                <li><span>bootstrap/cache</span><span><i class="bi bi-check-circle-fill me-2"></i>775</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>  <input type="button" name="next" class="next action-button" value="Submit" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                        </fieldset>
                        <fieldset data-field='multistepField'>
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="steps">Step 4 - 5</h2>
                                </div>
                                <ul class="nav-js nav nav-tabs style-4" role="tablist">
                                    <li class="nav-item " role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tab-one" aria-selected="false" role="tab" tabindex="-1">Verification</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link " data-bs-toggle="tab" href="#tab-two" aria-selected="true" role="tab">Environment</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link " data-bs-toggle="tab" id="lastTab" href="#tab-three" aria-selected="true" role="tab">Database</a>
                                    </li>
                                </ul>
                                <div class="app-info-box">
                                    <div id="myTabContent" class="tab-content">
                                        <div class="tab-pane fade active show" id="tab-one" role="tabpanel">
                                            <h6>Verification</h6>
                                            <div class="form-inner">
                                                <label for="purchase-code">Envato Purchase Code</label>
                                                <input type="text" id="purchase-code" placeholder="Provide your Envato purchasing code">
                                            </div>
                                            <div class="form-inner">
                                                <label for="purchase-code">Email Address</label>
                                                <input type="text" id="purchase-code" placeholder="Provide your Envato purchasing code">
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab-two" role="tabpane2">
                                            <h6>Environment</h6>
                                            <div class="form-inner">
                                                <label for="purchase-code">App Name</label>
                                                <input type="text" id="purchase-code" placeholder="App Name">
                                            </div>
                                            <div class="form-inner">
                                                <label for="purchase-code">Email Address</label>
                                                <input type="text" id="purchase-code" placeholder="App Environment">
                                            </div>
                                            <div class="form-inner">
                                                <label for="purchase-code">App Url</label>
                                                <input type="text" id="purchase-code" placeholder="https://beta.igensolutions.limited">
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab-three" role="tabpane3">
                                        <h6>Database Connection</h6>
                                            <div class="form-inner">
                                                <label for="purchase-code">Database Connection</label>
                                                <input type="text" id="purchase-code" placeholder="App Name">
                                            </div>
                                            <div class="form-inner">
                                                <label for="purchase-code">Database Host</label>
                                                <input type="text" id="purchase-code" placeholder="127.0.0.1">
                                            </div>
                                            <div class="form-inner">
                                                <label for="purchase-code">Database Port</label>
                                                <input type="text" id="purchase-code" placeholder="3306">
                                            </div>
                                            <div class="form-inner">
                                                <label for="purchase-code">Database Name</label>
                                                <input type="text" id="purchase-code" placeholder="Database Name">
                                            </div>
                                            <div class="form-inner">
                                                <label for="purchase-code">DatabaseUser Name</label>
                                                <input type="text" id="purchase-code" placeholder="3306">
                                            </div>
                                            <div class="form-inner">
                                                <label for="purchase-code">DatabaseUser Password</label>
                                                <input type="text" id="purchase-code" placeholder="*****">
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                            <input type="button" name="next" class="next action-button" value="Submit" />
                            <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                        </fieldset>
                        <fieldset>
                        <div class="row">
                                    <div class="col-12">
                                        <h2 class="steps">Step 5 - 5</h2>
                                    </div>
                                </div>
                                <div class="app-info-box">
                                <div class="checkmark-wrapper">
                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 98.5 98.5" enable-background="new 0 0 98.5 98.5" xml:space="preserve">
                                        <path class="checkmark" fill="none" stroke-width="6" stroke-miterlimit="10" d="M81.7,17.8C73.5,9.3,62,4,49.2,4
                                            C24.3,4,4,24.3,4,49.2s20.3,45.2,45.2,45.2s45.2-20.3,45.2-45.2c0-8.6-2.4-16.6-6.5-23.4l0,0L45.6,68.2L24.7,47.3"/>
                                        </svg>
                                    </div>
                                <h4 class="text-center">Installed Successfully !</h4>
                                </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

    

@endsection