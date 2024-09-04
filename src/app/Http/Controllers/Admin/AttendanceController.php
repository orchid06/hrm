<?php

namespace App\Http\Controllers\admin;

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
        ->search(['user:name' , 'user:email'])
        ->paginate(paginateNumber())
        ->appends(request()->all());

        return view('admin.attendance.index' , [
            'breadcrumbs'       => ['Home' => 'admin.home', 'Attendance report' => null],
            'title'             =>  translate('Attendance'),
            'attendances'    => $attendances
        ]);
    }

    public function note(Request $request):RedirectResponse
    {
        Attendance::where('id' , $request->input('attendance_id'))->update([
            'note' => $request->input('note')
        ]);

        return back()->with(response_status('Note submitted successfully'));
    }
}
