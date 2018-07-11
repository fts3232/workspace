<?php

if (!function_exists('upload_image')) {

    /**
     * @param string $config
     * @return mixed
     */
    function upload_image($key, $fileName = '')
    {
        return app('uploadImage')->upload($key, $fileName);
    }
}
