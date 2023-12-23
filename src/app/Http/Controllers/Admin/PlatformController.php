<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Core\File;
use App\Models\MediaPlatform;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Traits\ModelAction;
use App\Traits\Fileable;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
class PlatformController extends Controller
{
    
    use ModelAction , Fileable;
    /**
     *
     * @return void
     */
    public function __construct()
    {

        //check permissions middleware
        $this->middleware(['permissions:view_platform'])->only(['list']);
        $this->middleware(['permissions:update_platform'])->only(['updateStatus','update','edit','bulk']);
    }


    /**
     * page list
     *
     * @return View
     */
    public function list () :View{

        return view('admin.platform.list',[

            'breadcrumbs'  => ['Home'=>'admin.home','Platforms'=> null],
            'title'        => 'Manage Platforms',
            'platforms'    => MediaPlatform::search(['name'])->get()
        ]);
    }




    /**
     * Update a specific platform comfiguration
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function configurationUpdate(Request $request) :RedirectResponse{

        $request->validate([
            "id"                            => ['required','exists:media_platforms,id'],
            "configuration"                 => ["required",'array'],
            "configuration.*"               => ["required","max:255"],
        ]);

        $platform                      = MediaPlatform::findOrfail($request->input('id'));
        $platform->configuration       = $request->input("configuration");
        $platform->save();

    
        return  back()->with(response_status('Configuration updated successfully'));
    }


    /**
     * Update a specific platform
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request) :RedirectResponse{

        $request->validate([
            "id"            => ['required','exists:media_platforms,id'],
            "description"   => ["nullable","string",'max:255']
        ]);

        DB::transaction(function() use ($request) {

            $platform                      = MediaPlatform::findOrfail($request->input('id'));
            $platform->description         = $request->input("description");
            $platform->save();

            if($request->hasFile('image')){

                $oldFile = $platform->file()->where('type','feature')->first();
                $response = $this->storeFile(
                    file        : $request->file('image'), 
                    location    : config("settings")['file_path']['platform']['path'],
                    removeFile  : $oldFile
                );

                if(isset($response['status'])){
                    $image = new File([
                        'name'      => Arr::get($response, 'name', '#'),
                        'disk'      => Arr::get($response, 'disk', 'local'),
                        'type'      => 'feature',
                        'size'      => Arr::get($response, 'size', ''),
                        'extension' => Arr::get($response, 'extension', ''),
                    ]);
                    $platform->file()->save($image);
                }
            }
        });
      
        return  back()->with(response_status('Platform updated successfully'));
    }

    /**
     * Update a specific platform status
     *
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request) :string{

        $request->validate([
            'id'      => 'required|exists:media_platforms,uid',
            'status'  => ['required',Rule::in(StatusEnum::toArray())],
            'column'  => ['required',Rule::in(['status','is_feature','is_integrated'])],
        ]);

        return $this->changeStatus($request->except("_token"),[
            "model"    => new MediaPlatform(),
        ]);
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
                "model"        => new MediaPlatform(),
            ]);
    
        } catch (\Exception $exception) {
            $response  = \response_status($exception->getMessage(),'error');
        }
        return  back()->with($response);
    }

}
