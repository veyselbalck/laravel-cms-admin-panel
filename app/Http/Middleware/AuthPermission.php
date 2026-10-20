<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class AuthPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    public function handle(Request $request, Closure $next)
    {
        if(Route::getCurrentRoute() != null) {

            $parse = explode('.', Route::getCurrentRoute()->getName());
            $route_name = current($parse);
            $route_method=Route::getCurrentRoute()->getActionMethod();


            if(!method_exists(Route::getCurrentRoute()->getController(), $route_method)){
                abort(404);
            }

            $checkForRouteMethod = Str::replace(['store', 'update'], ['create', 'edit'] , $route_method);

            if(!auth()->user()->hasPermission($route_name, $checkForRouteMethod)){
                return redirect()->route('error.permission');
            }
        }

        return $next($request);
    }
}
