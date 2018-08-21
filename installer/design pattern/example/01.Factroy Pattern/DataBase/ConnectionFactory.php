<?php

namespace Database;

class ConnectionFactory
{
    public function make(array $config)
    {
        try {
            return $this->createConnection($config['driver']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function createConnection($driver)
    {
        switch ($driver) {
            case 'Mysql':
                return new MySqlConnection();
            case 'pgsql':
                return new PostgresConnection();
            case 'SQLite':
                return new SQLiteConnection();
            case 'SqlServer':
                return new SqlServerConnection();
        }
        throw new \Exception("Unsupported driver [$driver]");
    }
}
