<?php

namespace Cms\Model;

use Think\Model;

class PostsModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    public function getList()
    {
        $result = $this->field('POST_ID,TITLE,CONTENT,AUTHOR,PUBLISHED_TIME,CREATED_TIME,MODIFIED_TIME')->order('PUBLISHED_TIME DESC')->limit(20)->select();
        return $result ? $result : array();
    }

    public function addPost($title,$keyword,$description,$category,$content)
    {
        $data = array(
            'TITLE' => $title,
            'KEYWORD' => $keyword,
            'DESCRIPTION' => $description,
            'CATEGORY_ID' =>$category,
            'CONTENT' => $content,
            'TRANSLATE_ID' => 0,
            'LANG'=>'zh_CN'
        );
        return $this->add($data);
    }

    public function get($id)
    {

        return $this->field('POST_ID,TITLE,CONTENT,AUTHOR,PUBLISHED_TIME,KEYWORD,DESCRIPTION,CATEGORY_ID')->where(array('POST_ID' => $id))->find();
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
