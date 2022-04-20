<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Tracker
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
        return $next($request);
    }

    /**
     * Write log
     *
     * @param Request $request
     * @param mixed $response
     */
    public function terminate(Request $request, $response)
    {
        $browser = @get_browser(null, true);
        if(!$browser){
            return;
        }

        try{
            $referer_host = null;
            $referer = $request->headers->get('referer');
            if($referer){
                $url = parse_url($referer);
                $referer_host = $url && $url['host'] ? $url['host'] : null;
            }

            \App\Models\Utils\Tracker::create([
                'event' => \App\Models\Utils\Tracker::EVENT_ACCESS,
                'status' => $response->getStatusCode(),
                'method' => $request->getMethod(),
                'host' => $request->getHost(),
                'url' => $request->fullUrl(),
                'title' => $this->getPageTitle($response->getContent()),
                'referer_host' => $referer_host,
                'referer' => $referer,
                'platform' => $browser && $browser['platform'] ? $browser['platform'] : null,
                'browser' => $browser && $browser['browser'] ? $browser['browser'] : null,
                'version' => $browser && $browser['version'] ? $browser['version'] : null,
                'ip' => $request->ip(),
                'user_id' => $this->getUserId($request),
            ]);
        }catch (\Exception $e){
            error_log($e->getMessage());
        }
    }

    private function getUserId(Request $request){
        $user_id = null;
        if($request->user()){
            $user_id = $request->user()->getKey();
        }
        return $user_id;
    }

    private function getPageTitle($page)
    {
        if (preg_match('/<title>(.*?)<\/title>/', $page, $matches)) {
            return $matches[1];
        } else {
            return null;
        }
    }
}
