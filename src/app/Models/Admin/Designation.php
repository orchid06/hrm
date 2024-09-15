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
use Illuminate\Database\Eloquent\Relations\HasMany;

class Designation extends Model
{
    use HasFactory, Filterable, ModelAction;

    protected $guarded = [];

    protected static function booted()
    {

        static::creating(function (Model $model) {
            $model->uid        = Str::uuid();
        });
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where("status", StatusEnum::true->status());
    }

    /**
     * Get the department this designation bleongs to
     *
     * @return BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, "department_id");
    }


    /**
     * Get all of users under this designation
     *
     * @return HasMany
     */
    public function userDesignations(): HasMany
    {
        return $this->hasMany(UserDesignation::class, "designation_id");
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, UserDesignation::class, 'designation_id', 'id', 'id', 'user_id');
    }
}
