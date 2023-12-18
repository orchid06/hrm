<?php
namespace App\Http\Services;



use Illuminate\Http\Request;

use App\Traits\Fileable;
use App\Models\Admin\Frontend;
use App\Models\Core\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
class FrontendService
{

    use Fileable;
    


     public function save (Request $request) :array {

        $response = response_status('Saved successfully');
        try {
            DB::transaction(function() use ($request) {

                if(!$request->input('id') && $request->input('type') == 'element'){
                    
                    $frontend      = new Frontend();
                    $frontend->key =  $request->input('type') . "_" . $request->input('key');
                }
                else{
                
                    $frontend = Frontend::with(['file'])
                    ->when($request->input('id'), function (Builder $query) use($request){
                        return $query->find($request->input('id'));
                    }, function (Builder $query) use ($request) {
                        return $query->firstOrNew(['key' => $request->input('type') . "_" . $request->input('key')]);
                    });
                }
            
                $frontend->value = $request->except(['_token', 'key', 'id', 'type', 'image_input','files']);
                $frontend->save();

                if($request->input('image_input')){

                    $files = [];
                    foreach($request->input('image_input') as $k => $v){

                        $oldFile = $frontend->file()->where('type', $k)->first();
                        $response = $this->storeFile(
                            file        : $v, 
                            location    : config("settings")['file_path']['frontend']['path'],
                            removeFile  : $oldFile
                        );

                        if(isset($response['status'])){

                            $files [] = new File([
                                'name'      => Arr::get($response, 'name', '#'),
                                'disk'      => Arr::get($response, 'disk', 'local'),
                                'type'      => $k,
                                'size'      => Arr::get($response, 'size', ''),
                                'extension' => Arr::get($response, 'extension', ''),
                            ]);
                            
                        }

                    }
                    if (!empty($files)) {
                        $frontend->file()->saveMany($files);
                    }
                }
           });
        } catch (\Exception $ex) {

            $response = response_status(strip_tags($ex->getMessage()),"error");
        }

        return $response;



     }

}
