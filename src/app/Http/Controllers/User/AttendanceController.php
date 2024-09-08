<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Services\AttendanceService;
use App\Models\Attendance;
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

        $attendances = Attendance::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->date()
            ->year()
            ->month()
            ->day()
            ->paginate(paginateNumber());


        return view('user.attendance_sheet', [
            'breadcrumbs'           => ['Home' => 'user.home', 'Attendance' => null],
            'title'                 => translate('Attendance Sheet'),
            'attendances'           => $attendances
        ]);
    }
}
