<?php

namespace fts\OAuth;

use Illuminate\Config\Repository;
use Illuminate\Redis\RedisManager;
use OAuth2\GrantType;
use OAuth2\GrantType\AuthorizationCode;
use OAuth2\GrantType\ClientCredentials;
use OAuth2\GrantType\RefreshToken;
use OAuth2\HttpFoundationBridge\Request;
use OAuth2\Response;
use OAuth2\Scope;
use OAuth2\Server;
use OAuth2\Storage\Memory;
use OAuth2\Storage\Pdo;
use OAuth2\Storage\Redis;

class OAuth
{
    protected $server;

    protected $scope;

    protected $grantType = array();

    protected $request;

    protected $config = array();

    protected $clients = array();

    protected $configRepository;

    protected $storage;

    public function __construct(RedisManager $redis, Repository $config)
    {

        $this->configRepository = $config;
        $this->configure();

        switch ($this->storage) {
            case 'redis':
                $storage = new Redis($redis);
                break;
        }

        foreach ($this->clients as $client) {
            $storage->setClientDetails($client['client_id'], $client['client_secret'], $client['redirect_uri']);
        }

        $server = new Server($storage, $this->config);
        foreach ($this->grantType as $grantType) {
            switch ($grantType) {
                case 'client_credentials':
                    $server->addGrantType(new ClientCredentials($storage)); //客户端模式
                    break;
                case 'authorization_code':
                    $server->addGrantType(new AuthorizationCode($storage)); // or any grant type you like!
                    break;
                case 'refresh_token':
                    $server->addGrantType(new RefreshToken($storage)); // or any grant type you like!
                    break;
                case '':
                    break;
            }
        }
        if ($this->scope) {
            $memory = new Memory($this->scope);
            $scopeUtil = new Scope($memory);
            $server->setScopeUtil($scopeUtil);
        }

        $this->server = $server;
    }

    public function getServer()
    {
        return $this->server;
    }

    public function configure()
    {
        if ($this->configRepository->has('oauth2')) {
            $config = $this->configRepository->get('oauth2');
            foreach ($config as $key => $val) {
                $this->{$key} = $val;
            }
        }
    }

    public function getAccessTokenData($request)
    {
        $request = Request::createFromRequest($request);
        return $this->server->getAccessTokenData($request);
    }

    public function getToken($request)
    {
        $request = Request::createFromRequest($request);
        $response = new Response();
        $token = $this->server->grantAccessToken($request, $response);
        if (!$token) {
            return $response->getParameters();
        }
        return $token;
    }

    public function verify($request, $scope = '')
    {
        $request = Request::createFromRequest($request);
        $response = new Response();
        if (!$this->server->verifyResourceRequest($request, $response, $scope)) {
            return $response->getParameters();
        }
        return true;
    }
}
