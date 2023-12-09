<?php

namespace App\Http\Middleware;

use App\Enums\StatusEnum;
use App\Http\Controllers\User\Auth\LoginController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        try {

            // $loginMethod       = new LoginController(); 
            // $emailVerification = site_settings('email_verification');
            // $user              = auth_user('web') ;

            // if($user ->status == StatusEnum::false->status()){
            //     return  $loginMethod->logout()->with(response_status('Your Account is Banned!!','error'));
            // }

            // if($emailVerification  == StatusEnum::true->status() &&  !$user->email_verified_at ){

            //      return redirect()->route("email.verification");
            // }
            
            
        } catch (\Throwable $th) {
            //throw $th;
        }



        return $next($request);
    }
}
