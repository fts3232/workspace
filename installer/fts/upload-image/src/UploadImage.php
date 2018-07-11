<?php

namespace fts\UploadImage;

use Illuminate\Config\Repository;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\Request;

class UploadImage
{
    protected $request;

    protected $allowTypes;

    protected $maxSize;

    protected $upload;

    protected $config;

    protected $imageManager;

    protected $watermark = false;

    protected $watermarkImage;

    protected $watermarkPosition;

    protected $watermarkPositionX;

    protected $watermarkPositionY;

    public function __construct(Request $request, Repository $config, ImageManager $imageManager)
    {
        $this->request = $request;
        $this->config = $config;
        $this->imageManager = $imageManager;
        $this->allowTypes = array('image/png', 'image/jpeg', 'image/pjpeg', 'image/jpeg', 'image/gif');
        $this->maxSize = 1024 * 1024 * 1;
        $this->uploadDir = storage_path('upload');

        $this->configure();
    }

    protected function configure()
    {
        if ($this->config->has('uploadImage')) {
            $config = $this->config->get('uploadImage');
            foreach ($config as $key => $val) {
                $this->{$key} = $val;
            }
        }
    }

    protected function join(array $paths)
    {
        $trimmed = array_map(function ($path) {
            return trim($path, '/');
        }, $paths);
        return $this->matchRelativity(
            $paths[0],
            implode('/', array_filter($trimmed))
        );
    }

    protected function matchRelativity($source, $target)
    {
        return $source[0] == '/' ? '/' . $target : $target;
    }

    public function upload($key, $fileName = '')
    {
        $data = array('status' => true);

        try {
            $file = $this->request->file($key);
            if (!$file || !$file->isValid()) {
                throw new \Exception('上传文件不正确', 100);
            }
            if (!in_array($file->getmimeType(), $this->allowTypes)) {
                throw new \Exception('上传文件格式不正确', 101);
            }
            if ($file->getSize() >= $this->maxSize) {
                throw new \Exception('上传文件大小不正确', 102);
            }

            if (!file_exists($this->uploadDir)) {
                $result = mkdir($this->uploadDir, 0755, true);
                if (!$result) {
                    throw new \Exception('创建上传目录失败', 103);
                }
            }
            if (!is_writable($this->uploadDir)) {
                throw new \Exception('上传目录不可写', 104);//upload.error.notWritable
            }
            $extension = $file->extension();
            if (!$fileName) {
                $fileName = date("YmdHis") . floor(microtime() * 1000) . '.' . $extension;
            }

            $img = $this->imageManager->make($file);
            if ($this->watermark) {
                $img->insert($this->watermarkImage, $this->watermarkPosition, $this->watermarkPositionX, $this->watermarkPositionY);
            }

            if (!$img->save($this->join([$this->uploadDir, $fileName]))) {
                throw new \Exception('上传文件写入失败', 105);
            }
            $data['file'] = $this->join([$this->uploadDir, $fileName]);
        } catch (\Exception $e) {
            $data = array(
                'msg' => $e->getMessage(),
                'code' => $e->getCode(),
                'status' => false
            );
        }
        return $data;
    }
}
