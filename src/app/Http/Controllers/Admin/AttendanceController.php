<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ClockStatusEnum;
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

        $attendances = Attendance::with('user')
        ->orderBy('date', 'desc')
        ->year()
        ->month()
        ->date()
        ->day()
        ->search(['user:username' , 'user:email'])
        ->paginate(paginateNumber())
        ->appends(request()->all());



        return view('admin.attendance.index' , [
            'breadcrumbs'       => ['Home' => 'admin.home', 'Clocl In Request' => null],
            'title'             =>  translate('Clock In Request '),
            'attendances'       => $attendances,
            'users'             => User::all()
        ]);
    }


    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'attendance_id'         => 'required|exists:attendances,id',
            'clock_in'              => 'nullable|string',
            'clock_in_status'       => [Rule::in(ClockStatusEnum::toArray()) ,'nullable'],
            'clock_out'             => 'nullable|string',
            'clock_out_status'      => [Rule::in(CLockStatusEnum::toArray()), 'nullable'],
            'note'                  => 'nullable|string',
        ]);

        $attendance = Attendance::findOrFail($validatedData['attendance_id']);

        $date           = $attendance->date;
        $dayOfWeek      = t2k(Carbon::parse($date)->format('l'));
        $clockInTime    = $validatedData['clock_in'];
        $clockOutTime   = $validatedData['clock_out'];

        if($validatedData['clock_in']){
            $clockInTimestamp   = Carbon::createFromFormat('Y-m-d H:i:s', "$date $clockInTime:00");
            $lateTime           = $this->attendanceService->processClockIn($clockInTimestamp);
        }
        if($validatedData['clock_out']){
            $clockIn            = Carbon::parse($attendance->clock_in ?? $clockInTimestamp);
            $clockOutTimestamp  = Carbon::createFromFormat('Y-m-d H:i:s', "$date $clockOutTime:00");

            $data               = $this->attendanceService->processCLockOut( $dayOfWeek , $clockIn , $clockOutTimestamp);
        }



        $attendance->clock_in           = $clockInTimestamp ?? $attendance->clock_in;
        $attendance->late_time          = $lateTime ?? $attendance->late_time;
        $attendance->clock_in_status    = $validatedData['clock_in_status'] ?? $attendance->clock_in_status;

        $attendance->clock_out          = $clockOutTimestamp ?? $attendance->clock_out;
        $attendance->clock_out_status   = $validatedData['clock_out_status'] ?? $attendance->clock_out_status;
        $attendance->over_time          = $data['over_time'] ?? $attendance->over_time;
        $attendance->work_hour          = $data['work_hour']?? $attendance->work_hour;
        $attendance->note               = $request->input('note') ?? null;

        $attendance->save();


        return redirect()->back()->with('success', translate('Attendance updated successfully.'));

    }

    public function viewDetails($attendance_id): View
    {
        return view('admin.attendance.details' , [
            'title'         => translate('Attendance Details'),
            'breadcrumbs'   => ['Home' => 'admin.home', 'Attendance report' => 'admin.attendance.list' , 'Attendance Details'=> null],
        ]);
    }

    public function setting()
    {
        return view('admin.attendance.setting' , [
            'title' => translate('Attendance Settings'),
            'breadcrumbs'   => ['Home' => 'admin.home', 'Attendance Settings' => null],
        ]);
    }

    public function settingStore(Request $request)
    {
        $data = $request->validate([

            'ip_whitelist_status'   => [Rule::in(CLockStatusEnum::toArray())],
            'ip_start_range'        => ['required_if:ip_whitelist_status,' . StatusEnum::true->status(),'ip'],
            'ip_end_range'          => ['required_if:ip_whitelist_status,' . StatusEnum::true->status(),'ip'],
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

    public function sheet()
    {
        $attendanceData  = $this->attendanceService->generateAttendance(2024 , 8);

        return view('admin.attendance.sheet' , [
            'breadcrumbs'       => ['Home' => 'admin.home', 'Attendance report' => null],
            'title'             =>  translate('Attendance Sheet'),
            'attendanceData'       => $attendanceData ,
            'users'             => User::all()
        ]);
    }
}
