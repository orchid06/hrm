<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\ModelAction;

class CashIn extends Model
{
    use HasFactory ,  Filterable ,ModelAction;

    protected $guarded = [];


}
