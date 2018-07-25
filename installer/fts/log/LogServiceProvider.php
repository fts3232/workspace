<?php

namespace fts\UploadImage;

use Illuminate\Support\ServiceProvider;
use Log;
use Monolog\Handler\MongoDBHandler;
use Monolog\Handler\RotatingFileHandler;

class LogServiceProvider extends ServiceProvider
{

    public function boot()
    {
        try {
            $monolog = Log::getMonolog();
            $host = config('database.connections.mongodb.host');
            $port = config('database.connections.mongodb.port');
            $username = config('database.connections.mongodb.username');
            $password = config('database.connections.mongodb.password');
            $database = config('database.connections.mongodb.database');
            $collection = config('database.connections.mongodb.collection');
            $mongoHandler = new MongoDBHandler(new \MongoClient("mongodb://{$username}:{$password}@{$host}:{$port}"), $database, $collection);
            $monolog->pushHandler($mongoHandler);
        } catch (\Exception $e) {
            $filename = storage_path('logs/log.log');
            $monolog->pushHandler(new RotatingFileHandler($filename));
            if ($e instanceof MongoConnectionException) {
                $monolog->addError('mongodb链接不上');
            }
        }
    }

    public function register()
    {
        //
    }
}
