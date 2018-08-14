<?php

namespace Cms\Model;

use Think\Model;

/**
 * 页面模型
 *
 * Class PagesModel
 * @package Cms\Model
 */
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
    public function getList($whereData, $offset, $size)
    {
        $where = $this->getWhere($whereData);
        $list = $this
            ->where($where)
            ->field('PAGE_ID, PAGE_NAME, PAGE_SLUG, PAGE_PARENT, CREATED_TIME, MODIFIED_TIME')
            ->order('PAGE_PARENT ASC, PAGE_ID ASC')
            ->select();
        if ($list) {
            $list = $this->getTree($list);
            //获取别名列表
            $slugList = array_reduce($list, function ($carry, $item) {
                $carry[$item['PAGE_ID']] = $item['PAGE_SLUG'];
                return $carry;
            });
            //切割列表
            $list2 = array_slice($list, $offset, $size);
            //获取第一项的父别名
            $parentSlug = $list2[0]['PAGE_PARENT'] == 0 ? '' : $slugList[$list2[0]['PAGE_PARENT']];
            foreach ($list2 as $key => $page) {
                if ($page['PAGE_PARENT'] != 0) {
                    $paths = [$parentSlug];
                } else {
                    $parentSlug = $page['PAGE_SLUG'];
                }
                $paths[] = $page['PAGE_SLUG'];
                $list2[$key]['PAGE_URL'] = $this->getUrl($paths);
            }
        }
        return $list2;
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
        !empty($whereData['time']) && $where['_string'] = "DATE_FORMAT(CREATED_TIME, '%Y-%m') = '{$whereData['time']}'";
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
        $result = $this->field('PAGE_ID, PAGE_NAME, PAGE_SLUG, PAGE_PARENT, PAGE_DIRECTING, PAGE_LANG, SEO_TITLE, SEO_KEYWORD, SEO_DESCRIPTION')
            ->where(array('PAGE_ID' => $id))
            ->find();
        if ($result) {
            $paths = [];
            if ($result['PAGE_PARENT'] != 0) {
                $parentSLug = $this->field('PAGE_SLUG')
                    ->where(array('PAGE_ID' => $result['PAGE_PARENT']))
                    ->getField('PAGE_SLUG');
                $paths[] = $parentSLug;
            }
            $paths[] = $result['PAGE_SLUG'];
            $result['PAGE_URL'] = $this->getUrl($paths);
        }
        return $result;
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
     * 判断指定别名是否存在
     *
     * @param        $slug
     * @param        $lang
     * @param string $id
     * @return bool
     */
    public function isSlugExists($slug, $lang, $id = '')
    {
        $where = array('PAGE_SLUG' => $slug, 'PAGE_LANG' => $lang);
        if ($id) {
            $where['PAGE_ID'] = array('neq', $id);
        }
        $count = $this->where($where)->count();
        return $count > 0;
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
     * @param         $language
     * @param string  $id
     * @return mixed
     */
    public function getParent($language, $id = '')
    {
        $where = array('PAGE_PARENT' => 0, 'PAGE_LANG' => $language);
        if (!empty($id)) {
            $where['PAGE_ID'] = array('neq', $id);
        }
        return $this->where($where)->select();
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
            $return = array('status' => true);
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

    /**
     * 更新页面
     *
     * @param $data
     * @return array
     */
    public function updatePage($data)
    {
        try {
            $return = array('status' => true);
            $data['MODIFIED_TIME'] = array('exp', 'NOW()');
            //判断id是否存在
            $page = $this->field('PAGE_LANG')->where(array('PAGE_ID'=>$data['PAGE_ID']))->find();
            if (!$page) {
                throw new \Exception('该页面id不存在', 200);
            }
            //判断别名是否存在
            if ($this->isSlugExists($data['PAGE_SLUG'], $page["PAGE_LANG"], $data['PAGE_ID'])) {
                throw new \Exception('该页面别名已存在！', 201);
            }
            //判断是否存在子页面
            if ($data['PAGE_PARENT'] != 0 && $this->hasChild($data['PAGE_ID'])) {
                throw new \Exception('该页面还有子页面，不能移到别的页面下！', 202);
            }
            //修改操作
            $result = $this->where(array('PAGE_ID' => $data['PAGE_ID']))->save($data);
            if (!$result) {
                throw new \Exception('删除失败', 203);
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
     * 添加页面
     *
     * @param $data
     * @return array
     */
    public function addPage($data)
    {
        try {
            $return = array('status' => true);
            //判断别名是否存在
            if ($this->isSlugExists($data['PAGE_SLUG'], $data["PAGE_LANG"])) {
                throw new \Exception('该页面别名已存在！', 200);
            }
            //添加操作
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
     * 获取页面url
     *
     * @param $paths
     * @return string
     */
    protected function getUrl($paths)
    {
        $path = implode('/', $paths);
        $protocol = C('www.protocol');
        $domain = C('www.domain');
        $uri = "{$protocol}://{$domain}/{$path}";
        return $uri;
    }
}
