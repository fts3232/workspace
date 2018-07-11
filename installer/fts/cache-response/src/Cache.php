<?php

namespace fts\CacheResponse;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request as LaravelRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Cache
{
    protected $files;

    protected $cachePath;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function setCachePath($path)
    {
        $this->cachePath = rtrim($path, '\/');
    }

    public function cache(Request $request, Response $response)
    {
        list($path, $file) = $this->getDirectoryAndFileNames($request);
        $this->files->makeDirectory($path, 0775, true, true);
        $this->files->put(
            $this->join([$path, $file]),
            $response->getContent(),
            true
        );
    }

    public function getCachePath()
    {
        $base = $this->cachePath ? $this->cachePath : public_path('static');
        if (is_null($base)) {
            throw new Exception('Cache path not set.');
        }
        return $this->join(array_merge([$base], func_get_args()));
    }

    protected function getDirectoryAndFileNames($request)
    {
        $segments = explode('/', ltrim($request->getPathInfo(), '/'));
        $fileName = array_pop($segments);
        $fileName = $fileName ?: 'index';
        $file = $fileName . '.html';
        return [$this->getCachePath(implode('/', $segments)), $file];
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

    public function exists(Request $request)
    {
        list($path, $file) = $this->getDirectoryAndFileNames($request);
        $fileName = $this->join([$path, $file]);

        if ($this->files->exists($fileName)) {
            return $this->files->get($fileName);
        }
        return false;
    }

    public function forget($slug)
    {
        return $this->files->delete($this->getCachePath($slug . '.html'));
    }

    public function clear($slug = '')
    {
        if (!empty($slug)) {
            return $this->files->deleteDirectory($this->getCachePath($slug));
        } else {
            return $this->files->cleanDirectory($this->getCachePath());
        }
    }

    public function getCacheRoute()
    {
        $app = app();
        $routes = $app->routes->getRoutes();
        $temp = array();
        foreach ($routes as $route) {
            $middleware = $route->action['middleware'];
            if ((is_array($middleware) && in_array('cache', $middleware)) || $middleware == 'cache') {
                $temp[] = $route->uri;
            }
        }
    }

    public function createCache($uri)
    {
        $kernel = app(Kernel::class);
        $request = LaravelRequest::createFromBase(Request::create($uri));
        $response = $kernel->handle($request);
        return $this->shouldCache($request, $response);
    }

    private function shouldCache(Request $request, Response $response)
    {
        return $request->isMethod('GET') && $response->getStatusCode() == 200;
    }
}
