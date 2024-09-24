@extends('admin.layouts.master')
@section('content')
@php
    $attendanceSettings = json_decode(site_settings('ip_white_list'))?? [];
@endphp
<form data-route="{{route('admin.attendance.settings.store')}}"  class="settingsForm" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">
                {{ translate('IP Whitelist Settings') }}
            </h4>
        </div>
        <div class="card-body">
            <div class="mb-10">
                <div class="mt-30">
                    <div class="row">


                        <!-- IP Range Start -->
                        <div class="col-xl-6">
                            <div class="form-inner">
                                <label for="ip_start_range">
                                    {{ translate('IP Range Start') }} <small class="text-danger">*</small>
                                </label>
                                <input id="ip_start_range"
                                       name="ip_start_range"
                                       placeholder="e.g. 192.168.1.1"
                                       type="text"
                                       class="form-control"
                                       value="{{@$attendanceSettings->ip_start_range}}"
                                       required>
                            </div>
                        </div>

                        <!-- IP Range End -->
                        <div class="col-xl-6">
                            <div class="form-inner">
                                <label for="ip_end_range">
                                    {{ translate('IP Range End') }} <small class="text-danger">*</small>
                                </label>
                                <input id="ip_end_range"
                                       name="ip_end_range"
                                       placeholder="e.g. 192.168.1.255"
                                       type="text"
                                       class="form-control"
                                       value="{{@$attendanceSettings->ip_end_range}}"
                                       required>
                            </div>
                        </div>

                        <!-- Status Dropdown -->
                        <div class="col-xl-6">
                            <div class="form-inner mt-4">
                                <label for="ip_whitelist_status">
                                    {{ translate('Status') }} <small class="text-danger">*</small>
                                </label>
                                <select class="form-select" name="ip_whitelist_status" id="ip_whitelist_status">
                                    @foreach(App\Enums\StatusEnum::toArray() as $key => $value)
                                        <option value="{{$value}}" {{$value == @$attendanceSettings->ip_whitelist_status ? 'selected' : ''}}>{{ $key}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Default Clock-in Status Dropdown -->
                        <div class="col-xl-6">
                            <div class="form-inner mt-4">
                                <label for="clock_in_status">
                                    {{ translate('Default Clock-in Status') }} <small class="text-danger">*</small>
                                </label>
                                <select class="form-select" name="clock_in_status" id="clock_in_status">
                                    @foreach(App\Enums\ClockStatusEnum::toArray() as $key => $value)
                                    <option value="{{$value}}" {{$value == @$attendanceSettings->clock_in_status ? 'selected' : ''}}>{{ $key}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="i-btn ai-btn btn--md btn--primary" data-anim="ripple">
                    {{ translate('Submit') }}
                </button>
            </div>
        </div>

    </div>

</form>
@endsection

@section('modal')
@include('modal.delete_modal')
@include('modal.bulk_modal')
@endsection

@push('script-include')

@endpush

@push('script-push')
@endpush
