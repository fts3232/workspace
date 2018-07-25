<?php

namespace App\Http\Middleware;

use Closure;

class VerifySign
{

    protected $scopeMap = array(
        'createCache',
        'clearCache'
    );

    protected $clientIDMap = array(
        'crm.xxx.com'
    );

    public function handle(Request $request, Closure $next, $grant = '')
    {
        try {
            $sign = $request->input('sign');
            $scope = $grant;
            $time = $request->input('time');
            $clientID = $request->input('client_id');
            $key = "{$clientID}-{$scope}-{$time}-" . "&J$#KF(S(K@@L";
            if (md5($key) != $sign) {
                throw new \Exception('该sign无效', 100);
            }
            if ($time < time() - 600) {//过期时间10分钟
                throw new \Exception('该sign已过期', 101);
            }
            if (!in_array($scope, $this->scopeMap) || $grant != $scope) {
                throw new \Exception('该scope不在有效范围内', 102);
            }
            if (!in_array($clientID, $this->clientIDMap)) {
                throw new \Exception('该clientID不在有效范围内', 103);
            }
            return $next($request);
        } catch (\Exception $e) {
            $return = array(
                'status' => false,
                'code' => $e->getCode(),
                'msg' => $e->getMessage()
            );
            return response()->json($return);
        }
    }
}
