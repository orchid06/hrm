<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Enums\StatusEnum;
use App\Http\Requests\Admin\LeaveTypeRequest;
use App\Models\admin\Expense;
use App\Models\Leave;
use Illuminate\Http\JsonResponse;

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

        return view('admin.leave_type.index',[

            'title'                 =>  translate('Manage Leave Types'),
            'breadcrumbs'           =>  ['Home'=>'admin.home','Leave'=> 'admin.leave.list' , 'Leave types' =>null],
            'leave_types'           =>  LeaveType::latest()
                                        ->search(['name'])
                                        ->paginate(paginateNumber())
                                        ->appends(request()->all())
        ]);
    }

    public function create()
    {
        return view('admin.leave_type.create' ,[
            'title'                 =>  translate('create Leave Types'),
            'breadcrumbs'           =>  ['Home'=>'admin.home','Leave'=> 'admin.leave.list' , 'Leave types' =>'admin.leave_type.list', 'Create Leave Types' => null],
        ]);
    }

    public function store(LeaveTypeRequest $request)
    {
        $customInputs = $request->input('custom_inputs');

        if($customInputs){
            $promptInputs       = [];
            foreach ($request->input('custom_inputs') as $index => $field) {
                $newField = $field;
                if (is_null($field['name'])) {
                    $newField['name'] = t2k($newField['labels']);
                }
                $promptInputs[$index] = $newField;
            }
        }




        LeaveType::create([
            'name'              => $request->input('name'),
            'days'              => $request->input('days'),
            'is_paid'           => $request->input('is_paid'),
            'status'            => $request->input('status'),
            'custom_inputs'     => $customInputs ? json_encode($promptInputs) : null
        ]);

        return json_encode([
            'status'  =>  true,
            'message' => translate('Leave type created successfully')
        ]);

    }

    public function edit($id)
    {

        return view('admin.leave_type.edit' ,[
            'title'                 =>  translate('Edit Leave Types'),
            'breadcrumbs'           =>  ['Home'=>'admin.home','Leave'=> 'admin.leave.list' , 'Leave types' =>'admin.leave_type.list', 'Edit Leave Types' => null],
            'leave_type'            =>  LeaveType::findOrFail($id)
        ]);
    }

    public function update(LeaveTypeRequest $request)
    {

        $customInputs = $request->input('custom_inputs');

        if($customInputs){
            $promptInputs       = [];
            foreach ($request->input('custom_inputs') as $index => $field) {
                $newField = $field;
                if (is_null($field['name'])) {
                    $newField['name'] = t2k($newField['labels']);
                }
                $promptInputs[$index] = $newField;
            }
        }

        $leave = LeaveType::whereid($request->input('id'))->first();



        $leave->name                = $request->input('name');
        $leave->Days                = $request->input('days');
        $leave->status              = $request->input('status');
        $leave->is_paid             = $request->input('is_paid');
        $leave->custom_inputs       = $customInputs ? json_encode($promptInputs) : null;
        $leave->update();

        return json_encode([
            'status'  =>  true,
            'message' => translate('Leave type updated successfully')
        ]);

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
