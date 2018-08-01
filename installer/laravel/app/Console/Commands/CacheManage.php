<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CacheManage extends Command
{
    /**
     * 命令名称 uri 可选项 可多个
     *
     * @var string
     */
    protected $signature = 'cache-manage';

    /**
     * 命令描述
     *
     * @var string
     */
    protected $description = 'page cache manage';

    /**
     * 执行命令逻辑
     *
     * @return void
     */
    public function handle()
    {
        $time = date('Y-m-d H:i:s');
        try {
            //php artisan schedule:run
            $staticDir = public_path('static');
            $slugs = array();
            //获取到发布时间的状态为等待发布的文章所属栏目别名
            $sql = 'SELECT
                    b.CATEGORY_SLUG
                FROM
                    posts AS a
                LEFT JOIN category b ON a.POST_CATEGORY_ID = b.CATEGORY_ID
                WHERE
                    PUBLISHED_TIME <= NOW()
                AND POST_STATUS = 1';
            $result = DB::select($sql);
            foreach ($result as $item) {
                $slugs[] = $item->CATEGORY_SLUG;
            }
            //更新发布时间的状态为等待发布的文章状态为发布
            $sql = "UPDATE posts
                SET POST_STATUS = 2
                WHERE
                    PUBLISHED_TIME <= NOW()
                AND POST_STATUS = 1";
            DB::update($sql);
            //获取redis有序集合里到到期的要清楚的栏目别名
            $redisSlugs = Redis::ZRANGEBYSCORE('www_page_cache_clear', '-inf', time());
            foreach ($redisSlugs as $item) {
                $temp2 = explode(' ', $item);
                $slugs = array_merge($slugs, $temp2);
                Redis::ZREM('www_page_cache_clear', $item);
            }
            //获取创建时间超过配置参数的文件
            $filesSystem = app('files');
            $files = $filesSystem->allFiles($staticDir);
            foreach ($files as $file) {
                $pathName = $file->getPathName();
                $createTime = $file->getCTime();
                if ($createTime < time() - 600) {//创建时间超过10分钟 删除
                    $slugs[] = $pathName;
                }
            }
            //去除重复项
            $slugs = array_unique($slugs);
            foreach ($slugs as $slug) {
                if (strpos($slug, $staticDir) === false) {
                    $slug = $staticDir . DIRECTORY_SEPARATOR . $slug;
                }
                if ($filesSystem->type($slug) == 'file') {
                    $filesSystem->delete($slug);
                } else {
                    $filesSystem->cleanDirectory($slug);
                }
            }
            $this->info("[$time] 清除cache成功");
        } catch (\Exception $e) {
            $msg = iconv('GBK', 'utf-8', $e->getMessage());
            $msg = "[$time] 清除cache失败 错误：" . $msg;
            $this->warn($msg);
        }
    }
}
