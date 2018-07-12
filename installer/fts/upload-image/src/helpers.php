<?php

if (!function_exists('upload_image')) {

    /**
     * 上传图片辅助函数
     *
     * @param string $key      上传文件的key值
     * @param string $fileName 保存的文件名
     * @return mixed
     */
    function upload_image($key, $fileName = '')
    {
        return app('uploadImage')->upload($key, $fileName);
    }
}
