<?php

namespace Database;

class SqlServerConnection implements ConnectorInterface
{
    public function connect(array $config)
    {
        return 'SqlServer';
    }
}