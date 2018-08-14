<?php

namespace Cms\Model;

use Think\Model;

/**
 * 栏目模型
 *
 * Class CategoryModel
 * @package Cms\Model
 */
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
        'CATEGORY_LANG',
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
    protected function getTree($data, $parent = null)
    {
        $tree = array();
        foreach ($data as $k => $v) {
            if ($parent == null) {
                $parent = $v['CATEGORY_PARENT'];
            }
            if ($v['CATEGORY_PARENT'] == $parent) {        //父亲找到儿子
                $tree[] = $v;
                $tree = array_merge($tree, $this->getTree($data, $v['CATEGORY_ID']));
                //unset($data[$k]);
            }
        }
        return $tree;
    }

    /**
     * 生成供select下拉列表用的树状数组
     *
     * @param      $data
     * @param null $parent
     * @return array
     */
    protected function getTreeForSelect($data, $parent = null)
    {
        $tree = array();
        foreach ($data as $k => $v) {
            if ($v['CATEGORY_PARENT'] == $parent) {        //父亲找到儿子
                $v['CHILD'] = $this->getTreeForSelect($data, $v['CATEGORY_ID']);
                $tree[] = $v;
            }
        }
        return $tree;
    }

    /**
     * 获取所有栏目信息
     *
     * @param $whereData
     * @param $offset
     * @param $size
     * @return array
     */
    public function getList($whereData, $offset, $size)
    {
        $where = $this->getWhere($whereData);
        $list = $this
            ->field('CATEGORY_ID, CATEGORY_NAME, CATEGORY_PARENT, CATEGORY_DESCRIPTION, CATEGORY_SLUG, CREATED_TIME, MODIFIED_TIME')
            ->where($where)
            ->order('CATEGORY_PARENT ASC, CATEGORY_ID ASC')
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
        !empty($whereData['name']) && $where['CATEGORY_NAME'] = $whereData['name'];
        !empty($whereData['language']) && $where['CATEGORY_LANG'] = $whereData['language'];
        return $where;
    }

    /**
     * 获取所有栏目列表
     *
     * @param $language
     * @return mixed|string|void
     */
    public function getAll($language)
    {
        $list = $this
            ->field('CATEGORY_ID, CATEGORY_NAME, CATEGORY_PARENT, CATEGORY_SLUG')
            ->where(array('CATEGORY_LANG'=>$language))
            ->order('CATEGORY_PARENT ASC, CATEGORY_ID ASC')
            ->select();

        if ($list) {
            $list = $this->getTreeForSelect($list, 0);
        } else {
            $list = array();
        }
        return json_encode($list);
    }

    /**
     * 判断是否存在子栏目
     *
     * @param $id
     * @return bool
     */
    public function hasChild($id)
    {
        $count = $this->where(array('CATEGORY_PARENT' => $id))->count();
        return $count > 0;
    }

    /**
     * 获取父栏目
     *
     * @param string $id
     * @return mixed
     */
    public function getParent($language, $id = '')
    {
        $where = array('CATEGORY_PARENT' => 0, 'CATEGORY_LANG' => $language);
        if (!empty($id)) {
            $where['CATEGORY_ID'] = array('neq', $id);
        }
        return $this->field('CATEGORY_ID, CATEGORY_SLUG, CATEGORY_NAME')->where($where)->select();
    }

    /**
     * 判断id是否存在
     *
     * @param $id
     * @return bool
     */
    public function isExists($id)
    {
        $count = $this->where(array('CATEGORY_ID' => $id))->count();
        return $count > 0;
    }

    /**
     * 判断指定别名是否存在
     *
     * @param        $slug
     * @param        $lang
     * @param string $id
     * @return bool
     */
    public function isSlugExists($slug, $lang, $id = '')
    {
        $where = array('CATEGORY_SLUG' => $slug, 'CATEGORY_LANG' => $lang);
        if ($id) {
            $where['CATEGORY_ID'] = array('neq', $id);
        }
        $count = $this->where($where)->count();
        return $count > 0;
    }

    /**
     * 删除栏目
     *
     * @param $id
     * @return array
     */
    public function deleteCategory($id)
    {
        try {
            $return = array('status' => true);
            //判断id是否存在
            if (!$this->isExists($id)) {
                throw new \Exception('该栏目不存在！', 200);
            }
            //判断是否有子栏目
            if ($this->hasChild($id)) {
                throw new \Exception('该栏目底下还有子栏目，请先删除子栏目内容！', 201);
            }
            $result = $this->delete($id);
            if (!$result) {
                throw new \Exception('删除失败！', 202);
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
     * 添加栏目
     *
     * @param $data
     * @return array
     */
    public function addCategory($data)
    {
        try {
            $return = array('status' => true);
            //判断别名是否存在
            if ($this->isSlugExists($data['CATEGORY_SLUG'], $data["CATEGORY_LANG"])) {
                throw new \Exception('该栏目别名已存在！', 200);
            }
            $result = $this->add($data);
            if (!$result) {
                throw new \Exception('添加失败！', 201);
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
     * @param $data
     * @return array
     */
    public function updateCategory($data)
    {
        try {
            $return = array('status'=>true);
            $data['MODIFIED_TIME'] = array('exp', 'NOW()');
            //判断id是否存在
            if (!$result = $this->get($data['CATEGORY_ID'])) {
                throw new \Exception('该栏目id不存在', 200);
            }
            //判断别名是否存在
            if ($this->isSlugExists($data['CATEGORY_SLUG'], $result["CATEGORY_LANG"], $data['CATEGORY_ID'])) {
                throw new \Exception('该栏目别名已存在！', 201);
            }
            //判断是否存在子栏目
            if ($data['CATEGORY_PARENT'] != 0 && $this->hasChild($data['CATEGORY_ID'])) {
                throw new \Exception('该栏目还有子栏目，不能移到别的栏目下！', 200);
            }
            //修改操作
            $result = $this->where(array('CATEGORY_ID' => $data['CATEGORY_ID']))->save($data);
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

    /**
     * 获取指定id父类别名
     *
     * @param $id
     * @return mixed
     */
    public function getParentSlug($id)
    {
        $parent = $this->where(array('CATEGORY_ID' => $id))->getField('CATEGORY_PARENT');
        return $this->where(array('CATEGORY_ID' => $parent))->getField('CATEGORY_SLUG');
    }

    /**
     * 获取指定id的栏目信息
     *
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->field('CATEGORY_ID, CATEGORY_NAME, CATEGORY_SLUG, CATEGORY_PARENT, CATEGORY_DESCRIPTION, CATEGORY_LANG, SEO_TITLE, SEO_KEYWORD, SEO_DESCRIPTION')
            ->where(array('CATEGORY_ID' => $id))
            ->find();
    }
}
