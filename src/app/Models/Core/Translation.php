<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;
    protected static function booted()
    {
        static::creating(function ($translation) {
            $translation->uid = str_unique();
        });
    }
    protected $guarded = [];
}
