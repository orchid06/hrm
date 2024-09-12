<?php

namespace App\Http\Controllers\admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Admin\Department;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    use ModelAction, Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_department'])->only(['list', 'subcategories']);
        $this->middleware(['permissions:create_department'])->only(['store', 'create']);
        $this->middleware(['permissions:update_department'])->only(['updateStatus', 'update', 'edit', 'bulk']);
        $this->middleware(['permissions:delete_department'])->only(['destroy', 'bulk']);
    }


    /**
     * category list
     *
     * @return View
     */
    public function list(): View
    {

        return view('admin.department.list', [

            'breadcrumbs'   => ['Home' => 'admin.home', 'Departments' => null],
            'title'         =>  translate('Manage Departments'),
            'departments'   =>  Department::latest()
                ->search(['name'])
                ->paginate(paginateNumber())
                ->appends(request()->all())
        ]);
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate(
            [
                'name'      => 'required|unique:departments,name',
                'status'    => ['required',Rule::in(StatusEnum::toArray())],
            ],
            [
                'name.unique' => translate('Department already exists')
            ]
        );
        $department = Department::create([
            'name'      => $request->input('name'),
            'parent_id' => $request->input('parent_id'),
            'status'    => $request->input('status'),
        ]);

        return back()->with(response_status('Department created successfully'));
    }

    public function update(Request $request): RedirectResponse
    {


        $request->validate([
            'uid'       => 'required|exists:departments,uid',
            'name'      => ['required',Rule::unique('departments', 'name')->ignore($request->uid, 'uid')],
            'status'    => ['required',Rule::in(StatusEnum::toArray())],
        ]);


        $department = Department::whereUid($request->input('uid'))->first();

        $department->name       = $request->input('name');
        $department->parent_id  = $request->input('parent_id');
        $department->status     = $request->input('status');
        $department->update();

        return back()->with(response_status('Department updated successfully '));
    }

    public function updateStatus(Request $request)
    {

        $request->validate([
            'id'      => 'required|exists:departments,uid',
            'status'  => ['required', Rule::in(StatusEnum::toArray())],
            'column'  => ['required', Rule::in(['status', 'is_feature'])],
        ]);

        return $this->changeStatus($request->except("_token"), [
            "model"    => new Department(),
        ]);
    }

    public function destroy($uid): RedirectResponse
    {
        $department = Department::whereUid($uid)->first();

        if ($department->designations()->exists()) {
            return back()->withErrors(['error' => translate('Cannot delete department with existing designations.')]);
        }

        $department->delete();
        return back()->with(response_status('Department deleted successfully'));
    }

    public function bulk(Request $request): RedirectResponse
    {

        try {
            $response =  $this->bulkAction($request, [
                "model"        => new Department(),

            ]);
        } catch (\Exception $exception) {
            $response  = \response_status($exception->getMessage(), 'error');
        }
        return  back()->with($response);
    }
}
