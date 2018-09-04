<?php

namespace App\Models;

class CashBook extends Model
{
    protected $table = 'CASH_BOOK';

    protected function createTable()
    {
        $sql = "CREATE TABLE `CASH_BOOK` (
                  `ROW_ID` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
                  `TYPE` TINYINT(4) NOT NULL COMMENT '类型 1：支出 2：收入',
                  `AMOUNT` INT(11) NOT NULL COMMENT '金额',
                  `TAGS` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '标签',
                  `DESCRIPTION` TEXT COLLATE utf8_unicode_ci COMMENT 'my comment',
                  `DATE` DATE NOT NULL COMMENT '收入支出时间',
                  `CREATED_AT` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                  PRIMARY KEY (`ROW_ID`),
                  KEY `cash_book_date_index` (`DATE`),
                  KEY `cash_book_type_index` (`TYPE`),
                  KEY `cash_book_tags_index` (`TAGS`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
        $ret = $this->db->statement($sql);
        return $ret === true;
    }

    protected function get($offset, $size)
    {
        $sql = "SELECT
                    ROW_ID,
                    TYPE,
                    AMOUNT,
                    TAGS,
                    DATE,
                    DESCRIPTION,
                    CREATED_AT
                FROM
                    CASH_BOOK
                ORDER BY
                    CREATED_AT DESC
                LIMIT :OFFSET,:SIZE";
        return $this->select($sql, ['OFFSET' => $offset, 'SIZE' => $size]);
    }

    protected function getCount()
    {
        $sql = "SELECT
                    COUNT(*) AS TOTAL
                FROM
                    CASH_BOOK";
        $result = $this->find($sql);
        $count = false;
        $result && $count = $result->TOTAL;
        return $count;
    }

    protected function add($data)
    {
        $sql = "INSERT INTO CASH_BOOK (
                    AMOUNT,
                    TYPE,
                    TAGS,
                    DESCRIPTION,
                    DATE,
                    CREATED_AT
                )
                VALUES
                    (
                        :AMOUNT,
                        :TYPE,
                        :TAGS,
                        :DESCRIPTION,
                        :DATE,
                        NOW()
                    )";
        return $this->insert($sql, $data);
    }
}
