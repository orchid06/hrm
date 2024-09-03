<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    use ModelAction ,Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_attendance'])->only(['list']);
        $this->middleware(['permissions:create_attendance'])->only(['store','create']);
        $this->middleware(['permissions:update_attendance'])->only(['updateStatus','update','edit','bulk']);
        $this->middleware(['permissions:delete_attendance'])->only(['destroy','bulk']);
    }



    public function list(Request $request): View
    {
        $year   = $request->input('year', date('Y'));
        $month  = $request->input('month', date('m'));


        $users = User::with(['file','createdBy'])
                    ->routefilter()
                    ->search(['name', 'email', "phone"])
                    ->filter(['country:name'])
                    ->latest()
                    ->paginate(paginateNumber())
                    ->appends(request()->all());

        $startDate = new DateTime("$year-$month-01");
        $endDate = (clone $startDate)->modify('last day of this month');
        $attendanceRecords = Attendance::whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                                        ->get()
                                        ->groupBy('date');


        $attendanceData = [];
        foreach ($attendanceRecords as $date => $records) {
            foreach ($records as $record) {
                $attendanceData[$date][$record->user_id] = $record->clock_in ? ['clock_in' => $record->clock_in] : [];
            }
        }


        $datesInMonth = new DatePeriod(
            $startDate,
            new DateInterval('P1D'),
            $endDate->modify('+1 day')
        );


        return view('admin.attendance.index', [
            'breadcrumbs'           => ['Home' => 'admin.home', 'Attendance' => null],
            'title'                 => translate('Attendance Sheet'),
            'users'                 =>  $users,
            'datesInMonth'          => $datesInMonth,
            'attendanceData'        => $attendanceData

        ]);
    }


}
