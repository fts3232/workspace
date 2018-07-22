<?php

namespace Cms\Model;

use Think\Model;

class CategoryModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    /**
     * 可以插入数据的字段
     *
     * @var array
     */
    protected $insertFields = array(
        'CATEGORY_NAME',
        'CATEGORY_PARENT',
        'CATEGORY_ORDER',
        'CATEGORY_SLUG',
        'CATEGORY_DESCRIPTION',
        'SEO_TITLE',
        'SEO_KEYWORD',
        'SEO_DESCRIPTION'
    );

    /**
     * 可以更新数据的字段
     *
     * @var array
     */
    protected $updateFields = array(
        'CATEGORY_NAME',
        'CATEGORY_PARENT',
        'CATEGORY_ORDER',
        'CATEGORY_SLUG',
        'CATEGORY_DESCRIPTION',
        'SEO_TITLE',
        'SEO_KEYWORD',
        'SEO_DESCRIPTION',
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
            if ($v['CATEGORY_PARENT'] == $parent) {        //父亲找到儿子
                $v['CHILD'] = $this->getTree($data, $v['CATEGORY_ID']);
                $tree[] = $v;
                //unset($data[$k]);
            }
        }
        return $tree;
    }

    /**
     * 获取所有栏目信息
     *
     * @return mixed|string|void
     */
    public function getAll()
    {
        $list = $this
            ->field('CATEGORY_ID, CATEGORY_NAME, CATEGORY_PARENT, CATEGORY_SLUG, CATEGORY_ORDER, CATEGORY_DESCRIPTION, SEO_TITLE, SEO_KEYWORD, SEO_DESCRIPTION')
            ->order('CATEGORY_PARENT ASC, CATEGORY_ORDER ASC')
            ->select();

        if ($list) {
            $list = $this->getTree($list, 0);
        }
        return json_encode($list);
    }

    /**
     * 删除指定栏目信息
     *
     * @param $id
     * @return array
     */
    public function deleteCategory($id)
    {
        try {
            $return = array('status' => true, 'msg' => '删除成功');
            //判断是否有子栏目
            $count = $this->where(array('CATEGORY_PARENT' => $id))->count();
            if ($count > 0) {
                throw new \Exception('该栏目底下还有子栏目，请先删除子栏目内容！', 100);
            }
            //删除操作
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

    /**
     * 更新栏目信息
     *
     * @param $items
     * @param $addItems
     * @return bool
     */
    public function updateCategory($items, $addItems)
    {
        try {
            $return = true;
            $this->startTrans();
            $list = $this->field('CATEGORY_ID, CATEGORY_NAME, CATEGORY_SLUG, CATEGORY_PARENT, CATEGORY_ORDER')
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
            //判断哪些是有更新的栏目
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
