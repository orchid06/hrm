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
use App\Http\Services\SettingService;
use App\Models\Admin\Account;
use App\Models\Admin\CashIn;
use App\Models\Admin\Expense;
use App\Models\Admin\ExpenseCategory;
use App\Models\Core\File;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    use ModelAction, Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:create_cashIn'])->only(['cashIn']);
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

        $month          = request('month', now()->month);
        $year           = request('year', now()->year);
        $currentDate    = Carbon::today();

        $categories = ExpenseCategory::with(['expenses' => function ($query) use ($month, $year) {
            $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
        }])->get();

        $totalExpense = $categories->sum(function ($category) {
            return $category->expenses->sum('amount');
        });



        $averageDailyExpense = $totalExpense / Carbon::now()->daysInMonth;

        $cardData = [
            'totalExpense'                  => $totalExpense,
            'averageDailyExpense'           => $averageDailyExpense,
        ];



        return view('admin.expense.list', [

            'breadcrumbs'           =>  ['Home' => 'admin.home', 'Expense' => null],
            'title'                 =>  translate('Manage Expense'),
            'cardData'              =>  $cardData,
            'selectedMonth'         =>  $month,
            'selectedYear'          =>  $year,
            'accounts'              => Account::all(),
            'expense_categories'    => ExpenseCategory::latest()->get(),
            'expenses'              => Expense::with('category')
                                                ->latest()
                                                ->whereMonth('created_at' , $month)
                                                ->whereYear('created_at' , $year)
                                                ->search(['category:name'])
                                                ->paginate(paginateNumber())
                                                ->appends(request()->all())
        ]);
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate(
            [
                'account_id'       => 'required|exists:accounts,id',
                'category_id'      => 'required|exists:expense_categories,id',
                'amount'           => 'required|numeric|gt:0',
                'description'      => 'required',

            ],
            [
                'account_id.exists'  => translate('The account does not exists'),
                'category_id.exists' => translate('The category does not exists'),
                'amount.required'    => translate('Amount is required.'),
                'amount.numeric'     => translate('Amount must be a number.'),
                'amount.gt'          => translate('Amount must be greater than zero.'),
            ]
        );

        $month       = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $account = Account::findOrFail($request->input('account_id'));

        $balance    = $account->balance;

        $newBalance = $balance - $request->input('amount');

        $account->balance = $newBalance;
        $account->save();

        $expense = Expense::create([
            'expense_category_id'       => $request->input('category_id'),
            'amount'                    => $request->input('amount'),
            'description'               => $request->input('description'),
        ]);

        if ($request->has('files')) {

            foreach ($request->input('files') as $key => $file) {
                $response = $this->storeFile(
                    file: $file,
                    location: config("settings")['file_path']['expense_data']['path'],
                );

                if (isset($response['status'])) {
                    $fileRecord = new File([
                        'name'      => Arr::get($response, 'name', '#'),
                        'disk'      => Arr::get($response, 'disk', 'local'),
                        'type'      => $key,
                        'size'      => Arr::get($response, 'size', ''),
                        'extension' => Arr::get($response, 'extension', ''),
                    ]);


                    $expense->file()->save($fileRecord);
                }
            }
        }



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

        if ($request->has('files')) {

            foreach ($request->input('files') as $key => $file) {
                $response = $this->storeFile(
                    file: $file,
                    location: config("settings")['file_path']['expense_data']['path'],
                );

                if (isset($response['status'])) {
                    $fileRecord = new File([
                        'name'      => Arr::get($response, 'name', '#'),
                        'disk'      => Arr::get($response, 'disk', 'local'),
                        'type'      => $key,
                        'size'      => Arr::get($response, 'size', ''),
                        'extension' => Arr::get($response, 'extension', ''),
                    ]);


                    $expense->file()->save($fileRecord);
                }
            }
        }

        return back()->with(response_status('Expense updated successfully '));
    }

    public function destroy($uid): RedirectResponse
    {
        $expense = Expense::whereUid($uid)->first();
        $expense->delete();
        return back()->with(response_status('Expense deleted successfully'));
    }

    public function details($uid)
    {

        return view('admin.expense.details', [

            'breadcrumbs'           =>  ['Home' => 'admin.home', 'Expense' => 'admin.expense.list' , 'Expense details' => null ],
            'title'                 =>  translate('Expense details'),
            'expense'              =>  Expense::with('category' , 'file')
                                                ->whereUid($uid)->first()
        ]);
    }

    public function cashIn(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'month'  => 'required|integer|between:1,12',
        ]);

        CashIn::create([
            'amount' => $request->input('amount'),
            'month'  =>  Carbon::create(now()->year, $request->input('month'), now()->day, now()->hour, now()->minute, now()->second) ,
            'balance'=> $request->input('amount'),
        ]);

        return back()->with(response_status('Cash added successfully'));
    }
}
