<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ExpenseCategory;
use Illuminate\Http\Request;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Enums\StatusEnum;
use App\Models\admin\Expense;

class ExpenseCategoryController extends Controller
{
    use ModelAction ,Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_expense_category'])->only(['list']);
        $this->middleware(['permissions:create_expense_category'])->only(['store','create']);
        $this->middleware(['permissions:update_expense_category'])->only(['updateStatus','update','edit','bulk']);
        $this->middleware(['permissions:delete_expense_category'])->only(['destroy','bulk']);
    }

    /**
     * category list
     *
     * @return View
     */
    public function list() :View{

        return view('admin.expense.category',[

            'title'                 =>  translate('Manage Expense Category'),
            'breadcrumbs'           =>  ['Home'=>'admin.home','Expense category'=> null],
            'expense_categories'     => ExpenseCategory::latest()
                                        ->search(['name'])
                                        ->paginate(paginateNumber())
                                        ->appends(request()->all())
        ]);
    }

    public function store(Request $request) :RedirectResponse
    {

        $request->validate([
            'name'      => 'required|unique:expense_categories,name|string|max:191',
            'status'    => ['required',Rule::in(StatusEnum::toArray())],
        ],
        [
            'name.unique' => translate('The category already exists')
        ]);

        ExpenseCategory::create([
            'name'      => $request->input('name'),
            'status'    => $request->input('status'),
        ]);

        return back()->with(response_status('Category created successfully'));
    }

    public function update(Request $request) : RedirectResponse
    {


        $request->validate([
            'uid'       => 'required|exists:expense_categories,uid',
            'name'      => ['required','string','max:191',Rule::unique('expense_categories', 'name')->ignore($request->uid, 'uid')],
            'status'    => ['required',Rule::in(StatusEnum::toArray())],
        ]);


        $department = ExpenseCategory::whereUid($request->input('uid'))->first();

        $department->name       = $request->input('name');
        $department->status     = $request->input('status');
        $department->update();

        return back()->with(response_status('Category updated successfully '));



    }

    public function updateStatus(Request $request) {

        $request->validate([
            'id'      => 'required|exists:expense_categories,uid',
            'status'  => ['required',Rule::in(StatusEnum::toArray())],
            'column'  => ['required',Rule::in(['status','is_feature'])],
        ]);

        return $this->changeStatus($request->except("_token"),[
            "model"    => new ExpenseCategory(),
        ]);

    }

    public function destroy($uid) : RedirectResponse
    {
        $expense_category = ExpenseCategory::whereUid($uid)->first();
        $expense_category->delete();
        return back()->with(response_status('Category deleted successfully'));
    }

    public function bulk(Request $request) :RedirectResponse {

        try {
            $response =  $this->bulkAction($request,[
                "model"        => new ExpenseCategory(),
            ]);

        } catch (\Exception $exception) {
            $response  = \response_status($exception->getMessage(),'error');
        }
        return  back()->with($response);
    }
}
