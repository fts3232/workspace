<?php

namespace fts\OAuth2;

use Illuminate\Support\ServiceProvider;

class OAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // 发布配置文件  run php artisan vendor:publish
        $this->publishes([
            __DIR__ . '/../config/oauth2.php' => config_path('oauth2.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../key/privkey.pem' => storage_path('key/privkey.pem'),
            __DIR__ . '/../key/pubkey.pem' => storage_path('key/pubkey.pem')
        ]);

        //获取token 路由
        $this->app['router']
            ->post('oauth/token', '\fts\OAuth2\OAuthController@token')
            ->middleware(['api']);
    }


    public function register()
    {
        $this->app->singleton(OAuth2::class, function ($app) {
            $instance = new OAuth2(
                $app['Illuminate\Config\Repository'],
                $app['redis'],
                $app['Illuminate\Database\DatabaseManager']->getPDO()
            );
            return $instance;
        });
    }
}
