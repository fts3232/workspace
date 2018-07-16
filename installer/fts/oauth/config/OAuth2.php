<?php
return [
    //存储系统配置
    'storage' => [
        //存放客户端信息的地方
        'client_credentials' => 'memory',
        //存放public key的地方
        'public_key'=>'memory',
        //存放用户信息的地方
        'user_credentials' => 'pdo',
        //存放访问令牌的地方
        'access_token' => 'redis',
        //存放请求范围的地方
        'scope' => 'memory',
        //存放刷新令牌的地方
        'refresh_token' => 'redis',
        /*'authorization_code' => 'OAuth2\Storage\AuthorizationCodeInterface',
        'client' => 'OAuth2\Storage\ClientInterface',
        'user_claims' => 'OAuth2\OpenID\Storage\UserClaimsInterface',
        'jwt_bearer' => 'OAuth2\Storage\JWTBearerInterface',*/
    ],
    //server 配置
    'config' => [
        //启用jwt token
        'use_jwt_access_tokens' => false,
        //
        'store_encrypted_token_string' => true,
        //启用open id
        'use_openid_connect' => false,
        //id 生存时间
        'id_lifetime' => 60,
        //访问令牌生存时间
        'access_lifetime' => 60,
        'www_realm' => 'Service',
        //token参数名
        'token_param_name' => 'access_token',
        //token barer头部名
        'token_bearer_header_name' => 'Bearer',
        //启用强制带state
        'enforce_state' => true,
        //
        'require_exact_redirect_uri' => true,
        //
        'allow_implicit' => false,
        //
        'allow_credentials_in_request_body' => true,
        //
        'allow_public_clients' => true,
        //在刷新令牌使用后删除
        'unset_refresh_token_after_use' => true,
        //一直发布新的刷新令牌
        'always_issue_new_refresh_token' => true,
        //刷新令牌生存时间
        'refresh_token_lifetime' => 2419200,
    ],
    //pdo 配置
    'pdoConfig' => [
        //客户端信息表名
        'client_table' => 'oauth_clients',
        //访问令牌表名
        'access_token_table' => 'oauth_access_tokens',
        //刷新令牌表名
        'refresh_token_table' => 'oauth_refresh_tokens',
        //授权码表名
        'code_table' => 'oauth_authorization_codes',
        //用户表名
        'user_table' => 'oauth_users',
        //jwt表名
        'jwt_table'  => 'oauth_jwt',
        //jti表名
        'jti_table'  => 'oauth_jti',
        //请求范围表名
        'scope_table'  => 'oauth_scopes',
        //公钥表名
        'public_key_table'  => 'oauth_public_keys',
        //用户名列名
        'user_column_name' => 'username',
        //密码列名
        'password_column_name' => 'password',
        //密码加密方式
        'password_encrypt' => 'sha1'
    ],
    //redis 配置
    'redisConfig' => [
        //客户端信息key名
        'client_key' => 'oauth_clients:',
        //访问令牌key名
        'access_token_key' => 'oauth_access_tokens:',
        //刷新令牌key名
        'refresh_token_key' => 'oauth_refresh_tokens:',
        //授权码key名
        'code_key' => 'oauth_authorization_codes:',
        //用户信息key名
        'user_key' => 'oauth_users:',
        //jwt key名
        'jwt_key' => 'oauth_jwt:',
        //请求范围key名
        'scope_key' => 'oauth_scopes:',
    ],
    //请求范围
    'scope' => [
        //默认范围
        'default_scope' => 'basic',
        //支持的范围
        'supported_scopes' => array(
            'basic',
            'cache',
            'getImage'
        )
    ],
    //客户端信息
    'clients' => [
        [
            'client_id' => 'demoapp',
            'client_secret' => 'demopass',
            'redirect_uri' => ''
        ]
    ],
    //启用的授权类型
    'grantType' => [
        'client_credentials',
        //'authorization_code',
        'refresh_token',
        //'jwt_bearer',
        'user_credentials'
    ],
    //公钥私钥
    'keys' => array(
        'public_key' => storage_path('key/pubkey.pem'),
        'private_key' => storage_path('key/privkey.pem')
    )
];
