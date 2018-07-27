<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Log;
use MongoConnectionException;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\MongoDBHandler;
use Monolog\Handler\RotatingFileHandler;

class LogServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $monolog = Log::getMonolog();
        $filename = storage_path('logs/log.log');
        // the default date format is "Y-m-d H:i:s"
        $dateFormat = "Y-m-d H:i:s";
        // the default output format is "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n"
        $output = "[%datetime%] %level_name% %message%" . PHP_EOL . PHP_EOL;
        // finally, create a formatter
        $formatter = new LineFormatter($output, $dateFormat);
        $handler = new RotatingFileHandler($filename);
        $handler->setFormatter($formatter);
        $monolog->setHandlers(array($handler));
        try {
            $host = config('database.connections.mongodb.host');
            $port = config('database.connections.mongodb.port');
            $username = config('database.connections.mongodb.username');
            $password = config('database.connections.mongodb.password');
            $database = config('database.connections.mongodb.database');
            $collection = config('database.connections.mongodb.collection');
            $mongoHandler = new MongoDBHandler(
                new \MongoClient("mongodb://{$username}:{$password}@{$host}:{$port}", array('connectTimeoutMS' => '5000', 'socketTimeoutMS' => '5000', 'wTimeout' => '5000')),
                $database,
                $collection
            );
            $monolog->pushHandler($mongoHandler);
        } catch (\Exception $e) {
            if ($e instanceof MongoConnectionException) {
                $monolog->addAlert($e->getMessage());
            }
        }
    }

    public function register()
    {
        //
    }
}
