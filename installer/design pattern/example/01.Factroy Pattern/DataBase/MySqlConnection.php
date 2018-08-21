<?php

namespace Database;

class MySqlConnection implements ConnectorInterface
{
    public function connect(array $config)
    {
        return 'mysql';
    }
}