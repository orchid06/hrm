<?php

namespace App\Models;


use App\Enums\StatusEnum;
use App\Models\Admin;
use App\Models\Admin\Template;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Core\File;
use App\Models\Core\Otp;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ,Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'user_name',
        'created_by',
        'updated_by',
        'phone',
        'custom_data',
        'status',
        'kyc_verified',
        'notification_settings',
        'settings',
        'address',
        "muted_admin",
        "last_login"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at'     => 'datetime',
        'password'              => 'hashed',
        'settings'              => 'object',
        'notification_settings' => 'object',
        'address'               => 'object',
        'custom_data'           => 'object',
    ];


  
    protected static function booted(){
        static::creating(function (Model $model) {

            $model->uid        = Str::uuid();

            $model->created_by = request()->routeIs('admin.*') ? auth_user('admin')?->id : null;
            $model->status     = StatusEnum::true->status();

        });

        static::updating(function(Model $model) {

            $model->updated_by = request()->routeIs('admin.*') ? auth_user('admin')?->id : null;
        });

        static::saved(function (Model $model) {
            Cache::forget('system_users');

        });

        static::deleted(function(Model $model) {
	        Cache::forget('system_users');
	    });
    }



    public function createdBy() :BelongsTo{
        return $this->belongsTo(Admin::class,'created_by','id')->withDefault([
            'name' => 'N/A',
            'username' => 'N/A',
        ]);
    }
    public function updatedBy() :BelongsTo{
        return $this->belongsTo(Admin::class,'updated_by','id')->withDefault([
             'name' => 'N/A',
             'username' => 'N/A',
        ]);
    }


    public function file() :MorphOne{
        return $this->morphOne(File::class, 'fileable');
    }


    public function referral() :BelongsTo{

        return  $this->belongsTo(User::class,"referral_id",'id');
    }


    
    public function affilateUser() :HasMany{

        return  $this->hasMany(User::class,"referral_id",'id');
    }

    public function otp() : MorphMany{
        return $this->morphMany(Otp::class, 'otpable');
    }


    public function notifications() :MorphMany{
        return $this->morphMany(Notification::class, 'notificationable');
    }



    public function tickets() :HasMany{

        return $this->hasMany(Ticket::class,'user_id')->latest();
    }


    public function subscriptions() :HasMany{

        return $this->hasMany(Subscription::class,'user_id')->latest();
    }
    public function runningSubscription() :HasOne{

        return $this->hasOne(Subscription::class,'user_id')->running();
    }


    public function transactions() :HasMany{

        return $this->hasMany(Transaction::class,'user_id')->latest();
    }

    public function paymentLogs() :HasMany{

        return $this->hasMany(PaymentLog::class,'user_id')->latest();
    }

    public function withdraws() :HasMany{

        return $this->hasMany(WithdrawLog::class,'user_id')->latest();
    }


    public function pendingWithdraws() :HasMany{

        return $this->hasMany(WithdrawLog::class,'user_id')->pending();
    }


    public function scopeActive(Builder $q) :Builder{
        
        return $q->where("status",StatusEnum::true->status());
    }

    public function scopeBanned(Builder $q) :Builder{

        return $q->where("status",StatusEnum::false->status());
    }

    public function scopeKycverified(Builder $q) :Builder{

        return $q->where("is_kyc_verified",StatusEnum::true->status());
    }


        
    public function scopeKycbanned(Builder $q) :Builder{

        return $q->where("is_kyc_verified",StatusEnum::false->status());
    }


    public function scopeRoutefilter(Builder $q) :Builder{

        return $q->when(request()->routeIs('admin.user.banned'),function($query) {
            return $query->banned();
        })->when(request()->routeIs('admin.user.active'),function($query) {
            return $query->active();
        })->when(request()->routeIs('admin.user.kyc.verfied'),function($query) {
            return $query->kycverified();
        })->when(request()->routeIs('admin.user.kyc.banned'),function($query) {
            return $query->kycbanned();
        });
    }





    /**
     * Get all of the templates for the User
     *
     * @return HasMany
     */
    public function templates(): HasMany
    {
        return $this->hasMany(AiTemplate::class, 'user_id', 'id');
    }
    


    /**
     * Get all of the template usages for the AiTemplate
     *
     * @return HasMany
     */
    public function templateUsages(): HasMany
    {
        return $this->hasMany(TemplateUsage::class, 'user_id');
    }


    /**
     * Get all of the kyc logs 
     *
     * @return HasMany
     */
    public function kycLogs(): HasMany
    {
        return $this->hasMany(KycLog::class, 'user_id');
    }

    /**
     * Get all of credit logs
     *
     * @return HasMany
     */
    public function creditLogs(): HasMany
    {
        return $this->hasMany(CreditLog::class, 'user_id');
    }



    /**
     * Get all of social accounts
     *
     * @return HasMany
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class, 'user_id');
    }



    /**
     * Get all of social post
     *
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(SocialPost::class, 'user_id');
    }




    
    /**
     * Get all of credit logs
     *
     * @return HasMany
     */
    public function affiliates(): HasMany
    {
        return $this->hasMany(AffiliateLog::class, 'user_id');
    }


    /**
     * Get all of credit logs
     *
     * @return HasMany
     */
    public function affiliateLogs(): HasMany
    {
        return $this->hasMany(AffiliateLog::class, 'referred_to');
    }


    


    /**
     * Get the country that user bleongs to
     *
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id')->withDefault([
            'name'=> "N/A"
        ]);
    }




}
