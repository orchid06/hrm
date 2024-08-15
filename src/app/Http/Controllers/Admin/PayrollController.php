<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    use ModelAction ,Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_payroll'])->only(['list']);
        $this->middleware(['permissions:create_payroll'])->only(['store','create']);
        $this->middleware(['permissions:update_payroll'])->only(['updateStatus','update','edit','bulk']);
        $this->middleware(['permissions:delete_payroll'])->only(['destroy','bulk']);
    }
}
