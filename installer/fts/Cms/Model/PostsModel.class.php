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
        'POST_TAGS_ID',
        'POST_STATUS',
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
        'POST_TAGS_ID',
        'POST_STATUS',
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
            ->field('POST_ID, POST_TITLE, POST_AUTHOR_ID, PUBLISHED_TIME, CREATED_TIME, MODIFIED_TIME')
            ->order('PUBLISHED_TIME DESC')
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
        if (empty($data['PUBLISHED_TIME'])) {
            $data['PUBLISHED_TIME'] = array('exp', 'NOW()');
        }
        return $this->add($data);
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
        if (empty($data['PUBLISHED_TIME'])) {
            unset($data['PUBLISHED_TIME']);
        }
        $data['MODIFIED_TIME'] = array('exp', 'NOW()');
        return $this->where(array('POST_ID' => $id))->save($data);
    }

    /**
     * 获取指定id的文章信息
     *
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->field('POST_ID, POST_TITLE, POST_CONTENT, POST_AUTHOR_ID, POST_CATEGORY_ID, POST_TAGS_ID, POST_TRANSLATE_ID, POST_LANG, POST_STATUS, PUBLISHED_TIME, SEO_KEYWORD, SEO_DESCRIPTION, SEO_TITLE')
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
}
