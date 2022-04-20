<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Timezone
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
        if($request->has('timezone')){
            $user = $request->user();
            if($user){
                $user->timezone = $request->get('timezone');
                $user->save();
            }
        }

        return $next($request);
    }
}
