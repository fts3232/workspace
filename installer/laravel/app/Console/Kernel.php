<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
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
                $slug = $staticDir.DIRECTORY_SEPARATOR.$slug;
            }
            if ($filesSystem->type($slug) == 'file') {
                $filesSystem->delete($slug);
            } else {
                $filesSystem->cleanDirectory($slug);
            }
        }
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
