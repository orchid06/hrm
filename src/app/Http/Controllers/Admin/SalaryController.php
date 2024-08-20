<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Department;
use App\Models\Admin\Designation;
use App\Models\Admin\Payroll;
use App\Models\Admin\UserDesignation;
use App\Models\User;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SalaryController extends Controller
{
    use ModelAction, Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_salary'])->only(['list']);
        $this->middleware(['permissions:create_salary'])->only(['store', 'create']);
        $this->middleware(['permissions:update_salary'])->only(['updateStatus', 'update', 'edit', 'bulk']);
        $this->middleware(['permissions:delete_salary'])->only(['destroy', 'bulk']);
    }

    /**
     * category list
     *
     * @return View
     */
    public function list(): View
    {

        $title         =  translate('Set Salary');
        $breadcrumbs   =  ['Home' => 'admin.home', 'salaries' => null];

        return view('admin.salary.list', [

            'breadcrumbs'    =>  $breadcrumbs,
            'title'          =>  $title,
            'users'           =>  User::with('file')
                ->latest()->get(),
            'designations'   =>  Designation::with('department')
                ->latest()
                ->search(['name', 'department:name'])
                ->paginate(paginateNumber())
                ->appends(request()->all())
        ]);
    }

    public function create($uid): View
    {
        $title = translate('Set Salary');
        $breadcrumbs   =  ['Home' => 'admin.home', 'salaries' => 'admin.salary.list' , 'set salary' => null];

        $user = User::whereUid($uid)->first();

        return view('admin.salary.create', [
            'breadcrumbs'   => $breadcrumbs,
            'title'         => $title,
            'user'          => $user
        ]);
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'uid'       => 'required|exists:users,uid',
            'labels.*'  => 'required',
            'type.*'    => 'required',
            'amount.*'  => 'required',
        ]);

        $total_allowance    = 0;
        $total_deduction    = 0;
        $custom_inputs      = $request->input('custom_inputs');

        $salaryDetails = [];

        foreach ($custom_inputs as $input) {
            if (is_array($input) && isset($input['labels'])) {
                $key = t2k($input['labels']);
                $salaryDetails[$key] = [
                    'labels'  => $input['labels'],
                    'type'    => $input['type'],
                    'amount'  => $input['amount'],
                    'default' => $input['default'],
                ];

                $input['type'] == "1"
                    ? $total_allowance += (float)$input['amount']
                    : $total_deduction += (float)$input['amount'];
            } else {
                $salaryDetails[$input] = $input;
            }
        }

        $net_salary = $total_allowance - $total_deduction;

        $user       = User::whereUid($request->input('uid'))->first();

       UserDesignation::where('user_id' , $user->id)->update([
            'salary'        => json_encode($salaryDetails, true),
            'net_salary'    => $net_salary,
            'payslip_cycle' => $request->input('payslip_cycle')
       ]);

        return back()->with('success', trans('Salary setting stored successfully'));
    }
}
