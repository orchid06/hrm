<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Fileable;
use App\Traits\ModelAction;
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

    public function list(): View
    {
        return view('admin.attendance.index');
    }
}
