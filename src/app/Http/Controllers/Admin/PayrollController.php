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

class PayrollController extends Controller
{
    use ModelAction, Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_payroll'])->only(['list']);
        $this->middleware(['permissions:create_payroll'])->only(['store', 'create']);
        $this->middleware(['permissions:update_payroll'])->only(['updateStatus', 'update', 'edit', 'bulk']);
        $this->middleware(['permissions:delete_payroll'])->only(['destroy', 'bulk']);
    }

    public function list(): View
    {
        $title         =  translate('Payslip log');
        $breadcrumbs   =  ['Home' => 'admin.home', 'Payslip log' => null];
        $months        = collect(range(1, 12))->mapWithKeys(function ($month) {
            return [
                Carbon::createFromDate(null, $month, 1)->format('Y-m') => Carbon::createFromDate(null, $month, 1)->format('F')
            ];
        });

        $payrolls = DB::table('payrolls')
                        ->select(
                            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                            DB::raw('COUNT(user_id) as total_employees'),
                            DB::raw('MIN(created_at) as created_at'),
                            DB::raw('SUM(net_pay) as total_expense')
                        )
                        ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
                        ->get()
                        ->map(function ($payroll) {
                            $payroll->month = Carbon::createFromFormat('Y-m', $payroll->month)->format('F Y');
                            return $payroll;
                        });

        $currentMonth = now()->format('Y-m');

        $users        = User::Active()
            ->paginate(paginateNumber());



        return view('admin.payroll.list', [
            'breadcrumbs'   => $breadcrumbs,
            'title'         => $title,
            'months'        => $months,
            'currentMonth' =>  $currentMonth,
            'users'         => $users,
            'payrolls'      => $payrolls
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $currentMonth = now()->format('Y-m');

        $users        = User::Active()
            ->whereDoesntHave('payrolls', function ($query) use ($currentMonth) {
                $query->where('pay_period', $currentMonth);
            })
            ->get();

        foreach ($users as $user) {
            Payroll::create([
                'user_id'       => $user->id,
                'salary'        => json_decode($user->userDesignation->salary)->basic_salary->amount,
                'net_pay'       => $user->userDesignation->net_salary,
                'details'       => $user->userDesignation->salary,
                'pay_period'    => $currentMonth
            ]);
        }


        return back()->with('success', trans('Payslip generated successfully'));
    }

    public function show ($month) : View
    {
        $title         =  translate('Payslip log');
        $breadcrumbs   =  ['Home' => 'admin.home', 'Payslip log' => 'admin.payroll.list' , $month => null];

        $payrolls = Payroll::whereMonth('created_at', $month)
                        ->with('user')
                        ->get();


        return view('admin.payroll.show', [
            'breadcrumbs'   => $breadcrumbs,
            'title'         => $title,
            'payrolls'      => $payrolls
        ]);
    }
}
