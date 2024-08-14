<?php

namespace App\Models\Admin;

use App\Enums\StatusEnum;
use App\Models\User;
use App\Traits\Filterable;
use App\Traits\ModelAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class , "user_id");
    }
}
