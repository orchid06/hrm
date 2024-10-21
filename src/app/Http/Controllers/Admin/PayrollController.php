<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Services\Admin\PayrollService;
use App\Http\Services\SettingService;
use App\Models\Admin\Payroll;
use App\Models\User;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PayrollController extends Controller
{
    use ModelAction, Fileable;



    public function __construct(protected PayrollService $payrollService)
    {
        //check permissions middleware
        $this->middleware(['permissions:view_payroll'])->only(['list']);
        $this->middleware(['permissions:create_payroll'])->only(['store', 'create']);
        $this->middleware(['permissions:update_payroll'])->only(['updateStatus', 'update', 'edit', 'bulk']);
        $this->middleware(['permissions:delete_payroll'])->only(['destroy', 'bulk']);
        $this->payrollService  = $payrollService;
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
            ->orderBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), 'asc')
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
        $request->validate([
            'month'         => 'required',
            'user_ids.*'    => 'required|exists:users,id'
        ]);

        $month      = $request->input('month');
        $userIds    = $request->input('user_ids');

        $results = $this->payrollService->createPayrolls($userIds, $month);

        if (!empty($results['errors'])) {
            return back()->with('error', implode(', ', $results['errors']));
        }

        return back()->with('success', trans('Payslip generated successfully'));
    }



    public function show($month): View
    {
        $title         =  translate('Payslip log');
        $formattedMonth = Carbon::parse($month . '-01')->format('F Y');

        $breadcrumbs   =  ['Home' => 'admin.home', 'Payslip log' => 'admin.payroll.list',  $formattedMonth => null];

        $year = date('Y', strtotime($month));
        $monthNumber = date('m', strtotime($month));




        $payrolls = Payroll::whereYear('created_at', $year)
                            ->whereMonth('created_at', $monthNumber)
                            ->with('user')
                            ->search(['user:name'])
                            ->paginate(paginateNumber());

        $cardData['totalEmployees']     = $payrolls->unique('user_id')->count();
        $cardData['totalPayrollAmount'] = $payrolls->sum('net_pay');


        return view('admin.payroll.show', [
            'breadcrumbs'           => $breadcrumbs,
            'title'                 => $title,
            'formattedMonth'        => $formattedMonth,
            'payrolls'              => $payrolls,
            'cardData'              => $cardData
        ]);
    }

    public function allowance()
    {
        return view('admin.payroll.allowance', [
            'breadcrumbs'           => ['Home' => 'admin.home', 'Allowance & Bonus' => null],
            'title'                 => translate('Allowance & Bonus'),
        ]);
    }

    public function allowanceStore(Request $request)
    {
        $request->validate([
            'labels.*'          => 'required',
            'type.*'            => 'required',
            'amount.*'          => 'required|numeric|gt:0',
            'is_percentage.*'   => ['required',Rule::in(StatusEnum::toArray())],
        ]);

        $custom_inputs      = $request->input('custom_inputs');

        foreach ($custom_inputs as $input) {
            if (is_array($input) && isset($input['labels'])) {
                $key = t2k($input['labels']);

                $is_percentage = $input['is_percentage'] ?? StatusEnum::false->status();

                $allowance[] = [
                    'labels'        => $input['labels'],
                    'type'          => $input['type'],
                    'amount'        => $input['amount'],
                    'default'       => $input['default'],
                    'is_percentage' => $is_percentage,
                    'key'           => $key
                ];

            }
        }

        $data =[
            'allowance' => $allowance
        ];

        (new SettingService())->updateSettings($data);

        optimize_clear();

        return json_encode([
            'status'  =>  true,
            'message' => translate('Allowance has been updated')
        ]);
    }
}
