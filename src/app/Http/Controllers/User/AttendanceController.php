<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Services\AttendanceService;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    protected $attendanceService, $user;

    public function __construct()
    {

        $this->attendanceService = new AttendanceService();

        $this->middleware(function ($request, $next) {
            $this->user = auth_user('web');
            return $next($request);
        });
    }

    public function clockInRequest(): RedirectResponse
    {

        try {

            $this->attendanceService->requestClockIn();
            return redirect()->back()->with('success', translate('Your clock-in request has been sent.'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', translate($e->getMessage()));
        }
    }


    public function clockOutRequest(): RedirectResponse
    {
        try {

            $this->attendanceService->requestClockOut();


            return redirect()->back()->with('success', translate('Your clock-out request has been sent.'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', translate($e->getMessage()));
        }
    }


    public function index()
    {
        $user = Auth::user();


        $month          = request('month', now()->month);
        $year           = request('year', now()->year);
        $currentDate    = Carbon::today();

        $dates          = $this->attendanceService->getDatesOfMonth($month, $year);

        $users          = $this->attendanceService->getAttendance( dates: $dates, currentDate: $currentDate , userId: $user->id);


        return view('user.attendance.index', [
            'breadcrumbs'               => ['Home' => 'admin.home', 'Attendance Sheet' => null],
            'title'                     =>  translate('Attendance Sheet'),
            'users'                     => $users,
            'dates'                     => $dates,
            'currentDate'               => $currentDate,
            'selectedMonth'             => $month,
            'selectedYear'              => $year
        ]);
    }

    public function viewDetails(Request $request): JsonResponse
    {
        $user = Auth::user();

        $date = Carbon::create($request->year, $request->month, $request->date);

        $attendance = Attendance::where('user_id', $user->id)
                                ->whereDate('clock_in', $date)
                                ->first();

        $status = $attendance ?  'success' :  'fail';

        $html = view('user.attendance.details', ['attendance' => $attendance , 'date'   => $date,])->render();

        return response()->json([
            'status' => $status,
            'html'   => $html,

        ]);

    }
}
