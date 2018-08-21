<?php

namespace Database;

class SQLiteConnection implements ConnectorInterface
{
    public function connect(array $config)
    {
        return 'SQLite';
    }
}