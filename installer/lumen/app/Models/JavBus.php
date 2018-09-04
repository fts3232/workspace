<?php

namespace App\Models;

class JavBus extends Model
{
    protected $table = 'CASH_BOOK';

    protected function createTable()
    {
        $sql = "
            CREATE TABLE `cash_book` (
              `ROW_ID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
              `TYPE` tinyint(4) NOT NULL COMMENT '类型 1：支出 2：收入',
              `AMOUNT` int(11) NOT NULL COMMENT '金额',
              `TAGS` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '标签',
              `DESCRIPTION` text COLLATE utf8_unicode_ci COMMENT 'my comment',
              `DATE` date NOT NULL COMMENT '收入支出时间',
              `CREATED_TIME` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
              PRIMARY KEY (`ROW_ID`),
              KEY `cash_book_date_index` (`DATE`),
              KEY `cash_book_type_index` (`TYPE`),
              KEY `cash_book_tags_index` (`TAGS`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        ";
        $ret = $this->db->statement($sql);
        return $ret === true;
    }
}
