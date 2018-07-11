<?php
namespace fts\CacheResponse\Console;

use fts\CacheResponse\Cache;
use Illuminate\Console\Command;

class CreateCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'page-cache:create {uri?* : URL  of page to create}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the page cache.';
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $cache = $this->laravel->make(Cache::class);

        $uris = $this->argument('uri');
        $time = date('Y/m/d H:i:s', time());
        if (empty($uris)) {
            $uris= $this->getShouldCacheRoute();
            $this->info("[{$time}]: All router cache create");
        }
        foreach ($uris as $uri) {
            $this->create($cache, $uri);
        }
    }

    protected function getShouldCacheRoute()
    {
        $routes = $this->laravel->routes->getRoutes();
        $return = array();
        foreach ($routes as $route) {
            $middleware = $route->action['middleware'];
            if ((is_array($middleware) && in_array('cache', $middleware)) || $middleware == 'cache') {
                $return[] = $route->uri;
            }
        }
        return $return;
    }

    protected function create($cache, $uri)
    {
        $time = date('Y/m/d H:i:s', time());
        if ($cache->createCache($uri)) {
            $this->info("[{$time}]: Page Cache create at {$uri}");
        } else {
            $this->warn("[{$time}]: Page Cache create fail at {$uri}");
        }
    }
}
