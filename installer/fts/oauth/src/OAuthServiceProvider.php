<?php

namespace fts\OAuth;

use Illuminate\Support\ServiceProvider;

class OAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish configuration files
        $this->publishes([
            __DIR__ . '/../config/api.php' => config_path('api.php')
        ], 'config');

        $this->app['router']->post('oauth/token', '\fts\OAuth\OAuthController@token');
    }


    public function register()
    {
        $this->app->singleton(OAuth::class, function ($app) {
            $instance = new OAuth(
                $app['redis']
            );
            return $instance;
        });
    }

    /**
     * 获取由提供者提供的服务.
     *
     * @return array
     */
    public function provides()
    {
        return [OAuth::class];
    }
}
