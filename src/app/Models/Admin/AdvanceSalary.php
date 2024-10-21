<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvanceSalary extends Model
{
    use HasFactory , Filterable;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class , 'user_id');
    }

}
