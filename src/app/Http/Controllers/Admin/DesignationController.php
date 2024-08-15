<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use App\Enums\StatusEnum;
use App\Models\Admin\Department;
use App\Models\Admin\Designation;

class DesignationController extends Controller
{
    use ModelAction ,Fileable;

    public function __construct()
    {
        //check permissions middleware
        $this->middleware(['permissions:view_designation'])->only(['list']);
        $this->middleware(['permissions:create_designation'])->only(['store','create']);
        $this->middleware(['permissions:update_designation'])->only(['updateStatus','update','edit','bulk']);
        $this->middleware(['permissions:delete_designation'])->only(['destroy','bulk']);
    }


   /**
     * category list
     *
     * @return View
     */
    public function list() :View{

        $title         =  translate('Manage Designations');
        $breadcrumbs   =  ['Home'=>'admin.home','Designations'=> null];

        if(request()->routeIs("admin.category.subcategories")){
            $title             = translate('Manage Designations');
            $breadcrumbs       = ['Home'=>'admin.home','Department'=> route('admin.department.list') ,"Designation" => null];
        }

        return view('admin.designation.list',[

            'breadcrumbs'    =>  $breadcrumbs,
            'title'          =>  $title,
            'departments'    =>  Department::latest()->get(),
            'designations'   =>  Designation::with('department')
                                ->latest()
                                ->search(['name' , 'department:name'])
                                ->paginate(paginateNumber())
                                ->appends(request()->all())
        ]);
    }

    public function store(Request $request) :RedirectResponse
    {


        $request->validate([
            'name'              => 'required',
            'department_id'     => 'required',
            'status'            => 'required',
        ]);
        $designation = Designation::create([
            'name'          => $request->input('name'),
            'department_id' => $request->input('department_id'),
            'status'        => $request->input('status'),
        ]);

        return back()->with(response_status('Designation created successfully'));
    }

    public function update(Request $request) : RedirectResponse
    {


        $request->validate([
            'uid'               => 'required|exists:designations,uid',
            'name'              => 'required',
            'department_id'     => 'required',
            'status'            => 'required',
        ]);


        $designation = Designation::whereUid($request->input('uid'))->first();

        $designation->name              = $request->input('name');
        $designation->department_id     = $request->input('department_id');
        $designation->status            = $request->input('status');
        $designation->update();

        return back()->with(response_status('Designation updated successfully '));
    }

    public function updateStatus(Request $request) {

        $request->validate([
            'id'      => 'required|exists:designations,uid',
            'status'  => ['required',Rule::in(StatusEnum::toArray())],
            'column'  => ['required',Rule::in(['status','is_feature'])],
        ]);

        return $this->changeStatus($request->except("_token"),[
            "model"    => new Designation(),
        ]);

    }

    public function destroy($uid) : RedirectResponse
    {
        $designation = Designation::whereUid($uid)->first();
        $designation->delete();
        return back()->with(response_status('Designation deleted successfully'));
    }

    public function bulk(Request $request) :RedirectResponse {

        try {
            $response =  $this->bulkAction($request,[
                "model"        => new Designation(),
                "with_count"   => ['articles','templates','childrens'],
            ]);

        } catch (\Exception $exception) {
            $response  = \response_status($exception->getMessage(),'error');
        }
        return  back()->with($response);
    }
}
