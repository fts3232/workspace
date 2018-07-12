<?php

namespace fts\OAuth\Middleware;

use Closure;
use fts\OAuth\OAuth as OAuthServer;
use Symfony\Component\HttpFoundation\Request;

class OAuth
{

    protected $server;

    public function __construct(OAuthServer $oauth)
    {
        $this->server = $oauth;
    }

    public function handle(Request $request, Closure $next, $grant = '')
    {
        try {
            $grant = explode(':', $grant);
            if ($grant[0] == 'resource') {
                $scope = !empty($grant[1]) ? $grant[1] : '';
                $result = $this->server->verify($request, $scope);
                if (!empty($result['error'])) {
                    throw new \Exception('验证失败');
                }
            }
            return $next($request);
        } catch (\Exception $e) {
            return response()->json($result, 401);
        }
    }
}
