<?php
return [
    'storage' => [
        'client_credentials' => 'memory',
        'public_key'=>'memory',
        'user_credentials' => 'pdo',
        'access_token' => 'redis',
        'scope' => 'memory',
        'refresh_token' => 'redis',
        /*'authorization_code' => 'OAuth2\Storage\AuthorizationCodeInterface',
        'client' => 'OAuth2\Storage\ClientInterface',
        'refresh_token' => 'OAuth2\Storage\RefreshTokenInterface',
        'user_claims' => 'OAuth2\OpenID\Storage\UserClaimsInterface',
        'jwt_bearer' => 'OAuth2\Storage\JWTBearerInterface',*/
    ],
    'config' => [
        'use_jwt_access_tokens' => false,
        'store_encrypted_token_string' => true,
        'use_openid_connect' => false,
        'id_lifetime' => 60,
        'access_lifetime' => 60,
        'www_realm' => 'Service',
        'token_param_name' => 'access_token',
        'token_bearer_header_name' => 'Bearer',
        'enforce_state' => true,
        'require_exact_redirect_uri' => true,
        'allow_implicit' => false,
        'allow_credentials_in_request_body' => true,
        'allow_public_clients' => true,
        'unset_refresh_token_after_use' => true,
        'always_issue_new_refresh_token' => true,
        'refresh_token_lifetime' => 2419200,
    ],
    'pdoConfig' => [
        'client_table' => 'oauth_clients',
        'access_token_table' => 'oauth_access_tokens',
        'refresh_token_table' => 'oauth_refresh_tokens',
        'code_table' => 'oauth_authorization_codes',
        'user_table' => 'user',
        'jwt_table'  => 'oauth_jwt',
        'jti_table'  => 'oauth_jti',
        'scope_table'  => 'oauth_scopes',
        'public_key_table'  => 'oauth_public_keys',
        'user_column_name' => 'user_name',
        'password_column_name' => 'password',
        'password_encrypt' => 'md5'
    ],
    'redisConfig' => [
        'client_key' => 'oauth_clients:',
        'access_token_key' => 'oauth_access_tokens:',
        'refresh_token_key' => 'oauth_refresh_tokens:',
        'code_key' => 'oauth_authorization_codes:',
        'user_key' => 'oauth_users:',
        'jwt_key' => 'oauth_jwt:',
        'scope_key' => 'oauth_scopes:',
    ],
    'scope' => [
        'default_scope' => 'basic',
        'supported_scopes' => array(
            'basic',
            'cache',
            'getImage'
        )
    ],
    'clients' => [
        [
            'client_id' => 'demoapp',
            'client_secret' => 'demopass',
            'redirect_uri' => ''
        ]
    ],
    'grantType' => [
        'client_credentials',
        //'authorization_code',
        'refresh_token',
        //'jwt_bearer',
        'user_credentials'
    ],
    'keys' => array(
        'public_key' => storage_path('key/pubkey.pem'),
        'private_key' => storage_path('key/privkey.pem')
    )
];
