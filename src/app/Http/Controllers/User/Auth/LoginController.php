<?php

namespace App\Http\Controllers\User\Auth;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AuthenticateRequest;
use App\Http\Services\User\AuthService;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View ;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    private $maxLoginAttempts,$lockoutTime, $authService;
    public function __construct()
    {

        if(site_settings("user_login") == StatusEnum::false->status()){
            abort(403,unauthorized_message("Login module is currently off now"));
        }
        $this->authService = new AuthService();

        //max login Attempts
        $this->maxLoginAttempts = site_settings("max_login_attemtps");

        //lockout time in second
        $this->lockoutTime = 2*60;
    }

    /**
     * Undocumented function
     *
     * @return View
     */
    public function showLoginForm():View{
        
        return view('user.auth.login',[
            'meta_data'=> $this->metaData([],'login'),
        ]);
    }

    
    public function authenticate(AuthenticateRequest $request)
    {
        $field = $this->getLoginField($request->input('login_data'));
        $remember_me = $request->has('remember_me') ? true : false; 
        
        /** cheek to many attempts */
        if(site_settings("login_attempt_validation") == StatusEnum::true->status()){
            if ($this->hasTooManyLoginAttempts($request, $field)) {
                return $this->sendLockoutResponse($request, $field);
            }
        }
        if($this->authService->loginWithOtp()){
            
        $user =  User::where("phone","like","%".request()->input('login_data'))->first();
            if($user){
                $response =  $this->authService->sendOtp($user,'otp_verification');
                if($response['status']){
                    session()->forget('resend_otp');
                    session()->put('otp_phone', $user->phone);
                    $this->authService->checkExpiredStatus($user,'otp_verification');
                    return redirect(route('login.verify'))->with(response_status('Check your Phone!! An Otp sent successfully'));
                }
                else{
                    $user->otp()?->where('type','otp_verification')->delete();
                    return back()->with(response_status('Can\'t Sent Otp!! Configuration Error' , "error"));
                }
            }
        }
        else{
            if (Auth::guard('web')->attempt([$field => $request->input('login_data'), 'password' => $request->input('password')],$remember_me)) {
                $this->clearLoginAttempts($request, $field);
                return redirect()->intended('/')->with(response_status('Login Success'));
            }
        }

        /** basic login */
        if(site_settings("loggin_attempt_validation") == StatusEnum::true->status()){
            $this->incrementLoginAttempts($request, $field);
        }
       
        return redirect()->back()->with(response_status("Invalid Credential","error"));
    }
    
    /**
     * get login feild
     *
     * @param string $login
     * @return string
     */
    public function getLoginField(string $login):string{
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        } elseif (preg_match('/^[0-9]+$/', $login)) {
            return 'phone';
        }
        return 'user_name';
    }

    /**
     * Verify opt view
     *
     * @return View
     */
    public function verify() :View{

        return view('user.auth.otp',[
            'meta_data'=> $this->metaData([],'verification'),
        ]);
    }


    /**
     * Verify Otp
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function verifyOtp(Request $request ) :RedirectResponse{

        $request->validate([
            'otp'=>'required'
         ]);

         $user =  User::with("otp")->where("phone",session()->get("otp_phone"))->first();
         if($user){
             $userOtp = $user->otp()?->where('type','otp_verification')->first();
            if($userOtp && $userOtp->otp == $request->get("otp")){
                if(site_settings('otp_expired_status') == StatusEnum::true->status()){
                   if($userOtp->expired_at < Carbon::now()) {
                      session()->put('resend_otp' , true);
                      return redirect()->back()->with(response_status("Your Otp Code is Expired !! ","error"));
                   }
                }
                session()->forget('otp_phone');
                session()->forget('otp_expired_alert');
                session()->forget('resend_otp');
                $user->otp()?->where('type','otp_verification')->delete();
                Auth::guard('web')->login($user);
                return redirect()->intended('/')->with(response_status("Verification Completed!!"));
            }

            session()->put('resend_otp' , true);
            $this->authService->checkExpiredStatus($user,'otp_verification');
            return redirect()->back()->with(response_status("Invalid Otp","error"));

         }

         return redirect()->route('login')->with(response_status("No Account Found!!!","error"));
    }


    /**
     * resend otp
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function resend(Request $request ) :RedirectResponse{
        $user =  User::with("otp")->where("phone",session()->get("otp_phone"))->first();

        if($user){
            if(!$this->authService->otpResendStatus($user,"otp_verification")){
                return back()->with(response_status('Please Check Your Phone. if not found Try To Resend Code After 1 Miniute' , "error"));
            }
            $response =  $this->authService->sendOtp($user,'otp_verification');
            if($response['status']){
                session()->forget('resend_otp');
                session()->forget('otp_expired_alert');
                session()->put('otp_phone', $user->phone);
                $this->authService->checkExpiredStatus($user,'otp_verification');

                return redirect(route('login.verify'))->with(response_status('Check your Phone!! An Otp sent successfully'));
            }
            else{
                $user->otp()?->where('type','otp_verification')->delete();
                return back()->with(response_status('Can\'t Sent Otp!! Configuration Error' , "error"));
            }
        }
     
        return redirect()->route("login")->with(response_status("User Not Found!!",'error'));

    }
    protected function hasTooManyLoginAttempts(Request $request,string $field)
    {
        return RateLimiter::tooManyAttempts($this->throttleKey($request, $field), $this->maxLoginAttempts);
    }
    
    /**
     *
     * @param Request $request
     * @param string $field
     * @return string
     */
    protected function throttleKey(Request $request, string $field) :string
    {
        return $field . '|' . $request->ip();
    }
    

    /**
     * send lockout response
     *
     * @param Request $request
     * @param string $field
     * @return RedirectResponse
     */
    protected function sendLockoutResponse(Request $request,string $field) :RedirectResponse
    {
        $seconds = RateLimiter::availableIn($this->throttleKey($request,$field));
        $minutes = ceil($seconds / 60);
        return redirect()->back()->with(
            'error', translate("Too many login attempts!! Please try again after ").$minutes.' minute '
        );
    }
    
    protected function incrementLoginAttempts(Request $request, string $field)
    {
        RateLimiter::hit($this->throttleKey($request, $field),$this->lockoutTime);
    }
    
    /**
     * clear login attemps
     * @param Request $request
     * @param string $field
     * @return void
     */
    protected function clearLoginAttempts(Request $request,string $field)
    {
        RateLimiter::clear($this->throttleKey($request, $field));
    }

    /**
     * logout method
     *
     * @return RedirectResponse
     */
    public function logout() :RedirectResponse{
        Auth::guard('web')->logout();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
