<?php

namespace fts\OAuth2;

use Illuminate\Config\Repository;
use Illuminate\Redis\RedisManager;
use OAuth2\GrantType\AuthorizationCode;
use OAuth2\GrantType\ClientCredentials;
use OAuth2\GrantType\JwtBearer;
use OAuth2\GrantType\RefreshToken;
use OAuth2\GrantType\UserCredentials;
use OAuth2\HttpFoundationBridge\Request;
use OAuth2\Response;
use OAuth2\Scope;
use OAuth2\Server;
use OAuth2\Storage\Memory;
use OAuth2\Storage\Pdo;
use OAuth2\Storage\Redis;

class OAuth2
{
    protected $server;

    protected $scope;

    protected $pdo;

    protected $grantType = array();

    protected $request;

    protected $config = array();

    protected $clients = array();

    protected $configRepository;

    protected $storage;

    protected $keys = array();

    public function __construct(Repository $config, RedisManager $redis, \PDO $pdo)
    {
        $this->configRepository = $config;
        $this->redis = $redis;
        $this->pdo = $pdo;

        $this->configure();

        if ($this->config['use_jwt_access_tokens']) {
            $publicKey = file_get_contents(__DIR__ . '/../key/pubkey.pem');
            $privateKey = file_get_contents(__DIR__ . '/../key/privkey.pem');
            $this->keys = array(
                'keys' => array(
                    'public_key' => $publicKey,
                    'private_key' => $privateKey,
                )
            );
            $this->keys;
        }

        $storage = $this->createStorage();

        $server = new Server($storage, $this->config);
        foreach ($this->grantType as $grantType) {
            switch ($grantType) {
                case 'client_credentials':
                    $server->addGrantType(new ClientCredentials($storage['client_credentials'])); //客户端模式
                    break;
                case 'authorization_code':
                    $server->addGrantType(new AuthorizationCode($storage['authorization_code'])); // or any grant type you like!
                    break;
                case 'refresh_token':
                    $server->addGrantType(new RefreshToken($storage['refresh_token'], array(
                        'always_issue_new_refresh_token' => $this->config['always_issue_new_refresh_token'],
                        'refresh_token_lifetime' => $this->config['refresh_token_lifetime'],
                    ))); // or any grant type you like!
                    break;
                case 'jwt_bearer':
                    $server->addGrantType(new JwtBearer($storage['jwt_bearer']));
                    break;
                case 'user_credentials':
                    $server->addGrantType(new UserCredentials($storage['user_credentials']));
                    break;
            }
        }

        if ($this->scope) {
            $scopeUtil = new Scope($this->scope);
            $server->setScopeUtil($scopeUtil);
        }

        $this->server = $server;
    }

    protected function configure()
    {
        if ($this->configRepository->has('oauth2')) {
            $config = $this->configRepository->get('oauth2');
            foreach ($config as $key => $val) {
                $this->{$key} = $val;
            }
        }
    }

    protected function setClientDetails($storage)
    {
        foreach ($this->clients as $client) {
            $storage->setClientDetails($client['client_id'], $client['client_secret'], $client['redirect_uri']);
        }
    }

    protected function createStorage()
    {
        $storages = array();
        foreach ($this->storage as $key => $storage) {
            switch ($storage) {
                case 'redis':
                    if (!isset($redisStorage)) {
                        $redisStorage = new Redis($this->redis);
                    }
                    $storages[$key] = $redisStorage;
                    break;
                case 'memory':
                    if (!isset($memoryStorage)) {
                        $memoryStorage = new Memory($this->keys);
                    }
                    $storages[$key] = $memoryStorage;
                    break;
                case 'pdo':
                    if (!isset($pdoStorage)) {
                        $pdoStorage = $storage = new PDO($this->pdo);
                    }
                    $storages[$key] = $pdoStorage;
                    break;
            }
            if ($key == 'client_credentials') {
                $this->setClientDetails($storages[$key]);
            }
        }
        return $storages;
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
