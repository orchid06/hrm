<?php

namespace App\Http\Services;

use App\Enums\AttendanceStatus;
use App\Enums\ClockStatusEnum;
use App\Enums\LeaveStatus;
use App\Enums\StatusEnum;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Arr;
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




    public function getAttendance( $dates, $currentDate)
    {


        $officeHolidays      = collect(json_decode(site_settings('holidays')));
        $officeSchedules     = json_decode(site_settings('office_hour'), true);


        $users = User::with([
            'attendances' => function ($query) {
                return $query->month()->year();
            },
            'leaves' => function ($query) {
                return $query->month()->year();
            }
        ])
        ->userOnUser()
        ->get()->map(function (User $user) use ($officeHolidays, $officeSchedules, $dates , $currentDate) {



            $userAttendances = $user->attendances->map(function ($attendance) {

                return (object)['userAttendance' => $attendance , 'parse_date_key' => (Carbon::parse($attendance->clock_in)->format('d')), 'date_key' => Carbon::parse($attendance->clock_in)];
            });

            $holidayCount = 0;
            $presentCount = 0;
            $leaveCount   = 0;

            foreach ($dates as $date) {

                $enumValue = AttendanceStatus::INVALID->value;

                if ($date->original_format <= $currentDate) {



                    $attendenceExist =  $userAttendances->values()->where('parse_date_key', $date->parse_date)->first();



                    if ($attendenceExist) {

                        $clockIn        = $attendenceExist->userAttendance->clock_in;
                        $clockOut       = $attendenceExist->userAttendance->clock_out;
                        $clockInStatus  = $attendenceExist->userAttendance->clock_in_status;
                        $late           = $attendenceExist->userAttendance->late_time;


                        $clockInStatus   == ClockStatusEnum::approved ? $enumValue = AttendanceStatus::PRESENT->value
                                                                      : $enumValue = AttendanceStatus::CLOCKED_IN->value;

                        if($late > 0)  $enumValue= AttendanceStatus::LATE->value;

                        $presentCount++;

                    } else {

                        $enumValue  = AttendanceStatus::ABSENT->value;

                        $day        = t2k($date->original_format->format('l'));



                        $custom_office_hour = $user->custom_office_hour ? @json_decode($user->custom_office_hour, true) : null;

                        #check office holiday
                        $officeSchedule = Arr::get($officeSchedules, $day, null);
                        $is_open        = Arr::get($officeSchedule, 'is_on');

                        if($is_open == false) {
                            $enumValue = AttendanceStatus::OFFICE_HOLIDAY->value;
                            $holidayCount++;
                        }
                        #check custom holiday
                        if ($custom_office_hour) {

                            $holidayCount = 0;

                            $customCurrentDaySchedule = Arr::get($custom_office_hour, $day, null);

                            $is_custom_open = Arr::get($customCurrentDaySchedule, 'is_on');

                            if($is_custom_open == false){
                                $enumValue = AttendanceStatus::EMPLOYEE_HOLIDAY->value;
                                $holidayCount++;
                            }
                        }

                        $carbonDate         = $date->original_format;

                        #check holidays
                        foreach ($officeHolidays as $officeHoliday) {

                            $startDate          = Carbon::parse($officeHoliday->start_date);
                            $endDate            = Carbon::parse($officeHoliday->end_date);


                            $is_holiday = $carbonDate->between($startDate, $endDate);

                            if ($is_holiday) {
                                $enumValue = AttendanceStatus::PUBLIC_HOLIDAY->value;
                                $holidayCount++;
                            }
                        }

                        #check employee Leave
                        $employeeLeaves = $user->leaves->where('status' , LeaveStatus::approved->status()) ?? [];

                        foreach ($employeeLeaves as $leave) {

                            $startDate              = Carbon::parse($leave->start_date);
                            $endDate                = Carbon::parse($leave->end_date);
                            $is_on_leave            = $carbonDate->between($startDate, $endDate);

                            if($is_on_leave){
                                $enumValue = AttendanceStatus::ON_LEAVE->value;
                                $leaveCount++;
                        }    }
                    }
                }


                $attendance[$date->parse_date] = $enumValue;
            }

            $daysInMonth    = count($dates);
            $holidays       = $holidayCount;
            $workingDays    = max(0, $daysInMonth - $holidays);

            $attendanceTotal = [
                'working_days'  => $workingDays,
                'present_count' => $presentCount,
                'leave_count'   => $leaveCount,
                'absent_count'  => $workingDays - ($presentCount + $leaveCount)
            ];

            $user->attendanceStatus = $attendance;
            $user->attendanceTotal  = (object)$attendanceTotal;

            return $user;
        });

        return $users;
    }



    public function getDatesOfMonth($month, $year) {

        return collect(CarbonPeriod::create("$year-$month-01", '1 day', Carbon::create($year, $month)->endOfMonth()))
            ->map(fn($date) => (object)[
                'parse_date' => $date->format('d'),
                'original_format' => $date
            ])->all();
    }


}
