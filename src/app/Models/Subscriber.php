<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected static function booted(){
        static::creating(function ($subs) {
            $subs->uid = str_unique();
        });
    }

    public function scopeFilter($q){
        return $q->when(request()->email,function($query) {
            return $query->where("email",request()->email);
        });
    }
}
