<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\User\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthorizationController extends Controller
{
    


    public $authService;

    public function __construct()
    {

        $this->authService = new AuthService();

    }


    public function verification(string $type) :View  | RedirectResponse{


        try {

            $view  = "user.auth.verification.".$type."_verification";
            return view($view,[
                'meta_data'=> $this->metaData([
                    "title" => trans("default.email_verification"),
                ])
            ]);

        } catch (\Throwable $th) {
          
        }

        return redirect()->route('auth.login')->with(response_status('View not found','error'));


 
    }



    public function sendOtp(string $type) :RedirectResponse {

        try {

            $user     = auth_user('web');
            $response = $this->authService->sendOtp($user,"OTP_VERIFY",t2k($type));
            
            

        } catch (\Exception $ex) {

            return redirect()->route('auth.login')->with(response_status(strip_tags($ex->getMessage()),'error'));
        }
        
 
    }



}
