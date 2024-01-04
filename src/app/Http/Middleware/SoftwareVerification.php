<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SoftwareVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $logFile = storage_path(base64_decode('X2ZpbGVjYWNoZWluZw=='));
        if (!file_exists($logFile)) {
             return redirect()->route('install.init');
        } 

        return $next($request);
    }
}
