<?php

namespace fts\OAuth;

use Illuminate\Hashing\BcryptHasher as Hasher;
use OAuth2\Storage\Pdo;
use OAuth2\Server;
use OAuth2\GrantType;
use OAuth2\Request;
use OAuth2\GrantType\AuthorizationCode;
use OAuth2\GrantType\ClientCredentials;
use OAuth2\Storage\Memory;
use OAuth2\Scope;
use Illuminate\Redis\RedisManager;
use OAuth2\Storage\Redis;

class OAuth
{
    protected $server;

    protected $scope;

    protected $grantType;

    protected $request;

    public function __construct(RedisManager $redis)
    {


        $this->scope = array(
            'default_scope'=>'basic',
            'supported_scopes'=>array(
                'basic',
                'cache',
                'getImage'
            )
        );

        $storage = new Redis($redis,$this->scope);
        $storage->setClientDetails('demoapp','123','');

        $memory = new Memory($this->scope);
        $scopeUtil = new Scope($memory);

        $server = new Server($storage);
        $server->addGrantType(new AuthorizationCode($storage)); // or any grant type you like!
        $server->addGrantType(new ClientCredentials($storage)); //客户端模式
        $server->setScopeUtil($scopeUtil);
        $this->server = $server;
       // var_dump($server->grantAccessToken(Request::createFromGlobals()));
        //$server->handleTokenRequest(Request::createFromGlobals())->send();
    }

    public function token($request,$response)
    {
        $this->server->grantAccessToken($request,$response);
        return $response->send();
    }

    private function fileMd5SignValid($id, $category, $type, $sign, $time, $from)
    {
        //$timeout = config('app.MD5_KEY_TIMEOUT');
        $timeout = 1800;
        $time = intval($time);
        $now = time() - $timeout;
        $md5Sign = $this->getFileMd5Sign($id, $category, $type, $time, $from);
        return $sign === $md5Sign && $now < $time;
    }

    private function getFileMd5Sign($id, $category, $type, $time, $from)
    {
        /* $key = config('app.MD5_KEY');
        $md5 = md5($key."{$id}-{$time}-{$type}"); */
        $md5Key = $this->md5KeyMap[$from];
        $key = "uid={$id}&category={$category}&time={$time}&type={$type}&from={$from}www.202fx.com/" . $md5Key;
        $md5 = md5($key);
        return $md5;
    }
}
