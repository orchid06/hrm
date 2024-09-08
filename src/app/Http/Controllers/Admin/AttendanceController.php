<?php

namespace App\Http\Controllers\admin;

use App\Enums\ClockStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Models\Admin\Leave;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    use ModelAction, Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_attendance'])->only(['list']);
        $this->middleware(['permissions:create_attendance'])->only(['store', 'create']);
        $this->middleware(['permissions:update_attendance'])->only(['updateStatus', 'update', 'edit', 'bulk']);
        $this->middleware(['permissions:delete_attendance'])->only(['destroy', 'bulk']);
    }



    public function list(Request $request): View
    {
        $attendances = Attendance::with('user')
        ->orderBy('date', 'desc')
        ->year()
        ->month()
        ->date()
        ->search(['user:username' , 'user:email'])
        ->paginate(paginateNumber())
        ->appends(request()->all());


        return view('admin.attendance.index' , [
            'breadcrumbs'       => ['Home' => 'admin.home', 'Attendance report' => null],
            'title'             =>  translate('Attendance'),
            'attendances'       => $attendances,
            'users'             => User::all()
        ]);
    }

    public function note(Request $request):RedirectResponse
    {
        Attendance::where('id' , $request->input('attendance_id'))->update([
            'note' => $request->input('note')
        ]);

        return back()->with(response_status('Note submitted successfully'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
            'clock_in' => 'nullable|string',
            'clock_in_status' => [Rule::in(ClockStatusEnum::toArray())],
            'clock_out' => 'nullable|string',
            'clock_out_status' => [Rule::in(CLockStatusEnum::toArray())],
        ]);

        $attendance = Attendance::findOrFail($validatedData['attendance_id']);

        $date           = $attendance->date;
        $clockInTime    = $validatedData['clock_in'];
        $clockOutTime   = $validatedData['clock_out'];

        if($validatedData['clock_in']){
            $clockInTimestamp   = Carbon::createFromFormat('Y-m-d H:i:s', "$date $clockInTime:00");
        }
        if($validatedData['clock_out']){
            $clockOutTimestamp  = Carbon::createFromFormat('Y-m-d H:i:s', "$date $clockOutTime:00");
        }



        $attendance->clock_in           = $clockInTimestamp ?? $attendance->clock_in;
        $attendance->clock_in_status    = $validatedData['clock_in_status'] ?? $attendance->clock_in_status;
        $attendance->clock_out          = $clockOutTimestamp ?? $attendance->clock_out;
        $attendance->clock_out_status   = $validatedData['clock_out_status'] ?? $attendance->clock_out_status;

        $attendance->save();


        return redirect()->back()->with('success', translate('Attendance updated successfully.'));

    }

    public function updateClockIn()
    {

    }
}
