<?php

if (!function_exists('http_request')) {
    /**
     * 发送http请求辅助函数
     *
     * @param $type 请求类型
     * @param $url  请求url
     * @param array $options  请求选项
     * @return mixed
     */
    function http_request($type, $url, $options = array())
    {
        return app('fts\HttpClient\HttpClient')->request($type, $url, $options);
    }
}
