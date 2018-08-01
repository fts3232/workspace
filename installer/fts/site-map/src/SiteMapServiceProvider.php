<?php

namespace fts\SiteMap;

use fts\SiteMap\Console\CreateSiteMap;
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
        $this->publishes([
            __DIR__ . '/../config/siteMap.php' => config_path('siteMap.php')
        ]);

        //添加构建site map命令
        $this->commands(CreateSiteMap::class);
    }

    public function register()
    {
        $this->app->singleton(SiteMap::class, function ($app) {
            return new SiteMap($app['router'], $app['files'], $app['Illuminate\Config\Repository']);
        });
    }

    /**
     * 获取由提供者提供的服务.
     *
     * @return array
     */
    public function provides()
    {
        return [SiteMap::class];
    }
}
