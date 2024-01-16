<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PostWebhookLog extends Model
{
    use HasFactory ,Filterable;
    
    protected $guarded = [];

    protected $casts = [
        'webhook_response'  => 'object',
    ];


    protected static function booted(){

        static::creating(function (Model $model) {
            $model->uid        = Str::uuid();

        });


        
    }

}
