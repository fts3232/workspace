<?php

namespace Cms\Model;

use Think\Model;

class BannerModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    /**
     * 可以插入数据的字段
     *
     * @var array
     */
    protected $insertFields = array(
        'BANNER_NAME'
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
     * @param $offset
     * @param $size
     * @return array
     */
    public function getAll($offset, $size)
    {
        $result = $this->field('BANNER_ID, BANNER_NAME')->order('BANNER_ID DESC')->limit($offset, $size)->select();
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
        return $this->field('BANNER_NAME')->where(array('BANNER_ID' => $id))->getField('BANNER_NAME');
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
            if ($this->isExists($data['BANNER_NAME'], 'BANNER_NAME')) {
                throw new \Exception('该banner名称已存在', 200);
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
     * 更新banner
     *
     * @param $data
     * @return array
     */
    public function updateBanner($data)
    {
        try {
            $return = array('status' => true);
            //判断名称是否存在
            if (!$this->isExists($data['BANNER_ID'], 'BANNER_ID')) {
                throw new \Exception('该bannerID不存在', 200);
            }
            //判断名称是否存在
            if ($this->isExists($data['BANNER_NAME'], 'BANNER_NAME')) {
                throw new \Exception('该banner名称已存在', 201);
            }
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
     * @return bool
     */
    public function deleteBanner($id)
    {
        try {
            $return = array('status' => true);
            $this->startTrans();
            //判断名称是否存在
            if (!$this->isExists($id, 'BANNER_ID')) {
                throw new \Exception('该bannerID不存在', 200);
            }
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
    public function isExists($val, $type = 'BANNER_ID')
    {
        if ($type == 'BANNER_ID') {
            $where = array('BANNER_ID' => $val);
        } else {
            $where = array('BANNER_NAME' => $val);
        }
        $count = $this->where($where)->count();
        return $count > 0;
    }
}
