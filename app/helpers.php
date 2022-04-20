<?php

if (! function_exists('app_version')) {
    function app_version()
    {
       return config('app.version');
    }
}

if (! function_exists('asset_version')) {
    function asset_version($path, $secure = null): string
    {
       return asset($path, $secure) . '?v=' . app_version();
    }
}
