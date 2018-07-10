<?php

if (!function_exists('cache_response_forget')) {
    function cache_response_forget($slug)
    {
        $cache = app('fts\CacheResponse\Cache');
        if (is_array($slug)) {
            $cache->forgetMany($slug);
        } else {
            $cache->forget($slug);
        }
    }
}


if (!function_exists('cache_response_clear')) {
    function cache_response_clear()
    {
        app('fts\CacheResponse\Cache')->clear();
    }
}