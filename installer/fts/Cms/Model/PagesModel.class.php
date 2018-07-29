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
        'PAGE_CONTROLLER',
        'PAGE_VIEW'
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
        'PAGE_CONTROLLER',
        'PAGE_VIEW'
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
            $list = $this->getTree($list, 0);
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
        !empty($whereData['title']) && $where['a.POST_TITLE'] = $whereData['title'];
        !empty($whereData['category']) && $where['a.POST_CATEGORY_ID'] = $whereData['category'];
        !empty($whereData['language']) && $where['a.POST_LANG'] = $whereData['language'];
        !empty($whereData['status']) && $where['a.POST_STATUS'] = $whereData['status'];
        !empty($whereData['time']) && $where['DATE(a.PUBLISHED_TIME)'] = $whereData['time'];
        return $where;
    }

    public function isExists($id)
    {
        return $this->where(array('PAGE_ID' => $id))->count();
    }

    public function hasChild($id)
    {
        return $this->where(array('PAGE_PARENT' => $id))->count();
    }

    public function getParent(){
        return $this->where(array('PAGE_PARENT' => 0))->select();
    }
}
