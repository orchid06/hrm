<?php

namespace App\Traits;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
  
    /**
     * Get Only Recycled Data
     *
     * @param Builder $q
     * @return Builder
     */
    public function scopeRecycle(Builder $q) :Builder{
        return $q->when(request()->routeIs('admin.*.recycle.list'),function($query) {
            return $query->onlyTrashed();
        });
    }

    /**
     * scope search filter
     *
     * @param Builder $query
     * @param array $params
     * @param boolean $like
     * @return Builder
     */
    public function scopeSearch(Builder $query,array $params,bool $like = true)  :Builder{

        $search = request()->input("search");
        if (!$search) {
            return $query;
        }
        $search = $like ? "%$search%" : $search;

        $query->where(function(Builder $q) use ($params, $search) {
            foreach ($params as $key => $param) {
                $relations = explode(':', $param);
                if (isset($relations[1])) {
                    $q = $this->searchRelationalData($q,$relations,$search);
                }else{
                    $q->orWhere($param, 'LIKE', $search);
                }
            }
        });

        return $query;
    }


    /**
     * scope filter
     *
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function scopeFilter(Builder $query,array $params) :Builder {

        foreach ($params as $param) {
            $relations = explode(':', $param);
      
            $filters = array_keys(request()->all());
            if (isset($relations[1])) {
       
                $query = $this->filterRelationalData($query,$relations,$filters);
            }else{
                if (in_array($param, $filters) && request()->{$param} != null) {
                    if(gettype(request()->{$param}) == 'array' ){
                        $query->whereIn($param, request()->{$param});
                    }else{
                        $query->where($param, request()->{$param});
                    }
                }
            }
   
        }


        return $query;


    }

    /**
     * Date Filter
     *
     * @param Builder $query
     * @param string $column
     * @return Builder
     */
    public function scopeDate(Builder $query, string $column = 'created_at') : Builder {

        if (!request()->date) {
            return $query;
        }
        $dateRangeString             = request()->date;
        $start_date                  = $dateRangeString;
        $end_date                    = $dateRangeString;
        if (strpos($dateRangeString, ' to ') !== false) {
            list($start_date, $end_date) = explode(" to ", $dateRangeString);
        } 

        return $query->where(function ($query) use ($start_date, $end_date ,$column ) {
            $query->whereBetween($column , [$start_date, $end_date])
                ->orWhereDate($column , $start_date)
                ->orWhereDate($column , $end_date);
        });

    }


    /**
     * Search relational data
     *
     * @param Builder $query
     * @param array  $relations
     * @param string $search
     * @return Builder
     */
    private function searchRelationalData(Builder $query,array $relations, string $search) :Builder{

        foreach (explode(',',$relations[1]) as $column) {
            $query->orWhereHas($relations[0], function (Builder $q) use ($column,$search) {

                $q->when(method_exists($q->getModel(), 'translations'), function($query) use($search ,$column) {
                     $query->whereHas('translations',function($q ) use($search ,$column){
                                        $q->where('value',"like",$search);
                                    })->orwhere($column,'like',$search);
                },function (Builder $query)  use($search ,$column){
                    $query->where($column,'like',$search);
                });
             
            });
        }
        return $query;
    }


    /**
     * filter relational data
     *
     * @param Builder $query
     * @param array $relations
     * @param array $filters
     * @return Builder
     */
    private function filterRelationalData(Builder $query,array $relations,array $filters) :Builder {

        foreach (explode(',', $relations[1]) as $column) {
  
            if (in_array($relations[0], $filters) && request()->{$relations[0]} != null) {
                $query->whereHas($relations[0],function($q) use ($column,$relations){
                
                    $q->when(method_exists($q->getModel(), 'translations'), function($query) use($relations ,$column) {
                            $query->whereHas('translations',function($q ) use($relations){
                                $q->where('value',request()->{$relations[0]});
                            })->orwhere($column,request()->{$relations[0]});
                    },function (Builder $query)  use($relations ,$column){
                        $query->where($column,request()->{$relations[0]});
                    });
               
                });
            }
        }

        return $query;
    }

}