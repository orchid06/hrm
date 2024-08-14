@extends('admin.layouts.master')

@push('style-include')
<link rel="stylesheet" href="{{asset('assets/global/css/bootstrapicons-iconpicker.css')}}">
<link rel="stylesheet" href="{{asset('assets/global/css/step-inputform.css')}}">
@endpush

@section('content')

@php
$countries = App\Models\Country::get();
@endphp


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
            action="{{route('admin.user.store')}}">
            @csrf

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
                                    <select class="select2" name="country_id" id="country">
                                        <option value="">
                                            {{translate('Select Country')}}
                                        </option>
                                        @foreach ($countries as $country )
                                        <option {{old('country_id')==$country->id ? "selected" :""}}
                                            value="{{$country->id}}">
                                            {{$country->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="phone">
                                        {{translate('Phone')}}
                                        <small class="text-danger">*</small>
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
                            <div class="col-6">
                                <div class="form-inner">
                                    <label for="password">
                                        {{translate('Password')}}
                                        <small class="text-danger">*({{translate('Minimum 6
                                            Characters')}})</small>
                                    </label>
                                    <input placeholder="{{translate('Enter Password')}}" type="password" id="password"
                                        name="password" value="{{old('password')}}" required>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-inner">
                                    <label for="address">
                                        {{translate('Address')}}
                                    </label>
                                    <textarea id="address" name="address" class="form-control" rows="4"></textarea>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-inner">
                                    <label for="password_confirmation">
                                        {{translate('Confrim Password')}}
                                        <small class="text-danger">*({{translate('Minimum 6
                                            Characters')}})</small>
                                    </label>
                                    <input placeholder="{{translate('Enter Confirm Password')}}" type="password"
                                        id="password_confirmation" name="password_confirmation"
                                        value="{{old('password_confirmation')}}" required>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-inner">
                                    <label for="date_of_birth">
                                        {{translate('Date of Birth')}}
                                        <small class="text-danger">*</small>
                                    </label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{old('date_of_birth')}}" placeholder="{{translate('Enter Date of birth')}}" required>
                                </div>
                            </div>

                        </div>
                        <div class="button-container-left">
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

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="employee_id">
                                        {{translate('Employee ID')}} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="employee_id" id="employee_id" required
                                        placeholder="{{translate('Employee ID')}}" value="{{old('employee-id')}}">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-inner">
                                    <label for="date_of_joining">
                                        {{translate('Joining Date')}}
                                        <small class="text-danger">*</small>
                                    </label>
                                    <input type="date" name="date_of_joining" id="date_of_joining" value="{{old('date_of_joining')}}" placeholder="{{translate('Enter Date of Joining')}}" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="designation_id">
                                        {{translate('Designation')}}
                                        <small class="text-danger">*</small>
                                    </label>
                                    <select class="select2" name="designation_id" id="designation_id" required>
                                        <option value="">{{translate('Select a Designation')}}</option>
                                        @foreach ($designations as $designation)
                                        <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="salary">
                                        {{translate('Salary')}} <small class="text-danger">*</small>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{session()->get('currency')?->code}}</span>
                                        <input type="number" min="0" step="any" id="salary"  class="form-control " name="salary">
                                        <span class="input-group-text set-currency"></span>
                                        <span class="input-group-text">{{translate('Monthly')}}</span>
                                    </div>
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
                            {{translate('Bank Information')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="account_holder_name">
                                        {{translate('Account Holder Name')}}
                                    </label>
                                    <input type="text" name="account_holder_name" id="account_holder_name"
                                        placeholder="{{translate('Account Holder Name')}}"
                                        value="{{old('account_holder_name')}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="account_number">
                                        {{translate('Enter Account Number')}}

                                    </label>
                                    <input type="text" name="account_number" id="account_number"
                                        placeholder="{{translate('Enter Account Number')}}"
                                        value="{{old('account_number')}}" >
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="bank_name">
                                        {{translate('Bank Name')}}

                                    </label>

                                    <input type="text" name="bank_name" id="bank_name"
                                        placeholder="{{translate('Enter Bank Name')}}" value="{{old('bank_name')}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="bank_indentifier_code">
                                        {{translate('Bank Identifier Code')}}

                                    </label>

                                    <input type="text" name="bank_indentifier_code" id="bank_indentifier_code"
                                        placeholder="{{translate('Enter Bank Identifier Code')}}"
                                        value="{{old('bank_indentifier_code')}}" >
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <label for="branch_location">
                                        {{translate('Branch Location')}}
                                    </label>
                                    <input type="text" name="branch_location" id="branch_location"
                                        placeholder="{{translate('Enter Branch Location')}}"
                                        value="{{old('branch_location')}}" >
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

        $(".select2").select2({

        })

        $('.icon-picker').iconpicker({
            title: "{{translate('Search Here !!')}}",
        });

    })(jQuery);
</script>
@endpush
