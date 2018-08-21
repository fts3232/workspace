<?php

namespace Single;

class Single
{
    public static $instance;

    private function __construct($arg)
    {
        var_dump($arg);
        echo '不能外部实例化';
    }

    public static function getInstance($arg)
    {
        if (empty(self::$instance)) {
            self::$instance = new self($arg);
        }
        return self::$instance;
    }
}
