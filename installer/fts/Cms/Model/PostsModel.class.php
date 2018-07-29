<?php

namespace Cms\Model;

use Think\Model;

class PostsModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    /**
     * 可以插入数据的字段
     *
     * @var array
     */
    protected $insertFields = array(
        'POST_TITLE',
        'POST_CONTENT',
        'POST_TRANSLATE_ID',
        'POST_CATEGORY_ID',
        'POST_LANG',
        'POST_AUTHOR_ID',
        'POST_STATUS',
        'POST_ORDER',
        'SEO_TITLE',
        'SEO_KEYWORD',
        'SEO_DESCRIPTION',
        'PUBLISHED_TIME'
    );

    /**
     * 可以更新数据的字段
     *
     * @var array
     */
    protected $updateFields = array(
        'POST_TITLE',
        'POST_CONTENT',
        'POST_TRANSLATE_ID',
        'POST_CATEGORY_ID',
        'POST_LANG',
        'POST_AUTHOR_ID',
        'POST_STATUS',
        'POST_ORDER',
        'SEO_TITLE',
        'SEO_KEYWORD',
        'SEO_DESCRIPTION',
        'PUBLISHED_TIME'
    );

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
        $result = $this
            ->alias('a')
            ->where($where)
            ->field('a.POST_ID, a.POST_TITLE, a.POST_LANG, a.POST_AUTHOR_ID, POST_STATUS, a.PUBLISHED_TIME, a.CREATED_TIME, a.MODIFIED_TIME, a.POST_ORDER, b.CATEGORY_NAME')
            ->join('category b ON b.CATEGORY_ID = a.POST_CATEGORY_ID', 'LEFT')
            ->order('a.POST_ORDER DESC, a.PUBLISHED_TIME DESC')
            ->limit($offset, $size)
            ->select();
        return $result ? $result : array();
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
        return $this->alias('a')->where($where)->count();
    }

    /**
     * 获取搜索条件
     *
     * @param $whereData
     * @return array
     */
    private function getWhere($whereData)
    {
        $where = array('a.POST_STATUS'=>array('in','0,1,2'));
        !empty($whereData['title']) && $where['a.POST_TITLE'] = $whereData['title'];
        !empty($whereData['category']) && $where['a.POST_CATEGORY_ID'] = $whereData['category'];
        !empty($whereData['language']) && $where['a.POST_LANG'] = $whereData['language'];
        !empty($whereData['status']) && $where['a.POST_STATUS'] = $whereData['status'];
        !empty($whereData['time']) && $where['DATE(a.PUBLISHED_TIME)'] = $whereData['time'];
        return $where;
    }

    /**
     * 添加文章
     *
     * @param $data
     * @return mixed
     */
    public function addPost($data)
    {
        try {
            $return = true;
            //开启事务
            $this->startTrans();
            if (empty($data['PUBLISHED_TIME'])) {
                $data['PUBLISHED_TIME'] = array('exp', 'NOW()');
            }
            $data['POST_LAST_STATUS'] = $data['POST_STATUS'];
            //添加
            $id = $this->add($data);
            if (!$id) {
                throw new \Exception('添加失败');
            }
            //添加post和tag的关系
            foreach ($data['POST_TAGS_ID'] as $tag) {
                $result = D('PostsTagsRelation')->addRelation($id, $tag);
                if (!$result) {
                    throw new \Exception('添加关系失败');
                }
            }
            $this->commit();
        } catch (\Exception $e) {
            $this->rollback();
            $return = false;
        }
        return $return;
    }

    /**
     * 判断原标签和先标签的差异
     *
     * @param $source
     * @param $target
     * @return array
     */
    private function tagsDiff($source, $target)
    {
        $delete = [];
        $add = [];
        foreach ($source as $item) {
            if (!in_array($item, $target)) {
                $delete[] = $item;
            }
        }
        foreach ($target as $item) {
            if (!in_array($item, $source)) {
                $add[] = $item;
            }
        }
        return ['delete' => $delete, 'add' => $add];
    }

    /**
     * 修改文章
     *
     * @param $id
     * @param $data
     * @return bool
     */
    public function editPost($id, $data)
    {
        try {
            $return = true;
            //开启事务
            $this->startTrans();
            if (empty($data['PUBLISHED_TIME'])) {
                unset($data['PUBLISHED_TIME']);
            }
            $data['MODIFIED_TIME'] = array('exp', 'NOW()');
            $data['POST_LAST_STATUS'] = $data['POST_STATUS'];
            //保存
            $result = $this->where(array('POST_ID' => $id))->save($data);
            if (!$result) {
                throw new \Exception('修改失败');
            }
            //判断原标签和先标签的差异
            $relationModel = D('PostsTagsRelation');
            $tags = $relationModel->getRelation($id);
            $diff = $this->tagsDiff($tags, $data['POST_TAGS_ID']);
            //修改关系
            foreach ($diff['delete'] as $tag) {
                $result = $relationModel->deleteRelation($id, $tag);
                if ($result === false) {
                    throw new \Exception('删除对应关系失败');
                }
            }
            //添加关系
            foreach ($diff['add'] as $tag) {
                $result = $relationModel->addRelation($id, $tag);
                if (!$result) {
                    throw new \Exception('添加对应关系失败');
                }
            }
            $this->commit();
        } catch (\Exception $e) {
            $this->rollback();
            $return = false;
        }
        return $return;
    }

    /**
     * 获取指定id的文章信息
     *
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->field('POST_ID, POST_TITLE, POST_CONTENT, POST_AUTHOR_ID, POST_CATEGORY_ID, POST_TRANSLATE_ID, POST_LANG, POST_STATUS, PUBLISHED_TIME, SEO_KEYWORD, SEO_DESCRIPTION, SEO_TITLE, POST_ORDER')
            ->where(array('POST_ID' => $id))
            ->find();
    }

    /**
     * 判断指定id是否存在
     *
     * @param $id
     * @return bool
     */
    public function getCategorySlug($id)
    {
        $result = $this->field('b.CATEGORY_SLUG')
            ->alias('a')
            ->join('category b on b.CATEGORY_ID = a.POST_CATEGORY_ID', 'LEFT')
            ->where(array('POST_ID' => $id))
            ->find();
        return !empty($result['CATEGORY_SLUG']) ? $result['CATEGORY_SLUG'] : false;
    }

    /**
     * 判断指定id是否存在
     *
     * @param $id
     * @return bool
     */
    public function getCategorySlugAndLastStatus($id)
    {
        $result = $this->field('b.CATEGORY_SLUG, a.POST_LAST_STATUS')
            ->alias('a')
            ->join('category b on b.CATEGORY_ID = a.POST_CATEGORY_ID', 'LEFT')
            ->where(array('POST_ID' => $id))
            ->find();
        return $result;
    }

    /**
     *  获取指定id的对照文章
     *
     * @param $translateID
     * @param $postID
     * @return mixed
     */
    public function getTranslate($translateID, $postID)
    {
        if ($translateID == 0) {
            $where = array(
                'POST_TRANSLATE_ID' => $postID
            );
        } else {
            $where = array(
                array('POST_ID' => array('neq', $postID)),
                array(
                    'POST_TRANSLATE_ID' => $translateID,
                    'POST_ID' => $translateID,
                    '_logic' => 'or'
                ),
            );
        }
        return $this->where($where)->select();
    }

    /**
     * 删除文章
     *
     * @param $id
     * @return bool
     */
    public function deletePost($id)
    {
        try {
            $return = true;
            //开启事务
            $this->startTrans();
            //删除
            $result = $this->where(array('POST_ID' => $id))->delete($id);
            if (!$result) {
                throw new \Exception('删除失败');
            }
            //删除post和tag的关系
            $relationModel = D('PostsTagsRelation');
            $result = $relationModel->deleteRelation($id);
            if ($result === false) {
                throw new \Exception('删除失败');
            }
            $this->commit();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            $this->rollback();
            $return = false;
        }
        return $return;
    }

    /**
     * 软删除
     *
     * @param $id
     * @return mixed
     */
    public function softDeletePost($id)
    {
        return $this->where(array('POST_ID' => $id))->save(array('DELETED_TIME' => array('exp', 'NOW()'), 'POST_STATUS' => 3));
    }

    /**
     * 还原post
     *
     * @param $id
     * @return bool
     */
    public function restorePost($id, $status)
    {
        $where = array('POST_ID' => $id);
        return $this->where($where)->save(array('POST_STATUS' => $status));
    }
}
