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
    ]
];
