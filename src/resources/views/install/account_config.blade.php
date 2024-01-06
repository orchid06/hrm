@extends('install.layouts.master')
@section('content')

    <div class="installer-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                <div class="installer-progress">
                        <ul class="progress-list">
                            <li class="active">
                                <a href="#">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"  x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><circle cx="377" cy="377" r="120" style="stroke-width:30;stroke-miterlimit:10;" fill="none"  stroke-width="30" stroke-miterlimit="10" data-original="#000000"></circle><path d="M377 302v30M377 437v-60h-30M347 437h60M75 61v30M15 15h422v122H15zM75 182v30M437 137v136.054M15 257V137M75 302v30M135 61v30M135 182v30M135 302v30M257.002 377H15V257h422" style="stroke-width:30;stroke-miterlimit:10;" fill="none"  stroke-width="30" stroke-miterlimit="10" data-original="#000000"></path></g></svg>
                                    </div>
                                    <div class="content">
                                        <h6>Database Info</h6>
                                        <p>Database manages, organizes information.</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"  x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M18 24a.502.502 0 0 1-.194-.039C17.568 23.86 12 21.454 12 16.536v-4.179a.5.5 0 0 1 .34-.474l5.5-1.857a.5.5 0 0 1 .32 0l5.5 1.857a.5.5 0 0 1 .34.474v4.179c0 4.918-5.568 7.324-5.806 7.425A.502.502 0 0 1 18 24zm-5-11.283v3.819c0 3.784 4.055 5.958 5 6.413.944-.456 5-2.639 5-6.413v-3.819l-5-1.689z"  opacity="1" data-original="#000000" class=""></path><path d="m17.5 19-.027-.001a.496.496 0 0 1-.363-.187l-2-2.5a.5.5 0 0 1 .781-.625l1.65 2.063 3.105-3.104a.5.5 0 0 1 .707.707l-3.5 3.5A.498.498 0 0 1 17.5 19zM9.5 21h-7A2.502 2.502 0 0 1 0 18.5v-13C0 4.121 1.121 3 2.5 3h2a.5.5 0 0 1 0 1h-2C1.673 4 1 4.673 1 5.5v13c0 .827.673 1.5 1.5 1.5h7a.5.5 0 0 1 0 1zM16.5 8.5A.5.5 0 0 1 16 8V5.5c0-.827-.673-1.5-1.5-1.5h-2a.5.5 0 0 1 0-1h2C15.879 3 17 4.121 17 5.5V8a.5.5 0 0 1-.5.5z"  opacity="1" data-original="#000000" class=""></path><path d="M11.5 6h-6C4.673 6 4 5.327 4 4.5v-2a.5.5 0 0 1 .5-.5h1.55C6.282.86 7.293 0 8.5 0s2.218.86 2.45 2h1.55a.5.5 0 0 1 .5.5v2c0 .827-.673 1.5-1.5 1.5zM5 3v1.5c0 .275.225.5.5.5h6c.275 0 .5-.225.5-.5V3h-1.5a.5.5 0 0 1-.5-.5C10 1.673 9.327 1 8.5 1S7 1.673 7 2.5a.5.5 0 0 1-.5.5zM13.5 9h-10a.5.5 0 0 1 0-1h10a.5.5 0 0 1 0 1zM9.5 12h-6a.5.5 0 0 1 0-1h6a.5.5 0 0 1 0 1zM9.5 15h-6a.5.5 0 0 1 0-1h6a.5.5 0 0 1 0 1z"  opacity="1" data-original="#000000" class=""></path></g></svg>
                                    </div>
                                    <div class="content">
                                        <h6>File Permission</h6>
                                        <p>Database manages, organizes information.</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"  x="0" y="0" viewBox="0 0 68 68" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M16.033 15H39a2 2 0 0 1 0 4H16.76l2.91 16H48a2 2 0 0 1 0 4H20.396l1.273 7H50a2 2 0 0 1 0 4H20a2 2 0 0 1-1.968-1.642L10.331 6H2a2 2 0 0 1 0-4h10a2 2 0 0 1 1.968 1.642zM59.172 5l-1.586-1.586A2 2 0 0 1 60.414.586l5 5a2 2 0 0 1 0 2.828l-5 5a2 2 0 0 1-2.828-2.828L59.172 9H56a8 8 0 0 0-8 8 2 2 0 0 1-4 0c0-6.627 5.373-12 12-12zm-6.344 24 1.586 1.586a2 2 0 0 1-2.828 2.828l-5-5a2 2 0 0 1 0-2.828l5-5a2 2 0 0 1 2.828 2.828L52.828 25H56a8 8 0 0 0 8-8 2 2 0 0 1 4 0c0 6.627-5.373 12-12 12zM22 68a7 7 0 1 1 0-14 7 7 0 0 1 0 14zm0-4a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm24 4a7 7 0 1 1 0-14 7 7 0 0 1 0 14zm0-4a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"  opacity="1" data-original="#000000" class=""></path></g></svg>
                                    </div>
                                    <div class="content">
                                        <h6>Update Purchase</h6>
                                        <p>Database manages, organizes information.</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 682.667 682.667" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><defs><clipPath id="a" clipPathUnits="userSpaceOnUse"><path d="M0 512h512V0H0Z"  opacity="1" data-original="#000000"></path></clipPath></defs><g clip-path="url(#a)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)"><path d="M0 0c0 11.098-2.003 21.641-4.836 31.85l29.74 17.169-30 51.962-29.418-16.985C-49.516 99.263-68.666 110.193-90 115.739V150h-60v-34.261c-21.334-5.546-40.484-16.476-55.486-31.743l-29.418 16.985-30-51.962 29.74-17.169C-237.997 21.641-240 11.098-240 0c0-11.098 2.003-21.641 4.836-31.85l-29.74-17.169 30-51.962 29.418 16.985c15.002-15.267 34.152-26.197 55.486-31.743V-150h60v34.261c21.334 5.546 40.484 16.476 55.486 31.743l29.418-16.985 30 51.962-29.74 17.169C-2.003-21.641 0-11.098 0 0Z" style="stroke-width:30;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(376 256)" fill="none"  stroke-width="30" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path><path d="M0 0c-33.091 0-60 26.909-60 60s26.909 60 60 60 60-26.909 60-60S33.091 0 0 0Z" style="stroke-width:30;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(256 196)" fill="none"  stroke-width="30" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path><path d="M0 0c-11.289 27.806-18.51 58.19-18.51 90 0 132.334 108.666 241 241 241 75.8 0 146.904-37.457 190.919-92.508" style="stroke-width:30;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(33.51 166)" fill="none"  stroke-width="30" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path><path d="M0 0c11.289-27.806 18.51-58.19 18.51-90 0-132.334-108.666-241-241-241-75.8 0-146.904 37.457-190.919 92.508" style="stroke-width:30;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(478.49 346)" fill="none"  stroke-width="30" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path><path d="m0 0 21.213-63.64-63.64 21.214" style="stroke-width:30;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(425.706 468.132)" fill="none"  stroke-width="30" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path><path d="m0 0-63.64 21.213 21.213-63.639" style="stroke-width:30;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(128.72 86.294)" fill="none"  stroke-width="30" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class=""></path></g></g></svg>
                                    </div>
                                    <div class="content">
                                        <h6>Update Database</h6>
                                        <p>Database manages, organizes information.</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><g data-name="user setting"><path d="M13.381 13.95a6.35 6.35 0 1 0-6.35-6.35 6.353 6.353 0 0 0 6.35 6.35zm0-11.2a4.85 4.85 0 1 1-4.85 4.85 4.852 4.852 0 0 1 4.85-4.85zM17.448 16.265a.751.751 0 0 0-.457-.958A10.836 10.836 0 0 0 2.551 25.52a.75.75 0 0 0 1.5 0 9.334 9.334 0 0 1 12.44-8.8.751.751 0 0 0 .957-.455zM22.341 20.252a3.028 3.028 0 1 0 3.029 3.028 3.03 3.03 0 0 0-3.029-3.028zm0 4.556a1.528 1.528 0 1 1 1.529-1.528 1.529 1.529 0 0 1-1.529 1.528z"  opacity="1" data-original="#000000"></path><path d="M28.789 23.706a6.463 6.463 0 0 0 0-.854l.6-1.463a.751.751 0 0 0 .016-.529 7.486 7.486 0 0 0-1.438-2.491.751.751 0 0 0-.466-.25l-1.57-.21a6.453 6.453 0 0 0-.74-.427l-.966-1.254a.751.751 0 0 0-.45-.278 7.446 7.446 0 0 0-2.876 0 .751.751 0 0 0-.45.278l-.967 1.255a6.347 6.347 0 0 0-.74.427l-1.569.209a.751.751 0 0 0-.466.25 7.486 7.486 0 0 0-1.438 2.491.751.751 0 0 0 .016.529l.6 1.465a6.462 6.462 0 0 0 0 .854l-.6 1.463a.751.751 0 0 0-.016.529 7.484 7.484 0 0 0 1.438 2.491.75.75 0 0 0 .466.25l1.57.21a6.471 6.471 0 0 0 .74.427l.966 1.254a.751.751 0 0 0 .45.278 7.443 7.443 0 0 0 2.876 0 .751.751 0 0 0 .45-.278l.967-1.255a6.356 6.356 0 0 0 .74-.427l1.569-.209a.75.75 0 0 0 .466-.25 7.484 7.484 0 0 0 1.441-2.491.751.751 0 0 0-.016-.529zm-1.772 3.286-1.459.2a.748.748 0 0 0-.336.133 5.062 5.062 0 0 1-.821.474.74.74 0 0 0-.283.224l-.9 1.166a5.936 5.936 0 0 1-1.755 0l-.9-1.166a.74.74 0 0 0-.283-.224 5.062 5.062 0 0 1-.821-.474.748.748 0 0 0-.336-.133l-1.459-.2a5.968 5.968 0 0 1-.878-1.52l.56-1.362a.749.749 0 0 0 .053-.357 4.969 4.969 0 0 1 0-.948.749.749 0 0 0-.053-.357l-.561-1.361a5.954 5.954 0 0 1 .878-1.52l1.459-.2a.747.747 0 0 0 .336-.133 5.062 5.062 0 0 1 .821-.474.739.739 0 0 0 .283-.224l.9-1.166a5.931 5.931 0 0 1 1.755 0l.9 1.166a.739.739 0 0 0 .283.224 5.062 5.062 0 0 1 .821.474.747.747 0 0 0 .336.133l1.459.2a5.968 5.968 0 0 1 .878 1.52l-.56 1.362a.748.748 0 0 0-.053.357 4.969 4.969 0 0 1 0 .948.748.748 0 0 0 .053.357l.561 1.361a5.955 5.955 0 0 1-.878 1.52z"  opacity="1" data-original="#000000"></path></g></g></svg>
                                    </div>
                                    <div class="content">
                                        <h6>Account Config</h6>
                                        <p>Database manages, organizes information.</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"  x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M32.016 58.003c-9.888.001-19.006-5.665-23.373-14.583-4.419-9.027-3.081-20.285 3.331-28.014C18.379 7.685 28.792 4.316 38.5 6.823a2.002 2.002 0 0 1-1 3.874c-8.212-2.121-17.026.729-22.447 7.264-5.424 6.539-6.556 16.064-2.817 23.702 3.725 7.608 11.942 12.564 20.376 12.334 8.433-.23 16.086-5.359 19.497-13.066a22.13 22.13 0 0 0 1.192-14.432 2.001 2.001 0 0 1 3.874-1 26.155 26.155 0 0 1-1.407 17.051c-4.032 9.11-13.079 15.173-23.046 15.445-.236.005-.472.008-.706.008z"  opacity="1" data-original="#000000" class=""></path><path d="M32 38.24a2 2 0 0 1-1.414-3.414l24-24a2 2 0 1 1 2.828 2.828l-24 24c-.39.39-.902.586-1.414.586z"  opacity="1" data-original="#000000" class=""></path><path d="M32 38.24a1.99 1.99 0 0 1-1.414-.586l-8.485-8.485a2 2 0 1 1 2.828-2.828l8.485 8.485A2 2 0 0 1 32 38.24z"  opacity="1" data-original="#000000" class=""></path></g></svg>
                                    </div>
                                    <div class="content">
                                        <h6>Update Database</h6>
                                        <p>Database manages, organizes information.</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="installer-wrapper bg--light">
                        <div class="i-card-md">
                        <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="text-center mb-5">
                                        <h5 class="title">
                                            {{trans("default.account_setup_title")}}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        <form action="{{route('install.account.setup')}}" method="post">
                          @csrf
                            <div class="row g-3">
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
                    
                            <div class="text-center mt-4">
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
    </div>
    

@endsection