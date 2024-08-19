<?php

namespace App\Http\Controllers\admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Admin\Payroll;
use App\Models\User;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $title         =  translate('Manage Payrolls');
        $breadcrumbs   =  ['Home' => 'admin.home', 'Payrolls' => null];
        $months        = collect(range(1, 12))->mapWithKeys(function ($month) {
            return [
                Carbon::createFromDate(null, $month, 1)->format('Y-m') => Carbon::createFromDate(null, $month, 1)->format('F')
            ];
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
            'payrolls'      => Payroll::with('user')
                ->latest()
                ->search(['user:name'])
                ->paginate(paginateNumber())
                ->appends(request()->all())
        ]);
    }

    public function create(Request $request)
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
}
