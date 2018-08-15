<?php

namespace Cms\Model;

use Think\Model;

/**
 * 菜单模型
 *
 * Class MenuModel
 * @package Cms\Model
 */
class MenuModel extends Model
{
    protected $connection = 'DB_CONFIG1';

    protected $trueTableName = 'cms_menu';

    /**
     * 可以插入数据的字段
     *
     * @var array
     */
    protected $insertFields = array(
        'MENU_NAME',
        'MENU_LANG'
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
     * @param $whereData
     * @param $offset
     * @param $size
     * @return array
     */
    public function getList($whereData, $offset, $size)
    {
        $where = $this->getWhere($whereData);
        $result = $this->field('MENU_ID, MENU_NAME')
            ->where($where)
            ->order('MENU_ID DESC')
            ->limit($offset, $size)
            ->select();
        return $result ? $result : array();
    }

    /**
     * 获取总条数
     *
     * @param $whereData
     * @return mixed
     */
    public function getCount($whereData)
    {
        $where = $this->getWhere($whereData);
        return $this->where($where)->count();
    }

    /**
     * 获取查询条件
     *
     * @param $whereData
     * @return array
     */
    public function getWhere($whereData)
    {
        $where = array();
        $where['MENU_LANG'] = $whereData['language'];
        return $where;
    }

    /**
     * 获取指定id的menu名称
     *
     * @param $id
     * @return mixed
     */
    public function getName($id)
    {
        return $this->field('MENU_NAME')
            ->where(array('MENU_ID' => $id))
            ->getField('MENU_NAME');
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
            //判断id是否存在
            $menu = $this->field('MENU_LANG')->where(array('MENU_ID' => $data['MENU_ID']))->find();
            if (!$menu) {
                throw new \Exception('该菜单ID不存在', 200);
            }
            //判断名称是否存在
            if ($this->isNameExists($menu['MENU_LANG'], $data['MENU_NAME'], $data['MENU_ID'])) {
                throw new \Exception('该菜单名称已存在', 201);
            }
            $data['MODIFIED_TIME'] = array('exp', 'NOW()');
            //更新操作
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
            if ($this->isNameExists($data['MENU_LANG'], $data['MENU_NAME'])) {
                throw new \Exception('该菜单名称已存在', 200);
            }
            //添加操作
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
     * @return array
     */
    public function deleteMenu($id)
    {
        try {
            $return = array('status' => true);
            $this->startTrans();
            //判断名称是否存在
            if (!$this->isExists($id)) {
                throw new \Exception('该菜单ID不存在', 200);
            }
            //删除操作
            $result = $this->delete($id);
            if (!$result) {
                throw new \Exception('删除菜单失败', 201);
            }
            //删除菜单内容
            $result = D('MenuItem')->where(array('MENU_ID' => $id))->delete();
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
     * 判断指定的菜单id是否存在
     *
     * @param $id
     * @return bool
     */
    public function isExists($id)
    {
        $where = array('MENU_ID' => $id);
        $count = $this->where($where)->count();
        return $count > 0;
    }

    /**
     * 判断指定的菜单名是否存在
     *
     * @param        $lang
     * @param        $name
     * @param string $id
     * @return bool
     */
    public function isNameExists($lang, $name, $id = '')
    {
        $where = array('MENU_NAME' => $name, 'MENU_LANG' => $lang);
        if ($id) {
            $where['MENU_ID'] = array('neq', $id);
        }
        $count = $this->where($where)->count();
        return $count > 0;
    }
}
