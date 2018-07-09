<?php

namespace fts\Captcha;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Hashing\BcryptHasher as Hasher;
use Illuminate\Session\Store as Session;
use Illuminate\Config\Repository;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class Captcha
{
    protected $session;

    protected $hasher;

    protected $characters;

    protected $sensitive = false;
    protected $bgColor = '#ffffff';

    protected $canvas = null;

    protected $length = 4;
    /**
     * @var int
     */
    protected $width = 120;

    /**
     * @var int
     */
    protected $height = 36;

    /**
     * @var int
     */
    protected $angle = 15;


    protected $fonts = null;

    /**
     * @var int
     */
    protected $sharpen = 0;

    /**
     * @var int
     */
    protected $blur = 0;

    /**
     * @var bool
     */
    protected $invert = false;

    protected $lines = 3;

    protected $files;

    protected $config;

    /**
     * @var int
     */
    protected $quality = 90;


    public function __construct(Session $session, Hasher $hasher, ImageManager $imageManager, Str $str, Filesystem $files,Repository $config)
    {
        $this->session = $session;
        $this->hasher = $hasher;
        $this->config = $config;
        $this->imageManager = $imageManager;
        $this->str = $str;
        $this->files = $files;
        $this->characters = config('captcha.characters','2346789abcdefghjmnpqrtuxyzABCDEFGHJMNPQRTUXYZ');
    }

    public function create($config = 'default')
    {
        $this->fonts = $this->files->files(__DIR__ . '/../assets/fonts');
        $this->fonts = array_values($this->fonts); //reset fonts array index

        $this->configure($config);

        $this->text = $this->generate();

        $this->canvas = $this->imageManager->canvas(
            $this->width,
            $this->height,
            $this->bgColor
        );
        $this->image = $this->canvas;

        $this->text();

        $this->lines();

        if ($this->sharpen) {
            $this->image->sharpen($this->sharpen);
        }
        if ($this->invert) {
            $this->image->invert($this->invert);
        }
        if ($this->blur) {
            $this->image->blur($this->blur);
        }
        return $this->image->response('png', $this->quality);
    }

    protected function configure($config)
    {
        if ($this->config->has('captcha.' . $config)) {
            $config = $this->config->get('captcha.' . $config);
            foreach ($config as $key => $val) {
                $this->{$key} = $val;
            }
        }
    }


    protected function generate()
    {
        $characters = str_split($this->characters);

        $bag = '';
        for ($i = 0; $i < $this->length; $i++) {
            $bag .= $characters[rand(0, count($characters) - 1)];
        }

        $this->session->put('captcha', [
            'sensitive' => $this->sensitive,
            'key' => $this->hasher->make($this->sensitive ? $bag : $this->str->lower($bag))
        ]);

        return $bag;
    }

    protected function text()
    {
        $marginTop = $this->image->height() / $this->length;

        $i = 0;
        foreach (str_split($this->text) as $char) {
            $marginLeft = ($i * $this->image->width() / $this->length);

            $this->image->text($char, $marginLeft, $marginTop, function ($font) {
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
     * Image fonts
     *
     * @return string
     */
    protected function font()
    {
        return $this->fonts[rand(0, count($this->fonts) - 1)];
    }

    /**
     * Random font size
     *
     * @return integer
     */
    protected function fontSize()
    {
        return rand($this->image->height() - 10, $this->image->height());
    }

    /**
     * Random font color
     *
     * @return array
     */
    protected function fontColor()
    {
        if (!empty($this->fontColors)) {
            $color = $this->fontColors[rand(0, count($this->fontColors) - 1)];
        } else {
            $color = [rand(0, 255), rand(0, 255), rand(0, 255)];
        }

        return $color;
    }

    /**
     * Angle
     *
     * @return int
     */
    protected function angle()
    {
        return rand((-1 * $this->angle), $this->angle);
    }

    protected function lines()
    {
        for ($i = 0; $i <= $this->lines; $i++) {
            $this->image->line(
                rand(0, $this->image->width()) + $i * rand(0, $this->image->height()),
                rand(0, $this->image->height()),
                rand(0, $this->image->width()),
                rand(0, $this->image->height()),
                function ($draw) {
                    $draw->color($this->fontColor());
                }
            );
        }
        return $this->image;
    }

    public function img($config = null)
    {
        return '<img src="' . $this->src($config) . '" alt="captcha">';
    }

    public function src($config = null)
    {
        return url('captcha' . ($config ? '/' . $config : '/default')) . '?' . $this->str->random(8);
    }

    public function check($value)
    {
        if (!$this->session->has('captcha')) {
            return false;
        }

        $key = $this->session->get('captcha.key');

        if (!$this->session->get('captcha.sensitive')) {
            $value = $this->str->lower($value);
        }

        $this->session->remove('captcha');

        return $this->hasher->check($value, $key);
    }
}
