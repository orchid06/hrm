<?php

namespace App\Http\Controllers\admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Admin\Department;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    use ModelAction ,Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_department'])->only(['list','subcategories']);
        $this->middleware(['permissions:create_department'])->only(['store','create']);
        $this->middleware(['permissions:update_department'])->only(['updateStatus','update','edit','bulk']);
        $this->middleware(['permissions:delete_department'])->only(['destroy','bulk']);
    }


    /**
     * category list
     *
     * @return View
     */
    public function list() :View{

        $title         =  translate('Manage Departments');
        $breadcrumbs   =  ['Home'=>'admin.home','Departments'=> null];

        if(request()->routeIs("admin.category.subcategories")){
            $title             = translate('Manage Subcategories');
            $breadcrumbs       = ['Home'=>'admin.home','Categories'=> route('admin.category.list') ,"Subcategories" => null];
        }

        return view('admin.department.list',[

            'breadcrumbs'  =>  $breadcrumbs,
            'title'        =>  $title,
            'departments'   =>  Department::latest()
                                ->paginate(paginateNumber())
                                ->appends(request()->all())
        ]);
    }

    public function store(Request $request) :RedirectResponse
    {
        $request->validate([
            'name'      => 'required',
            'status'    => 'required',
        ]);
        $department = Department::create([
            'name'      => $request->input('name'),
            'parent_id' => $request->input('parent_id')??StatusEnum::false->status(),
            'status'    => $request->input('status'),
        ]);

        return back()->with(response_status('Department created successfully'));
    }

    public function update(Request $request, $uid) : RedirectResponse
    {
        $department = Department::findOrFail($uid);
        $department->name = $request->input('name');
        $department->status = $request->input('status');
        $department->save();

        return back()->with(response_status('Department updated successfully '));
    }

    public function updateStatus(Request $request) {

        $request->validate([
            'id'      => 'required|exists:departments,uid',
            'status'  => ['required',Rule::in(StatusEnum::toArray())],
            'column'  => ['required',Rule::in(['status','is_feature'])],
        ]);

        return $this->changeStatus($request->except("_token"),[
            "model"    => new Department(),
        ]);

    }

    public function destroy($id) : RedirectResponse
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return back()->with(response_status('Department deleted successfully'));
    }
}
