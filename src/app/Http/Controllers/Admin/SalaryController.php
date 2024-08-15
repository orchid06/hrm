<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Department;
use App\Models\Admin\Designation;
use App\Models\Admin\Payroll;
use App\Models\User;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SalaryController extends Controller
{
    use ModelAction ,Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_salary'])->only(['list']);
        $this->middleware(['permissions:create_salary'])->only(['store','create']);
        $this->middleware(['permissions:update_salary'])->only(['updateStatus','update','edit','bulk']);
        $this->middleware(['permissions:delete_salary'])->only(['destroy','bulk']);
    }

    /**
     * category list
     *
     * @return View
     */
    public function list() :View{

        $title         =  translate('Set Salary');
        $breadcrumbs   =  ['Home'=>'admin.home','salaries'=> null];

        return view('admin.salary.list',[

            'breadcrumbs'    =>  $breadcrumbs,
            'title'          =>  $title,
            'users'           =>  User::with('file')
                                    ->latest()->get(),
            'designations'   =>  Designation::with('department')
                                ->latest()
                                ->search(['name' , 'department:name'])
                                ->paginate(paginateNumber())
                                ->appends(request()->all())
        ]);
    }

    public function create($uid): View
    {
        $title = translate('Set Salary');

        $user = User::whereUid($uid)->first();

        return view('admin.salary.create',[
            'title'     => $title,
            'user'      => $user
        ]);
    }

    public function store(Request $request) : RedirectResponse
    {

        $request-> validate([
            'uid'     => 'required|exists:users,uid',
            'labels.*'=> 'required',
            'type.*'  => 'required',
            'amount.*'=> 'required',
        ]);

        $total_allowance = 0;
        $total_deduction = 0;
        $basic_salary    = 0;

        foreach ($request->custom_inputs as $input) {
            if ($input['type'] == "1") {
                $total_allowance += (float)$input['amount'];
            }
            elseif ($input['type'] == "0") {
                $total_deduction += (float)$input['amount'];
            }
            elseif ($input['default'] == '1') {
            $basic_salary = $input['amount'];
        }

        dd($total_allowance , $total_deduction, $basic_salary);

        $net_pay = $total_allowance - $total_deduction;

        User::whereUid($request->input('uid'))->first();

        Payroll::create([
            ''
        ]);





        return back()->with('success', trans('Salary setting stored successfully'));
    }
}
