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

        $month          = request('month', now()->month);
        $year           = request('year', now()->year);
        $currentDate    = Carbon::today();

        $dates          = $this->attendanceService->getDatesOfMonth($month, $year);

        $users          = $this->attendanceService->getAttendance( $dates, $currentDate);


        return view('admin.attendance.index', [
            'breadcrumbs'               => ['Home' => 'admin.home', 'Attendance Sheet' => null],
            'title'                     =>  translate('Attendance Sheet'),
            'users'                     => $users,
            'dates'                     => $dates,
            'currentDate'               => $currentDate,
            'selectedMonth'             => $month,
            'selectedYear'              => $year
        ]);
    }


    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'user_id'               => 'required|exists:users,id',
            'date'                  => 'required|date',
            'clock_in'              => 'nullable|string',
            'clock_in_status'       => [Rule::in(ClockStatusEnum::toArray()), 'nullable'],
            'clock_out'             => 'nullable|string',
            'clock_out_status'      => [Rule::in(CLockStatusEnum::toArray()), 'nullable'],
            'note'                  => 'nullable|string',
        ]);

        $date           = $validatedData['date'];
        $clockInTime    = $validatedData['clock_in'];
        $clockOutTime   = $validatedData['clock_out'];
        $dateOnly       = substr($date, 0, 10);



        if ($validatedData['clock_in']) {
            $clockInTimestamp   = Carbon::createFromFormat('Y-m-d H:i:s', "{$dateOnly} {$clockInTime}:00");
            $lateTime           = $this->attendanceService->processClockIn($clockInTimestamp);
        }
        if ($clockOutTime) {

            $existedClockIn     = Carbon::parse($attendance->clock_in ?? $clockInTimestamp);
            $clockOutTimestamp  = Carbon::createFromFormat('Y-m-d H:i:s', "{$dateOnly} {$clockOutTime}:00");

            $data               = $this->attendanceService->processClockOut( $existedClockIn, $clockOutTimestamp);
        }


        $attendance = Attendance::where('user_id', $validatedData['user_id'])
        ->whereDate('clock_in', $clockInTimestamp)
        ->first();

        if($attendance){

            $attendance->clock_in           = $clockInTimestamp ?? $attendance->clock_in;
            $attendance->late_time          = $lateTime ?? $attendance->late_time;
            $attendance->clock_in_status    = $validatedData['clock_in_status'] ?? $attendance->clock_in_status;

            $attendance->clock_out          = $clockOutTimestamp ?? $attendance->clock_out;
            $attendance->clock_out_status   = $validatedData['clock_out_status'] ?? $attendance->clock_out_status;
            $attendance->over_time          = $data['over_time'] ?? $attendance->over_time;
            $attendance->work_hour          = $data['work_hour'] ?? $attendance->work_hour;
            $attendance->note               = $request->input('note') ?? null;

            $attendance->save();
        }
        else{
            Attendance::create([
                'user_id'           => $validatedData['user_id'],
                'clock_in'          => $clockInTimestamp ?? null,
                'late_time'         => $lateTime ?? 0,
                'date'              => $dateOnly??null,
                'clock_in_status'   => $validatedData['clock_in_status'],
                'clock_out'         => $clockOutTimestamp ?? null,
                'clock_out_status'  => $validatedData['clock_out_status'],
                'over_time'         => $data['over_time'] ?? 0,
                'work_hour'         => $data['work_hour'] ??0,
                'note'              => $validatedData['note']??null,
            ]);
        }

        return redirect()->back()->with('success', translate('Attendance updated successfully.'));
    }

    public function viewDetails(Request $request): JsonResponse
    {
        $date = Carbon::create($request->year, $request->month, $request->date);

        $attendance = Attendance::where('user_id', $request->userId)
                                ->whereDate('clock_in', $date)
                                ->first();

        $status = $attendance ?  'success' :  'fail';

        $html = view('admin.attendance.details', ['attendance' => $attendance , 'date'   => $date,])->render();

        return response()->json([
            'status' => $status,
            'html'   => $html,

        ]);

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

            'clock_in_status'       => [Rule::in(CLockStatusEnum::toArray())],
            'grace_time'            => 'string|nullable'
        ]);

        Setting::updateOrInsert(
            ['key'    => 'attendance_settings'],
            ['value'      => json_encode($data)]
        );

        optimize_clear();

        return json_encode([
            'status'  =>  true,
            'message' => translate('Attendance Settings has been updated')
        ]);
    }
}
