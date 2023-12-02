<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AffiliateLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() :BelongsTo{

        return $this->belongsTo(User::class, "user_id");
    }


    public function referral() :BelongsTo{

        return $this->belongsTo(User::class, "referral_id");
    }

    public function subscription() :BelongsTo{

        return $this->belongsTo(Subscription::class, "subscription_id");
    }
}
