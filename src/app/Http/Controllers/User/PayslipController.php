<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Admin\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayslipController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $payslips = Payroll::where('user_id' , $user->id)
                            ->latest()
                            ->get();

        dd($payslips);

        return view('user.payslip.list' ,[
            'breadcrumbs'           => ['Home' => 'user.home', 'Payslip' => null],
            'title'                 => translate('Payslips'),
            'payslips'              => $payslips
        ]);
    }
}
