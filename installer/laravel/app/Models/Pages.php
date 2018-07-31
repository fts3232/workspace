<?php

namespace App\Models;

class Pages extends Model
{
    protected $table = 'pages';

    /**
     * 递归生成树状数组
     *
     * @param  array $data
     * @param int    $parent
     * @return array
     */
    protected function getTree($data, $parent = 0)
    {
        $tree = array();
        foreach ($data as $k => $v) {
            if ($v->PAGE_PARENT == $parent) {        //父亲找到儿子
                $v->CHILD = $this->getTree($data, $v->PAGE_ID);
                $tree[] = $v;
                //unset($data[$k]);
            }
        }
        return $tree;
    }

    protected function getAll()
    {
        $sql = 'SELECT
                    PAGE_ID,
                    PAGE_NAME,
                    PAGE_SLUG,
                    PAGE_DIRECTING,
                    PAGE_PARENT,
                    CREATED_TIME,
                    MODIFIED_TIME
                FROM
                    pages
                ORDER BY
                    PAGE_PARENT ASC,
                    PAGE_ID ASC';
        $list = $this->select($sql);
        if ($list) {
            $list = $this->getTree($list);
        }
        return $list;
    }
}
