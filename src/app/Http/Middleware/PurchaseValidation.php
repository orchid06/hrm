<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\InstallerManager;
use Illuminate\Support\Facades\Route;

class PurchaseValidation
{
    use InstallerManager;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$this->_isPurchased()){
            return redirect()->route('invalid.puchase',["verification_view" => request()->routeIs('admin.*') ? true:false]);
        }
        return $next($request);
    }
}
