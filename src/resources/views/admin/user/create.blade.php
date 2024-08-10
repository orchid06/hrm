@extends('admin.layouts.master')

@push('style-include')
<link rel="stylesheet" href="{{asset('assets/global/css/bootstrapicons-iconpicker.css')}}">
<link rel="stylesheet" href="{{asset('assets/global/css/step-inputform.css')}}">
@endpush

@section('content')

<div>
    <div id="multi-step-form-container">

        <ul class="form-stepper form-stepper-horizontal text-center mx-auto pl-0">

            <li class="form-stepper-active text-center form-stepper-list" step="1">
                <a class="mx-2">
                    <span class="form-stepper-circle">
                        <span>1</span>
                    </span>
                    <div class="label">{{translate('Basic Information')}}</div>
                </a>
            </li>

            <li class="form-stepper-unfinished text-center form-stepper-list" step="2">
                <a class="mx-2">
                    <span class="form-stepper-circle text-muted">
                        <span>2</span>
                    </span>
                    <div class="label text-muted">{{translate('Company Information')}}</div>
                </a>
            </li>

            <li class="form-stepper-unfinished text-center form-stepper-list" step="3">
                <a class="mx-2">
                    <span class="form-stepper-circle text-muted">
                        <span>3</span>
                    </span>
                    <div class="label text-muted">{{translate('Bank Information')}}</div>
                </a>
            </li>
        </ul>

        <form id="userAccountSetupForm" name="userAccountSetupForm" enctype="multipart/form-data" method="POST"
            action="">

            <section id="step-1" class="form-step">

                <div class="i-card-md">
                    <div class="card--header">
                        <h4 class="card-title">
                            {{translate('Basic Information')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="Name">
                                        {{translate('Name')}} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="Name" required
                                        placeholder="{{translate('Enter Name')}}" value="{{old('name')}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="username">
                                        {{translate('Username')}}
                                        <small class="text-danger">*</small>
                                    </label>
                                    <input type="text" name="username" id="username"
                                        placeholder="{{translate('Enter User Name')}}" value="{{old('username')}}"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-inner">
                                    <label for="email">
                                        {{translate('Email')}}
                                        <small class="text-danger">*</small>
                                    </label>

                                    <input type="email" name="email" id="email"
                                        placeholder="{{translate('Enter Email')}}" value="{{old('email')}}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="country">
                                        {{translate('Country')}}
                                    </label>
                                    <select name="country_id" id="country">
                                        <option value="">
                                            {{translate('Select Country')}}
                                        </option>
                                        {{-- @foreach ($countries as $country )
                                        <option {{old('country_id')==$country->id ? "selected" :""}}
                                            value="{{$country->id}}">
                                            {{$country->name}}
                                        </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="phone">
                                        {{translate('Phone')}}
                                    </label>
                                    <input type="text" name="phone" id="phone"
                                        placeholder="{{translate('Enter Phone')}}" value="{{old('phone')}}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="status">
                                        {{translate('Status')}}
                                        <small class="text-danger">*</small>
                                    </label>
                                    <select class="select2" name="status" id="status">
                                        @foreach(App\Enums\StatusEnum::toArray() as $status=>$value)
                                        <option {{old('status')==$value ? "selected" :"" }} value="{{$value}}">
                                            {{$status}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="image">
                                        {{translate('Profile Image')}}
                                    </label>
                                    <input data-size="{{config('settings')['file_path']['profile']['user']['size']}}"
                                        id="image" name="image" type="file" class="preview">
                                    <div class="mt-2 image-preview-section">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-inner">
                                    <label for="password">
                                        {{translate('Password')}}
                                        <small class="text-danger">*({{translate('Minimum 6
                                            Characters')}})</small>
                                    </label>
                                    <input placeholder="{{translate('Enter Password')}}" type="text" id="password"
                                        name="password" value="{{old('password')}}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-inner">
                                    <label for="password_confirmation">
                                        {{translate('Confrim Password')}}
                                        <small class="text-danger">*({{translate('Minimum 6
                                            Characters')}})</small>
                                    </label>
                                    <input placeholder="{{translate('Enter Confirm Password')}}" type="text"
                                        id="password_confirmation" name="password_confirmation"
                                        value="{{old('password_confirmation')}}">
                                </div>
                            </div>
                        </div>
                        <div class="button-container">
                            <button class="button btn-navigate-form-step" type="button" step_number="2">Next</button>
                        </div>

                    </div>
                </div>

            </section>

            <section id="step-2" class="form-step d-none">

                <div class="i-card-md">
                    <div class="card--header">
                        <h4 class="card-title">
                            {{translate('Company Information')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="form-inner">
                                    <label for="employee-id">
                                        {{translate('Employee ID')}} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="employee-id" id="employee-id" required
                                        placeholder="{{translate('Employee ID')}}" value="{{old('employee-id')}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="country">
                                        {{translate('Department')}}
                                    </label>
                                    <select name="country_id" id="country">
                                        <option value="">
                                            {{translate('Select Department')}}
                                        </option>
                                        {{-- @foreach ($countries as $country )
                                        <option {{old('country_id')==$country->id ? "selected" :""}}
                                            value="{{$country->id}}">
                                            {{$country->name}}
                                        </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="country">
                                        {{translate('Designation')}}
                                    </label>
                                    <select name="country_id" id="country">
                                        <option value="">
                                            {{translate('Select Designation')}}
                                        </option>
                                        {{-- @foreach ($countries as $country )
                                        <option {{old('country_id')==$country->id ? "selected" :""}}
                                            value="{{$country->id}}">
                                            {{$country->name}}
                                        </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="button-container">
                            <button class="button btn-navigate-form-step" type="button" step_number="1">Prev</button>
                            <button class="button btn-navigate-form-step" type="button" step_number="3">Next</button>
                        </div>

                    </div>
                </div>


            </section>

            <section id="step-3" class="form-step d-none">
                <div class="i-card-md">
                    <div class="card--header">
                        <h4 class="card-title">
                            {{translate('Company Information')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="account-holder-name">
                                        {{translate('Account Holder Name')}} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="account-holder-name" id="account-holder-name" required
                                        placeholder="{{translate('Account Holder Name')}}" value="{{old('account-holder-name')}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="account-number">
                                        {{translate('Enter Account Number')}}
                                        <small class="text-danger">*</small>
                                    </label>
                                    <input type="text" name="account-number" id="account-number"
                                        placeholder="{{translate('Enter Account Number')}}" value="{{old('account-number')}}"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="bank-name">
                                        {{translate('Bank Name')}}
                                        <small class="text-danger">*</small>
                                    </label>

                                    <input type="text" name="bank-name" id="bank-name"
                                        placeholder="{{translate('Enter Bank Name')}}" value="{{old('bank-name')}}" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="bank-indentifier-code">
                                        {{translate('Bank Identifier Code')}}
                                        <small class="text-danger">*</small>
                                    </label>

                                    <input type="text" name="bank-indentifier-code" id="bank-indentifier-code"
                                        placeholder="{{translate('Enter Bank Identifier Code')}}" value="{{old('bank-indentifier-code')}}" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="branch-location">
                                        {{translate('Branch Location')}}
                                    </label>
                                    <input type="text" name="branch-location" id="branch-location"
                                        placeholder="{{translate('Enter Branch Location')}}" value="{{old('branch-location')}}" required>
                                </div>
                            </div>

                        </div>

                        <div class="button-container">
                            <button class="button btn-navigate-form-step" type="button" step_number="2">Prev</button>
                            <button class="button submit-btn" type="submit">Save</button>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>
</div>

@endsection

@push('script-include')
<script src="{{asset('assets/global/js/bootstrapicon-iconpicker.js')}}"></script>
<script src="{{asset('assets/global/js/step-inputform.js')}}"></script>
@endpush

@push('script-push')
<script>
    (function ($) {
        "use strict";
        "use strict";

        $(".selectMeta").select2({
            placeholder: "{{translate('Enter Keywords')}}",
            tags: true,
            tokenSeparators: [',']
        })

        $('.icon-picker').iconpicker({
            title: "{{translate('Search Here !!')}}",
        });
        $('#parent_id').select2({});

    })(jQuery);
</script>
@endpush
