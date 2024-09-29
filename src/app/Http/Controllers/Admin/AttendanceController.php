<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AttendanceStatus;
use App\Enums\ClockStatusEnum;
use App\Enums\LeaveStatus;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Services\AttendanceService;
use App\Models\Attendance;
use App\Models\Core\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    use ModelAction, Fileable;

    public function __construct(protected AttendanceService $attendanceService)
    {
        //check permissions middleware
        $this->middleware(['permissions:view_attendance'])->only(['list']);
        $this->middleware(['permissions:create_attendance'])->only(['store', 'create']);
        $this->middleware(['permissions:update_attendance'])->only(['updateStatus', 'update', 'edit', 'bulk', 'setting']);
        $this->middleware(['permissions:delete_attendance'])->only(['destroy', 'bulk']);
    }



    public function list(Request $request): View
    {

        $month = request('month', now()->month);
        $year  = request('year', now()->year);


        $dates          = $this->attendanceService->getDatesOfMonth($month, $year);
        $currentDate    = Carbon::today();


        $officeHolidays      = collect(json_decode(site_settings('holidays')));
        $officeSchedules     = json_decode(site_settings('office_hour'), true);


        $users = User::with([
            'attendances' => function ($query) {
                return $query->month()->year();
            },
            'leaves' => function ($query) {
                return $query->month()->year();
            }
        ])->userOnUser()
        ->get()->map(function (User $user) use ($officeHolidays, $officeSchedules, $dates , $currentDate) {



            $userAttendances = $user->attendances->map(function ($attendance) {

                $userAttendance = $attendance;
                $attendanceDate = $attendance->date;

                return (object)['userAttendance' => $userAttendance , 'parse_date_key' => (Carbon::parse($attendanceDate)->format('d')), 'date_key' => Carbon::parse($attendanceDate)];
            });



            foreach ($dates as $date) {

                $enumValue = AttendanceStatus::INVALID->value;

                if ($date->original_format <= $currentDate) {



                    $attendenceExist =  $userAttendances->values()->where('parse_date_key', $date->parse_date)->first();



                    if ($attendenceExist) {
                        $enumValue = AttendanceStatus::PRESENT->value;

                        $clockIn        = $attendenceExist->userAttendance->clock_in;
                        $clockOut       = $attendenceExist->userAttendance->clock_out;
                        $clockInStatus  = $attendenceExist->userAttendance->clock_in_status;

                        $late     = $attendenceExist->userAttendance->late_time;
                        if($late > 0)  $enumValue= AttendanceStatus::LATE->value;

                        if( $clockInStatus != ClockStatusEnum::approved) $enumValue = AttendanceStatus::CLOCKED_IN->value;

                    } else {
                        $enumValue = AttendanceStatus::ABSENT->value;


                        $day = t2k($date->original_format->format('l'));


                        $custom_office_hour = $user->custom_office_hour ? @json_decode($user->custom_office_hour, true) : null;

                        #check office holiday
                        $officeSchedule = Arr::get($officeSchedules, $day, null);
                        $is_open        = Arr::get($officeSchedule, 'is_on');

                        if($is_open == false) $enumValue = AttendanceStatus::OFFICE_HOLIDAY->value;

                        #chek custom holiday
                        if ($custom_office_hour) {


                            $customCurrentDaySchedule = Arr::get($custom_office_hour, $day, null);

                            $is_custom_open = Arr::get($customCurrentDaySchedule, 'is_on');

                            if($is_custom_open == false) $enumValue = AttendanceStatus::EMPLOYEE_HOLIDAY->value;
                        }

                        $carbonDate         = $date->original_format;

                        #check holidays
                        foreach ($officeHolidays as $officeHoliday) {

                            $startDate          = Carbon::parse($officeHoliday->start_date);
                            $endDate            = Carbon::parse($officeHoliday->end_date);


                            $is_holiday = $carbonDate->between($startDate, $endDate);

                            if ($is_holiday) $enumValue = AttendanceStatus::PUBLIC_HOLIDAY->value;
                        }

                        #chek employee Leave
                        $employeeLeaves = $user->leaves->where('status' , LeaveStatus::approved->status()) ?? [];

                        foreach ($employeeLeaves as $leave) {

                            $startDate          = Carbon::parse($leave->start_date);
                            $endDate            = Carbon::parse($leave->end_date);
                            $is_on_leave         = $carbonDate->between($startDate, $endDate);

                            if ($is_on_leave) $enumValue = AttendanceStatus::ON_LEAVE->value;
                        }
                    }
                }


                $attendance[$date->parse_date] = $enumValue;
            }

            $user->attendanceStatus = $attendance;

            return $user;
        });

        return view('admin.attendance.index', [
            'breadcrumbs'       => ['Home' => 'admin.home', 'Attendance Sheet' => null],
            'title'             =>  translate('Attendance Sheet'),
            'users'             => $users,
            'dates'             => $dates,
            'currentDate'       => $currentDate,
            'month'             => $month,
            'year'              => $year
        ]);
    }


    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'attendance_id'         => 'required|exists:attendances,id',
            'clock_in'              => 'nullable|string',
            'clock_in_status'       => [Rule::in(ClockStatusEnum::toArray()), 'nullable'],
            'clock_out'             => 'nullable|string',
            'clock_out_status'      => [Rule::in(CLockStatusEnum::toArray()), 'nullable'],
            'note'                  => 'nullable|string',
        ]);

        $attendance = Attendance::findOrFail($validatedData['attendance_id']);

        $date           = $attendance->date;
        $dayOfWeek      = t2k(Carbon::parse($date)->format('l'));
        $clockInTime    = $validatedData['clock_in'];
        $clockOutTime   = $validatedData['clock_out'];

        if ($validatedData['clock_in']) {
            $clockInTimestamp   = Carbon::createFromFormat('Y-m-d H:i:s', "$date $clockInTime:00");
            $lateTime           = $this->attendanceService->processClockIn($clockInTimestamp);
        }
        if ($validatedData['clock_out']) {
            $clockIn            = Carbon::parse($attendance->clock_in ?? $clockInTimestamp);
            $clockOutTimestamp  = Carbon::createFromFormat('Y-m-d H:i:s', "$date $clockOutTime:00");

            $data               = $this->attendanceService->processCLockOut($dayOfWeek, $clockIn, $clockOutTimestamp);
        }



        $attendance->clock_in           = $clockInTimestamp ?? $attendance->clock_in;
        $attendance->late_time          = $lateTime ?? $attendance->late_time;
        $attendance->clock_in_status    = $validatedData['clock_in_status'] ?? $attendance->clock_in_status;

        $attendance->clock_out          = $clockOutTimestamp ?? $attendance->clock_out;
        $attendance->clock_out_status   = $validatedData['clock_out_status'] ?? $attendance->clock_out_status;
        $attendance->over_time          = $data['over_time'] ?? $attendance->over_time;
        $attendance->work_hour          = $data['work_hour'] ?? $attendance->work_hour;
        $attendance->note               = $request->input('note') ?? null;

        $attendance->save();


        return redirect()->back()->with('success', translate('Attendance updated successfully.'));
    }

    public function viewDetails(Request $request): JsonResponse
    {
        $attendanceDate = Carbon::create($request->year, $request->month, $request->date);

        $attendance = Attendance::where('user_id', $request->userId)
                                ->whereDate('date', $attendanceDate)
                                ->first();

        return $attendance
            ? response()->json(['success' => true, 'attendance' => $attendance])
            : response()->json(['success' => false, 'message' => 'No attendance record found.']);

    }

    public function setting()
    {
        return view('admin.attendance.setting', [
            'title' => translate('Attendance Settings'),
            'breadcrumbs'   => ['Home' => 'admin.home', 'Attendance Settings' => null],
        ]);
    }

    public function settingStore(Request $request)
    {
        $data = $request->validate([

            'ip_whitelist_status'   => [Rule::in(CLockStatusEnum::toArray())],
            'ip_start_range'        => ['required_if:ip_whitelist_status,' . StatusEnum::true->status(), 'ip'],
            'ip_end_range'          => ['required_if:ip_whitelist_status,' . StatusEnum::true->status(), 'ip'],
            'clock_in_status'       => [Rule::in(CLockStatusEnum::toArray())]
        ]);

        Setting::updateOrInsert(
            ['key'    => 'ip_white_list'],
            ['value'      => json_encode($data)]
        );

        optimize_clear();

        return json_encode([
            'status'  =>  true,
            'message' => translate('Attendance Settings has been updated')
        ]);
    }
}
