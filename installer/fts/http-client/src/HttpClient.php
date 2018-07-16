<?php

namespace fts\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7;

/**
 * http请求类
 *
 * Class HttpClient
 * @package fts\HttpClient
 */
class HttpClient
{
    /**
     * cuzzle http类
     *
     * @var Client
     */
    protected $client;

    /**
     * 参数选项
     *
     * @var array
     */
    protected $options;

    /**
     * HttpClient constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->options = array(
            'timeout' => 5, //返回响应超时时间
            'connect_timeout' => 5, //链接超时时间
            'query' => [],//get参数
            'form_params' => [],//form表单参数
            'body' => '', //主体部分
            'auth' => [], //认证信息
            /*'multipart' => [//multipart/form-data 表单参数
                [
                    'name'     => 'field_name',
                    'contents' => 'abc'
                ],
                [
                    'name'     => 'file_name',
                    'contents' => fopen('/path/to/file', 'r')
                ],
                [
                    'name'     => 'other_file',
                    'contents' => 'hello',
                    'filename' => 'filename.txt',
                    'headers'  => [
                        'X-Foo' => 'this is an extra header to include'
                    ]
                ]
            ]*/
        );
    }

    /**
     * 发送请求
     *
     * @param string $type    请求类型
     * @param string $uri     请求uri
     * @param array  $options 请求选项
     * @return array|mixed|object|string
     */
    public function request($type, $uri, $options = array())
    {
        try {
            $options = array_merge($this->options, $options);
            $response = $this->client->request($type, $uri, $options);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }
        $header = $response->getHeaders();
        $contentType = $response->getHeader('content-type');
        $body = $response->getBody();
        $content = $body->getContents();
        if($contentType[0] == 'application/json'){
            $content = json_decode($content,true);
        }
        return [
            //获取响应的状态码
            'code' => $response->getStatusCode(),
            //获取响应内容
            'body' => $body,
            'content' => $content,
            //获取响应头部
            'header' => $header
        ];
    }

    /**
     * 发送http异步请求
     *
     * @param string $type    请求类型
     * @param string $uri     请求uri
     * @param array  $options 请求选项
     * @return mixed
     */
    public function requestAsync($type, $uri, $options = array())
    {
        $options = array_merge($this->options, $options);
        $promise = $this->client->requestAsync($type, $uri, $options);
        return $promise->then(
            function (ResponseInterface $response) {
                $header = $response->getHeaders();
                $contentType = $response->getHeader('content-type');
                $body = $response->getBody();
                $content = $body->getContents();
                if($contentType[0] == 'application/json'){
                    $content = json_decode($content,true);
                }
                return [
                    //获取响应的状态码
                    'code' => $response->getStatusCode(),
                    //获取响应内容
                    'body' => $body,
                    'content' => $content,
                    //获取响应头部
                    'header' => $header
                ];
            },
            function (RequestException $e) {
                $response = $e->getResponse();
                $header = $response->getHeaders();
                $contentType = $response->getHeader('content-type');
                $body = $response->getBody();
                $content = $body->getContents();
                if($contentType[0] == 'application/json'){
                    $content = json_decode($content,true);
                }
                return [
                    //获取响应的状态码
                    'code' => $response->getStatusCode(),
                    //获取响应内容
                    'body' => $body,
                    'content' => $content,
                    //获取响应头部
                    'header' => $header
                ];
            }
        )->wait();
    }
}
