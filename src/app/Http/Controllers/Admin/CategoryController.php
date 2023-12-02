<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Services\CategoryService;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Traits\ModelAction;
use Illuminate\Support\Facades\Route;
use App\Traits\Fileable;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends Controller
{

    use ModelAction ,Fileable;
    private $categoryService;

    /**
     *
     * @return void
     */
    public function __construct()
    {

        $this->categoryService = new CategoryService();
        //check permissions middleware
        $this->middleware(['permissions:view_category'])->only(['list']);
        $this->middleware(['permissions:create_category'])->only(['store','create']);
        $this->middleware(['permissions:update_category'])->only(['updateStatus','update','edit','bulk']);
        $this->middleware(['permissions:delete_category'])->only(['destroy','bulk']);
    }


    /**
     * category list
     *
     * @return View
     */
    public function list() :View{

        
        return view('admin.category.list',[
    
            'breadcrumbs'  =>  ['Home'=>'admin.home','Categories'=> null],
            'title'        =>  'Manage Categories',
            'categories'   =>  Category::with(['createdBy'])
                                ->withCount(['templates'])
                                ->search(['title','translations:value'])
                                ->when(request()->routeIs('admin.ai.template.categories') ,function(Builder $q){
                                    $q->template();
                                })
                                ->latest()
                                ->paginate(paginateNumber())
                                ->appends(request()->all())
        ]);
    }




    /**
     * craate a  new category
     *
     */
    public function create() :View{

        return view('admin.category.create',[
            'breadcrumbs' =>  ['Home'=>'admin.home','Categories'=> !request()->routeIs('admin.ai.template.category.create') ? 'admin.category.list' :"admin.ai.template.categories","Create" => null],
            'title'       => 'Create Category',
        ]);

    }


    /**
     * store a  new category
     *
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request) :RedirectResponse{
        $this->categoryService->save($request);
        return  back()->with(response_status('Category created successfully'));
    }


    
    /**
     * edit a category
     *
     */
    public function edit(string $uid) :View{

        return view('admin.category.edit',[
            'breadcrumbs' => ['Home'=>'admin.home','Categories'=> 'admin.category.list',"Edit" => null],
            'title'       => 'Edit Category',
            'category'    => Category::withoutGlobalScope('autoload')
                             ->with(['translations'])
                             ->where("uid",$uid)->firstOrfail(),
        ]);

    }


    /**
     * Update a specific category
     *
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function update(CategoryRequest $request) :RedirectResponse{
        
        $this->categoryService->update($request);
        return  back()->with(response_status('Category updated successfully'));
    }

    /**
     * Update a specific category status
     *
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request) :string{

        $request->validate([
            'id'      => 'required|exists:categories,uid',
            'status'  => ['required',Rule::in(StatusEnum::toArray())],
            'column'  => ['required',Rule::in(['status','is_feature'])],
        ]);

        return $this->changeStatus($request->except("_token"),[
            "model"    => new Category(),
        ]);

    }

    
    /**
     * destroy a specific category
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string | int $id) :RedirectResponse{

        $category  = Category::withCount(['articles','templates'])->where('id',$id)->firstOrfail();

        $response =  response_status('Can not be deleted!! item has related data','error');
        if(1  > $category->articles_count &&  1  > $category->templates_count){
            $category->delete();
            $response =  response_status('Item deleted succesfully');

        }
        return  back()->with($response);

    }

  /**
     * Bulk action
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function bulk(Request $request) :RedirectResponse {

        try {
            $response =  $this->bulkAction($request,[
                "model"        => new Category(),
                "with_count"   => ['articles','templates'],
            ]);
    
        } catch (\Exception $exception) {
            $response  = \response_status($exception->getMessage(),'error');
        }
        return  back()->with($response);
    }
}
