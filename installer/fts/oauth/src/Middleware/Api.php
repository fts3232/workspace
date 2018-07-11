<?php

namespace fts\Api\Middleware;

use Closure;
use fts\Api\Api;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Api
{

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function handle(Request $request, Closure $next)
    {
        try {
            $id = $request->route('id');
            $category = $request->route('category');
            $type = $request->route('type');
            $data = $request->input();
            $rule = [
                'time' => 'required|numeric',
                'sign' => 'required',
                'from' => 'required|checkApiFrom',
            ];
            $msg = [];
            $validator = Validator::make($data, $rule, $msg);
            if ($validator->fails() || !in_array($type, $this->categoryMap[$category]))
                throw new \Exception('参数验证不通过');
            $isOk = $this->fileMd5SignValid($id, $category, $type, $data['sign'], $data['time'], $data['from']);
            if (!$isOk)
                throw new \Exception('md5验证不通过');
            return $next($request);
        } catch (\Exception $e) {
            abort(403);
        }
    }

    private function shouldCache(Request $request, Response $response)
    {
        return $request->isMethod('GET') && $response->getStatusCode() == 200;
    }
}
