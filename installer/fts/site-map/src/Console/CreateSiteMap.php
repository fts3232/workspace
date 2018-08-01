<?php

namespace fts\SiteMap\Console;

use fts\SiteMap\SiteMap;
use Illuminate\Console\Command;

/**
 * 生成缓存类
 *
 * Class CreateCache
 * @package fts\CacheResponse\Console
 */
class CreateSiteMap extends Command
{
    /**
     * 命令名称 uri 可选项 可多个
     *
     * @var string
     */
    protected $signature = 'site-map:build';

    /**
     * 命令描述
     *
     * @var string
     */
    protected $description = 'Create the site map.';

    /**
     * 执行命令逻辑
     *
     * @return void
     */
    public function handle()
    {
        $time = date('Y-m-d H:i:s');
        try {
            $siteMap = $this->laravel->make(SiteMap::class);
            $siteMap->build();
            $this->info("[$time] site map构建成功");
        } catch (\Exception $e) {
            $this->warn("[$time] site map构建失败 错误：" . $e->getMessage());
        }
    }
}
