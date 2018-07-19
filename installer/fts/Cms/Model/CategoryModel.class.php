<?php

namespace Cms\Model;

use Think\Model;

class CategoryModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    protected function getTree($data, $parent = 0)
    {
        $tree = array();
        foreach ($data as $k => $v) {
            if ($v['CATEGORY_PARENT'] == $parent) {        //父亲找到儿子
                $v['CHILD'] = $this->getTree($data, $v['CATEGORY_ID']);
                $tree[] = $v;
                //unset($data[$k]);
            }
        }
        return $tree;
    }

    public function get()
    {
        $list = $this->field('CATEGORY_ID, CATEGORY_NAME, CATEGORY_PARENT, CATEGORY_ORDER')
            ->order('CATEGORY_PARENT ASC, CATEGORY_ORDER ASC')
            ->select();

        if ($list) {
            $list = $this->getTree($list, 0);
        }
        return json_encode($list);
    }

    public function deleteCategory($id)
    {
        try {
            $return = array('status' => true,'msg'=>'删除成功');
            $count = $this->where(array('CATEGORY_PARENT' => $id))->count();
            if ($count > 0) {
                throw new \Exception('该栏目底下还有子栏目，请先删除子栏目内容！', 100);
            }
            $result = $this->delete($id);
            if (!$result) {
                throw new \Exception('删除失败！', 101);
            }
        } catch (\Exception $e) {
            $return = array(
                'status' => false,
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }
        return $return;
    }

    public function updateCategory($items, $addItems)
    {
        try {
            $return = true;
            $this->startTrans();
            $list = $this->field('CATEGORY_ID, CATEGORY_NAME, CATEGORY_PARENT, CATEGORY_ORDER')
                ->order('CATEGORY_PARENT ASC, CATEGORY_ORDER ASC')
                ->select();
            $temp = array();
            foreach ($items as $k => $v) {
                $temp[$v['CATEGORY_ID']] = $v;
            }
            foreach ($addItems as $v) {
                $result = $this->add($v);
                if (!$result) {
                    throw new \Exception('添加失败');
                }
            }
            foreach ($list as $k => $v) {
                if ($v == $temp[$v['ITEM_ID']]) {
                    continue;
                }
                $temp[$v['CATEGORY_ID']]['MODIFIED_TIME'] = array('exp', 'NOW()');
                $result = $this->where(array('CATEGORY_ID' => $v['CATEGORY_ID']))->save($temp[$v['CATEGORY_ID']]);
                if (!$result) {
                    throw new \Exception('更新失败');
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
