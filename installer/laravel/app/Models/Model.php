<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Log;

class Model
{
    protected $connection;
    protected $table;
    protected static $instance = [];
    protected $db;
    protected static $log;

    //
    public function __construct()
    {
        $this->db = DB::connection($this->connection);
    }

    //
    public static function __callStatic($funcName, $arguments)
    {
        try {
            $className = static::class;
            if (!array_key_exists($className, self::$instance)) {
                self::$instance[$className] = new $className();
            }
            return call_user_func_array(array(self::$instance[$className], $funcName), $arguments);
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
    }

    //select
    protected function select($sql, $param = [])
    {
        return $this->db->select($sql, $param);
    }

    //find
    protected function find($sql, $param = [])
    {
        $result = $this->db->select($sql, $param);
        return ($result && count($result) > 0) ? $result[0] : false;
    }

    //update
    protected function update($sql, $param = [])
    {
        return $this->db->update($sql, $param);
    }

    //insert
    protected function insert($sql, $param = [])
    {
        $result = $this->db->insert($sql, $param);
        $pdo = $this->db->getPdo();
        return $result ? $pdo->lastInsertId() : false;
    }

    //delete
    protected function delete($sql, $param = [])
    {
        return $this->db->delete($sql, $param);
    }

    //beginTransaction
    protected function beginTransaction()
    {
        $this->db->beginTransaction();
    }

    //rollback
    protected function rollback()
    {
        return $this->db->rollBack();
    }

    //commit
    protected function commit()
    {
        return $this->db->commit();
    }
}
