<?php

namespace Cms\Model;

use Think\Model;

class TagsModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    /**
     * 可以插入数据的字段
     *
     * @var array
     */
    protected $insertFields = array(
        'TAG_NAME',
        'TAG_DESCRIPTION',
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
        'TAG_NAME',
        'TAG_DESCRIPTION',
        'SEO_TITLE',
        'SEO_KEYWORD',
        'SEO_DESCRIPTION',
        'MODIFIED_TIME'
    );

    /**
     * 获取tag分页数据
     *
     * @param $offset
     * @param $size
     * @return array
     */
    public function getAll($offset, $size)
    {
        $result = $this->field('TAG_ID,TAG_NAME')->order('TAG_ID ASC')->limit($offset, $size)->select();
        return $result ? $result : array();
    }

    /**
     * 获取指定tag信息
     *
     * @param string $id tagID
     * @return mixed
     */
    public function get($id)
    {
        return $this->field('TAG_ID, TAG_NAME, TAG_DESCRIPTION, SEO_TITLE, SEO_KEYWORD, SEO_DESCRIPTION')
            ->where(array('TAG_ID' => $id))
            ->find();
    }

    /**
     * 添加tag
     *
     * @param $data
     * @return bool|mixed
     */
    public function addTag($data)
    {
        $data = array(
            'TAG_NAME' => $data['name'],
            'TAG_DESCRIPTION' => $data['description'],
            'SEO_TITLE' => $data['seo_title'],
            'SEO_DESCRIPTION' => $data['seo_description'],
            'SEO_KEYWORD' => $data['seo_keyword']
        );
        return $this->add($data);
    }

    /**
     * 更新tag
     *
     * @param $data
     * @return bool
     */
    public function updateTag($data)
    {
        $where = array(
            'TAG_ID' => $data['id']
        );
        $data = array(
            'TAG_NAME' => $data['name'],
            'TAG_DESCRIPTION' => $data['description'],
            'SEO_TITLE' => $data['seo_title'],
            'SEO_DESCRIPTION' => $data['seo_description'],
            'SEO_KEYWORD' => $data['seo_keyword']
        );
        $result = $this->where($where)->save($data);
        return $result;
    }

    /**
     * 判断tag是否存在
     *
     * @param $name
     * @return bool
     */
    public function isExists($name)
    {
        return $this->field('TAG_ID')->where(array('TAG_NAME' => $name))->find();
    }
}
