<?php

namespace fts\UploadImage;

use Illuminate\Config\Repository;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * 上传图片类
 *
 * Class UploadImage
 * @package fts\UploadImage
 */
class UploadImage
{
    /**
     * 请求类
     *
     * @var Request
     */
    protected $request;

    /**
     * 允许上传的文件类型
     *
     * @var array
     */
    protected $allowTypes;

    /**
     * /允许上传的文件大小
     *
     * @var float|int
     */
    protected $maxSize;

    /**
     * 配置仓库类
     *
     * @var Repository
     */
    protected $config;

    /**
     * 图片管理类
     *
     * @var ImageManager
     */
    protected $imageManager;

    /**
     * 是否打上水印
     *
     * @var bool
     */
    protected $watermark = false;

    /**
     * 水印图片地址
     *
     * @var string
     */
    protected $watermarkImage;

    /**
     * 水印图片位置
     *
     * @var string
     */
    protected $watermarkPosition;

    /**
     * 水印图片位置x轴偏移数量
     *
     * @var int
     */
    protected $watermarkPositionX;

    /**
     * 水印图片位置Y轴偏移数量
     *
     * @var int
     */
    protected $watermarkPositionY;

    /**
     * UploadImage constructor.
     *
     * @param Request      $request      请求类
     * @param Repository   $config       配置类
     * @param ImageManager $imageManager 图片管理类
     */
    public function __construct(Request $request, Repository $config, ImageManager $imageManager)
    {
        //请求类
        $this->request = $request;
        //配置类
        $this->config = $config;
        //图片管理类
        $this->imageManager = $imageManager;
        //读取配置
        $this->configure();
    }

    /**
     * 读取配置文件的配置项
     */
    protected function configure()
    {
        if ($this->config->has('uploadImage')) {
            $config = $this->config->get('uploadImage');
            foreach ($config as $key => $val) {
                $this->{$key} = $val;
            }
        }
    }

    /**
     * 路径拼接
     *
     * @param array $paths 路径数组
     * @return string 拼接后的路径
     */
    protected function join(array $paths)
    {
        //过滤左右两边的/
        $trimmed = array_map(function ($path) {
            return trim($path, '/');
        }, $paths);
        //判断是否需要前面补上/
        return $this->matchRelativity(
            $paths[0],
            implode('/', array_filter($trimmed))
        );
    }

    /**
     * 如果source第一位是/,则在target前补上/
     *
     * @param string $source 源路径
     * @param string $target 目标路径
     * @return string 拼接后的路径
     */
    protected function matchRelativity($source, $target)
    {
        return $source[0] == '/' ? '/' . $target : $target;
    }

    /**
     * 上传图片辅助函数
     *
     * @param string $key      上传文件的key值
     * @param string $fileName 保存的文件名
     * @return array 结果数组
     */
    public function upload($key, $fileName = '')
    {
        $data = array('status' => true);

        try {
            $file = $this->request->file($key);
            //判断文件是否正确
            if (!$file || !$file->isValid()) {
                throw new \Exception('上传文件不正确', 100);
            }
            //判断格式
            if (!in_array($file->getmimeType(), $this->allowTypes)) {
                throw new \Exception('上传文件格式不正确', 101);
            }
            //判断大小
            if ($file->getSize() >= $this->maxSize) {
                throw new \Exception('上传文件大小不正确', 102);
            }
            //判断上传目录是否存在，不存在则创建目录
            if (!file_exists($this->uploadDir)) {
                $result = mkdir($this->uploadDir, 0755, true);
                if (!$result) {
                    throw new \Exception('创建上传目录失败', 103);
                }
            }
            //判断上传目录是否可写
            if (!is_writable($this->uploadDir)) {
                throw new \Exception('上传目录不可写', 104);//upload.error.notWritable
            }
            //获取文件后缀
            $extension = $file->extension();
            //若没指定保存的文件名，按当前时间命名
            if (!$fileName) {
                $fileName = date("YmdHis") . floor(microtime() * 1000) . '.' . $extension;
            }
            //创建图片
            $img = $this->imageManager->make($file);
            //是否需要打上谁赢
            if ($this->watermark) {
                $img->insert(
                    $this->watermarkImage,
                    $this->watermarkPosition,
                    $this->watermarkPositionX,
                    $this->watermarkPositionY
                );
            }
            //文件写入到上传目录
            if (!$img->save($this->join([$this->uploadDir, $fileName]))) {
                throw new \Exception('上传文件写入失败', 105);
            }
            //返回保存后的文件名
            $data['fileName'] = $fileName;
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
