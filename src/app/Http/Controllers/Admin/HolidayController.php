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

class HolidayController extends Controller
{
    use ModelAction, Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_holiday'])->only(['list']);
        $this->middleware(['permissions:create_holiday'])->only(['store', 'create']);
        $this->middleware(['permissions:update_holiday'])->only(['updateStatus', 'update', 'edit', 'bulk']);
        $this->middleware(['permissions:delete_holiday'])->only(['destroy', 'bulk']);
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


        return view('admin.holiday.index', [

            'breadcrumbs'           =>  ['Home' => 'admin.home', 'Holidays' => null],
            'title'                 =>  translate('Manage Holidays'),

        ]);
    }
}
