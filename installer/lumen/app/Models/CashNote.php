<?php

namespace App\Models;

class CashNote extends Model
{
    protected $table = 'CASH_NOTE';

    protected function createTable()
    {
        $sql = "CREATE TABLE `CASH_NOTE` (
                    `ROW_ID` INT (10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
                    `TYPE` TINYINT (1) NOT NULL COMMENT '类型 0：支出 1：收入',
                    `AMOUNT` DECIMAL (10, 2) NOT NULL COMMENT '金额',
                    `CATEGORY` VARCHAR (10) NOT NULL COMMENT '项目',
                    `REMARK` TEXT  COMMENT '备注',
                    `DATE` DATE NOT NULL COMMENT '收入支出时间',
                    `CREATED_TIME` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                    PRIMARY KEY (`ROW_ID`),
                    KEY `cash_book_date_index` (`DATE`),
                    KEY `cash_book_type_index` (`TYPE`),
                    KEY `cash_book_tags_index` (`CATEGORY`)
                ) ENGINE = INNODB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;";
        $ret = $this->db->statement($sql);
        return $ret === true;
    }

    protected function getMonthData()
    {
        $returnData = ['income' => [], 'cost' => [],'invest' => [],'key'=>[]];
        $sql = "SELECT
                    TYPE,
                    SUM(AMOUNT) AS SUM,
                    CONCAT(
                        YEAR (DATE),
                        '-',
                        LPAD(MONTH(DATE), 2, '0')
                    ) AS MONTH
                FROM
                    CASH_NOTE
                GROUP BY
                    TYPE,
                    MONTH
                ORDER BY
                    MONTH ASC";
        $result = $this->select($sql);
        if ($result) {
            foreach ($result as $v) {
                $key = $v->MONTH;
                if(!in_array($key,$returnData['key'])){
                    $returnData['key'][] = $key;
                }
                if ($v->TYPE == 1) {
                    $returnData['income'][] = [$key,$v->SUM];
                } elseif ($v->TYPE == 2) {
                    $returnData['invest'][] = [$key,$v->SUM];
                } else {
                    $returnData['cost'][] = [$key,$v->SUM];
                }
            }
        }
        return $returnData;
    }

    protected function getTotalExpenditure($search = [])
    {
        $search['type'] = 0;
        $where = $this->getWhere($search);
        $sql = "SELECT
                    SUM(AMOUNT) AS SUM
                FROM
                    CASH_NOTE
                {$where['string']}";
        $result = $this->find($sql, $where['data']);
        return $result && !empty($result->SUM) ? $result->SUM : '0.00';
    }

    protected function getGrossIncome($search = [])
    {
        $search['type'] = 1;
        $where = $this->getWhere($search);
        $sql = "SELECT
                    SUM(AMOUNT) AS SUM
                FROM
                    CASH_NOTE
                {$where['string']}";
        $result = $this->find($sql, $where['data']);
        return $result && !empty($result->SUM) ? $result->SUM : '0.00';
    }

    protected function fetch($page, $size, $search = [])
    {
        $where = $this->getWhere($search);
        $offset = ($page - 1) * $size;
        $sql = "SELECT
                    ROW_ID,
                    TYPE,
                    CATEGORY,
                    AMOUNT,
                    DATE,
                    REMARK
                FROM
                    CASH_NOTE
                {$where['string']}
                ORDER BY DATE DESC, ROW_ID DESC
                LIMIT :OFFSET, :SIZE";
        $where['data']['OFFSET'] = $offset;
        $where['data']['SIZE'] = $size;
        return $this->select($sql, $where['data']);
    }

    protected function getCount($search = [])
    {
        $where = $this->getWhere($search);
        $sql = "SELECT
                    COUNT(*) AS TOTAL
                FROM
                    CASH_NOTE
                {$where['string']}";
        $result = $this->find($sql, $where['data']);
        $count = false;
        $result && $count = $result->TOTAL;
        return $count;
    }

    protected function getPieData($search = [])
    {
        $returnData = ['income' => [], 'cost' => [],'invest'=>[]];
        $where = $this->getWhere($search);
        $sql = "SELECT
                    TYPE,
                    CATEGORY,
                    SUM(AMOUNT) AS SUM
                FROM
                    CASH_NOTE
                {$where['string']}
                GROUP BY
                    CATEGORY";
        $result = $this->select($sql, $where['data']);
        if ($result) {
            foreach ($result as $k => $v) {
                if ($v->TYPE == 1) {
                    $returnData['income'][] = ['value' => $v->SUM, 'category' => $v->CATEGORY];
                } elseif ($v->TYPE == 2) {
                    $returnData['invest'][] = ['value' => $v->SUM, 'category' => $v->CATEGORY];
                } else {
                    $returnData['cost'][] = ['value' => $v->SUM, 'category' => $v->CATEGORY];
                }
            }
        }
        return $returnData;
    }

    protected function add($data)
    {
        $sql = "INSERT INTO CASH_NOTE (
                    AMOUNT,
                    TYPE,
                    CATEGORY,
                    REMARK,
                    DATE,
                    CREATED_TIME
                )
                VALUES
                    (
                        :AMOUNT,
                        :TYPE,
                        :CATEGORY,
                        :REMARK,
                        :DATE,
                        NOW()
                    )";
        return $this->insert($sql, $data);
    }

    protected function getWhere($search)
    {
        $where = [];
        $whereData = [];
        foreach ($search as $k => $v) {
            switch ($k) {
                case 'date':
                    $where[] = "date_format(DATE, '%Y-%m') = :DATE";
                    $whereData['DATE'] = $v;
                    break;
                case 'type':
                    $where[] = "TYPE = :TYPE";
                    $whereData['TYPE'] = $v;
                    break;
                case 'category':
                    $where[] = "CATEGORY = :CATEGORY";
                    $whereData['CATEGORY'] = $v;
                    break;
            }
        }
        $where = implode(' AND ', $where);
        if (!empty($where)) {
            $where = 'WHERE ' . $where;
        } else {
            $where = '';
        }
        return ['string' => $where, 'data' => $whereData];
    }
}
