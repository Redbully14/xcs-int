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
        if($request->is('settings/change_password') or $request->is('settings') or $request->is('logout')){
            return $next($request);
        }

        if(auth()->check() && auth()->user()->temp_password) {
            return redirect()->route('settings')->with('temp_password_required', [true]);
        }

        return $next($request);
    }
}
