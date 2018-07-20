<?php

namespace Cms\Model;

use Think\Model;

class TagsModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    public function getList($offset, $size)
    {
        $result = $this->field('TAG_ID,TAG_NAME')->order('TAG_ID ASC')->limit($offset . ',' . $size)->select();
        return $result ? $result : array();
    }

    public function get($id){
        return $this->field('TAG_ID,TAG_NAME,TITLE,KEYWORD,DESCRIPTION')->where(array('TAG_ID'=>$id))->find();
    }

    public function addTag($data)
    {
        $where = array(
            'TAG_NAME' => $data['name']
        );
        $data = array(
            'TAG_NAME' => $data['name'],
            'TITLE' => $data['title'],
            'DESCRIPTION' => $data['description'],
            'KEYWORD' => $data['keyword']
        );
        $result = $this->where($where)->find();
        if ($result > 0) {
            return false;//$result['TAG_ID'];
        }
        return $result = $this->add($data);
    }

    public function updateTag($data)
    {
        $where = array(
            'TAG_ID'=>$data['id']
        );
        $data = array(
            'TAG_NAME' => $data['name'],
            'TITLE' => $data['title'],
            'DESCRIPTION' => $data['description'],
            'KEYWORD' => $data['keyword']
        );
        $result = $this->where($where)->save($data);
        return $result;
    }
}
