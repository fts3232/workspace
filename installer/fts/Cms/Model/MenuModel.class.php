<?php

namespace Cms\Model;

use Think\Model;

class MenuModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    public function get()
    {
        $result = $this->field('MENU_ID,MENU_NAME')->select();
        return $result ? $result : array();
    }

    public function addMenu($name)
    {
        $data = array(
            'MENU_NAME' =>$name
        );
        return $result = $this->add($data);
    }

    public function deleteMenu($id)
    {
        return $result = $this->delete($id);
    }

}
