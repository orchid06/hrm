<?php

namespace App\Models;

use App\Enums\WithdrawStatus;
use App\Models\Core\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KycLog extends Model
{
    use HasFactory , Filterable;
    protected $guarded = [];


    protected $casts = [
        'kyc_data' => 'object',
    ];


    public function file() :MorphMany{
        
        return $this->morphMany(File::class, 'fileable');
    }

    public function scopePending(Builder $q) :Builder{

        return $q->where('status',WithdrawStatus::value("PENDING",true));
    }

    public function user() :BelongsTo{
        
        return $this->belongsTo(User::class,'user_id');
    }
}
