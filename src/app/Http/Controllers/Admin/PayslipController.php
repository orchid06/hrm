<?php

namespace App\Http\Controllers\admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Admin\Payroll;
use App\Models\User;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Mail\PayslipMail;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\PDF;

class PayslipController extends Controller
{
    use ModelAction, Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:print_payslip'])->only(['printPayslip']);
        $this->middleware(['permissions:send_payslip'])->only(['sendPayslip']);
        $this->middleware(['permissions:download_payslip'])->only(['downloadPayslip']);
    }

    public function printPayslip($userId, $month)
    {

        $payroll = Payroll::where('user_id', $userId)
            ->whereYear('created_at', substr($month, 0, 4))
            ->whereMonth('created_at', substr($month, 5, 2))
            ->first();



        return view('admin.payroll.payslip', [
            'breadcrumbs'   => ['Home' => 'admin.home', 'Payrolls' => 'admin.payroll.list', 'Print' => null],
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


    public function sendPayslip($userId, $month)
    {

        $payslip = Payroll::with('user')->where('user_id', $userId)->where('created_at', $month)->first();

        if (!$payslip)    return redirect()->back()->with('error', 'Payslip not found.');


        $pdf = \PDF::loadView('pdf.payslip', compact('payslip'))->output();


        Mail::to($payslip->user->email)->send(new PayslipMail($payslip));

        return redirect()->back()->with('success', 'Payslip sent successfully.');
    }
}
