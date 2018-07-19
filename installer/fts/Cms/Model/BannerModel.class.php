<?php

namespace Cms\Model;

use Think\Model;

class BannerModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    public function get()
    {
        $result = $this->field('BANNER_ID,BANNER_NAME')->order('BANNER_ID ASC')->select();
        return $result ? $result : array();
    }

    public function addBanner($name)
    {
        $data = array(
            'BANNER_NAME' => $name
        );
        return $result = $this->add($data);
    }

    public function updateBanner($id, $name)
    {
        $data = array(
            'BANNER_NAME' => $name,
            'MODIFIED_TIME' => array('exp', 'NOW()')
        );
        return $result = $this->where(array('BANNER_ID' => $id))->save($data);
    }

    public function deleteBanner($id)
    {
        try {
            $return = true;
            $this->startTrans();
            $result = $this->delete($id);
            if (!$result) {
                throw new \Exception('删除banner失败');
            }
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

}
