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
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
    use ModelAction, Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_leave'])->only(['list']);
        $this->middleware(['permissions:create_leave'])->only(['store', 'create']);
        $this->middleware(['permissions:update_leave'])->only(['updateStatus', 'update', 'edit', 'bulk']);
        $this->middleware(['permissions:delete_leave'])->only(['destroy', 'bulk']);
    }

     /**
     * category list
     *
     * @return View
     */
    public function list(): View
    {

        return view('admin.leave.index', [

            'breadcrumbs'           =>  ['Home' => 'admin.home', 'Leaves requests' => null],
            'title'                 =>  translate('Leaves Requests'),
            'leaves'                => Leave::with('user', 'leaveType')
                                        ->orderBy('date', 'desc')
                                        ->year()
                                        ->month()
                                        ->date()
                                        ->day()
                                        ->paginate(paginateNumber())
                                        ->appends(request()->all())
        ]);
    }


    public function approve(Leave $leave): RedirectResponse
    {
        $leave->update(['status' => 'approved']);
        return redirect()->route('admin.leaves.index')->with('success', translate('Leave approved.'));
    }

    public function decline(Leave $leave): RedirectResponse
    {
        $leave->update(['status' => 'declined']);
        return redirect()->route('admin.leaves.index')->with('success', translate('Leave Declined.'));
    }
}
