<?php

namespace fts\UploadImage;

use Illuminate\Support\ServiceProvider;

class UploadImageServiceProvider extends ServiceProvider
{
    /**
     * 服务提供者加是否延迟加载.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        // Publish configuration files
        $this->publishes([
            __DIR__ . '/../config/uploadImage.php' => config_path('uploadImage.php')
        ], 'config');
    }

    public function register()
    {
        $this->app->singleton('uploadImage', function ($app) {
            return new UploadImage(
                $app['request'],
                $app['Illuminate\Config\Repository']
            );
        });
    }

    /**
     * 获取由提供者提供的服务.
     *
     * @return array
     */
    public function provides()
    {
        return ['uploadImage'];
    }
}
