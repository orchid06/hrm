<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;
use App\Models\Core\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;
use App\Traits\ModelAction;
use App\Traits\Filterable;
class MediaPlatform extends Model
{
    use HasFactory ,ModelAction ,Filterable;

    protected $guarded = [];

    protected $casts = [

        'meta_keywords' => 'object',
    ];

    protected static function booted(){


        static::addGlobalScope('autoload', function (Builder $builder) {
            $builder->with(['file']);
        });

        static::creating(function (Model $model) {
            $model->uid        = Str::uuid();
            $model->status     = StatusEnum::true->status();
        });


        static::saving(function (Model $model) {

            if(request()->input('name')){
                $model->slug       = make_slug(request()->input('name'));
            }
    
        });
        
    }

    public function file() :MorphOne{
         return $this->morphOne(File::class, 'fileable');
    }

    public function scopeActive(Builder $q) :Builder{
        return $q->where("status",StatusEnum::true->status());
    }

    public function scopeFeature(Builder $q) :Builder{
        return $q->where("is_feature",StatusEnum::true->status());
    }

    public function scopeIntegrated(Builder $q) :Builder{
        return $q->where("is_integrated",StatusEnum::true->status());
    }


   
}
