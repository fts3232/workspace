<?php

if (!function_exists('captcha')) {
    /**
     * 返回验证码图片
     *
     * @param string $config 要读取的配置
     * @return mixed
     */
    function captcha($config = 'default')
    {
        return app('captcha')->create($config);
    }
}

if (!function_exists('captcha_src')) {
    /**
     * 返回验证码访问路径
     *
     * @param string $config 要读取的配置
     * @return string
     */
    function captcha_src($config = 'default')
    {
        return app('captcha')->src($config);
    }
}

if (!function_exists('captcha_img')) {
    /**
     * 返回验证码img标签
     *
     * @param string $config 要读取的配置
     * @return mixed
     */
    function captcha_img($config = 'default')
    {
        return app('captcha')->img($config);
    }
}


if (!function_exists('captcha_check')) {
    /**
     * 检查验证码是否正确
     *
     * @param string $value 要检查的值
     * @return bool
     */
    function captcha_check($value)
    {
        return app('captcha')->check($value);
    }
}
