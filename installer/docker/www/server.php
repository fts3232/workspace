#!/usr/bin/env php
<?php
declare(strict_types=1);

$http = new Swoole\Http\Server("0.0.0.0", 9501);
$http->on(
    "request", function (Swoole\Http\Request $request, Swoole\Http\Response $response) {
        try{
            if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
                $response->end();
                return;
            }
            list($controller, $action) = explode('/', trim($request->server['request_uri'], '/'));
            if(empty($controller) || !class_exists($controller)){
                throw new Exception('404');
            }
            $class = new $controller;
            if(!method_exists($class,$action)){
                throw new Exception('404');
            }
            //根据 $controller, $action 映射到不同的控制器类和方法
            (new $controller)->$action($request, $response);
        }catch(Exception $e){
            $response->end('<pre>404</pre>');
        }
    }
);
$http->start();

class test {
    function index($request, $response){
        ob_start();
        phpinfo();
        $content = ob_get_clean();
        $response->end('<pre>' . $content. '</pre>');
    }
}