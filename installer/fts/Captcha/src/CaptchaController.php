<?php

namespace fts\Captcha;

use fts\Captcha\Captcha;
use Illuminate\Routing\Controller;

/**
 * Class CaptchaController
 * @package Mews\Captcha
 */
class CaptchaController extends Controller
{

    /**
     * 返回验证码图片
     *
     * @param \fts\Captcha\Captcha $captcha 验证码类
     * @param string               $config  要读取的配置
     * @return mixed
     */
    public function getCaptcha(Captcha $captcha, $config = 'default')
    {
        return $captcha->create($config);
    }

}