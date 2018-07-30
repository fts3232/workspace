<?php

namespace Cms\Model;

use Think\Model;

class PagesModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    /**
     * 可以插入数据的字段
     *
     * @var array
     */
    protected $insertFields = array(
        'PAGE_NAME',
        'PAGE_PARENT',
        'PAGE_SLUG',
        'PAGE_DIRECTING',
        'PAGE_LANG'
    );

    /**
     * 可以更新数据的字段
     *
     * @var array
     */
    protected $updateFields = array(
        'PAGE_NAME',
        'PAGE_PARENT',
        'PAGE_SLUG',
        'PAGE_DIRECTING',
        'PAGE_LANG'
    );

    /**
     * 递归生成树状数组
     *
     * @param  array $data
     * @param int    $parent
     * @return array
     */
    protected function getTree($data, $parent = null)
    {
        $tree = array();
        foreach ($data as $k => $v) {
            if ($parent == null) {
                $parent = $v['PAGE_PARENT'];
            }
            if ($v['PAGE_PARENT'] == $parent) {        //父亲找到儿子
                $tree[] = $v;
                $tree = array_merge($tree, $this->getTree($data, $v['PAGE_ID']));
                //unset($data[$k]);
            }
        }
        return $tree;
    }

    /**
     * 获取文章分页数据
     *
     * @param $whereData
     * @param $offset
     * @param $size
     * @return array
     */
    public function getAll($whereData, $offset, $size)
    {
        $where = $this->getWhere($whereData);
        $list = $this
            ->where($where)
            ->field('PAGE_ID, PAGE_NAME, PAGE_SLUG, PAGE_PARENT, CREATED_TIME, MODIFIED_TIME')
            ->order('PAGE_PARENT ASC, PAGE_ID ASC')
            ->select();
        if ($list) {
            $list = $this->getTree($list);
            $list = array_slice($list, $offset, $size);
        }
        return $list;
    }

    /**
     * 获取总条数
     *
     * @param $whereData
     * @return mixed
     */
    public function getCount($whereData)
    {
        $where = $this->getWhere($whereData);
        return $this->where($where)->count();
    }

    /**
     * 获取搜索条件
     *
     * @param $whereData
     * @return array
     */
    private function getWhere($whereData)
    {
        $where = array();
        !empty($whereData['name']) && $where['PAGE_NAME'] = $whereData['name'];
        !empty($whereData['language']) && $where['PAGE_LANG'] = $whereData['language'];
        return $where;
    }

    /**
     * 获取指定tag信息
     *
     * @param string $id tagID
     * @return mixed
     */
    public function get($id)
    {
        return $this->field('PAGE_ID, PAGE_NAME, PAGE_SLUG, PAGE_PARENT, PAGE_DIRECTING, PAGE_LANG, SEO_TITLE, SEO_KEYWORD, SEO_DESCRIPTION')
            ->where(array('PAGE_ID' => $id))
            ->find();
    }

    /**
     * 判断id是否存在
     *
     * @param $id
     * @return mixed
     */
    public function isExists($id)
    {
        return $this->where(array('PAGE_ID' => $id))->count();
    }

    /**
     * 判断是否有子页面
     *
     * @param $id
     * @return mixed
     */
    public function hasChild($id)
    {
        return $this->where(array('PAGE_PARENT' => $id))->count();
    }

    /**
     * 获取父页面
     *
     * @param string $id
     * @return mixed
     */
    public function getParent($id = '')
    {
        $where = array('PAGE_PARENT' => 0);
        if (!empty($id)) {
            $where['PAGE_ID'] = array('neq', $id);
        }
        return $this->where(array('PAGE_PARENT' => 0))->select();
    }

    /**
     * 删除页面
     *
     * @param $id
     * @return array
     */
    public function deletePage($id)
    {
        try {
            $return = array('status'=>true);
            //判断id是否存在
            if (!$this->isExists($id)) {
                throw new \Exception('该页面id不存在', 200);
            }
            //判断是否存在子页面
            if ($this->hasChild($id)) {
                throw new \Exception('该页面存在子页面，请先把子页面删除', 201);
            }
            //删除操作
            $result = $this->delete($id);
            if (!$result) {
                throw new \Exception('删除失败', 202);
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

    public function updatePage($data)
    {
        try {
            $return = array('status'=>true);
            //判断id是否存在
            if (!$this->isExists($data['PAGE_ID'])) {
                throw new \Exception('该页面id不存在', 200);
            }
            //修改操作
            $result = $this->where(array('PAGE_ID' => $data['PAGE_ID']))->save($data);
            if (!$result) {
                throw new \Exception('删除失败', 202);
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
}
