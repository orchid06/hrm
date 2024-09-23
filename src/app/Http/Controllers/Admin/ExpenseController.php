<?php

namespace App\Http\Controllers\Admin;

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

        $currentMonth           = Carbon::now()->month;
        $currentYear            = Carbon::now()->year;

        $categories = ExpenseCategory::with(['expenses' => function ($query) use ($currentMonth, $currentYear) {
            $query->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear);
        }])->get();

        $totalExpense = $categories->sum(function ($category) {
            return $category->expenses->sum('amount');
        });

        $categoryWithHighestExpense = $categories->map(function ($category) {
            return [
                'name' => $category->name,
                'total_amount' => $category->expenses->sum('amount')
            ];
        })->sortByDesc('total_amount')->first();

        $averageDailyExpense = $totalExpense / Carbon::now()->daysInMonth;

        $cardData = [
            'totalExpense'                  => $totalExpense,
            'categoryWithHighestExpense'    => $categoryWithHighestExpense,
            'averageDailyExpense'           => $averageDailyExpense,
        ];


        $yearlyCategoryExpenses = ExpenseCategory::with(['expenses' => function ($query) use ($currentYear) {
            $query->select(
                'expense_category_id',
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as total_amount')
            )
                ->whereYear('created_at', $currentYear)
                ->groupBy('month', 'expense_category_id');
        }])->get();

        $graphData = [];
        $months = range(1, 12);

        foreach ($yearlyCategoryExpenses as $category) {
            $monthlyExpenses = array_fill_keys($months, 0);

            foreach ($category->expenses as $expense) {
                $monthlyExpenses[$expense->month] = $expense->total_amount;
            }

            $graphData[] = [
                'name' => $category->name,
                'data' => array_values($monthlyExpenses),
            ];
        }



        return view('admin.expense.list', [

            'breadcrumbs'           =>  ['Home' => 'admin.home', 'Expense' => null],
            'title'                 =>  translate('Manage Expense'),
            'cardData'              =>  $cardData,
            'graphData'             =>  $graphData,
            'expense_categories'    => ExpenseCategory::latest()->get(),
            'expenses'              => Expense::with('category')
                                                ->latest()
                                                ->search(['category:name'])
                                                ->paginate(paginateNumber())
                                                ->appends(request()->all())
        ]);
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate(
            [
                'category_id'      => 'required|exists:expense_categories,id',
                'amount'           => 'required|numeric|gt:0',
                'description'      => 'required'
            ],
            [
                'category_id.exists' => translate('The category does not exists'),
                'amount.required' => translate('Amount is required.'),
                'amount.numeric'  => translate('Amount must be a number.'),
                'amount.gt'       => translate('Amount must be greater than zero.'),
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
            'amount'                    => 'required|numeric|gt:0',
            'description'               => 'required'
        ],
        [
            'category_id.exists'    => translate('The category does not exists'),
            'amount.required'       => translate('Amount is required.'),
            'amount.numeric'        => translate('Amount must be a number.'),
            'amount.gt'             => translate('Amount must be greater than zero.'),
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
