<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostWebhookLog extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $casts = [
        'webhook_response'  => 'object',
    ];

}
