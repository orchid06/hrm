<?php

namespace App\Traits;

use App\Enums\StatusEnum;
use App\Models\ModelTranslation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Traits\Fileable;
use Illuminate\Database\Eloquent\Model;
trait ModelAction
{

    use Fileable;
    /**
     * Change a model status
     *
     * @param array $request
     * @param array $modelData
     * @return array
     */
    private function changeStatus(array $request , array $modelData ) :string{

        $response['reload']   = Arr::get($modelData,'reload','true');
        $response['status']   = false;
        $response['message']  = trans('default.failed_to_update');
   

        try {
            $data = Arr::get($modelData,'model',null)::where(Arr::get($modelData,'find_by','uid'),Arr::get($request,'id',''))
                   ->when(Arr::get($modelData,'recycle',false) , function($q){
                      return $q->withTrashed();
                   })->when(Arr::get($modelData,'user_id',null) , function($q) use($modelData){
                         return $q->where('user_id',Arr::get($modelData,'user_id'));
                    })
                   ->firstOrfail();
            $data->{Arr::get($request,'column','status')} =  Arr::get($request,'status',null);
            $data->save();
            
            $response['status']  = true;
            $response['message'] = trans('default.updated_successfully');

           
        } catch (\Throwable $th) {
      
        }

        return json_encode($response);

    }



    private function saveTranslation(mixed $model ,array $data ,string $key ) :void{

            $translations = [];
            $model->translations()->where("key",$key)->delete();
            foreach ($data as $locale => $value) {
                if ($value && $locale != 'default') {
                    $translations[] = new ModelTranslation([
                        'locale' => $locale,
                        'key'    => $key,
                        'value'  => $value,
                    ]);
                }
            }

            if (!empty($translations)) {
                $model->translations()->saveMany($translations);
            }

    }


    protected function parseManualParameters() :array{
    
        $parameter = [];
        if (request()->has('field_name')) {
            for ($i = 0; $i < count(request()->field_name); $i++) {
                $arr = [];
                $arr['field_name']             = t2k(request()->field_name[$i]);
                $arr['field_label']            = request()->field_name[$i];
                $arr['type']                   = request()->type[$i];
                $arr['validation']             = request()->validation[$i];
                $parameter[$arr['field_name']] = $arr;
            }
        }
        return $parameter;
    }

    


    /**
     * Bulk action update/delete
     *
     * @param Request $request
     * @param array $modelData
     * @return array
     */
    private function bulkAction(Request $request , array $modelData ) :array{
        
        $response =  response_status('Items status updated successfully');
        if ($request->get("type") == 'restore') {
            $response =  response_status('Items restored successfully');
        } elseif ($request->get("type") == 'force_delete') {
            $response =  response_status('Items without any related data have been permanently deleted');
        } elseif ($request->get("type") == 'delete') {
            $response =  response_status('Items without any related data have been deleted');
        }
        
        $bulkIds = json_decode($request->input('bulk_id'), true);
 
        $request->merge([
            "bulk_id" =>  $bulkIds
        ]);

        $tableName = Arr::get($modelData,'model',null)->getTable();

        $rules = [
            'bulk_id'    => ['array', 'required'],
            'bulk_id.*'  => ["required",'exists:'.$tableName.',id'],
            'type'       => ['required', Rule::in(['status', 'delete', 'restore',"force_delete","is_feature",'is_blocked'])],
            'value'      => [
                Rule::requiredIf(function () use ($request) {
                    return in_array($request->get("type"),['status','is_feature','is_blocked']);
                }),
                function ($attribute, $value, $fail) use ($request) {
                    if (in_array($request->get("type"),['status','is_feature','is_blocked']) && !in_array($value, StatusEnum::toArray())) {
                        $fail("The {$attribute} is invalid.");
                    }
                },
            ]
        ];

        $request->validate($rules);
        $bulkIds  = $request->get('bulk_id');
        if(in_array($request->get("type"),['status','is_feature','is_blocked'])){
            Arr::get($modelData,'model',null)::whereIn('id',$bulkIds)
              ->when(Arr::get($modelData,'recycle',false) , function($q){
                return $q->withTrashed();
             })
             ->lazyById(100)
            ->each->update([$request->input("type") => $request->input('value')]);
        }
        else{

            $records = Arr::get($modelData, 'model', null)
                ->when(in_array($request->get("type"), ['restore', 'force_delete']), function ($query) {
                    return $query->withTrashed();
                })
                ->withCount(Arr::get($modelData, 'with_count', []))
                ->with(Arr::get($modelData, 'with', []))
                ->whereIn('id', $bulkIds)
                ->cursor();

            foreach ($records as $record) {

                if ($request->get("type") == 'restore') {
                    $record->restore();
                } elseif ($request->get("type") == 'force_delete') {
                    $this->handleForceDelete($record, $modelData);
                } else {
                    $this->handleDefaultDelete($record, $modelData);
                }
            }

        }

        return $response;

    }


    /**
     * force delete
     *
     * @param mixed $record
     * @param array $modelData
     * @return void
     */
    private function handleForceDelete(mixed $record, array $modelData) :void {

        if(isset($modelData['force_flag'])){
            $this->unlinkData($record , $modelData);
        }
        $record->forceDelete();
    }
    
    /**
     * regular delete
     *
     * @param mixed $record
     * @param array $modelData
     * @return void
     */
    private function handleDefaultDelete(mixed $record, array $modelData) :void {

        $relationals = Arr::get($modelData, 'with_count', []);
        $flag        = true;

        foreach ($relationals as $relation) {
            if ($record->{$relation . "_count"} > 0) {
                $flag = false;
                break;
            }
        }
    
        if ($flag) {
            if(!isset($modelData['force_flag'])){
               $this->unlinkData($record , $modelData);
            }
            $record->delete();
        }
    }


    /**
     * Unlink and delete relational data
     *
     * @param mixed $record
     * @param array $modelData
     * @return void
     */
    private function unlinkData(mixed $record , array $modelData) :void{

        //unlink and delete file
        if(isset($modelData['file_unlink'])){
            foreach($modelData['file_unlink'] as $k => $v){
                $files = $record->file()->where('type',$k)->get();
                foreach($files as $file){
                    $this->unlink(
                        location    : $v,
                        file        : $file
                    );
                }
            }
        }
        //delete relational data
        if(isset($modelData['with'])){
            foreach($modelData['with'] as $v){
                if($v == 'file'){
                    continue;
                }
                $record->{$v}()->delete();
            }
        }
        
    }



    public static function saveSeo(Model $model) :void{

        $fillableKeys = ['meta_title', 'meta_description', 'meta_keywords'];
        $data = [];
        foreach ($fillableKeys as $key) {
            if (request()->filled($key)) {
                $data[$key] = request()->input($key);
            }
        }
        $model->fill($data);
    }


    
}