@extends('admin.layouts.master')
@section('content')
<div class="i-card-md">
    <div class="card-body">
        <div class="search-action-area">
            <div class="row g-3">



            </div>
        </div>

        <div class="table-container position-relative">
            <form data-route="{{route('admin.office.hour.store')}}" class="settingsForm" method="POST">
                @csrf
                <div class="row g-4">

                    <div class="table-responsive operating-table">
                        <table class="table align-middle table-nowrap mb-0 ">
                            <thead class="table-light ">
                                <tr>

                                    <th scope="col">
                                        {{translate('Days')}}
                                    </th>
                                    <th scope="col">
                                        {{translate('Start time')}}
                                    </th>
                                    <th scope="col">
                                        {{translate('End time')}}
                                    </th>

                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $days =  [
                                        'Monday'    =>  'Monday',
                                        'Tuesday'   =>  'Tuesday',
                                        'Wednesday' =>  'Wednesday',
                                        'Thursday'  =>  'Thursday',
                                        'Friday'    =>  'Friday',
                                        'Saturday'  =>  'Saturday',
                                        'Sunday'    =>  'Sunday',
                                    ];
                                    $operatingTimes = generateOperatingTimes();
                                @endphp
                                @php
                                  $office_hours =   site_settings(key:'office_hour',default:null)
                                                     ? json_decode(site_settings(key:'office_hour',default:null),true)
                                                     : [];


                                @endphp
                                    @foreach ($days as $key => $day )
                                        <tr>
                                             @php

                                               $officeDay   =  Arr::get($office_hours ,$key,[]);
                                               $is_holiday  =  Arr::get($officeDay ,'is_on',false);
                                               $startTime   =  Arr::get($officeDay ,'start_time',null);
                                               $endTime     =  Arr::get($officeDay ,'end_time',null);
                                             @endphp
                                                <td>
                                                    <input {{$is_holiday ? "checked" :''}}  class="form-check-input" name="operating_day[]" type="checkbox" value="{{$key}}" id="{{$key}}">
                                                    <label class="form-check-label fs-14" for="{{$key}}">
                                                        {{$day}}
                                                    </label>
                                                </td>

                                                <td>
                                                    <select name="start_time[{{$key}}]" class="select2" id="start_time[{{$key}}]">

                                                        <option value="">
                                                            {{translate('Select time')}}
                                                        </option>
                                                        <option {{$startTime == '24H' ? "selected" :''}} value="24H">
                                                              {{translate("24 Hour")}}
                                                        </option>


                                                        @foreach($operatingTimes as $time)
                                                            <option {{$startTime == $time ? "selected" :''}} value="{{$time}}">{{$time}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="endtime_td">
                                                    <select @if($startTime == '24H') disabled @endif name="end_time[{{$key}}]" class="select2" id="end_time[{{$key}}]" >

                                                        <option label="{{translate('Select end time')}}"></option>
                                                        @foreach($operatingTimes as $time)
                                                            <option {{$endTime == $time ? "selected" :''}} value="{{$time}}">{{$time}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                        </tr>
                                    @endforeach

                            </tbody>

                        </table>
                    </div>

                    <div class="col-12 mt-2">
                        <div class="text-start">
                            <button type="submit" class="btn btn-success">
                                {{translate('Update')}}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@section('modal')
@endsection

@push('script-push')
<script>
    "use strict";

    $(".select2").select2({
                placeholder: "{{translate('Select a Time')}}",
            })
</script>
@endpush
