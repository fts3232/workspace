<?php

namespace fts\SiteMap;

use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Router;

/**
 * site map 生成
 *
 * Class SiteMap
 * @package fts\SiteMap
 */
class SiteMap
{
    /**
     * 路由类
     *
     * @var Router
     */
    protected $router;

    /**
     * 文件系统类
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * 忽略的路由
     *
     * @var array
     */
    protected $ignoreMap;

    protected $postControllerName;

    protected $tagControllerName;

    protected $categoryTable;

    protected $postTable;

    protected $uriFormat;

    /**
     * SiteMap constructor.
     * @param Router     $router
     * @param Filesystem $filesystem
     * @param Repository $config
     */
    public function __construct(Router $router, Filesystem $filesystem, Repository  $config)
    {
        $this->router = $router;
        $this->filesystem = $filesystem;
        $this->config = $config;
        //读取配置
        $this->configure();
    }

    /**
     * 读取配置
     *
     */
    protected function configure()
    {
        if ($this->config->has('siteMap')) {
            $config = $this->config->get('siteMap');
            foreach ($config as $key => $val) {
                $this->{$key} = $val;
            }
        }
    }

    /**
     * 构建内容
     *
     * @param $data
     * @param $type
     * @return string
     */
    private function buildContent($data, $type)
    {
        $content = '';
        switch ($type) {
            case 'xml':
                $content .= "<url>";
                $content .= "<loc>{$data['uri']}</loc>";
                $content .= "<lastmod>{$data['lastmod']}</lastmod>";
                $content .= "<changefreq>{$data['changefreq']}</changefreq>";
                $content .= "<priority>{$data['priority']}</priority>";
                $content .= "</url>";
                break;
            case 'html':
                $content .= "<li>";
                $content .= "<a href='" . $data['uri'] . "' title='" . $data['title'] . "' target='_blank'>" . $data['title'] . "</a>";
                $content .= "</li>";
                break;
        }
        return $content;
    }

    /**
     * 路由分组
     *
     * @return array
     */
    private function routeChunk()
    {
        $return = array('page' => [], 'post' => [], 'tag' => []);
        $routes = $this->router->getRoutes();
        foreach ($routes as $route) {
            $middleware = $route->action['middleware'];
            if (!in_array($route->uri, $this->ignoreMap) && ((is_array($middleware) && in_array('web', $middleware)) || $middleware == 'web')) {
                $controller = $route->action['controller'];
                $params = explode('@', $controller);
                if ($params[0] == $this->postControllerName) {
                    $return['post'][] = $params[1];
                } else {
                    $return['page'][] = $route;
                }
            }
        }
        return $return;
    }

    /**
     * 构建site map
     */
    public function build()
    {
        $routes = $this->router->getRoutes();
        $xmlContent = '';
        $htmlContent = '';
        $routeChunk = $this->routeChunk();
        //页面
        $htmlContent .= '<h3>页面</h3>';
        foreach ($routeChunk['page'] as $route) {
            $content = $this->buildPage($route);
            $xmlContent .= $content['xml'];
            $htmlContent .= $content['html'];
        }
        //文章
        $htmlContent .= '<h3>文章</h3>';
        foreach ($routeChunk['post'] as $route) {
            $content = $this->buildPost($route);
            $xmlContent .= $content['xml'];
            $htmlContent .= $content['html'];
        }
        //标签
        $htmlContent .= '<h3>标签</h3>';
        foreach ($routeChunk['tag'] as $tag) {
            $content = $this->buildTag($tag);
            $xmlContent .= $content['xml'];
            $htmlContent .= $content['html'];
        }
        //生成文件
        $this->buildXML($xmlContent);
        $this->buildHTML($htmlContent);
    }

    /**
     * 构建文章
     *
     * @param $slug
     * @return array
     */
    private function buildPost($slug)
    {
        $xmlContent = '';
        $htmlContent = '';
        $parent = \DB::table($this->categoryTable['tableName'])
            ->where($this->categoryTable['slugField'], $slug)
            ->first([$this->categoryTable['primaryKey']]);
        $child = \DB::table($this->categoryTable['tableName'])
            ->where($this->categoryTable['parentField'], $parent->CATEGORY_ID)
            ->pluck($this->categoryTable['primaryKey']);
        $posts = \DB::table($this->postTable['tableName'])
            ->whereIn($this->postTable['categoryField'], $child)
            ->get();
        $postTitleField = $this->postTable['titleField'];
        $postPublishedTImeField = $this->postTable['publishedTimeField'];
        foreach ($posts as $post) {
            $publishedTime = strtotime($post->$postPublishedTImeField);
            $data = array(
                'lastmod' => date("Y-m-d\TH:i:s+00:00", $publishedTime),
                'changefreq' => 'daily',
                'priority' => '0.7',
                'title' => $post->$postTitleField
            );
            if (isset($this->uriFormat[$slug])) {
                $data['uri'] = $this->replacePostUriFormat($post, $this->uriFormat[$slug]);
            }
            $xmlContent .= $this->buildContent($data, 'xml');
            $htmlContent .= $this->buildContent($data, 'html');
        }
        return ['xml' => $xmlContent, 'html' => $htmlContent];
    }

    /**
     * 替换uri格式
     *
     * @param $post
     * @param $format
     * @return mixed
     */
    private function replacePostUriFormat($post, $format)
    {
        $postPublishedTImeField = $this->postTable['publishedTimeField'];
        $postPrimaryKey = $this->postTable['primaryKey'];
        $publishedTime = strtotime($post->$postPublishedTImeField);
        $uri = str_replace("{date}", date('Y-m-d', $publishedTime), $format);
        $uri = str_replace("{id}", $post->$postPrimaryKey, $uri);
        return url($uri);
    }

    /**
     * 构建页面
     *
     * @param $route
     * @return array
     */
    private function buildPage($route)
    {
        $data = array(
            'uri' => url($route->uri),
            'lastmod' => date("Y-m-d\TH:i:s+00:00", time()),
            'changefreq' => 'daily',
            'priority' => '0.7',
            'title' => isset($route->action['as']) ? $route->action['as'] : ''
        );
        return ['xml' => $this->buildContent($data, 'xml'), 'html' => $this->buildContent($data, 'html')];
    }

    /**
     * 构建xml
     *
     * @param $contents
     */
    public function buildXML($contents)
    {
        $begin = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
        $end = '</urlset>';
        $xml = $begin . $contents . $end;
        $this->filesystem->put(
            public_path('sitemap.xml'),
            $xml,
            true
        );
    }

    /**
     * 构建html
     *
     * @param $contents
     */
    public function buildHTML($contents)
    {
        $begin = '<html><head><meta charset="UTF-8"></head><body>';
        $end = '</body></html>';
        $this->filesystem->put(
            public_path('sitemap.html'),
            $begin . $contents . $end,
            true
        );
    }
}
