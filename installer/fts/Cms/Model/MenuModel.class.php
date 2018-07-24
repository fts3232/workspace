<?php

namespace Cms\Model;

use Think\Model;

class MenuModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    /**
     * 可以插入数据的字段
     *
     * @var array
     */
    protected $insertFields = array(
        'MENU_NAME'
    );

    /**
     * 可以更新数据的字段
     *
     * @var array
     */
    protected $updateFields = array(
        'MENU_NAME',
        'MODIFIED_TIME'
    );

    /**
     * 获取分页菜单信息
     *
     * @param $offset
     * @param $size
     * @return array
     */
    public function getAll($offset, $size)
    {
        $result = $this->field('MENU_ID,MENU_NAME')->order('MENU_ID ASC')->limit($offset, $size)->select();
        return $result ? $result : array();
    }

    /**
     * 获取指定id的menu名称
     *
     * @param $id
     * @return mixed
     */
    public function getName($id)
    {
        return $this->field('MENU_NAME')->where(array('MENU_ID' => $id))->getField('MENU_NAME');
    }

    /**
     * 添加菜单
     *
     * @param $name
     * @return mixed
     */
    public function addMenu($name)
    {
        $data = array(
            'MENU_NAME' => $name
        );
        return $this->add($data);
    }

    /**
     * 更新菜单
     *
     * @param $id
     * @param $name
     * @return bool
     */
    public function updateMenu($id, $name)
    {
        $data = array(
            'MENU_NAME' => $name,
            'MODIFIED_TIME' => array('exp', 'NOW()')
        );
        return $this->where(array('MENU_ID' => $id))->save($data);
    }

    /**
     * 删除菜单
     *
     * @param $id
     * @return bool
     */
    public function deleteMenu($id)
    {
        try {
            $return = true;
            $this->startTrans();
            $result = $this->delete($id);
            if (!$result) {
                throw new \Exception('删除menu失败');
            }
            //删除菜单内容
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

    public function isExists($id)
    {
        $count = $this->where(array('MENU_ID' => $id))->count();
        return $count > 0 ? true : false;
    }
}
