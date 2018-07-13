<?php

namespace fts\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7;

class HttpClient
{
    protected $client;

    protected $options;

    public function __construct()
    {
        $this->client = new Client();
        $this->options = array(
            'timeout' => 5,
            'connect_timeout' => 5,
            'query' => [],//get
            'form_params' => [],//post
            'body' => '',
            'auth'=>[],
            /*'multipart' => [//file
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

    public function request($type, $uri, $options = array())
    {
        try {
            $options = array_merge($this->options, $options);
            $response = $this->client->request($type, $uri, $options);
            $contentType = $response->getHeader('Content-Type');
            $body = $response->getBody();
            if ($contentType[0] == 'application/json') {
                return json_decode($body, true);
            } else {
                return (string)$body;
            }
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $contentType = $e->getResponse()->getHeader('Content-Type');
            $body = $response->getBody();
            if ($contentType[0] == 'application/json') {
                return json_decode($body, true);
            } else {
                return (string)$body;
            }
        }
    }

    public function requestAsync($type, $uri, $options = array())
    {
        $options = array_merge($this->options, $options);
        $promise = $this->client->requestAsync($type, $uri, $options);
        return $promise->then(
            function (ResponseInterface $res) {
                $contentType = $res->getHeader('Content-Type');
                $body = $res->getBody();
                if ($contentType[0] == 'application/json') {
                    return json_decode($body, true);
                } else {
                    return (string)$body;
                }
            },
            function (RequestException $e) {
                $res = $e->getResponse();
                $contentType = $res->getHeader('Content-Type');
                $body = $res->getBody();
                if ($contentType[0] == 'application/json') {
                    return json_decode($body, true);
                } else {
                    return (string)$body;
                }
            }
        )->wait();
    }
}
