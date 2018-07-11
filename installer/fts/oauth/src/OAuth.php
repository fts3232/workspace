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
        return $this->server->handleTokenRequest($request)->send();
        var_dump($parameters = $response->getParameters());
        return $response->send();
    }

    public function resource($request,$response){
        var_dump($this->server->verifyResourceRequest($request,$response,'basic'));
    }
}
