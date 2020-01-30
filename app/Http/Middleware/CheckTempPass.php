<?php

namespace App\Http\Middleware;

use Closure;

class CheckTempPass
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->is('register/submit') or $request->is('register') or $request->is('logout') or $request->is('superadmin/normalmode')){
            return $next($request);
        }

        if(auth()->check() && auth()->user()->temp_password) {
            return redirect()->route('register');
        }

        return $next($request);
    }
}
