<?php
namespace App\Http\Services\User;

use App\Enums\StatusEnum;
use App\Http\Utility\SendMail;
use App\Http\Utility\SendSMS;
use App\Models\Admin;
use App\Models\Core\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Closure;
use Illuminate\Support\Facades\Http;

class AuthService 
{


    
    /**
     * send otp method
     *
     * @return array
     */
    public function sendOtp(mixed $sendTo ,string $template = "PASSWORD_RESET" , string $medium = 'email' ) :array {
        
        #send mail
        $code = generateOTP();
        $templateCode = [
            'name'    => $sendTo->name,
            'code'    => $code,
            'time'    => Carbon::now(),
        ];

        $sendTo->otp()->delete();

        $expiredTime = (int) site_settings('otp_expired_in');

        $otp               = new Otp();
        $otp->otp          = $code;
        $otp->type         = strtolower($template);
        $otp->expired_at   = Carbon::now()->addSeconds($expiredTime);
        
        $sendTo->otp()->save($otp);

        $otpMethod =  [
            "sms"       => "App\Http\Utility\SendSMS",
            "email"     => "App\Http\Utility\SendMail",
        ];
        $method    =  $medium == 'sms' ? "smsNotification" : "mailNotifications" ;

        $response  =  Arr::get($otpMethod, $medium,"")::{$method}($template,$templateCode ,$sendTo);

        $response["otp"] = $otp;
        return $response;
 

    
    }


    /**
     * Captcha validation rules
     *
     * @param string $type
     * @return array
     */
    public function captchaValidationRules(string $type = 'default') :array {
        $googleCaptcha = (object) json_decode(site_settings("google_recaptcha"));

        $rules = ['required' , function (string $attribute, mixed $value, Closure $fail) {
            if (strtolower($value) != strtolower(session()->get('gcaptcha_code'))) {
                $fail(translate("Invalid captcha code"));
            }
        }];

        if($type =="google"){
            $rules =  ['required' , function (string $attribute, mixed $value, Closure $fail) use($googleCaptcha) {
                $g_response =  Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify",[
                    "secret"=> $googleCaptcha->secret_key,
                    "response"=> $value,
                    "remoteip"=> request()->ip,
                ]);

                if (!$g_response->json("success")) {
                    $fail(translate("Recaptcha validation failed"));
                }
            }];
        }

        return $rules;
    }



    /**
     * opt Resend Status
     *
     * @param User $user
     * @return boolean
     */
    public function otpResendStatus(User $user , string $type ) :bool {
        $userOtp = $user->otp()?->where('type',$type)->first();
        if($userOtp){
            if(Carbon::parse($userOtp->created_at)->addMinute() > Carbon::now()) {
                return false;
            }
            return true;
        }
        return true;
    }


    /**
     * Otp login check
     *
     * @return boolean
     */
    public function loginWithOtp() :bool {

        $loginAttributes =  json_decode(site_settings('login_with'),true);
        if(is_array($loginAttributes) && count($loginAttributes) == 1 && in_array('phone',$loginAttributes) && site_settings('sms_otp_verification') == StatusEnum::true->status() ){
            return true;
        }
        return false;

    }
    

    /**
     * check verification code expired 
     *
     * @param User $user
     * @return void
     */
    public function checkExpiredStatus(User $user , string $type ) :void {

        $sessionParam = "expired_alert";
        if($type == "otp_verification"){
            $sessionParam = "otp_expired_alert";
        }

        if(site_settings('otp_expired_status') == StatusEnum::true->status()){
            $userOtp = $user->otp()?->where('type',$type)->first();
            session()->forget($sessionParam);
            if($userOtp){
                session()->put($sessionParam, $userOtp->expired_at);
            }
        }

    }


}