<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Models\Core\File;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
class SocialPost extends Model
{
    use HasFactory;

    use HasFactory , Filterable;

    protected $casts = [
        'platform_response' => 'object',
    ];


    protected $guarded = [];


    protected static function booted(){
        static::creating(function (Model $model) {
            $model->uid        = Str::uuid();
        });
    }

    public function file() :MorphMany{
        return $this->morphMany(File::class, 'fileable');
    }

    public function user() :BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }


    public function admin() :BelongsTo{
        return $this->belongsTo(Admin::class, 'admin_id');
    }


    public function account() :BelongsTo{
        return $this->belongsTo(SocialAccount::class, 'account_id');
    }

    public function scopePending(Builder $q) :Builder{
        return $q->where('status',strval(PostStatus::Pending->value));
    }

    public function scopeSuccess(Builder $q) :Builder{
        return $q->where('status',strval(PostStatus::Success->value));
    }

    public function scopeSchedule(Builder $q) :Builder{
        return $q->where('status',strval(PostStatus::Schedule->value));
    }

    public function scopeFailed(Builder $q) :Builder{
        return $q->where('status',strval(PostStatus::Failed->value));
    }

}
