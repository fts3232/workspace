<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        $slugs = Redis::ZRANGEBYSCORE('www_page_cache_clear', '-inf', time());
        $temp = array();
        foreach($slugs as $slug){
            Redis::ZREM('www_page_cache_clear', $slug);
            $temp2 = explode(' ', $slug);
            $temp = array_merge($temp, $temp2);

        }
        $slugs = array_unique($temp);
        $schedule->command('page-cache:clear',['slug'=>$slugs])->everyFiveMinutes()->appendOutputTo(storage_path('logs/cron.log'));
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
