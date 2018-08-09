<?php

namespace Cms\Model;

use Think\Model;

/**
 * banner模型
 *
 * Class BannerModel
 * @package Cms\Model
 */
class BannerModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    /**
     * 可以插入数据的字段
     *
     * @var array
     */
    protected $insertFields = array(
        'BANNER_NAME',
        'BANNER_LANG'
    );

    /**
     * 可以更新数据的字段
     *
     * @var array
     */
    protected $updateFields = array(
        'BANNER_NAME',
        'MODIFIED_TIME'
    );

    /**
     * 获取分页banner信息
     *
     * @param $whereData
     * @param $offset
     * @param $size
     * @return array
     */
    public function getList($whereData, $offset, $size)
    {
        $where = $this->getWhere($whereData);
        $result = $this->field('BANNER_ID, BANNER_NAME')
            ->where($where)
            ->order('BANNER_ID DESC')
            ->limit($offset, $size)
            ->select();
        return $result ? $result : array();
    }

    /**
     * 获取指定id的banner名称
     *
     * @param $id
     * @return mixed
     */
    public function getName($id)
    {
        return $this->field('BANNER_NAME')
            ->where(array('BANNER_ID' => $id))
            ->getField('BANNER_NAME');
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
        $where['BANNER_LANG'] = $whereData['language'];
        return $where;
    }

    /**
     * 添加banner
     *
     * @param $data
     * @return mixed
     */
    public function addBanner($data)
    {
        try {
            $return = array('status' => true);
            //判断名称是否存在
            if ($this->isNameExists($data['BANNER_LANG'], $data['BANNER_NAME'])) {
                throw new \Exception('该banner名称已存在', 200);
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
     * 更新banner
     *
     * @param $data
     * @return array
     */
    public function updateBanner($data)
    {
        try {
            $return = array('status' => true);
            //判断id是否存在
            $banner = $this->field('BANNER_LANG')->where(array('BANNER_ID' => $data['BANNER_ID']))->find();
            if (!$banner) {
                throw new \Exception('该bannerID不存在', 200);
            }
            //判断名称是否存在
            if ($this->isNameExists($banner['BANNER_LANG'], $data['BANNER_NAME'], $data['BANNER_ID'])) {
                throw new \Exception('该banner名称已存在', 201);
            }
            //更新操作
            $data['MODIFIED_TIME'] = array('exp', 'NOW()');
            $result = $this->where(array('BANNER_ID' => $data['BANNER_ID']))->save($data);
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
     * 删除banner
     *
     * @param $id
     * @return array
     */
    public function deleteBanner($id)
    {
        try {
            $return = array('status' => true);
            $this->startTrans();
            //判断名称是否存在
            if (!$this->isExists($id)) {
                throw new \Exception('该bannerID不存在', 200);
            }
            //删除操作
            $result = $this->delete($id);
            if (!$result) {
                throw new \Exception('删除banner失败', 201);
            }
            //删除菜单内容
            $result = $this->table('banner_item')->where(array('BANNER_ID' => $id))->delete();
            if ($result === false) {
                throw new \Exception('清空banner项失败', 202);
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
     * 判断banner是否存在
     *
     * @param $id
     * @return bool
     */
    public function isExists($id)
    {
        $where = array('BANNER_ID' => $id);
        $count = $this->where($where)->count();
        return $count > 0;
    }

    /**
     * 判断指定的banner名是否存在
     *
     * @param        $lang
     * @param        $name
     * @param string $id
     * @return bool
     */
    public function isNameExists($lang, $name, $id = '')
    {
        $where = array('BANNER_NAME' => $name, 'BANNER_LANG' => $lang);
        if ($id) {
            $where['BANNER_ID'] = array('neq', $id);
        }
        $count = $this->where($where)->count();
        return $count > 0;
    }
}
