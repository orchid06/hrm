<?php

namespace App\Models\Admin;

use App\Enums\StatusEnum;
use App\Models\Admin;
use App\Models\Core\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Frontend extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'value' => 'object',
    ];
    protected static function booted(){
        static::creating(function (Model $model) {
            $model->uid        = Str::uuid();
            $model->status     = StatusEnum::true->status();

        });
        static::saved(function(Model $model) {
            $model->updated_by = auth_user()->id;
        });
    }
    public function file() :MorphMany{
        return $this->morphMany(File::class, 'fileable');
    }

    public function updatedBy() :BelongsTo{
        return $this->belongsTo(Admin::class,'updated_by','id')->withDefault([
            'username' => 'N/A',
            'name' => 'N/A'
        ]);
    }
}
