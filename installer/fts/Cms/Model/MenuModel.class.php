<?php

namespace Cms\Model;

use Think\Model;

class MenuModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    public function getAll($offset, $size)
    {
        $result = $this->field('MENU_ID,MENU_NAME')->order('MENU_ID ASC')->limit($offset, $size)->select();
        return $result ? $result : array();
    }

    public function addMenu($name)
    {
        $data = array(
            'MENU_NAME' => $name
        );
        return $this->add($data);
    }

    public function updateMenu($id, $name)
    {
        $data = array(
            'MENU_NAME' => $name,
            'MODIFIED_TIME' => array('exp', 'NOW()')
        );
        return $this->where(array('MENU_ID' => $id))->save($data);
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
