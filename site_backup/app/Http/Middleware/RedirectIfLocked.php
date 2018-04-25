<?php

namespace App\Http\Middleware;

use App\Exceptions\UserLockedException;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfLocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws UserLockedException
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard()->check() && Auth::user()->lock != 0) {
            Auth::guard()->logout();
            throw new UserLockedException();
        }

        return $next($request);
    }
}
