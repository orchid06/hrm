<?php

namespace App\Models\admin;

use App\Enums\StatusEnum;
use App\Traits\Filterable;
use App\Traits\ModelAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory , Filterable ,ModelAction;

    protected $guarded = [];

    /**
     * Get the category this expense bleongs to
     *
     * @return BelongsTo
     */
    public function department() : BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, "expense_category_id");
    }
}
