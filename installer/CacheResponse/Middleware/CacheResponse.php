<?php

namespace CacheResponse\Middleware;

use Closure;
use CacheResponse\Cache;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CacheResponse
{
    protected $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function handle(Request $request, Closure $next)
    {
        if ($html = $this->cache->exists($request)) {
            return $html;
        } else {
            $response = $next($request);
            if ($this->shouldCache($request, $response)) {
                $this->cache->cache($request, $response);
            }
            return $response;
        }
    }

    private function shouldCache(Request $request, Response $response)
    {
        return $request->isMethod('GET') && $response->getStatusCode() == 200;
    }
}
