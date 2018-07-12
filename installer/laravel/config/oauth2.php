<?php
return [
    'storage' => 'redis',
    'config' => [
        'use_jwt_access_tokens' => false,
        'store_encrypted_token_string' => true,
        'use_openid_connect' => false,
        'id_lifetime' => 60,
        'access_lifetime' => 600,
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
        'refresh_token_lifetime'         => 2419200,
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
        'authorization_code',
        'refresh_token'
    ]
];
