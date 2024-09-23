<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\PDF;

class PayslipController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $payslips = Payroll::where('user_id' , $user->id)
                            ->latest()
                            ->paginate(paginateNumber());



        return view('user.payslip.list' ,[
            'breadcrumbs'           => ['Home' => 'user.home', 'Payslip' => null],
            'title'                 => translate('Payslips'),
            'payslips'              => $payslips
        ]);
    }

    public function printPayslip($userId, $month)
    {

        $payroll = Payroll::where('user_id', $userId)
            ->whereYear('created_at', substr($month, 0, 4))
            ->whereMonth('created_at', substr($month, 5, 2))
            ->first();



        return view('user.payslip.print', [
            'breadcrumbs'   => ['Home' => 'user.home', 'Payslip' => 'user.payslip.list', 'Print' => null],
            'title'         => translate('Payslip Print'),
            'payroll'       => $payroll,
        ]);
    }

    public function downloadPayslip($userId, $month)
    {

        $payroll = Payroll::where('user_id', $userId)
            ->whereYear('created_at', substr($month, 0, 4))
            ->whereMonth('created_at', substr($month, 5, 2))
            ->first();

        if (!$payroll)  return redirect()->back()->with('error', 'Payslip not found.');


        $pdf = \PDF::loadView('admin.payroll.pdf.payslip', compact('payroll'));


        return $pdf->download('payslip-' . $payroll->created_at . '.pdf');
    }
}
