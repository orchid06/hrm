<?php

namespace App\Traits;

use App\Enums\StatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

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

        if (!$search) return $query;
        $search = $like ? "%$search%" : $search;
        $query->where(function(Builder $q) use ($params, $search) {
            collect($params)->map(function(string $param) use($q,$search) :void {
                $relations = explode(':', $param);
                switch (count($relations)) {
                    case 2:
                        $q = $this->searchRelationalData($q, $relations, $search);
                        break;
                    default:
                        $q->orWhere($param, 'LIKE', $search);
                        break;
                }
   
            });
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


        collect($params)->map(function(string $param) use($query){

            $relations = explode(':', $param);
            $filters   = array_keys(request()->all());

            switch (count($relations)) {
                case 2:
                    $query = $this->filterRelationalData($query, $relations, $filters);
                    break;
            
                default:
                   $query->when(in_array($param, $filters) && request()->input($param) !== null , fn(Builder $query) : Builder => 
                        $query->when(gettype(request()->input($param)) === 'array' , fn(Builder $query) : Builder => $query->whereIn($param,  request()->input($param)), fn(Builder $query) : Builder =>  $query->where($param, request()->input($param)))
                   );
                break;
            }

        });

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

        if (!request()->input('date'))   return $query;

            $dateRangeString             = request()->input('date');
            $start_date                  = $dateRangeString;
            $end_date                    = $dateRangeString;
            if (strpos($dateRangeString, ' - ') !== false) list($start_date, $end_date) = explode(" - ", $dateRangeString); 

            $start_date = Carbon::createFromFormat('m/d/Y', $start_date)->format('Y-m-d');
            $end_date   = Carbon::createFromFormat('m/d/Y', $end_date)->format('Y-m-d');

            return $query->where(fn (Builder $query) :Builder =>  
                            $query->whereBetween($column , [$start_date, $end_date])
                                    ->orWhereDate($column , $start_date)
                                    ->orWhereDate($column , $end_date));

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

        $relation = Arr::get($relations , 0);
        collect(explode(',', $relations[1]))->map(fn(string $column) : Builder => 
            $query->orWhereHas( $relation , fn (Builder $q)  : Builder =>  $q->where($column,'like',$search))
        );

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

        $relation = Arr::get($relations , 0);
        collect(explode(',', $relations[1]))->map( fn(string $column) :Builder =>
                $query->when(in_array($relation, $filters) && request()->input($relation) != null ,fn(Builder $query) :Builder => $query->whereHas($relation,fn(Builder $q) :Builder => $q->where($column,request()->input($relation)))));

        return $query;
    }

}