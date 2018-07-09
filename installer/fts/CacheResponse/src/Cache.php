<?php
namespace fts\CacheResponse;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Container\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Redis\RedisManager;

class Cache{
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
        $base = $this->cachePath ? $this->cachePath : 'static';
        if (is_null($base)) {
            throw new Exception('Cache path not set.');
        }
        return $this->join(array_merge([$base], func_get_args()));
    }

    protected function getDirectoryAndFileNames($request)
    {
        $segments = explode('/', ltrim($request->getPathInfo(), '/'));
        $fileName = array_pop($segments);
        $fileName = $fileName ? : 'index';
        $file = $fileName.'.html';
        return [$this->getCachePath(implode('/', $segments)), $file];
    }

    protected function join(array $paths)
    {
        $trimmed = array_map(function ($path) {
            return trim($path, '/');
        }, $paths);
        return $this->matchRelativity(
            $paths[0], implode('/', array_filter($trimmed))
        );
    }

    protected function matchRelativity($source, $target)
    {
        return $source[0] == '/' ? '/'.$target : $target;
    }

    public function exists(Request $request){
        list($path, $file) = $this->getDirectoryAndFileNames($request);
        $fileName = $this->join([$path, $file]);
        if($this->files->exists($fileName)){
            return $this->files->get($fileName);
        }
        return false;
    }

    public function forgetMany($slugs)
    {
        foreach ($slugs as $slug) {
            $this->forget($slug);
        }
    }

    public function forget($slug)
    {
        return $this->files->delete($this->getCachePath($slug . '.html'));
    }

    public function clear()
    {
        return $this->files->deleteDirectory($this->getCachePath(), true);
    }
}