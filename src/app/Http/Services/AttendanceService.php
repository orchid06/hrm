<?php

namespace App\Http\Services;


use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class AttendanceService
{
    public function clockIn()
    {
        $userId     = Auth::id();
        $today      = Carbon::today()->toDateString();

        $attendance = Attendance::where('user_id', $userId)->where('date', $today)->first();

        if ($attendance) {
            throw new \Exception(translate('You have already clocked in today.'));
        }


        $officeHours    = json_decode(site_settings('office_hour'), true);
        $currentDay     = strtolower(Carbon::now()->format('l'));
        $todaySchedule  = $officeHours[$currentDay];

        if (!$todaySchedule['is_on']) {
            throw new \Exception(translate('Office is closed today.'));
        }

        $officeStartTime    = Carbon::parse($todaySchedule['clock_in']);
        $clockInTime        = Carbon::now();

        $lateMinutes = $clockInTime->greaterThan($officeStartTime)
            ? $officeStartTime->diffInMinutes($clockInTime)
            : 0;

        return Attendance::create([
            'user_id' => $userId,
            'date' => $today,
            'clock_in' => $clockInTime,
            'late_time' => $lateMinutes,
        ]);
    }

    public function clockOut()
    {
        $userId = Auth::id();
        $today = Carbon::today()->toDateString();


        $attendance = Attendance::where('user_id', $userId)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            throw new \Exception('You need to clock in before clocking out.');
        }

        if ($attendance->clock_out) {
            throw new \Exception('You have already clocked out today.');
        }


        $officeHours = json_decode(site_settings('office_hour'), true);
        $currentDay = strtolower(Carbon::now()->format('l'));
        $todaySchedule = $officeHours[$currentDay];

        if (!$todaySchedule['is_on']) {
            throw new \Exception('Office is closed today.');
        }

        $scheduledClockInTime = Carbon::parse($todaySchedule['clock_in']);
        $scheduledClockOutTime = Carbon::parse($todaySchedule['clock_out']);


        $scheduledWorkMinutes = $scheduledClockInTime->diffInMinutes($scheduledClockOutTime);


        $clockInTime = Carbon::parse($attendance->clock_in);
        $clockOutTime = Carbon::now();


        $actualWorkMinutes = $clockInTime->diffInMinutes($clockOutTime);


        $overtimeMinutes = max(0, $actualWorkMinutes - $scheduledWorkMinutes);

        
        $attendance->update([
            'clock_out' => $clockOutTime,
            'work_hour' => $actualWorkMinutes,
            'over_time' => $overtimeMinutes,
        ]);

        return $attendance;
    }
}
