<?php
namespace App\Http\Services\Admin;

use App\Enums\PaymentStatus;
use App\Enums\SalaryTypeEnum;
use App\Enums\StatusEnum;
use App\Models\Admin\Payroll;
use App\Models\User;
use Carbon\Carbon;

class PayrollService
{
    /**
     * Create payrolls for users who haven't received it for the specified month.
     *
     * @param array $userIds
     * @param string $month
     * @return array
     */
    public function createPayslips(array $userIds, string $month): array
    {


        $results = [
            'success' => [],
            'errors' => []
        ];

        $monthCarbon = Carbon::parse($month);

        $users = User::with(['advanceSalaries' => function ($query) use ($monthCarbon) {
            $query->whereYear('for_month', $monthCarbon->year)
                    ->whereMonth('for_month', $monthCarbon->month);
            }])
            ->active()
            ->whereIn('id', $userIds)
            ->whereDoesntHave('payrolls', function ($query) use ($monthCarbon) {
                $query->whereYear('created_at', $monthCarbon->year)
                    ->whereMonth('created_at', $monthCarbon->month);
            })
            ->get();



        $allowanceDeductions = json_decode(site_settings('allowance') , true);


        foreach ($users as $user) {

            $basic_salary   = $user->userDesignation->basic_salary;
            $netPay         = $basic_salary;

            if (!$basic_salary) {

                $results['errors'][] = trans("Please set baisc salary for :name first.", ['name' => $user->name]);
                continue;
            }

            foreach ($allowanceDeductions as $item) {
                // Check if the item is a percentage
                $item['is_percentage'] == "1" ? $amount = $basic_salary * ($item['amount'] / 100) : $amount = $item['amount'];

                //check if item is allowance of deduction
                $item['type'] == "1" ? $netPay += $amount :  $netPay -= $amount;
            }

            if($user->advanceSalaries){
                $totalAdvanceSalary = $user->advanceSalaries->sum('amount');
                $netPay -= $totalAdvanceSalary;
            }

            try {

                Payroll::create([
                    'user_id'       => $user->id,
                    'basic_salary'  => $basic_salary,
                    'net_pay'       => $netPay,
                    'details'       => json_encode($allowanceDeductions),
                    'pay_period'    => $month,
                ]);


                $results['success'][] = $user->name;
            } catch (\Exception $e) {

                $results['errors'][] = trans("Failed to create payroll for :name", ['name' => $user->name]);
            }
        }

        return $results;
    }

    public function makePayment($userIds , $month)
    {
        $results = [
            'success' => [],
            'errors' => []
        ];

        $monthCarbon = Carbon::parse($month);
        $now = Carbon::now();
        $status = PaymentStatus::PAID->status();

        $payrolls = Payroll::whereIn('user_id', $userIds)
                    ->whereYear('pay_period', $monthCarbon->year)
                    ->whereMonth('pay_period', $monthCarbon->month)
                    ->where('status' , PaymentStatus::UNPAID->status())
                    ->get();

        $payrolls->each(function ($payroll) use ($status, $now) {
            $payroll->status = $status;
            $payroll->payment_date = $now;
        });

        try{

            $payrolls->each->save();
        }catch(\Exception $e){

            $results['errors'][] = trans("Failed to make payment");

        }

        return $results;

    }
}
