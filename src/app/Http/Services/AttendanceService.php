<?php

namespace App\Http\Services;

use App\Enums\ClockStatusEnum;
use App\Enums\LeaveStatus;
use App\Enums\StatusEnum;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $clockInTime = Carbon::now();

        $lateMinutes = $this->processClockIn($clockInTime);

        Attendance::updateOrCreate(
            ['user_id' => $userId, 'date' => $today],
            [
                'clock_in'          => Carbon::now(),
                'late_time'         => $lateMinutes,
                'clock_in_status'   => ClockStatusEnum::pending->status(),
            ]
        );
    }

    public function processClockIn($clockInTime)
    {
        $officeHours = json_decode(site_settings('office_hour'), true);
        $currentDay = strtolower(Carbon::now()->format('l'));
        $todaySchedule = $officeHours[$currentDay] ?? null;

        if (!$todaySchedule || !$todaySchedule['is_on']) {
            throw new \Exception(translate('Office is closed today.'));
        }

        $officeStartTime = Carbon::parse($todaySchedule['clock_in']);


        $lateMinutes = $clockInTime->greaterThan($officeStartTime)
            ? $clockInTime->diffInMinutes($officeStartTime)
            : 0;
        return $lateMinutes;
    }

    public function requestClockOut()
    {
        $userId     = Auth::id();
        $today      = Carbon::today()->toDateString();

        $attendance = Attendance::where('user_id', $userId)->where('date', $today)->first();


        if (!$attendance) throw new \Exception('You must clock in first.');
        if ($attendance->clock_in_status !== ClockStatusEnum::approved->status()) throw new \Exception('Clock-in has not approved yet.');
        if ($attendance->clock_out_status === ClockStatusEnum::approved->status()) throw new \Exception('Already clocked out.');


        $clockInTime    = Carbon::parse($attendance->clock_in);
        $clockOutTime   = Carbon::now();
        $dayOfWeek      = t2k(Carbon::today()->format('l'));

        $data           = $this->processCLockOut($dayOfWeek, $clockInTime, $clockOutTime);

        Attendance::updateOrCreate(
            ['user_id' => $userId, 'date' => $today],
            [
                'clock_out'         => carbon::now(),
                'clock_out_status'  => ClockStatusEnum::pending->status(),
                'work_hour'         => $data['work_hour'],
                'over_time'         => $data['over_time'],
            ]
        );
    }

    public function processCLockOut($dayOfWeek, $clockInTime, $clockOutTime)
    {

        $officeHours        = json_decode(site_settings('office_hour'), true);
        $officeClockIn      = Carbon::parse($officeHours[$dayOfWeek]['clock_in']);
        $officeClockOut     = Carbon::parse($officeHours[$dayOfWeek]['clock_out']);

        $officeWorkDuration = $officeClockIn->diffInMinutes($officeClockOut);

        $data['work_hour']              = $clockInTime->diffInMinutes($clockOutTime);
        $data['over_time']              = max(0, $data['work_hour'] - $officeWorkDuration);

        return $data;
    }




    public function generateAttendance($year, $month)
    {
        $users = User::where('status' , StatusEnum::true->status())->get();

        $datesOfSpecifiedMonth = $this->getDatesOfMonth(12, 1997);
        $officeHolidays = $this->getOfficeHolidays();

        dd($officeHolidays , $datesOfSpecifiedMonth);

        return $users;
    }

    public function getDatesOfMonth($month, $year) {

        $start = new DateTime("$year-$month-01");

        $end = clone $start;
        $end->modify('last day of this month');


        $period = new DatePeriod($start, new DateInterval('P1D'), $end->modify('+1 day'));

        $dates = [];
        foreach ($period as $date) {
            $dates[] =(object)[
                'parse_date' => $date->format('d'),
                'original_format' => Carbon::instance($date),

            ];

        }

        return $dates;
    }


}
