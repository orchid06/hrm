<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory , Filterable;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class , 'user_id');
    }
}
