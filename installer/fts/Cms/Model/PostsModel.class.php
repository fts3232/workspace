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
     * @param $offset
     * @param $size
     * @return array
     */
    public function getAll($offset, $size)
    {
        $result = $this
            ->alias('a')
            ->field('a.POST_ID, a.POST_TITLE, a.POST_AUTHOR_ID, a.PUBLISHED_TIME, a.CREATED_TIME, a.MODIFIED_TIME, a.POST_ORDER, b.CATEGORY_NAME')
            ->join('category b ON b.CATEGORY_ID = a.POST_CATEGORY_ID', 'LEFT')
            ->order('a.POST_ORDER DESC, a.PUBLISHED_TIME DESC')
            ->limit($offset, $size)
            ->select();
        return $result ? $result : array();
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
            foreach($diff['delete'] as $tag){
                $result = $relationModel->deleteRelation($id, $tag);
                if (!$result) {
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
     * 获取指定id的对照文章
     *
     * @param $translateID
     * @param $postID
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
    public function deletePost($id){
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
            if (!$result) {
                throw new \Exception('删除失败');
            }
            $this->commit();
        } catch (\Exception $e) {
            $this->rollback();
            $return = false;
        }
        return $return;
    }
}
