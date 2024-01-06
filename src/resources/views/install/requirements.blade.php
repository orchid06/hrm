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
                                            {{trans("default.requirments_title")}}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="list-header">
                                        <h6>
                                            Requirements
                                        </h6>
                                    </div>
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
                                <div class="col-lg-6">
                                    <div class="list-header">
                                        <h6>
                                            File Permissions
                                        </h6>
                                    </div>
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
                            <div class="text-center mt-4">
                                <div>
                                    <a href="{{route('install.envato.verification',['verify_token' => bcrypt(base64_decode('ZW52YXRvX3ZlcmlmaWNhdGlvbg=='))])}}"  class="i-btn btn--lg btn--primary"> 
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