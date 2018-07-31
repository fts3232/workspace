<?php

namespace fts\SiteMap;

use Illuminate\Support\ServiceProvider;

class SiteMapServiceProvider extends ServiceProvider
{

    /**
     * 服务提供者加是否延迟加载.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        // 发布配置文件 run php artisan vendor:publish
    }

    public function register()
    {
        $this->app->singleton('siteMap', function ($app) {
            return new SiteMap($app['router'],$app['files']);
        });
    }

    /**
     * 获取由提供者提供的服务.
     *
     * @return array
     */
    public function provides()
    {
        return ['siteMap'];
    }
}
