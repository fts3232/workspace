<?php

namespace App\Models;

class Movie extends Model
{
    protected $table = 'MOVIE';

    protected function createTable()
    {
        $sql = "CREATE TABLE MOVIE (
                    `MOVIE_ID` INT NOT NULL AUTO_INCREMENT,
                    `CATEGORY` TINYINT (1) NOT NULL DEFAULT 1,
                    `IDENTIFIER` VARCHAR (30) NOT NULL,
                    `TITLE` VARCHAR (255) NOT NULL,
                    `STAR` VARCHAR (255) DEFAULT NULL,
                    `TAG` VARCHAR (255) DEFAULT NULL,
                    `PUBLISH_TIME` DATETIME NOT NULL,
                    `CREATED_TIME` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    `UPDATED_TIME` DATETIME DEFAULT NULL,
                    PRIMARY KEY (`MOVIE_ID`)
                ) ENGINE = INNODB DEFAULT CHARACTER
                SET = utf8 COLLATE = utf8_general_ci;";
        $ret = $this->db->statement($sql);
        return $ret === true;
    }

    protected function getTag()
    {
        $sql = "SELECT
                    TAG_ID,
                    TAG_NAME
                FROM
                    TAG";
        return $this->select($sql);
    }

    protected function get($offset, $size, $key, $value)
    {
        $params = ['OFFSET' => $offset, 'SIZE' => $size];
        switch ($key) {
            case 'title':
                $where = 'IDENTIFIER LIKE :IDENTIFIER';
                $params['IDENTIFIER'] = "%{$value}%";
                break;
            case 'tag':
                $where = 'FIND_IN_SET(:TAG,TAG)';
                $params['TAG'] = $value;
                break;
            default:
                $where = '';
        }
        if ($where) {
            $where = 'WHERE ' . $where;
        }
        $sql = "SELECT
                    MOVIE_ID,
                    TITLE,
                    IDENTIFIER,
                    TAG,
                    STAR,
                    PUBLISH_TIME,
                    COVER_PIC,
                    THUMB_PIC
                FROM
                    MOVIE AS a
                {$where}
                ORDER BY
                    UPDATED_TIME DESC,
                    PUBLISH_TIME DESC,
                    CREATED_TIME DESC
                LIMIT :OFFSET, :SIZE";
        $list = $this->select($sql, $params);
        foreach ($list as $key => $item) {
            if ($item->TAG) {
                $list[$key]->TAG = $this->select('
                SELECT
                    TAG_NAME
                FROM
                    TAG
                WHERE
                    FIND_IN_SET(TAG_ID ,:TAG)', ['TAG' => $item->TAG]);
            }
            $list[$key]->PLAY = is_dir("E:\迅雷下载\{$item->IDENTIFIER}");
            $list[$key]->THUMB_PIC = 'data:image/jpg;base64,' . base64_encode($item->THUMB_PIC);
            $list[$key]->COVER_PIC = 'data:image/jpg;base64,' . base64_encode($item->COVER_PIC);
            if ($item->STAR) {
                $star = $this->select('
                SELECT
                    STAR_NAME,
                    STAR_PIC
                FROM
                    STAR
                WHERE
                    FIND_IN_SET(STAR_ID ,:STAR)', ['STAR' => $item->STAR]);
                foreach ($star as $k => $v) {
                    $star[$k]->STAR_PIC = 'data:image/jpg;base64,' . base64_encode($v->STAR_PIC);
                }
                $list[$key]->STAR = $star;
            }
            $list[$key]->LINK = $this->select('
                SELECT
                    LINK
                FROM
                    DOWNLOAD_LINK
                WHERE
                    MOVIE_ID = :MOVIE_ID', ['MOVIE_ID' => $item->MOVIE_ID]);
            $list[$key]->SAMPLE = $this->select('
                SELECT
                    URL
                FROM
                    SAMPLE
                WHERE
                    MOVIE_ID = :MOVIE_ID', ['MOVIE_ID' => $item->MOVIE_ID]);
        }
        return $list;
    }

    protected function getCount()
    {
        $sql = "SELECT
                    COUNT(*) AS TOTAL
                FROM
                    MOVIE";
        $result = $this->find($sql);
        $count = false;
        $result && $count = $result->TOTAL;
        return $count;
    }
}
