<?php

namespace App\Traits;

use App\Enums\AccountType;
use App\Enums\StatusEnum;
use App\Http\Services\UserService;
use App\Models\CreditLog;
use App\Models\MediaPlatform;
use App\Models\SocialAccount;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Cookie\CookieJar;

trait AccoutManager
{


    protected $userService;

    public function __construct(){

        $this->userService = new UserService();
    }


    /**
     * Save social account
     *
     * @param string $guard
     * @param MediaPlatform $platform
     * @param array $accountInfo
     * @param string $account_type
     * @return array
     */
    protected function saveAccount(string $guard , MediaPlatform $platform , array $accountInfo, string  $account_type , string $is_official ) :array{

        $socialAccount = DB::transaction(function() use ($guard,$platform,$accountInfo,$account_type ,$is_official ) {

                        $user = auth_user($guard);
                        $accountId = Arr::get($accountInfo,"id",null);

                        $account = SocialAccount::firstOrNew(['account_id' => $accountId ,'platform_id' => $platform->id ]);
                        $account->platform_id                 = $platform->id;
                        $account->name                        = Arr::get($accountInfo,'name');
                        $account->account_information         = $accountInfo;
                        $account->status                      = StatusEnum::true->status();
                        $account->account_type                = $account_type;
                        $account->is_official                 = $is_official;

                        switch ($guard) {
                            case 'web':
                                $account->subscription_id = $user->runningSubscription?->id;
                                $account->user_id         = $user->id;
                                break;
                            case 'admin':
                                $account->admin_id        = $user->id;
                                break;
                        }
                        
                        $account->save();

                        if($account->user_id){

                            $this->generateCreditLog(
                                user        : $user,
                                trxType     : Transaction::$MINUS,
                                postBalance : (int)$user->runningSubscription->total_profile,
                                details     :  'A new '. $platform->name .' Account Created',
                                remark      : t2k("profile_credit"),
                            );

                            $user->runningSubscription->decrement('total_profile',1);

                        }

                        return $account;

                    });


        return [
            'status'  => true,
            'account' => $socialAccount
        ];


    }



    /**
     * Generate credit log
     *
     * @param User $user
     * @param string $trxType
     * @param integer $balance
     * @param integer $postBalance
     * @param string $details
     * @param string $remark
     * @return CreditLog
     */
    public function generateCreditLog(User $user, string  $trxType , int $balance = 1 , int $postBalance ,string $details ,string $remark) : CreditLog {

        $creditLog                   = new CreditLog();
        $creditLog->user_id          = $user->id;
        $creditLog->subscription_id  = $user->runningSubscription->id;
        $creditLog->trx_code         = trx_number();
        $creditLog->type             = $trxType;
        $creditLog->balance          = $balance;
        $creditLog->post_balance     = $postBalance;
        $creditLog->details          = $details;
        $creditLog->remark           = $remark;
        $creditLog->save();
        return $creditLog;

    }


}