<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MenuVisibilty;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Models\Admin\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Traits\ModelAction;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
class MenuController extends Controller
{

    use ModelAction;
    /**
     *
     * @return void
     */
    public function __construct()
    {

        //check permissions middleware
        $this->middleware(['permissions:view_menu'])->only('list');
        $this->middleware(['permissions:create_menu'])->only(['store']);
        $this->middleware(['permissions:update_menu'])->only(['updateStatus','update','edit','bulk']);
        $this->middleware(['permissions:delete_menu'])->only(['destroy']);
    }


    /**
     * menu list
     *
     * @return View
     */
    public function list() :View{


        $menu      = Menu::with(['createdBy'])->orderBy('serial_id','desc')->first();
        $serialId  = $menu ? $menu->serial_id + 1 : 1;
        return view('admin.menu.list',[
            'breadcrumbs' =>  ['Home'=>'admin.home','Menus'=> null],
            'title'       => 'Manage Menu',
            'menus'       =>  Menu::search(['name'])->with(['createdBy'])
                             ->latest()
                            ->paginate(paginateNumber()),
            "serialId"    =>  $serialId,
        ]);
    }


    /**
     * edit menu
     *
     * @return View
     */
    public function edit(string $uid) :View{

        return view('admin.menu.edit',[
            'breadcrumbs' => ['Home'=>'admin.home','Menu'=> 'admin.menu.list' ,'Edit'=>null],
            'title'       => 'Edit Menu',
            'menu'        => Menu::where('uid',$uid)->firstOrFail(),
        ]);
    }



    /**
     * store a  new menu
     *
     * @param MenuRequest $request
     * @return RedirectResponse
     */
    public function store(MenuRequest $request) :RedirectResponse{

        $menu  = new Menu();
        $menu->serial_id              =  $request->input("serial_id");
        $menu->name                   =  $request->input("name");
        $menu->url                    =  $request->input("url");
        $menu->save();
        return  back()->with(response_status('Menu created successfully'));
    }



    /**
     * Update a specific menu
     *
     * @param MenuRequest $request
     * @return RedirectResponse
     */
    public function update(MenuRequest $request) :RedirectResponse{


        $menu                         =  Menu::findOrFail($request->input('id'));
        $menu->serial_id              =  $request->input("serial_id");
        $menu->name                   =  $request->input("name");
        $menu->url                    =  $request->input("url");
        $menu->menu_visibility        =  $request->input("menu_visibility") ?? MenuVisibilty::value("Both") ;
        $menu->save();
   
        return  back()->with(response_status('Menu updated successfully'));
    }

    /**
     * Update a specific Menu status
     *
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request) :string{
        $request->validate([
            'id'      => 'required|exists:menus,uid',
            'status'  => ['required',Rule::in(StatusEnum::toArray())],
            'column'  => ['required',Rule::in(['status','show_in_footer','show_in_header'])],
        ]);

        return $this->changeStatus($request->except("_token"),[
            "model"    => new Menu(),
        ]);
        
    }


   
    public function destroy(string $id) :RedirectResponse{

        Menu::where('id',$id)->delete();
        return  back()->with(response_status('Menu deleted!!'));
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
                "model"        => new Menu(),
            ]);
    
        } catch (\Exception $exception) {
            $response  = \response_status($exception->getMessage(),'error');
        }
        return  back()->with($response);
       
    }
}
