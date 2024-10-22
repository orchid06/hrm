<?php
namespace App\Http\Services\Admin;

use App\Enums\SalaryTypeEnum;
use App\Enums\StatusEnum;
use App\Models\Admin\Payroll;
use App\Models\User;

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


        $users = User::with(['advanceSalaries' => function ($query) use ($month) {
                $query->whereYear('for_month', substr($month, 0, 4))
                    ->whereMonth('for_month', substr($month, 5, 2));
            }])
            ->active()
            ->whereIn('id', $userIds)
            ->whereDoesntHave('payrolls', function ($query) use ($month) {
                $query->whereYear('created_at', substr($month, 0, 4))
                      ->whereMonth('created_at', substr($month, 5, 2));
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
}
