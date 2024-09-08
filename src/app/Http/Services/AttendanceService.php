<?php

namespace App\Http\Services;

use App\Enums\ClockStatusEnum;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class AttendanceService
{
    public function requestClockIn()
    {
        $userId     = Auth::id();
        $today      = Carbon::today()->toDateString();


        $attendance = Attendance::where('user_id', $userId)->where('date', $today)->first();


        if ($attendance) {
            throw new \Exception('You have already requested for clocked in today.');
        }

        $officeHours = json_decode(site_settings('office_hour'), true);
        $currentDay = strtolower(Carbon::now()->format('l'));
        $todaySchedule = $officeHours[$currentDay] ?? null;

        if (!$todaySchedule || !$todaySchedule['is_on']) {
            throw new \Exception(translate('Office is closed today.'));
        }

        $officeStartTime = Carbon::parse($todaySchedule['clock_in']);
        $clockInTime = Carbon::now();

        $lateMinutes = $clockInTime->greaterThan($officeStartTime)
                        ? $clockInTime->diffInMinutes($officeStartTime)
                        : 0;




        Attendance::updateOrCreate(
            ['user_id' => $userId, 'date' => $today],
            [
                'clock_in'          => Carbon::now(),
                'late_time'         => $lateMinutes,
                'clock_in_status'   => ClockStatusEnum::pending->status(),
            ]
        );
    }

    public function requestClockOut()
    {
        $userId     = Auth::id();
        $today      = Carbon::today()->toDateString();

        $attendance = Attendance::where('user_id', $userId)->where('date', $today)->first();


        if (!$attendance || $attendance->clock_in_status !== ClockStatusEnum::approved->status() || $attendance->clock_out_status === ClockStatusEnum::approved->status()) {
            throw new \Exception('You must clock in first or you have already clocked out today.');
        }


        Attendance::updateOrCreate(
            ['user_id' => $userId, 'date' => $today],
            [
                'clock_out'         => carbon::now(),
                'clock_out_status'  => ClockStatusEnum::pending->status(),
            ]
        );
    }
}
