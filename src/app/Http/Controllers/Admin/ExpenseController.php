<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Enums\StatusEnum;
use App\Models\admin\Expense;
use App\Models\admin\ExpenseCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    use ModelAction, Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_expense'])->only(['list']);
        $this->middleware(['permissions:create_expense'])->only(['store', 'create']);
        $this->middleware(['permissions:update_expense'])->only(['updateStatus', 'update', 'edit', 'bulk']);
        $this->middleware(['permissions:delete_expense'])->only(['destroy', 'bulk']);
    }

    /**
     * category list
     *
     * @return View
     */
    public function list(): View
    {

        $title                  =  translate('Manage Expense');
        $breadcrumbs            =  ['Home' => 'admin.home', 'Expense' => null];

        $currentMonth           = Carbon::now()->month;
        $currentYear            = Carbon::now()->year;

        $expenses               = DB::table('expenses')
                                        ->whereMonth('created_at', $currentMonth)
                                        ->whereYear('created_at', $currentYear);

        $totalExpense               = $expenses->sum('amount');

        $categoryExpenses = DB::table('expenses')
                                    ->select('expense_categories.name as category_name', DB::raw('SUM(expenses.amount) as total_amount'))
                                    ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
                                    ->whereMonth('expenses.created_at', $currentMonth)
                                    ->whereYear('expenses.created_at', $currentYear)
                                    ->groupBy('expense_categories.name')
                                    ->get();


        $categoryWithHighestExpense = DB::table('expenses')
                                            ->select('expenses.expense_category_id', 'expense_categories.name as category_name', DB::raw('SUM(expenses.amount) as total_amount'))
                                            ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
                                            ->whereMonth('expenses.created_at', $currentMonth)
                                            ->whereYear('expenses.created_at', $currentYear)
                                            ->groupBy('expenses.expense_category_id', 'expense_categories.name')
                                            ->orderByDesc('total_amount')
                                            ->first();

        $averageDailyExpense = $totalExpense / Carbon::now()->daysInMonth;

        $cardData = [
            'totalExpense'                  => $totalExpense,
            'categoryWithHighestExpense'    => $categoryWithHighestExpense,
            'averageDailyExpense'           => $averageDailyExpense,
        ];

        $graphData = $categoryExpenses->map(function($item) {
            return [
                'category_name' => $item->category_name,
                'total' => $item->total_amount,
            ];
        })->toArray();

        return view('admin.expense.list', [

            'breadcrumbs'           =>  $breadcrumbs,
            'title'                 =>  $title,
            'cardData'              =>  $cardData,
            'graph_data'             => $graphData,
            'expense_categories'    => ExpenseCategory::latest()->get(),
            'expenses'              => Expense::latest()
                                        ->search(['name'])
                                        ->paginate(paginateNumber())
                                        ->appends(request()->all())
        ]);
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate(
            [
                'category_id'      => 'required|exists:expense_categories,id',
                'amount'           => 'required',
                'description'      => 'required'
            ],
            [
                'category_id.exists' => translate('The category does not exists')
            ]
        );

        Expense::create([
            'expense_category_id'       => $request->input('category_id'),
            'amount'                    => $request->input('amount'),
            'description'               => $request->input('description'),
        ]);

        return back()->with(response_status('Expense addedd successfully'));
    }

    public function update(Request $request): RedirectResponse
    {

        $request->validate([
            'uid'                       => 'required|exists:expenses,uid',
            'category_id'               => 'required|exists:expense_categories,id',
            'amount'                    => 'required',
            'description'               => 'required'
        ]);


        $expense = Expense::whereUid($request->input('uid'))->first();

        $expense->expense_category_id       = $request->input('category_id');
        $expense->amount                    = $request->input('amount');
        $expense->description               = $request->input('description');
        $expense->update();

        return back()->with(response_status('Expense updated successfully '));
    }

    public function destroy($uid): RedirectResponse
    {
        $expense = Expense::whereUid($uid)->first();
        $expense->delete();
        return back()->with(response_status('Expense deleted successfully'));
    }
}
