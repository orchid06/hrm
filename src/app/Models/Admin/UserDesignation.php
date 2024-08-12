<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class UserDesignation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted(){
        static::creating(function (Model $model) {
            $model->uid        = Str::uuid();
        });
    }

    /**
     * Get the user
     *
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    /**
     * Get the designation of the user
     *
     * @return BelongsTo
     */
    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class, "designation_id");
    }


}
