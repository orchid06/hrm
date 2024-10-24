<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SalaryTypeEnum;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdvanceSalary;
use App\Models\Admin\Designation;
use App\Models\Admin\UserDesignation;
use App\Models\User;
use App\Rules\Admin\FutureOrCurrentMonth;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

        return view('admin.salary.list', [

            'breadcrumbs'    =>  ['Home' => 'admin.home', 'salaries' => null],
            'title'          =>  translate('Set Salary'),
            'users'           =>  User::with('file')
                                ->when(request()->input('user_id'), function ($query) {
                                    return $query->where('id', request()->input('user_id'));
                                })
                                ->latest()
                                ->get(),

            'designations'   =>  Designation::with('department')
                                ->latest()
                                ->search(['name', 'department:name'])
                                ->paginate(paginateNumber())
                                ->appends(request()->all())
        ]);
    }

    public function create($uid): View
    {

        $user = User::whereUid($uid)->first();

        return view('admin.salary.create', [
            'breadcrumbs'   => ['Home' => 'admin.home', 'salaries' => 'admin.salary.list' , 'set salary' => null],
            'title'         => translate('Set Salary'),
            'user'          => $user
        ]);
    }

    public function store(Request $request): RedirectResponse
    {


        $request->validate([
            'uid'               => 'required|exists:users,uid',
            'labels.*'          => 'required',
            'type.*'            => 'required',
            'amount.*'          => 'required|numeric|gt:0',
            'is_percentage.*'   => ['required',Rule::in(StatusEnum::toArray())],
        ]);


        $total_allowance    = 0;
        $total_deduction    = 0;
        $baseSalary = 0;

        $custom_inputs      = $request->input('custom_inputs');

        $salaryDetails = [];

        foreach ($custom_inputs as $input) {
            if (is_array($input) && isset($input['labels'])) {
                if (($input['default']) === StatusEnum::true->status()) {
                    $baseSalary = $input['amount'];
                    break;
                }
            }
        }



        foreach ($custom_inputs as $input) {
            if (is_array($input) && isset($input['labels'])) {
                $key = t2k($input['labels']);

                $is_percentage = $input['is_percentage'] ?? StatusEnum::false->status();

                $salaryDetails[$key] = [
                    'labels'        => $input['labels'],
                    'type'          => $input['type'],
                    'amount'        => $input['amount'],
                    'default'       => $input['default'],
                    'is_percentage' => $is_percentage
                ];

                $is_percentage == StatusEnum::true->status()
                ? $amount = $baseSalary*($input['amount']/100)
                : $amount = $input['amount'];

                $input['type'] == SalaryTypeEnum::ALLOWANCE->status()
                ? $total_allowance += $amount
                : $total_deduction += $amount;

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

    public function advanceSalary()
    {
        $month          = request('month', now()->month);
        $year           = request('year', now()->year);



        return view('admin.advance_salary.list', [
            'breadcrumbs'   => ['Home' => 'admin.home', 'Advance salaries' => 'admin.salary.advance.list' ],
            'title'         => translate('Advance Salary '),
            'advanceSalaries'           => AdvanceSalary::with('user')
                                                        ->month()
                                                        ->year()
                                                        ->user()
                                                        ->orderBy('created_at', 'desc')
                                                        ->paginate(paginateNumber())
                                                        ->appends(request()->all()),
            'selectedMonth'             => $month,
            'selectedYear'              => $year,
            'users'                     => User::all()
        ]);
    }

    public function advanceSalaryStore(Request $request)
    {
        $currentMonth  = Carbon::now()->month;


        $request->validate([
            'user_id'  => 'required|exists:users,id',
            'for_month' => ['required','integer', "min:$currentMonth",'max:12'],
            'amount'    => 'required|numeric|min:1',
            'note'      => 'nullable|string|max:250',
        ],[
            'for_month' => translate('The selected month must be the current or a future month.')
        ]);

        AdvanceSalary::create([
            'user_id'   => $request->input('user_id'),
            'for_month' => Carbon::create(now()->year, $request->input('for_month'), now()->day, now()->hour, now()->minute, now()->second),
            'amount'    => $request->input('amount'),
            'note'      => $request->input('note')
        ]);

        return back()->with(response_status('Advance salary record created successfully'));

    }

    public function advanceSalaryUpdate(Request $request)
    {
        $currentMonth  = Carbon::now()->month;

        $request->validate([
            'id'        => 'required|integer|exists:advance_salaries,id',
            'user_id'   => 'required|integer|exists:users,id',
            'for_month' => ['required','integer', "min:$currentMonth",'max:12'],
            'amount'    => 'required|numeric|min:1',
            'note'      => 'nullable|string|max:255',
        ]);

        AdvanceSalary::findOrFail($request->input('id'))->update([
           'user_id'    => $request->input('id'),
           'for_month'  => Carbon::create(now()->year, $request->input('for_month'), now()->day, now()->hour, now()->minute, now()->second),
           'amount'     => $request->input('amount'),
           'note'       => $request->input('note')
        ]);

        return back()->with(response_status('Advance salary record updated successfully'));
    }

    public function advanceSalaryDestroy($id)
    {
        AdvanceSalary::findOrFail($id)->delete();

        return back()->with(response_status('Advanced salary record deleted successfully'));
    }


}
