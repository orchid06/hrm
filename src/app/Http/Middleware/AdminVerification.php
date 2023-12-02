<?php

namespace App\Http\Middleware;

use App\Enums\StatusEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class AdminVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

         try {
            if(auth_user() && auth_user()->status == StatusEnum::false->status() ){
            
                $request->session()->flash('error', translate("This Account Has Been Banned"));

                Auth::guard('admin')->logout();
                return redirect('/admin');
         
            }
         } catch (\Throwable $th) {
            //throw $th;
         }
        return $next($request);
    }
}
