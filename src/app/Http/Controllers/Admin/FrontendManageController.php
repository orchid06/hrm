<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FrontendSectionRequest;
use App\Http\Services\FrontendService;
use Illuminate\Http\Request;
use App\Models\Admin\Frontend;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Traits\Fileable;
use Illuminate\Validation\Rule;
use App\Traits\ModelAction;
use Illuminate\Support\Facades\DB;

class FrontendManageController extends Controller
{

    use Fileable ,ModelAction;
    private  $frontEndService;

    /**
     *
     * @return void
     */
    public function __construct()
    {

        $this->frontEndService = new FrontendService();
        $this->middleware(['permissions:view_frontend'])->only('list');
        $this->middleware(['permissions:update_frontend'])->only(['update','updateStatus','bulk','destroy']);
    }



    /**
     * manage frontend
     *
     * @return View
     */
    public function list(string $key) :View
    {
        $appearance = @get_appearance()->{$key};
        if (!$appearance)   abort(404);
        return view('admin.frontend.list',[
            'breadcrumbs'            =>  ['Home'=>'admin.home','Frontends'=> null],
            'title'                  =>  ucFirst(str_replace("_"," ",$appearance->name)),
            "appearance"             =>  $appearance,
            'appearance_content'     =>  Frontend::with(['file'])->where('key','content_'.$key )->first(),
            'appearance_elements'    =>  Frontend::with(['file'])->where('key', 'element_'.$key)->latest()->get()
        ]);

    }


    /**
     * update forntend section
     */

     public function update(FrontendSectionRequest $request) :RedirectResponse {

        return back()->with( $this->frontEndService->save($request));
     }


    
    /**
     * Update status
     *
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request) :string{

        $request->validate([
            'id'      => 'required|exists:frontends,uid',
            'status'  => ['required',Rule::in(StatusEnum::toArray())],
            'column'  => ['required',Rule::in(['status'])],
        ]);

        return $this->changeStatus($request->except("_token"),[
            "model"    => new Frontend(),
        ]);

    }

     /**
     * destroy a specific payment method
     *
     * @param string $uid
     * @return RedirectResponse
     */
    public function destroy(string $id) :RedirectResponse{


        DB::transaction(function() use ($id) {

            $frontend  =  Frontend::with('file')
                                ->withCount('file')
                                ->where('id',$id)
                                ->firstOrFail();

            if(0 < $frontend->file_count){
                foreach($frontend->file as $file){
                        $this->unlink(
                            location    : config("settings")['file_path']['frontend']['path'],
                            file        :  $file
                        );
                }

            }
            $frontend->delete();
        });
    
        return  back()->with(response_status('Deleted successfully'));
    }


    public function bulk(Request $request) :RedirectResponse {

        try {
            $response =  $this->bulkAction($request,[
                "model"        => new Frontend(),
            ]);
    
        } catch (\Exception $exception) {
            $response  = \response_status($exception->getMessage(),'error');
        }
        return  back()->with($response);
        
    }



}
