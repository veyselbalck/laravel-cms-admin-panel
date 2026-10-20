<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        $isAuthenticatedAdmin = (Auth::check() && Auth::user()->status == 1);

        if (! $isAuthenticatedAdmin)
        {
            Auth::guard()->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect(\route('login'))->withErrors(trans('auth.status'));
        }

        return $next($request);
    }
}
