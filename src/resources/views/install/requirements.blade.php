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




@endsection