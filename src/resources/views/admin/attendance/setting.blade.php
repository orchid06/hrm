@extends('admin.layouts.master')
@section('content')
@php
    $attendanceSettings = json_decode(site_settings('attendance_settings'))?? [];
@endphp

    <div class="i-card-md mb-4">
        <div class="card--header">
            <h4 class="card-title">
                {{ translate('Attendance Settings') }}
            </h4>
        </div>

            <div class="card-body">
                <form data-route="{{route('admin.attendance.settings.store')}}"  class="settingsForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-5">
                        <div class="mt-10">
                            <div class="row">

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

                                <div class="col-xl-6">
                                    <div class="form-inner mt-4">
                                        <label for="grace_time">
                                            {{ translate('Grace Time') }} <small class="text-danger">*</small>
                                        </label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="grace_time" id="grace_time"
                                                value="{{ @$attendanceSettings->grace_time }}" required min="0">

                                                <span class="input-group-text">minutes</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                         <!-- Submit Button -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="i-btn ai-btn btn--md btn--primary" data-anim="ripple">
                                {{ translate('Submit') }}
                            </button>
                        </div>
                    </div>


                </form>
            </div>

    </div>

    <div class="i-card-md">
        <div class="card--header">
            <h4 class="card-title">
                {{ translate('IP whitelist Settings') }}
            </h4>
        </div>
        <div class="card-body">
            <button type="button" id="add-ip" class="btn btn-primary mt-3">
                {{ translate('Add Another IP') }}
            </button>
            <div class="mb-5">
                <div class="mt-10">
                    <div class="row">

                        <!-- Status Dropdown -->
                        <div class="col-xl-6">
                            <div class="form-inner">
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

                         <!-- IP 1 -->
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

                        <div id="ipField"></div>

                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end">
                <button type="submit" class="i-btn ai-btn btn--md btn--primary" data-anim="ripple">
                    {{ translate('Submit') }}
                </button>
            </div>

        </div>

    </div>



@endsection

@section('modal')
@include('modal.delete_modal')
@include('modal.bulk_modal')
@endsection

@push('script-include')

@endpush

@push('script-push')
<script>
    "use strict"
    $(document).on('click','#add-ip',function(e){
        ipCount++; // Increment the count for each new field
            var html = `<tr>
                <td>
                    <div class="col-xl-6 ip-field">
                        <div class="form-inner">
                            <label for="ip_start_range_${ipCount}">
                                {{ translate('IP Range Start') }} <small class="text-danger">*</small>
                            </label>
                            <input id="ip_start_range_${ipCount}"
                                name="ip_start_range[]"
                                placeholder="e.g. 192.168.1.1"
                                type="text"
                                class="form-control"
                                required>
                        </div>
                    </div>
                </td>

                <td>
                    <div >
                                    <a href="javascript:void(0);" class="pointer icon-btn danger delete-option">
                                         <i class="las la-trash-alt"></i>
                                    </a>
                                </div>
                </td>
            </tr>`;

            $('#ipField').append(html)
            e.preventDefault()

    });

    $(document).on('click','.delete-option',function(e){
			$(this).closest("tr").remove()
			count--
			e.preventDefault()
	});
</script>
@endpush
