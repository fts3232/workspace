<?php

namespace fts\OAuth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\RequestGuard;
use fts\OAuth\Guards\TokenGuard;

class OAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish configuration files
        $this->publishes([
            __DIR__ . '/../config/oauth2.php' => config_path('oauth2.php')
        ], 'config');

        $this->app['router']
            ->post('oauth/token', '\fts\OAuth\OAuthController@token')
            ->middleware(['api']);
    }


    public function register()
    {
        $this->app->singleton(OAuth::class, function ($app) {
            $instance = new OAuth(
                $app['redis'],
                $app['Illuminate\Config\Repository']
            );
            return $instance;
        });
    }
}
