<?php

namespace App\Models;

class Setting extends Model
{
    protected $table = 'SETTING';

    protected function createTable()
    {
        $sql = "CREATE TABLE SETTING (
                    `ROW_ID` INT NOT NULL AUTO_INCREMENT,
                    `SETTING_KEY` VARCHAR (30) NOT NULL,
                    `SETTING_VALUE` VARCHAR (30) NOT NULL,
                    `CREATED_TIME` DATETIME DEFAULT NULL,
                    `UPDATED_TIME` DATETIME DEFAULT NULL,
                    PRIMARY KEY (`ROW_ID`)
                ) ENGINE = INNODB DEFAULT CHARACTER
                SET = utf8 COLLATE = utf8_general_ci;";
        $ret = $this->db->statement($sql);
        return $ret === true;
    }

    protected function add($key,$value)
    {
        $sql = "INSERT INTO SETTING (SETTING_KEY, SETTING_VALUE, CREATED_TIME)
                VALUES
                    (:KEY ,:VALUE, NOW())";
        return $this->insert($sql, ['KEY' => $key, 'VALUE' => $value]);
    }
}
