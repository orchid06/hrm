<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\ModelAction;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\StatusEnum;

class LeaveType extends Model
{
    use HasFactory,  Filterable ,ModelAction;

    protected $guarded = [];

    protected static function booted(){
        static::creating(function (Model $model) {
            $model->uid        = Str::uuid();
        });
    }

    public function scopeActive(Builder $q) :Builder{
        return $q->where("status",StatusEnum::true->status());
    }
}
