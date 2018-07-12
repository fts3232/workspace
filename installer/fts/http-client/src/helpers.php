<?php

if (!function_exists('http_request')) {

    /**
     * @param string $config
     * @return mixed
     */
    function http_request($type, $url, $options = array())
    {
        return app('fts\HttpClient\HttpClient')->request($type, $url, $options);
    }
}
