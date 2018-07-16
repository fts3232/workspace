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
use fts\OAuth2\Storage\Pdo;
use OAuth2\Storage\Redis;

/**
 * oauth2类
 *
 * Class OAuth2
 * @package fts\OAuth2
 */
class OAuth2
{
    /**
     * oauth server
     *
     * @var Server
     */
    protected $server;

    /**
     * oauth 范围
     *
     * @var
     */
    protected $scope;

    /**
     * pdo类
     *
     * @var \PDO
     */
    protected $pdo;

    /**
     * 要使用的授权类型
     *
     * @var array
     */
    protected $grantType = array();

    /**
     * 请求类
     *
     * @var
     */
    protected $request;

    /**
     * 配置
     *
     * @var array
     */
    protected $config = array();

    /**
     * clients数组
     *
     * @var array
     */
    protected $clients = array();

    /**
     * 配置仓库类
     *
     * @var Repository
     */
    protected $configRepository;

    /**
     * 存储
     *
     * @var
     */
    protected $storage;

    /**
     * keys
     *
     * @var array
     */
    protected $keys = array();

    /**
     * pdo存储系统配置
     *
     * @var array
     */
    protected $pdoConfig = array();

    /**
     * redis存储系统配置
     *
     * @var array
     */
    protected $redisConfig = array();

    /**
     * OAuth2 constructor.
     * @param Repository   $config 配置仓库类
     * @param RedisManager $redis  redis类
     * @param \PDO         $pdo    pdo类
     */
    public function __construct(Repository $config, RedisManager $redis, \PDO $pdo)
    {
        $this->configRepository = $config;
        $this->redis = $redis;
        $this->pdo = $pdo;

        //加载配置项
        $this->configure();

        //创建存储系统
        $storage = $this->createStorage();

        //实例化server
        $server = new Server($storage, $this->config);

        //添加授权类型
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

        //设置授权范围
        if ($this->scope) {
            $scopeUtil = new Scope($this->scope);
            $server->setScopeUtil($scopeUtil);
        }

        $this->server = $server;
    }

    /**
     * 加载配置项
     */
    protected function configure()
    {
        if ($this->configRepository->has('oauth2')) {
            $config = $this->configRepository->get('oauth2');
            foreach ($config as $key => $val) {
                $this->{$key} = $val;
            }
        }
    }

    /**
     * 设置客户端信息
     *
     * @param $storage
     */
    protected function setClientDetails($storage)
    {
        foreach ($this->clients as $client) {
            $storage->setClientDetails($client['client_id'], $client['client_secret'], $client['redirect_uri']);
        }
    }

    /**
     * 创建存储系统
     *
     * @return array
     */
    protected function createStorage()
    {
        $storages = array();
        foreach ($this->storage as $key => $storage) {
            switch ($storage) {
                case 'redis':
                    if (!isset($redisStorage)) {
                        $redisStorage = new Redis($this->redis, $this->redisConfig);
                    }
                    $storages[$key] = $redisStorage;
                    break;
                case 'memory':
                    if (!isset($memoryStorage)) {
                        //如果启用jwt
                        $params = array();
                        if ($this->config['use_jwt_access_tokens']) {
                            $params = array(
                                'keys' => $this->keys
                            );
                        }
                        $memoryStorage = new Memory($params);
                    }
                    $storages[$key] = $memoryStorage;
                    break;
                case 'pdo':
                    if (!isset($pdoStorage)) {
                        $pdoStorage = $storage = new PDO($this->pdo, $this->pdoConfig);
                    }
                    $storages[$key] = $pdoStorage;
                    break;
            }
            //设置客户端信息
            if ($key == 'client_credentials') {
                $this->setClientDetails($storages[$key]);
            }
        }
        return $storages;
    }

    /**
     * 获取token信息
     *
     * @param $request 请求类
     * @return mixed
     */
    public function getAccessTokenData($request)
    {
        $request = Request::createFromRequest($request);
        return $this->server->getAccessTokenData($request);
    }

    /**
     * 获取token
     *
     * @param $request 请求类
     * @return array|mixed
     */
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

    /**
     * 验证token是否正确
     *
     * @param        $request 请求类
     * @param string $scope   请求范围
     * @return array|bool
     */
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
