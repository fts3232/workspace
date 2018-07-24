<?php

namespace Cms\Model;

use Think\Model;

class PostsTagsModel extends Model
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
}
