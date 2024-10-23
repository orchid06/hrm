<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
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
                Carbon::createFromDate(null, $month, 1)->format('F') =>  Carbon::create(now()->year, $month, now()->day, now()->hour, now()->minute, now()->second)
            ];
        });

        $payrolls = DB::table('payrolls')
            ->select(
                DB::raw('DATE_FORMAT(pay_period, "%Y-%m") as month'),
                DB::raw('COUNT(user_id) as total_employees'),
                DB::raw('MIN(pay_period) as pay_period'),
                DB::raw('SUM(net_pay) as total_expense'),
                DB::raw('SUM(CASE WHEN status = "' . PaymentStatus::UNPAID->status() . '" THEN 1 ELSE 0 END) as unpaid_count')
            )
            ->groupBy(DB::raw('DATE_FORMAT(pay_period, "%Y-%m")'))
            ->orderBy(DB::raw('DATE_FORMAT(pay_period, "%Y-%m")'), 'desc')
            ->get()
            ->map(function ($payroll) {
                $payroll->month = Carbon::createFromFormat('Y-m', $payroll->month)->format('F Y');

                if ($payroll->unpaid_count > 0) {
                    $payroll->text = "{$payroll->unpaid_count} Unpaid";
                    $payroll->badge = "i-badge capsuled danger";
                    $payroll->status = PaymentStatus::UNPAID->status();

                } else {
                    $payroll->text = 'All Paid';
                    $payroll->badge = "i-badge capsuled success";
                    $payroll->status = PaymentStatus::PAID->status();
                }

                return $payroll;
            });

        $currentMonth = now()->format('Y-m');

        $users        = User::Active()->paginate(paginateNumber());
        

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
            'user_ids.*'    => 'nullable|exists:users,id'
        ]);

        $month      = $request->input('month');
        $userIds    = $request->input('user_ids');

        if (!$userIds) {
            $userIds = User::active()->pluck('id')->toArray();
        }

        $results = $this->payrollService->createPayslips($userIds, $month);

        if (!empty($results['errors'])) {
            return back()->with('error', implode(', ', $results['errors']));
        }

        return back()->with('success', trans('Payslip generated successfully'));
    }



    public function show($month): View
    {


        $title         =  translate('Payslip log');
        $carbonMonth   = Carbon::parse($month);
        $formattedMonth = $carbonMonth->format('F Y');

        $breadcrumbs   =  ['Home' => 'admin.home', 'Payslip log' => 'admin.payroll.list',  $formattedMonth => null];

        $payrolls = Payroll::whereYear('pay_period', $carbonMonth->year)
                            ->whereMonth('pay_period', $carbonMonth->month)
                            ->with('user')
                            ->search(['user:name'])
                            ->paymentStatus()
                            ->paginate(paginateNumber());

        $cardData['totalEmployees']     = $payrolls->unique('user_id')->count();
        $cardData['totalPayrollAmount'] = $payrolls->sum('net_pay');


        return view('admin.payroll.show', [
            'breadcrumbs'           => $breadcrumbs,
            'title'                 => $title,
            'formattedMonth'        => $formattedMonth,
            'payrolls'              => $payrolls,
            'cardData'              => $cardData,
            'month'                 => $month
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

    public function edit($uid)
    {
        $payroll        = Payroll::whereUid($uid)->first();
        $formattedMonth = Carbon::parse($payroll->pay_period)->format('F Y');

        return view('admin.payroll.edit', [
            'breadcrumbs'           => ['Home' => 'admin.home', 'Payslip log' => 'admin.payroll.list', $formattedMonth => route('admin.payroll.show' , $payroll->pay_period) , 'Payslip update' => null],
            'title'                 => translate('Payslip Update'),
            'payroll'               =>  $payroll
        ]);
    }

    public function update(Request $request)
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

                $allowanceDeductions[] = [
                    'labels'        => $input['labels'],
                    'type'          => $input['type'],
                    'amount'        => $input['amount'],
                    'default'       => $input['default'],
                    'is_percentage' => $is_percentage,
                    'key'           => $key
                ];

            }
        }

        $payroll        = Payroll::with('user.advanceSalaries')
                                ->whereUid($request->input('uid'))->first();
        $basic_salary   = $payroll->basic_salary;
        $netPay         = $basic_salary;

        foreach ($allowanceDeductions as $item) {
            // Check if the item is a percentage
            $item['is_percentage'] == "1" ? $amount = $basic_salary * ($item['amount'] / 100) : $amount = $item['amount'];

            //check if item is allowance of deduction
            $item['type'] == "1" ? $netPay += $amount :  $netPay -= $amount;
        }

        if($payroll->user->advanceSalaries){
            $totalAdvanceSalary = $payroll->user->advanceSalaries->sum('amount');
            $netPay -= $totalAdvanceSalary;
        }

        $payroll->details = json_encode($allowanceDeductions);
        $payroll->net_pay = $netPay;
        $payroll->save();


        return json_encode([
            'status'  =>  true,
            'message' => translate('Payslip has been updated')
        ]);

    }


    public function makePayment(Request $request)
    {
        $request->validate([
            'month'         => 'required',
            'user_ids.*'    => 'nullable|exists:users,id'
        ]);

        $month      = $request->input('month');
        $userIds    = $request->input('user_ids');

        if (!$userIds) {
            $userIds = User::active()->pluck('id')->toArray();
        }

        $results = $this->payrollService->makePayment($userIds, $month);

        if (!empty($results['errors'])) {
            return back()->with('error', implode(', ', $results['errors']));
        }

        return back()->with('success', trans('Payment successfully'));
    }

    public function destroy($uid) : RedirectResponse
    {
        Payroll::whereUid($uid)->first()->delete();

        return back()->with(response_status('Payslip deleted successfully'));
    }
}
