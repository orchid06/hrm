<?php

namespace App\Models;

use App\Models\Admin\Currency;
use App\Models\Admin\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Filterable;

class Transaction extends Model
{
    use HasFactory ,Filterable;

    public static $PLUS  = '+';
    public static $MINUS = '-';

    protected $guarded = [];


    public function user() :BelongsTo{

        return $this->belongsTo(User::class,'user_id','id')->withDefault([
            'username' => 'N/A',
            'name'     => 'N/A',
        ]);
    }

    public function admin() :BelongsTo{

        return $this->belongsTo(Admin::class,'admin_id','id')->withDefault([
            'name' => 'N/A',
            'username' => 'N/A',
        ]);
    }


    
    public function currency() :BelongsTo{

        return $this->belongsTo(Currency::class,'currency_id','id')->withDefault([
            'name'           => 'N/A',
            'exchange_rate'  => 1,
        ]);
    }






}
