<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\User\AuthService;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthorizationController extends Controller
{
    


    public $authService;

    public function __construct()
    {

        $this->authService = new AuthService();

    }


    /**
     * sms otp verification
     *
     * @return View
     */
    public function otpVerification() :View {

        return view('user.auth.verification.otp_verification',[
            
            'meta_data'=> $this->metaData([
                  "title" => trans("default.otp_verification")]),
            "route"    => "auth.otp.verify",

        ]);
    
    }


    /**
     * Account verification
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function otpVerify(Request $request) :RedirectResponse {

   
        $request->validate([
            "opt_code" => ['required','numeric']
        ]);

        $responseMessage =  response_status('The provided OTP does not exist. Please consider requesting a new OTP','error');

        try {
            $identification = session()->get("user_identification");
            if($identification 
            && is_array($identification) 
            && isset($identification['field'], $identification['value'])
           ){
                    DB::transaction(function() use ($request ,$identification) {
                        $user = User::with(['otp'])
                            ->where(Arr::get($identification,'field','phone') ,Arr::get($identification,'value',"") )
                            ->firstOrfail();

                        $otp = $user->otp->where("otp",$request->input("opt_code"))->first();

                        if($otp &&  $otp->expired_at > Carbon::now()){

                            $verificationType = $identification['field'] == "email" ? "email":"sms";

                            if($verificationType == 'email'){

                                $user->email_verified_at =  Carbon::now();
                                $user->save();
                            }
                            else{
                                Auth::guard('web')->loginUsingId($user->id); 
                            }

                            session()->forget('otp_expire_at');
                            session()->forget('user_identification');
                            $otp->delete();
                        
                       

                            return redirect()->route('user.home')->with(response_status('Verification process successfully completed. Your account is now verified and ready for use. Thank you for confirming your details with us.'));
                        }
                    });

            }
        } catch (\Exception $ex) {

            $responseMessage =  response_status(strip_tags($ex->getMessage()),'error');

        }

        return back()->with($responseMessage);

    }



    /**
     * Rsend Otp Method
     *
     * @return RedirectResponse
     */
    public function otpResend() :RedirectResponse {


        $responseMessage =  response_status('Resending OTP failed. We encountered an issue. Please try again later or contact support for assistance.','error');
      
        try {

            $identification = session()->get("user_identification");

            if($identification 
                && is_array($identification) 
                && isset($identification['field'], $identification['value'])
                && session()->get("otp_expire_at",Carbon::now()) <= Carbon::now()
            ){
                $user = User::with(['otp'])
                ->where(Arr::get($identification,'field',"") ,Arr::get($identification,'value',"") )
                ->firstOrfail();
                $type = $identification['field'] == "email" ? "email":"sms";

                $this->authService->otpConfiguration($user,$type);

                $responseMessage =  response_status('The One-Time Passcode (OTP) has been successfully reissued');
    
            }
    
        } catch (\Exception $ex) {
            $responseMessage =  response_status(strip_tags($ex->getMessage()),'error');

        }


        return back()->with( $responseMessage);
       
    
    }





}
