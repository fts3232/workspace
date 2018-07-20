<?php

namespace Cms\Model;

use Think\Model;

class PostsModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    public function getList($offset, $size)
    {
        $result = $this
            ->field('POST_ID,TITLE,CONTENT,AUTHOR,PUBLISHED_TIME,CREATED_TIME,MODIFIED_TIME')
            ->order('PUBLISHED_TIME DESC')
            ->limit($offset . ',' . $size)
            ->select();
        return $result ? $result : array();
    }

    public function addPost($data)
    {
        return $this->add($data);
    }

    public function editPost($id, $data)
    {
        $data['MODIFIED_TIME'] = array('exp', 'NOW()');
        return $this->where(array('POST_ID' => $id))->save($data);
    }

    public function get($id)
    {
        return $this
            ->field('POST_ID,TITLE,CONTENT,AUTHOR,PUBLISHED_TIME,KEYWORD,DESCRIPTION,CATEGORY_ID,TAGS_ID,TRANSLATE_ID,LANG')
            ->where(array('POST_ID' => $id))
            ->find();
    }

    public function deleteMenu($id)
    {
        try {
            $return = true;
            $this->startTrans();
            $result = $this->delete($id);
            if (!$result) {
                throw new \Exception('删除menu失败');
            }
            $result = $this->table('menu_item')->where(array('MENU_ID' => $id))->delete();
            if ($result === false) {
                throw new \Exception('删除menu_item失败');
            }
            $this->commit();
        } catch (\Exception $e) {
            $this->rollback();
            $return = false;
        }
        return $return;
    }

}
