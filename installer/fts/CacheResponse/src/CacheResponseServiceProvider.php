<?php

namespace fts\CacheResponse;

use Illuminate\Support\ServiceProvider;

class CacheResponseServiceProvider extends ServiceProvider
{
    public function register()
    {
        //$this->commands(ClearCache::class);
        $this->app->singleton(Cache::class, function () {
            $instance = new Cache($this->app->make('files'));
            return $instance;
        });
    }
}
