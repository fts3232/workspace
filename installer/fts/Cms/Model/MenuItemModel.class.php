<?php

namespace Cms\Model;

use Think\Model;

/**
 * 菜单项模型
 *
 * Class MenuItemModel
 * @package Cms\Model
 */
class MenuItemModel extends Model
{
    protected $connection = 'DB_CONFIG1';

    protected $trueTableName = 'cms_menu_item';

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
        } else {
            $list = array();
        }
        return json_encode($list);
    }

    /**
     * 添加菜单项
     *
     * @param $data
     * @return array
     */
    public function addItem($data)
    {
        try {
            $return = array('status' => true);
            $data['ITEM_PARENT'] = 0;
            $result = $this->add($data);
            if (!$result) {
                throw new \Exception('添加失败', 200);
            }
            $return['id'] = $result;
        } catch (\Exception $e) {
            $return = array(
                'status' => false,
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }
        return $return;
    }

    /**
     * 更新菜单项
     *
     * @param $data
     * @return array
     */
    public function updateItem($data)
    {
        try {
            $return = array('status'=>true);
            $this->startTrans();
            $where = array(
                'MENU_ID' => $data['MENU_ID']
            );
            $list = $this->field('ITEM_ID')
                ->where($where)
                ->select();
            //获取项
            $temp = array();
            if (is_array($data['ITEMS'])) {
                foreach ($data['ITEMS'] as $k => $v) {
                    $temp[$v['ITEM_ID']] = $v;
                }
            }
            //判断哪些是更新项
            foreach ($list as $k => $v) {
                if (!isset($temp[$v['ITEM_ID']])) {
                    $result = $this->delete($v['ITEM_ID']);
                    if (!$result) {
                        throw new \Exception('删除失败', 200);
                    }
                } else {
                    if ($v == $temp[$v['ITEM_ID']]) {
                        continue;
                    }
                    $temp[$v['ITEM_ID']]['MODIFIED_TIME'] = array('exp', 'NOW()');
                    $result = $this->where(array('ITEM_ID' => $v['ITEM_ID']))->save($temp[$v['ITEM_ID']]);
                    if (!$result) {
                        throw new \Exception('更新失败', 201);
                    }
                }
            }
            $this->commit();
        } catch (\Exception $e) {
            $this->rollback();
            $return = array(
                'status' => false,
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }
        return $return;
    }
}
