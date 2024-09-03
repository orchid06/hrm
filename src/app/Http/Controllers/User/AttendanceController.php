<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Services\AttendanceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    protected $attendanceService , $user;

    public function __construct(){

        $this->attendanceService = new AttendanceService();

        $this->middleware(function ($request, $next) {
            $this->user = auth_user('web');
            return $next($request);
        });
    }

    public function clockIn():RedirectResponse
    {
        try {
            $this->attendanceService->clockIn();
            return redirect()->back()->with('success', translate('You have successfully clocked in.'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', translate($e->getMessage()));
        }
    }

    public function clockOut(): RedirectResponse
    {
        try {
            $this->attendanceService->clockOut();
            return redirect()->back()->with('success', translate('You have successfully clocked out.'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', translate($e->getMessage()));
        }
    }

    public function index()
    {
        return view('user.attendance_sheet' , [
            'breadcrumbs'           => ['Home' => 'user.home', 'Attendance' => null],
            'title'                 => translate('Attendance Sheet'),
        ]);
    }

}
