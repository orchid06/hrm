<?php

namespace App\Models;

use App\Models\Core\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\ModelAction;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Leave extends Model
{
    use HasFactory , Filterable ,ModelAction;

    protected $guarded = [];

    protected $casts = [
        'leave_request_data' => 'object',
    ];

    public function file(): MorphMany{
        return $this->morphMany(File::class, 'fileable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }
}
