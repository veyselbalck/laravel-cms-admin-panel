<?php

namespace App\Http\Middleware;

use Closure;

class SeoRedirect
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
        $find = \App\Models\Panel\SeoRedirect::where('address', $request->fullUrl())->first();
        if($find){
            return redirect($find->redirect, $find->http_status);
        }
        return $next($request);
    }
}
