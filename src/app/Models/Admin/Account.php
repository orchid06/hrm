<?php

namespace App\Models\Admin;

use App\Models\Core\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\ModelAction;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Account extends Model
{
    use HasFactory ,  Filterable ,ModelAction;

    protected $guarded = [];

    public function file(): MorphMany{
        return $this->morphMany(File::class, 'fileable');
    }
}
