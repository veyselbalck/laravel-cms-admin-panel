<?php

namespace App\Http\Middleware;

use App\Models\Panel\Languages;
use App\Models\Panel\Settings;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class Frontend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    private $except = ['form-send'];

    public function handle(Request $request, Closure $next)
    {
        if(Schema::hasTable("settings")){
            foreach (Settings::all()->pluck('value', 'code') as $code => $value) {
                foreach ($value as $key => $item) {
                    if(is_array($item)){
                        foreach ($item as $k => $v) {
                            config()->set($key . '.' . $k, $v);
                        }
                    }else{
                        config()->set($key, $item);
                    }
                }
            }
        }

        date_default_timezone_set(config('app.timezone'));

        if(request()->getHost() == config('app.panel_url')) return $next($request);

        config()->set('app.locale', env("LOCALE"));
        config()->set('app.fallback_locale', env("LOCALE"));

        $languages = Languages::get()->pluck('name', 'code');
        if (count($languages) > 1) {
            $request_language = $request->segment(1);
            $langActive = Languages::where("code", $request_language)->first();

            if ($request_language && $langActive) {

                config()->set('app.locale', $request_language);
                config()->set('app.fallback_locale', $request_language);

                if ($languages->has($request_language)) {
                    app()->setLocale($request_language);
                } else {
                    if (!in_array(request()->route()->getName(), $this->except)) {
                        return redirect(config('app.locale'));
                    }
                }
            }
        }

        return $next($request);
    }
}
