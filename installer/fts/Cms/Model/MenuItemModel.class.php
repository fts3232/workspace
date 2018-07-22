<?php

namespace Cms\Model;

use Think\Model;

class MenuItemModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    /**
     * 可以插入数据的字段
     *
     * @var array
     */
    protected $insertFields = array(
        'MENU_ID',
        'ITEM_NAME',
        'ITEM_URL',
        'ITEM_ORDER',
        'ITEM_PARENT'
    );

    /**
     * 可以更新数据的字段
     *
     * @var array
     */
    protected $updateFields = array(
        'ITEM_NAME',
        'ITEM_URL',
        'ITEM_ORDER',
        'ITEM_PARENT',
        'MODIFIED_TIME'
    );

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
            if ($v['ITEM_PARENT'] == $parent) {        //父亲找到儿子
                $v['CHILD'] = $this->getTree($data, $v['ITEM_ID']);
                $tree[] = $v;
            }
        }
        return $tree;
    }

    /**
     * 获取菜单项
     *
     * @param $menuID
     * @return mixed|string|void
     */
    public function getItem($menuID)
    {
        $where = array(
            'MENU_ID' => $menuID
        );
        $list = $this->field('ITEM_ID, ITEM_NAME, ITEM_URL, ITEM_PARENT, ITEM_ORDER')
            ->where($where)
            ->order('ITEM_PARENT ASC, ITEM_ORDER ASC')
            ->select();

        if ($list) {
            $list = $this->getTree($list, 0);
        }
        return json_encode($list);
    }

    /**
     * 更新菜单项
     *
     * @param $menuID
     * @param $items
     * @param $addItems
     * @return bool
     */
    public function updateItem($menuID, $items, $addItems)
    {
        try {
            $return = true;
            $this->startTrans();
            $where = array(
                'MENU_ID' => $menuID
            );
            $list = $this->field('ITEM_ID, ITEM_NAME, ITEM_URL, ITEM_PARENT, ITEM_ORDER')
                ->where($where)
                ->order('ITEM_PARENT ASC, ITEM_ORDER ASC')
                ->select();
            $temp = array();
            foreach ($items as $k => $v) {
                $temp[$v['ITEM_ID']] = $v;
            }
            foreach ($addItems as $v) {
                $v['MENU_ID'] = $menuID;
                $result = $this->add($v);
                if (!$result) {
                    throw new \Exception('添加失败');
                }
            }
            //判断哪些是更新项
            foreach ($list as $k => $v) {
                if (!isset($temp[$v['ITEM_ID']])) {
                    $result = $this->delete($v['ITEM_ID']);
                    if (!$result) {
                        throw new \Exception('删除失败');
                    }
                } else {
                    if ($v == $temp[$v['ITEM_ID']]) {
                        continue;
                    }
                    $temp[$v['ITEM_ID']]['MODIFIED_TIME'] = array('exp', 'NOW()');
                    $result = $this->where(array('ITEM_ID' => $v['ITEM_ID']))->save($temp[$v['ITEM_ID']]);
                    if (!$result) {
                        throw new \Exception('更新失败');
                    }
                }
            }
            $this->commit();
        } catch (\Exception $e) {
            $this->rollback();
            $return = false;
        }
        return $return;
    }
}
