<?php
namespace fts\CacheResponse\Console;

use fts\CacheResponse\Cache;
use Illuminate\Console\Command;

class ClearCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'page-cache:clear {slug? : URL slug of page to delete}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the page cache.';
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $cache = $this->laravel->make(Cache::class);
        $slug = $this->argument('slug');
        if (strpos($slug, '.html') !== false) {
            $this->forget($cache, $slug);
        } else {
            $this->clear($cache, $slug);
        }
    }
    /**
     * Remove the cached file for the given slug.
     *
     * @param  fts\CacheResponse\Cache  $cache
     * @param  string  $slug
     * @return void
     */
    public function forget(Cache $cache, $slug)
    {
        $time = date('Y/m/d H:i:s', time());
        if ($cache->forget($slug)) {
            $this->info("[{$time}]: Page cache cleared for \"{$slug}\"");
        } else {
            $this->info("[{$time}]: No page cache found for \"{$slug}\"");
        }
    }
    /**
     * Clear the full page cache.
     *
     * @param  fts\CacheResponse\Cache $cache
     * @param  string  $slug
     * @return void
     */
    public function clear(Cache $cache, $slug = '')
    {
        $time = date('Y/m/d H:i:s', time());
        if ($cache->clear($slug)) {
            $this->info("[{$time}]: Page cache cleared at " . $cache->getCachePath($slug));
        } else {
            $this->warn("[{$time}]: Page cache not cleared at " . $cache->getCachePath($slug));
        }
    }
}
