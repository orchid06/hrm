<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Models\admin\Expense;
use App\Models\admin\ExpenseCategory;
use App\Models\Admin\Payroll;
use App\Models\Admin\UserDesignation;
use App\Models\Attendance;
use App\Models\Core\File;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Traits\Fileable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{


    use Fileable;

    /**
     * Admin Dashboard
     *
     * @param Request $request
     * @return void
     */
    public function home(Request $request): View
    {


        return view('admin.home', [
            'title' => translate("Dashboard"),
            'data'  => $this->getDashboardData()
        ]);
    }



    /**
     * get dashboard data
     *
     */

    public function getDashboardData(): array
    {


        $currentMonth = now()->month;
        $currentYear = now()->year;

        $data = [];


        $data['total_employees'] = User::count();


        $data['present_employees'] = Attendance::where('clock_in_status', StatusEnum::true->status())->when(request()->has('date'), function ($query) {
            $query->date();
        }, function ($query) {

            $query->whereDate('date', now());
        })->count();


        $data['absent_employees'] = User::whereDoesntHave('attendances', function ($query) {
            $query->when(request()->has('date'), function ($q) {
                $q->date();
            }, function ($q) {
                $q->whereDate('date', now());
            });
        })->count();

        $data['late_employees'] = Attendance::whereNotNull('late_time')
            ->where('late_time', '>', 0)
            ->when(request()->has('date'), function ($query) {
                $query->date();
            }, function ($query) {
                $query->whereDate('date', now());
            })->count();


        $startDate = request('start_date');
        $endDate = request('end_date');

        // Determine if a custom date range spans multiple months
        $isCustomDateRange = $startDate && $endDate && Carbon::parse($startDate)->month != Carbon::parse($endDate)->month;



        $data['total_payroll_processed'] = Payroll::when($isCustomDateRange, function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }, function ($query) {
            $query->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year);
        })->sum('net_pay');



        $data['pending_payroll'] = User::whereDoesntHave('payrolls', function ($query) use ($startDate, $endDate, $isCustomDateRange) {
            if ($isCustomDateRange) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } else {
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
            }
        })->count();


        $data['designation_changes'] = UserDesignation::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $totalOfficeExpenses = Expense::when(request()->has('date'), function ($query) {

            $query->date();
        }, function ($query) {

            $query->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year);
        })->sum('amount');


        $data['net_expense'] = $data['total_payroll_processed'] + $totalOfficeExpenses;

        $formattedDate = now()->format('m/d/Y');
        $todaysDateRange = "{$formattedDate} - {$formattedDate}";

        $data['date'] = request()->input('date') ?? $todaysDateRange;


        $yearlyCategoryExpenses = ExpenseCategory::with(['expenses' => function ($query) use ($currentYear) {
            $query->select(
                'expense_category_id',
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as total_amount')
            )
                ->whereYear('created_at', $currentYear)
                ->groupBy('month', 'expense_category_id');
        }])->get();

        $salaryExpenses = Payroll::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(net_pay) as total_amount')
        )
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('total_amount', 'month')
            ->toArray();

        $months = range(1, 12);

        $graphData = $yearlyCategoryExpenses->map(function ($category) use ($months) {
            $monthlyExpenses = array_fill_keys($months, 0);
            foreach ($category->expenses as $expense) {
                $monthlyExpenses[$expense->month] = $expense->total_amount;
            }
            return [
                'name' => $category->name,
                'data' => array_values($monthlyExpenses),
            ];
        })->toArray();

        $graphData[] = [
            'name' => 'Salary',
            'data' => array_values(array_replace(array_fill_keys($months, 0), $salaryExpenses)),
        ];

        $data['net_expense_chart_data'] = $graphData;


        $data['yearly_total_salary'] = Payroll::whereYear('created_at', $currentYear)
            ->sum('net_pay');


        $data['yearly_total_officeExpenses'] = Expense::whereYear('created_at', $currentYear)
            ->sum('amount');

        return $data;
    }



    /**
     * Admin profile
     *
     * @return View
     */
    public function profile(): View
    {

        return view('admin.profile', [

            'breadcrumbs' =>  ['home' => 'admin.home', 'profile' => null],
            "user"        =>  auth_user(),
            'title'       => "Profile",
        ]);
    }
    /**
     * Admin profile
     *
     * @return View
     */
    public function profileUpdate(ProfileRequest $request): RedirectResponse
    {


        $response = response_status('Profile Updated');

        try {

            DB::transaction(function () use ($request) {
                $admin = auth_user();
                $admin->username    = $request->input('username');
                $admin->phone       = $request->input('phone');
                $admin->email       = $request->input('email');
                $admin->name        = $request->input('name');
                $admin->save();


                if ($request->hasFile('image')) {

                    $oldFile = $admin->file()->where('type', 'avatar')->first();
                    $response = $this->storeFile(
                        file: $request->file('image'),
                        location: config("settings")['file_path']['profile']['admin']['path'],
                        removeFile: $oldFile
                    );


                    if (isset($response['status'])) {
                        $image = new File([
                            'name'      => Arr::get($response, 'name', '#'),
                            'disk'      => Arr::get($response, 'disk', 'local'),
                            'type'      => 'avatar',
                            'size'      => Arr::get($response, 'size', ''),
                            'extension' => Arr::get($response, 'extension', ''),
                        ]);
                        $admin->file()->save($image);
                    }
                }
            });
        } catch (\Exception $ex) {
            $response = response_status(strip_tags($ex->getMessage(), "error"));
        }



        return back()->with($response);
    }


    /**
     * update password
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function passwordUpdate(Request $request): RedirectResponse
    {

        $request->validate(
            [
                'current_password' => 'required',
                'password'         => 'required|confirmed|min:5',
            ],
            [
                'current_password.required' => translate('Your Current Password is Required'),
                'password' => translate('Password Feild Is Required'),
                'password.confirmed' => translate('Confirm Password Does not Match'),
                'password.min' => translate('Minimum 5 digit or character is required'),
            ]
        );
        $admin = auth_user();
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->with('error', translate("Your Current Password does not match !!"));
        }
        $admin->password = Hash::make($request->password);
        $admin->save();
        return back()->with(response_status('Password Updated'));
    }



    /**
     * read a notifications
     */

    public function readNotification(Request $request): string
    {

        $notification = Notification::where('notificationable_type', 'App\Models\Admin')
            ->where("id", $request->id)
            ->first();
        $status  = false;
        $message = translate('Notification Not Found');
        if ($notification) {
            $notification->is_read =  (StatusEnum::true)->status();
            $notification->save();
            $status = true;
            $message = translate('Notification Readed');
        }
        return json_encode([
            "status"  => $status,
            "message" => $message
        ]);
    }


    /**
     * read a notifications
     */

    public function notification(Request $request): View
    {

        Notification::where('notificationable_type', 'App\Models\Admin')
            ->update([
                "is_read" => (StatusEnum::true)->status()
            ]);

        return view('admin.notification', [

            'breadcrumbs'    =>  ['home' => 'admin.home', 'Notifications' => null],
            'title'          =>  "Notifications",
            'notifications'  =>  Notification::where('notificationable_type', 'App\Models\Admin')
                ->latest()
                ->paginate(paginateNumber())
        ]);
    }
}
