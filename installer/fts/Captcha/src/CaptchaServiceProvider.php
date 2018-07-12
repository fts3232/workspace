<?php

namespace fts\Captcha;

use Illuminate\Support\ServiceProvider;

class CaptchaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // 发布配置文件  run php artisan vendor:publish
        $this->publishes([
            __DIR__ . '/../config/captcha.php' => config_path('captcha.php')
        ], 'config');

        //验证码http路由
        $this->app['router']->get('captcha/{config?}', '\fts\Captcha\CaptchaController@getCaptcha')->middleware('web');

        //扩展检查验证码方法
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
