<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Traits\ModelAction;

class Leave extends Model
{
    use HasFactory , Filterable ,ModelAction;
}
