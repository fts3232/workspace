<?php

namespace fts\Captcha;

use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Hashing\BcryptHasher as Hasher;
use Illuminate\Session\Store as Session;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

/**
 * 验证码类
 *
 * Class Captcha
 * @package fts\Captcha
 */
class Captcha
{
    /**
     * session类
     *
     * @var Session
     */
    protected $session;

    /**
     * 哈希加密类
     *
     * @var Hasher
     */
    protected $hasher;

    /**
     * 生成验证码的字符集
     *
     * @var string
     */
    protected $characters;

    /**
     * 是否大小写敏感
     *
     * @var bool
     */
    protected $sensitive = false;

    /**
     * 验证码图片背景颜色
     *
     * @var string
     */
    protected $bgColor = '#ffffff';

    /**
     * 画布
     *
     * @var null
     */
    protected $canvas = null;

    /**
     * 验证码长度
     *
     * @var int
     */
    protected $length = 4;

    /**
     * 验证码图片宽度
     *
     * @var int
     */
    protected $width = 120;

    /**
     * 验证码图片高度
     *
     * @var int
     */
    protected $height = 36;

    /**
     * 验证码字符偏移角度
     *
     * @var int
     */
    protected $angle = 15;


    /**
     * 验证码字体
     *
     * @var null
     */
    protected $fonts = null;

    /**
     * 验证码字体颜色
     *
     * @var array
     */
    protected $fontColors = array();

    /**
     * 图片锐化
     *
     * @var int
     */
    protected $sharpen = 0;

    /**
     * 图片模糊
     *
     * @var int
     */
    protected $blur = 0;

    /**
     * 验证码字符是否颠倒
     *
     * @var bool
     */
    protected $invert = false;

    /**
     * 干扰线数量
     *
     * @var int
     */
    protected $lines = 3;

    /**
     * 文件系统类
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * 配置仓库类
     *
     * @var Repository
     */
    protected $config;

    /**
     * 验证码图片质量
     *
     * @var int
     */
    protected $quality = 90;

    /**
     * Captcha constructor.
     * @param Session      $session      session类
     * @param Hasher       $hasher       哈希加密类
     * @param ImageManager $imageManager 图片管理类
     * @param Str          $str          字符类
     * @param Filesystem   $files        文件系统类
     * @param Repository   $config       配置仓库类
     */
    public function __construct(Session $session, Hasher $hasher, ImageManager $imageManager, Str $str, Filesystem $files, Repository $config)
    {
        $this->session = $session;
        $this->hasher = $hasher;
        $this->config = $config;
        $this->imageManager = $imageManager;
        $this->str = $str;
        $this->files = $files;
        $this->characters = config('captcha.characters', '2346789abcdefghjmnpqrtuxyzABCDEFGHJMNPQRTUXYZ');
    }

    /**
     * 输出验证码
     *
     * @param string $config 要读取的配置
     * @return mixed
     */
    public function create($config = 'default')
    {
        //读取字体文件
        $this->fonts = $this->files->files(__DIR__ . '/../assets/fonts');
        $this->fonts = array_values($this->fonts); //reset fonts array index

        //读取配置
        $this->configure($config);

        //生成验证码字符串
        $this->text = $this->generate();

        //创建画布
        $this->canvas = $this->imageManager->canvas(
            $this->width,
            $this->height,
            $this->bgColor
        );

        //将字符串写入画布
        $this->text();

        //生成干扰线
        $this->lines();

        //图片锐化
        if ($this->sharpen) {
            $this->canvas->sharpen($this->sharpen);
        }

        //图片颠倒
        if ($this->invert) {
            $this->canvas->invert($this->invert);
        }

        //图片模糊
        if ($this->blur) {
            $this->canvas->blur($this->blur);
        }

        //输出png图片
        return $this->canvas->response('png', $this->quality);
    }

    /**
     * 读取配置
     *
     * @param string $config 要读取的配置
     */
    protected function configure($config)
    {
        if ($this->config->has('captcha.' . $config)) {
            $config = $this->config->get('captcha.' . $config);
            foreach ($config as $key => $val) {
                $this->{$key} = $val;
            }
        }
    }

    /**
     * 生成字符串
     *
     * @return string
     */
    protected function generate()
    {
        //生成字符串
        $characters = str_split($this->characters);
        $bag = '';
        for ($i = 0; $i < $this->length; $i++) {
            $bag .= $characters[mt_rand(0, count($characters) - 1)];
        }
        //写入session,如果不判断大小写敏感，全部转小写
        $this->session->put('captcha', [
            'sensitive' => $this->sensitive,
            'key' => $this->hasher->make($this->sensitive ? $bag : $this->str->lower($bag))
        ]);

        return $bag;
    }

    /**
     * 写入字符串
     */
    protected function text()
    {
        $marginTop = $this->canvas->height() / $this->length;

        $i = 0;
        foreach (str_split($this->text) as $char) {
            $marginLeft = ($i * $this->canvas->width() / $this->length);
            //写入字符串
            $this->canvas->text($char, $marginLeft, $marginTop, function ($font) {
                $font->file($this->font());
                $font->size($this->fontSize());
                $font->color($this->fontColor());
                $font->align('left');
                $font->valign('top');
                $font->angle($this->angle());
            });

            $i++;
        }
    }

    /**
     * 随机拿字体目录其中一个字体文件
     *
     * @return string
     */
    protected function font()
    {
        return $this->fonts[mt_rand(0, count($this->fonts) - 1)];
    }

    /**
     * 随机字体大小
     *
     * @return integer
     */
    protected function fontSize()
    {
        return mt_rand($this->canvas->height() - 10, $this->canvas->height());
    }

    /**
     * 随机字体颜色
     *
     * @return array
     */
    protected function fontColor()
    {
        if (!empty($this->fontColors)) {
            $color = $this->fontColors[mt_rand(0, count($this->fontColors) - 1)];
        } else {
            $color = [mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255)];
        }

        return $color;
    }

    /**
     * 随机字体角度
     *
     * @return int
     */
    protected function angle()
    {
        return mt_rand((-1 * $this->angle), $this->angle);
    }

    /**
     * 生成干扰线
     *
     * @return null
     */
    protected function lines()
    {
        for ($i = 0; $i <= $this->lines; $i++) {
            $this->canvas->line(
                mt_rand(0, $this->canvas->width()) + $i * mt_rand(0, $this->canvas->height()),
                mt_rand(0, $this->canvas->height()),
                mt_rand(0, $this->canvas->width()),
                mt_rand(0, $this->canvas->height()),
                function ($draw) {
                    $draw->color($this->fontColor());
                }
            );
        }
        return $this->canvas;
    }

    /**
     * 返回验证码img标签
     *
     * @param string $config
     * @return string
     */
    public function img($config = null)
    {
        return '<img src="' . $this->src($config) . '" alt="captcha">';
    }

    /**
     * 返回验证码访问路径
     *
     * @param string $config
     * @return string
     */
    public function src($config = null)
    {
        return url('captcha' . ($config ? '/' . $config : '/default')) . '?' . $this->str->random(8);
    }

    /**
     * 检查验证码是否正确
     *
     * @param string $value 要检查的值
     * @return bool
     */
    public function check($value)
    {
        //如果session不存在，返回false
        if (!$this->session->has('captcha')) {
            return false;
        }

        $key = $this->session->get('captcha.key');

        //如果不判断大小写敏感，全部转小写
        if (!$this->session->get('captcha.sensitive')) {
            $value = $this->str->lower($value);
        }

        //删除session
        $this->session->remove('captcha');

        return $this->hasher->check($value, $key);
    }
}
