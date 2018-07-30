<?php

namespace Cms\Model;

use Think\Model;

class BannerItemModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    /**
     * 可以插入数据的字段
     *
     * @var array
     */
    protected $insertFields = array(
        'BANNER_ID',
        'ITEM_IMG',
        'ITEM_URL',
        'ITEM_STATUS',
        'ITEM_ORDER'
    );

    /**
     * 可以更新数据的字段
     *
     * @var array
     */
    protected $updateFields = array(
        'ITEM_IMG',
        'ITEM_URL',
        'ITEM_ORDER',
        'ITEM_STATUS',
        'MODIFIED_TIME'
    );

    /**
     * 获取banner项
     *
     * @param $bannerID
     * @return mixed|string|void
     */
    public function getItem($bannerID)
    {
        $where = array(
            'BANNER_ID' => $bannerID
        );
        $list = $this->field('ITEM_ID, ITEM_IMG, ITEM_URL, ITEM_STATUS')
            ->where($where)
            ->order('ITEM_ORDER ASC')
            ->select();
        $list = $list ? $list : array();
        return json_encode($list);
    }

    /**
     * 更新banner项
     *
     * @param $data
     * @return bool
     */
    public function updateItem($data)
    {
        try {
            $return = array('status'=>true);
            $this->startTrans();
            $where = array(
                'BANNER_ID' => $data['BANNER_ID']
            );
            //判断id是否存在
            if (!D('Banner')->isExists($data['BANNER_ID'])) {
                throw new \Exception('该bannerID不存在', 200);
            }
            $list = $this->field('ITEM_ID, ITEM_URL, ITEM_IMG, ITEM_ORDER')
                ->where($where)
                ->select();
            $temp = array();
            foreach ($data['ITEMS'] as $k => $v) {
                $temp[$v['ITEM_ID']] = $v;
            }
            foreach ($data['ADD_ITEMS'] as $v) {
                $v['BANNER_ID'] = $data['BANNER_ID'];
                $result = $this->add($v);
                if (!$result) {
                    throw new \Exception('添加失败', 201);
                }
            }
            $i = 0;
            //判断哪些项是更新的
            foreach ($list as $k => $v) {
                if (!isset($temp[$v['ITEM_ID']])) {
                    $result = $this->delete($v['ITEM_ID']);
                    if (!$result) {
                        throw new \Exception('删除失败', 202);
                    }
                } else {
                    if ($v == $temp[$v['ITEM_ID']]) {
                        continue;
                    }
                    $i++;
                    $temp[$v['ITEM_ID']]['MODIFIED_TIME'] = array('exp', 'NOW()');
                    $result = $this->where(array('ITEM_ID' => $v['ITEM_ID']))->save($temp[$v['ITEM_ID']]);
                    if (!$result) {
                        throw new \Exception('更新失败', 203);
                    }
                }
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
}
