<?php

namespace App\Models\Admin;


use App\Models\Core\File;
use App\Traits\Filterable;
use App\Traits\ModelAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Expense extends Model
{
    use HasFactory , Filterable ,ModelAction;

    protected $guarded = [];

    protected static function booted(){
        static::creating(function (Model $model) {
            $model->uid        = Str::uuid();
        });
    }

    /**
     * Get the category this expense bleongs to
     *
     * @return BelongsTo
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, "expense_category_id");
    }

    public function file(): MorphMany{
        return $this->morphMany(File::class, 'fileable');
    }
}
