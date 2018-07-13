<?php

namespace fts\OAuth2;

use Illuminate\Support\ServiceProvider;

class OAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish configuration files
        $this->publishes([
            __DIR__ . '/../config/oauth2.php' => config_path('oauth2.php')
        ], 'config');

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
