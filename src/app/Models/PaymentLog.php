<?php

namespace App\Models;

use App\Enums\DepositStatus;
use App\Enums\StatusEnum;
use App\Models\Admin\Currency;
use App\Models\Admin\PaymentMethod;
use App\Models\Core\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

use App\Traits\ModelAction;
use App\Traits\Filterable;
class PaymentLog extends Model
{
    use HasFactory ,Filterable;


    protected $guarded = [];

    protected $casts = [
        'custom_data' => 'object',
    ];


    public function user() :BelongsTo {

        return $this->belongsTo(User::class,'user_id','id')->withDefault([
            'username' => 'N/A',
            'name'     => 'N/A',
        ]);
    }
    public function method() :BelongsTo {
        return $this->belongsTo(PaymentMethod::class,'method_id','id')->withDefault([
            'name' => 'N/A',
        ]);
    }

    public function currency() :BelongsTo {

        return $this->belongsTo(Currency::class,'currency_id','id')->withDefault([
            'name' => 'N/A',
        ]);
    }
  

    public function file() :MorphMany {
        return $this->morphMany(File::class, 'fileable');
    }


    public function scopePending(Builder $q) :Builder{

        return $q->where('status',DepositStatus::value("PENDING",true));
    }


}
