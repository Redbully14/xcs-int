<?php

namespace App\Http\Middleware;

use Closure;

class CheckActiveProfile
{
    /**
     * Checks if the user is active
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $message = 'Your accunt is currently deactivated, contact a Civilian Administrator for more information.';

        if(auth()->check() && !auth()->user()->antelope_status) {
            auth()->logout();
            return redirect()->route('inactive')->withMessage($message);
        }

        return $next($request);
    }
}
