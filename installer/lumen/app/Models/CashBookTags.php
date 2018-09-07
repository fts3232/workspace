<?php

namespace App\Models;

class CashBookTags extends Model
{
    protected $table = 'CASH_BOOK_TAGS';

    protected function createTable()
    {
        $sql = "CREATE TABLE `CASH_BOOK_TAGS` (
                  `TAG_ID` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
                  `TAG_NAME` VARCHAR(50) NOT NULL COMMENT 'tag名称',
                  `CREATED_AT` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                  PRIMARY KEY (`TAG_ID`),
                  KEY `cash_book_tag_name_index` (`TAG_NAME`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
        $ret = $this->db->statement($sql);
        return $ret === true;
    }

    protected function get($offset = null, $size = null)
    {
        if ($offset == null && $size == null) {
            $sql = "SELECT
                        TAG_ID,
                        TAG_NAME
                    FROM
                        CASH_BOOK_TAGS";
            $result = $this->select($sql);
            if ($result) {
                $temp = array_reduce($result, function ($carry, $item) {
                    $carry[$item->TAG_ID] = $item->TAG_NAME;
                    return $carry;
                });
                $result = $temp;
            }
            return $result;
        } else {
            $sql = "SELECT
                    TAG_ID,
                    TAG_NAME
                FROM
                    CASH_BOOK_TAGS
                ORDER BY
                    TAG_ID ASC
                LIMIT :OFFSET,:SIZE";
            return $this->select($sql, ['OFFSET' => $offset, 'SIZE' => $size]);
        }
    }

    protected function getCount()
    {
        $sql = "SELECT
                    COUNT(*) AS TOTAL
                FROM
                    CASH_BOOK_TAGS";
        $result = $this->find($sql);
        $count = false;
        $result && $count = $result->TOTAL;
        return $count;
    }

    protected function add($data)
    {
        $sql = "INSERT INTO CASH_BOOK_TAGS (
                    TAG_NAME,
                    CREATED_AT
                )
                VALUES
                    (
                        :NAME,
                        NOW()
                    )";
        return $this->insert($sql, $data);
    }

    protected function edit($data)
    {
        $sql = "UPDATE CASH_BOOK_TAGS
                SET TAG_NAME = :NAME
                WHERE
                    TAG_ID = :ID";
        return $this->update($sql, $data);
    }

    protected function deleteTag($data)
    {
        $sql = "DELETE FROM CASH_BOOK_TAGS
                WHERE
                    TAG_ID = :ID";
        return $this->delete($sql, $data);
    }
}
