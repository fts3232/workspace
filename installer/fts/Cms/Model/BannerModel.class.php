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
        $result = $this->field('BANNER_ID, BANNER_NAME')->order('BANNER_ID ASC')->limit($offset, $size)->select();
        return $result ? $result : array();
    }

    /**
     * 添加banner
     *
     * @param $name
     * @return mixed
     */
    public function addBanner($name)
    {
        $data = array(
            'BANNER_NAME' => $name
        );
        return $this->add($data);
    }

    /**
     * 更新banner
     *
     * @param $id
     * @param $name
     * @return bool
     */
    public function updateBanner($id, $name)
    {
        $data = array(
            'BANNER_NAME' => $name,
            'MODIFIED_TIME' => array('exp', 'NOW()')
        );
        return $this->where(array('BANNER_ID' => $id))->save($data);
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
            $return = true;
            $this->startTrans();
            $result = $this->delete($id);
            if (!$result) {
                throw new \Exception('删除banner失败');
            }
            //删除banner内容
            $result = $this->table('banner_item')->where(array('BANNER_ID' => $id))->delete();
            if ($result === false) {
                throw new \Exception('删除banner_item失败');
            }
            $this->commit();
        } catch (\Exception $e) {
            $this->rollback();
            $return = false;
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
        $count = $this->where(array('BANNER_ID' => $id))->count();
        return $count > 0 ? true : false;
    }
}
