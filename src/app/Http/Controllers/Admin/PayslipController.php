<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Utility\SendMail;
use App\Models\Admin\Payroll;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use App\Models\Admin\MailGateway;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;

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
        $monthCarbon = Carbon::parse($month);
        $formattedMonth = $monthCarbon->format('F Y');

        $payroll = Payroll::with('user.advanceSalaries')
            ->where('user_id', $userId)
            ->whereYear('pay_period', $monthCarbon->year)
            ->whereMonth('pay_period',$monthCarbon->month)
            ->first();


        return view('admin.payroll.payslip', [
            'breadcrumbs'   => ['Home' => 'admin.home', 'Payslip log' => 'admin.payroll.list', $formattedMonth => route('admin.payroll.show' , $payroll->pay_period) , 'Print' => null],
            'title'         => translate('Payslip Print'),
            'payroll'       => $payroll,
        ]);
    }


    public function downloadPayslip($userId, $month)
    {

        $monthCarbon = Carbon::parse($month);

        $payroll = Payroll::with('user.advanceSalaries')
                            ->where('user_id', $userId)
                            ->whereYear('pay_period', $monthCarbon->year)
                            ->whereMonth('pay_period',$monthCarbon->month)
                            ->first();

        if (!$payroll)  return redirect()->back()->with('error', 'Payslip not found.');


        $pdf = \PDF::loadView('admin.payroll.pdf.payslip', compact('payroll'));


        return $pdf->download('payslip-' . $payroll->created_at . '.pdf');
    }


    public function sendPayslip($userId, $month)
    {

        $monthCarbon = Carbon::parse($month);

        $payroll = Payroll::with('user.advanceSalaries')
                            ->where('user_id', $userId)
                            ->whereYear('pay_period', $monthCarbon->year)
                            ->whereMonth('pay_period',$monthCarbon->month)
                            ->first();


        $gateway = MailGateway::where('default', StatusEnum::true->status())->firstOrFail();

        $code = [
            'company_name' =>  "iGen Solutions",
            'month'        =>   $month
        ];

        $response = SendMail::mailNotifications("PAYSLIP_MAIL", $code, (object) ["name" =>$payroll->user->name, 'email' => $payroll->user->email], $gateway);
        return  back()->with(response_status((preg_replace('/[^a-zA-Z0-9@._\- ]/', '', $response['message'])), $response['status'] ? "success" : "error"));
    }
}
