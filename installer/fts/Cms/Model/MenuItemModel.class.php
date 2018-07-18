<?php

namespace Cms\Model;

use Think\Model;

class MenuItemModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    protected function getTree($data, $parent = 0)
    {
        $tree = array();
        foreach ($data as $k => $v) {
            if ($v['PARENT_ID'] == $parent) {        //父亲找到儿子
                $v['CHILD'] = $this->getTree($data, $v['ITEM_ID']);
                $tree[] = $v;
                //unset($data[$k]);
            }
        }
        return $tree;
    }

    public function getItem($menuID)
    {
        $where = array(
            'MENU_ID' => $menuID
        );
        $list = $this->field('ITEM_ID, ITEM_NAME, URL, PARENT_ID, ITEM_ORDER')
            ->where($where)
            ->order('PARENT_ID ASC, ITEM_ORDER ASC')
            ->select();

        if ($list) {
            $list = $this->getTree($list, 0);
        }
        return json_encode($list);
        //$result = $result ? $result : array();
    }

    public function updateItem($menuID, $data, $add)
    {
        $where = array(
            'MENU_ID' => $menuID
        );
        $list = $this->field('ITEM_ID, ITEM_NAME, URL, PARENT_ID, ITEM_ORDER')
            ->where($where)
            ->order('PARENT_ID ASC, ITEM_ORDER ASC')
            ->select();
        $temp = array();
        foreach ($data as $k => $v) {
            $temp[$v['ITEM_ID']] = $v;
        }
        foreach ($add as $v) {
            $v['MENU_ID'] = $menuID;
            $this->add($v);
        }
        foreach ($list as $k => $v) {
            if (!isset($temp[$v['ITEM_ID']])) {
                $this->delete($v['ITEM_ID']);
            } else {
                if ($v == $temp[$v['ITEM_ID']]) {
                    continue;
                }
                $this->where(array('ITEM_ID' => $v['ITEM_ID']))->save($temp[$v['ITEM_ID']]);
            }
            //echo $this->getLastSql();
        }
        //var_dump($data);
    }
}
