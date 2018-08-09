<?php

namespace Cms\Model;

use Think\Model;

/**
 * 文章历史修改记录模型
 *
 * Class PostsRevisionHistoryModel
 * @package Cms\Model
 */
class PostsRevisionHistoryModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    /**
     * 可以插入数据的字段
     *
     * @var array
     */
    protected $insertFields = array(
        'POST_ID',
        'POST_AUTHOR_ID'
    );

    /**
     * 可以更新数据的字段
     *
     * @var array
     */
    protected $updateFields = array(
        'POST_ID',
        'POST_AUTHOR_ID'
    );

    /**
     * 添加修改历史
     *
     * @param $postID
     * @param $authorID
     * @return mixed
     */
    public function addHistory($postID, $authorID)
    {

        return $this->add(array('POST_ID' => $postID, 'POST_AUTHOR_ID' => $authorID));
    }

    /**
     * 获取指定文章修改历史
     *
     * @param $postID
     * @return mixed
     */
    public function getHistory($postID)
    {
        return $this->field('POST_AUTHOR_ID AS AUTHOR_NAME, CREATED_TIME')
            ->where(array('POST_ID' => $postID))
            ->select();
    }

    /**
     * 删除指定文章的修改历史
     *
     * @param $postID
     * @return mixed
     */
    public function deleteHistory($postID)
    {
        return $this->where(array('POST_ID' => $postID))->delete();
    }
}
