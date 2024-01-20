<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Models\Admin\Category;
use App\Models\Core\File;
use App\Models\Scopes\Global\ActiveScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;
use App\Traits\ModelAction;
use App\Traits\Filterable;
class Article extends Model
{
    use HasFactory ,ModelAction ,Filterable;

    protected $guarded = [];

    protected $casts = [
        'meta_keywords' => 'object',
    ];

    protected static function booted(){

        static::addGlobalScope(new ActiveScope());

        static::addGlobalScope('autoload', function (Builder $builder) {
            $builder->with(['category' ,'file','createdBy']);
        });

        static::creating(function (Model $model) {

            $model->uid        = Str::uuid();
            $model->created_by = auth_user()?->id;
            $model->status     = StatusEnum::true->status();
        });

        static::updating(function(Model $model) {
            $model->updated_by = auth_user()?->id;
        });

        
        static::saving(function (Model $model) {

            if(request()->input('slug') || request()->input('title') ){
                $model->slug       = make_slug(request()->input('slug')?request()->input('slug'):request()->input('title'));
            }
          
            ModelAction::saveSeo($model);
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

    public function category() :BelongsTo{
        return $this->belongsTo(Category::class, 'category_id','id');
    }


    public function createdBy() :BelongsTo{
        return $this->belongsTo(Admin::class,'created_by','id')->withDefault([
            'username' => 'N/A',
            'name' => 'N/A'
        ]);
    }
    public function updatedBy() :BelongsTo{
        return $this->belongsTo(Admin::class,'updated_by','id')->withDefault([
            'username' => 'N/A',
            'name' => 'N/A'
        ]);
    }



}
