<?php

namespace fts\CacheResponse;

use Illuminate\Support\ServiceProvider;
use fts\CacheResponse\Console\ClearCache;
use fts\CacheResponse\Console\CreateCache;

class CacheResponseServiceProvider extends ServiceProvider
{
    /**
     * 服务提供者加是否延迟加载.
     *
     * @var bool
     */
    protected $defer = true;

    public function register()
    {
        $this->commands(ClearCache::class);
        $this->commands(CreateCache::class);
        $this->app->singleton(Cache::class, function () {
            $instance = new Cache($this->app->make('files'));
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
        return [Cache::class];
    }
}
