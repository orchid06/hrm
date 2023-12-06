<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Subscriber extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected static function booted(){
        static::creating(function (Model $model) {
            $model->uid        = Str::uuid();
        });
    }

    public function scopeFilter($q){
       
    }
}
