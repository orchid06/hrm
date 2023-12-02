<?php

namespace App\Models;

use App\Enums\WithdrawStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Builder;
class KycLog extends Model
{
    use HasFactory;
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
}
