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
                'clock_in_status'   => ClockStatusEnum::PENDING->status(),
            ]
        );
    }



    public function requestClockOut()
    {
        $userId     = Auth::id();
        $today      = Carbon::today()->toDateString();

        $attendance = Attendance::where('user_id', $userId)->where('date', $today)->first();


        if (!$attendance) throw new \Exception('You must clock in first.');
        if ($attendance->clock_in_status !== ClockStatusEnum::APPROVED->status()) throw new \Exception('Clock-in has not approved yet.');
        if ($attendance->clock_out_status === ClockStatusEnum::APPROVED->status()) throw new \Exception('Already clocked out.');


        $clockInTime    = Carbon::parse($attendance->clock_in);
        $clockOutTime   = Carbon::now();
        $dayOfWeek      = t2k(Carbon::today()->format('l'));

        $data           = $this->processCLockOut( clockInTime: $clockInTime, clockOutTime: $clockOutTime);

        Attendance::updateOrCreate(
            ['user_id' => $userId, 'date' => $today],
            [
                'clock_out'         => carbon::now(),
                'clock_out_status'  => ClockStatusEnum::PENDING->status(),
                'work_hour'         => $data['work_hour'],
                'over_time'         => $data['over_time'],
            ]
        );
    }

    public function processClockIn($clockInTime)
    {
        $officeHours                = json_decode(site_settings('office_hour'), true);
        $day                        = t2k($clockInTime->format('l'));
        $referenceDate              = $clockInTime->format('Y-m-d');
        $ClockInTimeString          = $clockInTime->format('h:i A');
        $todaySchedule              = $officeHours[$day] ?? null;
        $attendanceSettings         = json_decode(site_settings('attendance_settings'));


        if (!$todaySchedule || !$todaySchedule['is_on']) {
            throw new \Exception(translate('Office is closed today.'));
        }

        $officeStartTimeString      = $todaySchedule['clock_in'] ?? '00:00 AM';


        $actualClockInTime  = Carbon::createFromFormat('Y-m-d h:i A', "{$referenceDate} {$ClockInTimeString}");
        $officeStartTime    = Carbon::createFromFormat('Y-m-d h:i A', "{$referenceDate} {$officeStartTimeString}");

        $lateMinutes = $actualClockInTime->greaterThan($officeStartTime)
            ? $actualClockInTime->diffInMinutes($officeStartTime)
            : 0;


        if (!empty($attendanceSettings) && !empty($attendanceSettings->grace_time) && $lateMinutes <= $attendanceSettings->grace_time) {
            $lateMinutes = 0;
        }

        return $lateMinutes;
    }

    public function processClockOut($clockInTime, $clockOutTime)
    {

        $officeHours                = json_decode(site_settings('office_hour'), true);
        $day                        = t2k($clockInTime->format('l'));
        $referenceDate              = $clockInTime->format('Y-m-d');

        $officeClockIn              = $officeHours[$day]['clock_in'] ?? '00:00 AM';
        $officeClockOut             = $officeHours[$day]['clock_out'] ?? '00:00 AM';



        $officeStartTime            = Carbon::createFromFormat('Y-m-d h:i A', "{$referenceDate} {$officeClockIn}");
        $officeEndTime              = Carbon::createFromFormat('Y-m-d h:i A', "{$referenceDate} {$officeClockOut}");




        $officeWorkDuration             = $officeStartTime->diffInMinutes($officeEndTime);

        $data['work_hour']              = $clockInTime->diffInMinutes($clockOutTime);
        $data['over_time']              = max(0, $data['work_hour'] - $officeWorkDuration);

        return $data;
    }




    public function getAttendance($dates, $currentDate)
    {


        $officeHolidays      = collect(json_decode(site_settings('holidays')));
        $officeSchedules     = json_decode(site_settings('office_hour'), true);

        $requestedMonth = request()->input('month', now()->month);
        $requestedYear  = request()->input('year', now()->year);



        $users = User::with([
                    'attendances' => function ($query) use ($requestedMonth, $requestedYear){
                        return $query->whereMonth('created_at', $requestedMonth)
                                     ->whereYear('created_at', $requestedYear);
                    },
                    'leaves' => function ($query)use ($requestedMonth, $requestedYear) {
                        return $query->whereMonth('created_at', $requestedMonth)
                                     ->whereYear('created_at', $requestedYear);
                    }
            ])->userOnUser()
                ->get()
                ->map(function (User $user) use ($officeHolidays, $officeSchedules, $dates, $currentDate) {

                $userAttendances = $user->attendances->map(function ($attendance) {

                    return (object)['userAttendance' => $attendance, 'parse_date_key' => (Carbon::parse($attendance->clock_in)->format('d')), 'date_key' => Carbon::parse($attendance->clock_in)];
                });

                $holidayCount = 0;
                $presentCount = 0;
                $leaveCount   = 0;

                foreach ($dates as $date) {

                    $enumValue = AttendanceStatus::INVALID->value;

                    if ($date->original_format <= $currentDate) {



                        $attendenceExist =  $userAttendances->values()->where('parse_date_key', $date->parse_date)->first();



                        if ($attendenceExist) {

                            $clockOutStatus  = $attendenceExist->userAttendance->clock_out_status;
                            $clockInStatus  = $attendenceExist->userAttendance->clock_in_status;
                            $clock_out      = $attendenceExist->userAttendance->clock_out;
                            $late           = $attendenceExist->userAttendance->late_time;
                            $work_hour      = $attendenceExist->userAttendance->work_hour;
                            $attendanceSettings  = json_decode(site_settings('attendance_settings'));



                            $enumValue = $clockInStatus == ClockStatusEnum::APPROVED->status()
                                                                            ? AttendanceStatus::PRESENT->value
                                                                            : AttendanceStatus::CLOCKED_IN->value;

                            if($clockInStatus  != ClockStatusEnum::APPROVED->status()) $enumValue= AttendanceStatus::CLOCKED_IN->value;


                            if($clockInStatus  == ClockStatusEnum::APPROVED->status()){
                                $enumValue= AttendanceStatus::PRESENT->value;
                                $graceTime = $attendanceSettings->grace_time ?? 0;
                                if ($late > $graceTime)  $enumValue = AttendanceStatus::LATE->value;
                            }

                            if($clock_out){
                                if($clockOutStatus != ClockStatusEnum::APPROVED->status()) $enumValue= AttendanceStatus::CLOCKED_OUT->value;
                            }

                            if($clockOutStatus == ClockStatusEnum::APPROVED->status()){
                                if($work_hour){
                                    // Check if the time difference is less than or equal to 7 hours (360 minutes)
                                   if ($work_hour <= 420) $enumValue = AttendanceStatus::HALF_DAY->value;
                                }
                            }




                            $presentCount++;
                        } else {

                            $enumValue  = AttendanceStatus::ABSENT->value;

                            $day        = t2k($date->original_format->format('l'));



                            $custom_office_hour = $user->custom_office_hour ? @json_decode($user->custom_office_hour, true) : null;

                            #check office holiday
                            $officeSchedule = Arr::get($officeSchedules, $day, null);
                            $is_open        = Arr::get($officeSchedule, 'is_on');


                            if ($is_open == false) {
                                $enumValue = AttendanceStatus::OFFICE_HOLIDAY->value;
                                $holidayCount++;
                            }
                            #check custom holiday
                            if ($custom_office_hour) {

                                $holidayCount = 0;

                                $customCurrentDaySchedule = Arr::get($custom_office_hour, $day, null);

                                $is_custom_open = Arr::get($customCurrentDaySchedule, 'is_on');

                                if ($is_custom_open == false) {
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
                            $employeeLeaves = $user->leaves->where('status', LeaveStatus::APPROVED->status()) ?? [];

                            foreach ($employeeLeaves as $leave) {

                                $startDate              = Carbon::parse($leave->start_date);
                                $endDate                = Carbon::parse($leave->end_date);
                                $is_on_leave            = $carbonDate->between($startDate, $endDate);

                                if ($is_on_leave) {
                                    $enumValue = AttendanceStatus::ON_LEAVE->value;
                                    $leaveCount++;
                                }
                            }
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



    public function getDatesOfMonth($month, $year)
    {

        return collect(CarbonPeriod::create("$year-$month-01", '1 day', Carbon::create($year, $month)->endOfMonth()))
            ->map(fn($date) => (object)[
                'parse_date' => $date->format('d'),
                'original_format' => $date
            ])->all();
    }
}
