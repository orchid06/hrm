<?php

namespace App\Http\Middleware;

use App\Enums\StatusEnum;
use App\Http\Controllers\Admin\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\RegisterController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Verification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

         try {
            if(auth_user('web')){
                if(auth_user('web')->status == StatusEnum::false->status()){
                   return  (new LoginController())->logout()->with(response_status('Your Account is Banned!!','error'));
                }
                if(site_settings('email_verification') ==  StatusEnum::true->status() &&  !auth_user('web')->email_verified_at){
                    session()->put("registration_verify_email",auth_user('web')->email);
                    (new LoginController())->logout();
                    return (new RegisterController())->resend();
                }
            }

           
         } catch (\Throwable $th) {
       
         }

    
        return $next($request);
    }
}
