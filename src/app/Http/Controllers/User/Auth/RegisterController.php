<?php

namespace App\Http\Controllers\User\Auth;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Services\User\AuthService;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{


    protected $authService ,$settings;

    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->settings = (object) json_decode(site_settings("user_authentication"));

    
        $this->authService = new AuthService();
    }

    

    /**
     * user registration 
     *
     * @param UserRegisterRequest $request
     * @return RedirectResponse
     */
    public function store(UserRegisterRequest $request) :RedirectResponse{

        if($this->settings->registration == StatusEnum::false->status()){
            abort(403,unauthorized_message("Registration Module is Currently Off Now"));
        }

        $user = $this->authService->register($request->except('_token')['register_data']);
        if(site_settings('email_verification') ==  StatusEnum::true->status()){
            $response =  $this->authService->sendOtp($user,'email_verification',"email");
            if($response['status']){
                session()->forget('resend_verifiaction_code');
                session()->put('registration_verify_email', $user->email);
                $this->authService->checkExpiredStatus($user ,"email_verification");
                return redirect(route('register.verification'))->with(response_status('Check your email a code sent successfully for verify registration process'));
            }
            else{
                $user->otp()?->where('type','email_verification')->delete();
                $user->delete();
                return back()->with(response_status('Can\'t Sent Email!! Configuration Error' , "error"));
            }
        }
        Auth::guard('web')->login($user);
        return redirect()->route("home")->with(response_status("Registration Completed"));

    
    }


    /**
     * Show Registration Form
     *
     * @return View
     */
    public function create() :View{
        if($this->settings->registration == StatusEnum::false->status()){
            abort(403,unauthorized_message("Registration Module is Currently Off Now"));
        }
        return view('user.auth.register',[
            'meta_data'=> $this->metaData([],'register'),
        ]);
    }


    /**
     * Email Verification 
     *
     * @param Request $request
     * @return void
     */
    public function verify(Request $request) :RedirectResponse{
         $request->validate([
            'code'=>'required'
         ]);
         $user =  User::with("otp")->where("email",session()->get("registration_verify_email"))->first();

         if($user){
             $userOtp = $user->otp()?->where('type','email_verification')->first();
            if($userOtp && $userOtp->otp == $request->get("code")){
                if(site_settings('otp_expired_status') == StatusEnum::true->status()){
                   if($userOtp->expired_at < Carbon::now()) {
                      session()->put('resend_verifiaction_code' , true);
                      return redirect()->back()->with(response_status("Your Verificaition Code is Expired !! ","error"));
                   }
                }
                session()->forget('registration_verify_email');
                session()->forget('expired_alert');
                session()->forget('resend_verifiaction_code');
                $user->otp()?->where('type','email_verification')->delete();
                $user->email_verified_at = Carbon::now();
                $user->save();
                Auth::guard('web')->login($user);
                return redirect()->route("home")->with(response_status("Verification Completed!!"));
            }

            session()->put('resend_verifiaction_code' , true);
            $this->authService->checkExpiredStatus($user,'email_verification');
            return redirect()->back()->with(response_status("Invalid Verificaition Code","error"));

         }

         return redirect()->route('login')->with(response_status("No Account Found!!!","error"));

    }
    
    /**
     * resend verification code
     */

     public function resend():RedirectResponse{

        if($this->checkVerification()){
            return redirect('/login')->with(response_status('Email Verification Is Off !! Try To Login With Your Own Credential'));
        };

   
        $user =  User::with("otp")->where("email",session()->get("registration_verify_email"))->first();
  
        if($user && site_settings('email_verification') ==  StatusEnum::true->status()){
            if(!$this->authService->otpResendStatus($user,'email_verification')){
                return back()->with(response_status('Please check including your Junk/Spam Folder. if not found Try To Resend Code After 1 Miniute' , "error"));
            }
            $response = $this->authService->sendOtp($user,'email_verification',"email");
            if($response['status']){
                session()->forget('resend_verifiaction_code');
                session()->forget('expired_alert');
                session()->put('registration_verify_email', $user->email);
                $this->authService->checkExpiredStatus($user,'email_verification');
                return redirect(route('register.verification'))->with(response_status('Check your email a code sent successfully for verify registration process !! You Need To Verify Your Account!!'));
            }
            else{
                $user->otp()?->where('type','email_verification')->delete();
                return back()->with(response_status('Can\'t Sent Email!! Configuration Error' , "error"));
            }
        }
     
        return redirect()->route("login")->with(response_status("User Not Found!!",'error'));
     }

    /**
     * Show Verify Form
     *
     * @return View
     */
    public function verifyCode() :View | RedirectResponse{
        if($this->checkVerification()){
            return redirect('/login')->with(response_status('Email Verification Is Off !! Try To Login With Your Own Credential'));
        };
        
        return view('user.auth.verify_code',[
            'meta_data'=> $this->metaData([],'verification'),
            "title" => "Verify Your Email"
        ]);
    }


    /**
     * check email verifaction is active or not 
     *
     * @return boolean
     */
    public function checkVerification() :bool{
         if(site_settings('email_verification') ==  StatusEnum::false->status()){
            session()->forget('resend_verifiaction_code');
            session()->forget('expired_alert');
            session()->forget('registration_verify_email');
            return true;
         }

        return false;
    }

}

