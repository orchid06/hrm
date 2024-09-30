
@php

    $clockInTime    = $attendance ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : null;
    $clockOutTime   = $attendance ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : null;
    $clockInStatus  = $attendance ?$attendance->clock_in_status : null;
    $clockOutStatus = $attendance ?$attendance->clock_out_status : null;

@endphp

<input type="hidden" name="date" value="{{$date}}" >
<div class="row">
    <div class="col-6">
        <div class="form-inner">
            <label for="clock_in">{{translate('CLock In')}}</label>
            <input type="time" name="clock_in" id="clock_in" value="{{$clockInTime}}"
                placeholder="{{translate('Set Clock In')}}">
        </div>
    </div>

    <div class="col-6">
        <div class="form-inner">
            <label for="clock_in_status">{{translate('Status')}}</label>
            <select name="clock_in_status" id="clock_in_status" class="form-select">
                <option value="">{{translate('Select Status')}}</option>
                @foreach(\App\Enums\ClockStatusEnum::toArray() as $key=>$clockStatus);

                <option value="{{$clockStatus}}" {{ $clockInStatus == $clockStatus ? 'selected' : ''}}>{{$key}}</option>

                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="form-inner">
            <label for="clock_out">{{translate('CLock Out')}}</label>
            <input type="time" name="clock_out" id="clock_out" value="{{$clockOutTime}}"
                placeholder="{{translate('Set Clock Out')}}">
        </div>
    </div>

    <div class="col-6">
        <div class="form-inner">
            <label for="clock_out_status">{{translate('Status')}}</label>
            <select name="clock_out_status" id="clock_out_status" class="form-select">
                <option value="">{{translate('Select Status')}}</option>
                @foreach(\App\Enums\ClockStatusEnum::toArray() as $key=>$clockStatus);

                <option value="{{$clockStatus}}" {{$clockOutStatus == $clockStatus ? 'selected' : ''}}>{{$key}}</option>

                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-inner">
    <label for="note">{{translate('Note')}}</label>
    <textarea name="note" id="note" cols="30" rows="10"> </textarea>
</div>

