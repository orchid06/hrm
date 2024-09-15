<?php
namespace App\Http\Services\Admin;

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
    public function createPayrolls(array $userIds, string $month): array
    {

        $results = [
            'success' => [],
            'errors' => []
        ];


        $users = User::active()
            ->whereIn('id', $userIds)
            ->whereDoesntHave('payrolls', function ($query) use ($month) {
                $query->whereYear('created_at', substr($month, 0, 4))
                      ->whereMonth('created_at', substr($month, 5, 2));
            })
            ->get();


        foreach ($users as $user) {
            $salary = json_decode($user->userDesignation->salary);

            if (!$salary) {

                $results['errors'][] = trans("Please set salary for :name first.", ['name' => $user->name]);
                continue;
            }

            try {

                Payroll::create([
                    'user_id' => $user->id,
                    'salary' => $salary->basic_salary->amount,
                    'net_pay' => $user->userDesignation->net_salary,
                    'details' => $user->userDesignation->salary,
                    'pay_period' => $month,
                ]);


                $results['success'][] = $user->name;
            } catch (\Exception $e) {
                
                $results['errors'][] = trans("Failed to create payroll for :name", ['name' => $user->name]);
            }
        }

        return $results;
    }
}
