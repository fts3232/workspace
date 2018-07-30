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
        $result = $this->field('MENU_ID,MENU_NAME')->order('MENU_ID DESC')->limit($offset, $size)->select();
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
     * 更新菜单
     *
     * @param $data
     * @return array
     */
    public function updateMenu($data)
    {
        try {
            $return = array('status' => true);
            //判断名称是否存在
            if (!$this->isExists($data['MENU_ID'], 'MENU_ID')) {
                throw new \Exception('该菜单ID不存在', 200);
            }
            //判断名称是否存在
            if ($this->isExists($data['MENU_NAME'], 'MENU_NAME')) {
                throw new \Exception('该菜单名称已存在', 201);
            }
            $data['MODIFIED_TIME'] = array('exp', 'NOW()');
            $result = $this->where(array('MENU_ID' => $data['MENU_ID']))->save($data);
            if (!$result) {
                throw new \Exception('修改失败', 202);
            }
        } catch (\Exception $e) {
            $return = array(
                'status' => false,
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }
        return $return;
    }

    /**
     * 添加菜单
     *
     * @param $data
     * @return array
     */
    public function addMenu($data)
    {
        try {
            $return = array('status' => true);
            //判断名称是否存在
            if ($this->isExists($data['MENU_NAME'], 'MENU_NAME')) {
                throw new \Exception('该菜单名称已存在', 200);
            }
            $id = $this->add($data);
            if (!$id) {
                throw new \Exception('添加失败', 201);
            }
            $return['id'] = $id;
        } catch (\Exception $e) {
            $return = array(
                'status' => false,
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }
        return $return;
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
            $return = array('status' => true);
            $this->startTrans();
            //判断名称是否存在
            if (!$this->isExists($id, 'MENU_ID')) {
                throw new \Exception('该菜单ID不存在', 200);
            }
            $result = $this->delete($id);
            if (!$result) {
                throw new \Exception('删除菜单失败', 201);
            }
            //删除菜单内容
            $result = $this->table('menu_item')->where(array('MENU_ID' => $id))->delete();
            if ($result === false) {
                throw new \Exception('清空菜单项失败', 202);
            }
            $this->commit();
        } catch (\Exception $e) {
            $this->rollback();
            $return = array(
                'status' => false,
                'msg' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }
        return $return;
    }

    /**
     * 判断是否对应field值存在
     *
     * @param        $val
     * @param string $field
     * @return bool
     */
    public function isExists($val, $field = 'MENU_ID')
    {
        if ($field == 'MENU_ID') {
            $where = array('MENU_ID' => $val);
        } else {
            $where = array('MENU_NAME' => $val);
        }
        $count = $this->where($where)->count();
        return $count > 0;
    }
}
