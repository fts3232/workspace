<?php

namespace fts\Captcha;

use Illuminate\Support\ServiceProvider;

class CaptchaServiceProvider extends ServiceProvider
{
    /**
     * 服务提供者加是否延迟加载.
     *
     * @var bool
     */

    public function boot()
    {
        // Publish configuration files
        $this->publishes([
            __DIR__ . '/../config/captcha.php' => config_path('captcha.php')
        ], 'config');

        // HTTP routing
        $this->app['router']->get('captcha/{config?}', '\fts\Captcha\CaptchaController@getCaptcha')->middleware('web');

        // Validator extensions
        $this->app['validator']->extend('captcha', function ($attribute, $value, $parameters) {
            return captcha_check($value);
        });
    }

    public function register()
    {
        $this->app->singleton('captcha', function ($app) {
            return new Captcha(
                $app['Illuminate\Session\Store'],
                $app['Illuminate\Hashing\BcryptHasher'],
                $app['Intervention\Image\ImageManager'],
                $app['Illuminate\Support\Str'],
                $app['Illuminate\Filesystem\Filesystem'],
                $app['Illuminate\Config\Repository']
            );
        });
    }
}
