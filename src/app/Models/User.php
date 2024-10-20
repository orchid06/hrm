<?php

namespace App\Models;


use App\Enums\StatusEnum;
use App\Models\Admin;
use App\Models\Admin\AdvanceSalary;
use App\Models\Admin\BankAccount;
use App\Models\Admin\Payroll;
use App\Models\Admin\UserDesignation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Core\File;
use App\Models\Core\Otp;
use App\Traits\Filterable;
use Carbon\Carbon;
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
        "last_login",
        "custom_office_hour"
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




    /**
     * Get the admin who crate the record
     *
     * @return BelongsTo
     */
    public function createdBy():BelongsTo {
        return $this->belongsTo(Admin::class,'created_by','id')->withDefault([
            'name'     => translate("System"),
            'username' => translate("System"),
        ]);
    }



    /**
     * Get the admin who updated a record
     *
     * @return BelongsTo
     */
    public function updatedBy():BelongsTo {
        return $this->belongsTo(Admin::class,'updated_by','id')->withDefault([
            'name'     => translate("System"),
            'username' => translate("System"),
        ]);
    }

    /**
     * get user files
     *
     * @return MorphOne
     */
    public function file():MorphOne {
        return $this->morphOne(File::class, 'fileable');
    }

    /**
     * Get user OTP
     *
     * @return MorphMany
     */
    public function otp():MorphMany {
        return $this->morphMany(Otp::class, 'otpable');
    }


    /**
     * Get all notifications
     *
     * @return MorphMany
     */
    public function notifications(): MorphMany{
        return $this->morphMany(Notification::class, 'notificationable');
    }

    /**
     * Get all tickets
     *
     * @return HasMany
     */
    public function tickets():HasMany {
        return $this->hasMany(Ticket::class,'user_id')->latest();
    }



    /**
     * Get all transactions
     *
     * @return HasMany
     */
    public function transactions(): HasMany{
        return $this->hasMany(Transaction::class,'user_id')->latest();
    }



    /**
     * Get active users
     *
     * @param Builder $q
     * @return Builder
     */
    public function scopeActive(Builder $q): Builder{
        return $q->where("status",StatusEnum::true->status());
    }


    /**
     * Get banned users
     *
     * @param Builder $q
     * @return Builder
     */
    public function scopeBanned(Builder $q): Builder{
        return $q->where("status",StatusEnum::false->status());
    }


    /**
     * Get KYC verified users
     *
     * @param Builder $q
     * @return Builder
     */
    public function scopeKycverified(Builder $q): Builder{
        return $q->where("is_kyc_verified",StatusEnum::true->status());
    }


    /**
     * Get KYC banned user
     *
     * @param Builder $q
     * @return Builder
     */
    public function scopeKycbanned(Builder $q): Builder{
        return $q->where("is_kyc_verified",StatusEnum::false->status());
    }



    /**
     * Get all of the template usages for the AiTemplate
     *
     * @return HasMany
     */
    public function templateUsages(): HasMany{
        return $this->hasMany(TemplateUsage::class, 'user_id');
    }


    /**
     * Get all of the kyc logs
     *
     * @return HasMany
     */
    public function kycLogs(): HasMany{
        return $this->hasMany(KycLog::class, 'user_id');
    }



    /**
     * Get the country that user bleongs to
     *
     * @return BelongsTo
     */
    public function country(): BelongsTo{
        return $this->belongsTo(Country::class, 'country_id')->withDefault([
            'name'=> "N/A"
        ]);
    }


    /**
     * Get bank information of users
     *
     * @return HasMany
     */
    public function bank_accounts(): HasMany
    {
        return $this->hasMany(BankAccount::class);
    }

    /**
     * Get all of designation related to this user
     *
     * @return HasMany
     */
    public function designations(): HasMany
    {
        return $this->hasMany(UserDesignation::class);
    }

    public function userDesignation():HasOne
    {
        return $this->hasOne(UserDesignation::class,"user_id")->where('status', StatusEnum::true->status());
    }

    public function payrolls() : HasMany
    {
        return $this->hasMany(Payroll::class , 'user_id');
    }

    public function payslip (): HasOne
    {
        return $this->hasOne(Payroll::class, 'user_id')
                    ->where('pay_period', Carbon::now()->format('Y-m'));
    }

    public function attendances (): HasMany
    {
        return $this->hasMany(Attendance::class , 'user_id');
    }

    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class , 'user_id');
    }

    public function advanceSalaries(): HasMany
    {
        return $this->hasMany(AdvanceSalary::class , 'user_id');
    }





    /**
     * Scope route filter
     *
     * @param Builder $q
     * @return Builder
     */
    public function scopeRoutefilter(Builder $q): Builder{

        return $q->when(request()->routeIs('admin.user.banned'),fn(Builder $query): Builder=> $query->banned())
                 ->when(request()->routeIs('admin.user.active'),fn(Builder $query): Builder => $query->active())
                 ->when(request()->routeIs('admin.user.kyc.verfied'),fn(Builder $query): Builder => $query->kycverified())
                 ->when(request()->routeIs('admin.user.kyc.banned'),fn(Builder $query): Builder => $query->kycbanned())
                 ->when(request()->routeIs('admin.user.banned'),fn(Builder $query): Builder =>  $query->kycbanned());
    }




}
