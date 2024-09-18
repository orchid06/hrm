<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Enums\StatusEnum;
use App\Models\admin\Expense;
use App\Models\Leave;

class LeaveTypeController extends Controller
{
    use ModelAction ,Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_leave'])->only(['list']);
        $this->middleware(['permissions:create_leave'])->only(['store','create']);
        $this->middleware(['permissions:update_leave'])->only(['updateStatus','update','edit','bulk']);
        $this->middleware(['permissions:delete_leave'])->only(['destroy','bulk']);
    }

    /**
     * category list
     *
     * @return View
     */
    public function list() :View{

        return view('admin.leave.type',[

            'title'                 =>  translate('Manage Leave Types'),
            'breadcrumbs'           =>  ['Home'=>'admin.home','Leave'=> 'admin.leave.list' , 'Leave types' =>null],
            'leave_types'           =>  LeaveType::latest()
                                        ->search(['name'])
                                        ->paginate(paginateNumber())
                                        ->appends(request()->all())
        ]);
    }

    public function store(Request $request) :RedirectResponse
    {

        $request->validate([
            'name'      => 'required|unique:leave_types,name|string|max:191',
            'is_paid'    => ['required',Rule::in(StatusEnum::toArray())],
            'status'    => ['required',Rule::in(StatusEnum::toArray())],
        ],
        [
            'name.unique' => translate('The Type already exists')
        ]);

        LeaveType::create([
            'name'      => $request->input('name'),
            'is_paid'   => $request->input('is_paid'),
            'status'    => $request->input('status'),
        ]);

        return back()->with(response_status('Leave Type created successfully'));
    }

    public function update(Request $request) : RedirectResponse
    {

        $request->validate([
            'id'        => 'required|exists:leave_types,id',
            'name'      => ['required','string','max:191',Rule::unique('leave_types', 'name')->ignore($request->id, 'id')],
            'is_paid'   => ['required',Rule::in(StatusEnum::toArray())],
            'status'    => ['required',Rule::in(StatusEnum::toArray())],
        ]);


        $leave = LeaveType::whereid($request->input('id'))->first();

        $leave->name       = $request->input('name');
        $leave->status     = $request->input('status');
        $leave->is_paid    = $request->input('is_paid');
        $leave->update();

        return back()->with(response_status('Leave Type updated successfully '));



    }

    public function updateStatus(Request $request) {

        $request->validate([
            'id'      => 'required|exists:leave_types,uid',
            'status'  => ['required',Rule::in(StatusEnum::toArray())],
            'column'  => ['required',Rule::in(['status','is_feature'])],
        ]);

        return $this->changeStatus($request->except("_token"),[
            "model"    => new LeaveType(),
        ]);

    }

    public function destroy($id) : RedirectResponse
    {
        $leave_category = LeaveType::whereid($id)->first();
        $leave_category->delete();
        return back()->with(response_status('Category deleted successfully'));
    }

    public function bulk(Request $request) :RedirectResponse {

        try {
            $response =  $this->bulkAction($request,[
                "model"        => new LeaveType(),
            ]);

        } catch (\Exception $exception) {
            $response  = \response_status($exception->getMessage(),'error');
        }
        return  back()->with($response);
    }
}
