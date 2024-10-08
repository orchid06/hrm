<?php

namespace App\Models\Admin;

use App\Enums\StatusEnum;
use App\Traits\Filterable;
use App\Traits\ModelAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Department extends Model
{
    use HasFactory , Filterable ,ModelAction ;

    protected $guarded = [];

    protected static function booted(){
        static::creating(function (Model $model) {
            $model->uid        = Str::uuid();
        });
    }

    public function scopeActive(Builder $q) :Builder{
        return $q->where("status",StatusEnum::true->status());
    }

    /**
     * Get all the designations under this department
     *
     * @return HasMany
     */
    public function designations() : HasMany
    {
        return $this->hasMany(Designation::class, "department_id");
    }
}
