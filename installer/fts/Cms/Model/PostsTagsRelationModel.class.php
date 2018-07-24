<?php

namespace Cms\Model;

use Think\Model;

class PostsTagsRelationModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    /**
     * 可以插入数据的字段
     *
     * @var array
     */
    protected $insertFields = array(
        'POST_ID',
        'TAG_ID'
    );

    /**
     * 可以更新数据的字段
     *
     * @var array
     */
    protected $updateFields = array(
        'POST_ID',
        'TAG_ID'
    );

    /**
     * 添加tag和post的关系
     *
     * @param $postID
     * @param $tagID
     * @return mixed
     */
    public function addRelation($postID, $tagID)
    {

        return $this->add(array('POST_ID' => $postID, 'TAG_ID' => $tagID));
    }

    /**
     * 获取post的tag关系
     *
     * @param $postID
     * @return mixed
     */
    public function getRelation($postID)
    {
        return $this->field('TAG_ID')->where(array('POST_ID' => $postID))->getField('TAG_ID', true);
    }

    /**
     * 获取post的tag名称
     *
     * @param $postID
     * @return mixed
     */
    public function getTags($postID)
    {
        return $this->alias('a')->field('b.TAG_NAME, b.TAG_ID')->join('tags b ON a.TAG_ID = b.TAG_ID')->where(array('a.POST_ID' => $postID))->select();
    }

    /**
     * 删除post和tag的关系
     *
     * @param      $postID
     * @param null $tagID
     * @return mixed
     */
    public function deleteRelation($postID, $tagID = null)
    {
        if (empty($tagID)) {
            return $this->where(array('POST_ID' => $postID))->delete();
        }
        return $this->where(array('POST_ID' => $postID, 'TAG_ID' => $tagID))->delete();
    }
}
