<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->expectsJson()){
            $languages = $request->getLanguages();
            foreach ($languages as $language){
                if(in_array($language, config('app.locales'))){
                    App::setLocale($language);
                    Carbon::setLocale($language);
                    return $next($request);
                }
            }
        }

        return $next($request);
    }
}
