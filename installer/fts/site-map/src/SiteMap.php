<?php

namespace fts\SiteMap;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Router;

class SiteMap
{
    protected $router;

    protected $filesystem;

    protected $ignoreMap;

    public function __construct(Router $router, Filesystem $filesystem)
    {
        //
        $this->router = $router;
        $this->filesystem = $filesystem;
        $this->ignoreMap = array(
            'captcha/{config?}'
        );
        $this->create();
    }

    public function create()
    {
        $routes = $this->router->getRoutes();
        $xmlStr = '';
        $htmlStr = '';
        foreach ($routes as $route) {
            $uri = url($route->uri);
            $controller = $route->action['controller'];
            $params = explode('@',$controller);
            $as = isset($route->action['as']) ? $route->action['as'] : '';
            $middleware = $route->action['middleware'];
            if (!in_array($route->uri, $this->ignoreMap) && ((is_array($middleware) && in_array('web', $middleware)) || $middleware == 'web')) {

                if($params[0] == 'App\Http\Controllers\PostsController'){
                    echo 1;
                }

                $lastmod = date("Y-m-d\TH:i:s+00:00", time());
                $changefreq = 'daily';
                $priority = '0.7';
                $xmlStr .= "<url>";
                $xmlStr .= "<loc>$uri</loc>";
                $xmlStr .= "<lastmod>$lastmod</lastmod>";
                $xmlStr .= "<changefreq>$changefreq</changefreq>";
                $xmlStr .= "<priority>$priority</priority>";
                $xmlStr .= "</url>";

                $htmlStr .= "<li>";
                $htmlStr .= "<a href='" . $uri . "' title='" . $as . "' target='_blank'>" . $as . "</a>";
                $htmlStr .= "</li>";
            }
        }
        $this->xml($xmlStr);
        $this->html($htmlStr);
    }

    public function xml($contents)
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

    public function html($contents)
    {
        $this->filesystem->put(
            public_path('sitemap.html'),
            $contents,
            true
        );
    }
}
