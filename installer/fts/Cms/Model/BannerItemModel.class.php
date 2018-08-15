<?php

namespace Cms\Model;

use Think\Model;

/**
 * banner项模型
 *
 * Class BannerItemModel
 * @package Cms\Model
 */
class BannerItemModel extends Model
{
    protected $connection = 'DB_CONFIG1';

    protected $trueTableName = 'cms_banner_item';

    /**
     * 可以插入数据的字段
     *
     * @var array
     */
    protected $insertFields = array(
        'BANNER_ID',
        'ITEM_IMG',
        'ITEM_URL',
        'ITEM_TITLE',
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
        'ITEM_TITLE',
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
        $list = $this->field('ITEM_ID, ITEM_IMG, ITEM_URL, ITEM_STATUS, ITEM_TITLE')
            ->where($where)
            ->order('ITEM_ORDER ASC')
            ->select();
        $list = $list ? $list : array();
        return json_encode($list);
    }

    /**
     * 添加banner项
     *
     * @param $data
     * @return mixed
     */
    public function addItem($data)
    {
        $data = array(
            'BANNER_ID' => $data['BANNER_ID'],
            'ITEM_ORDER' => $data['ITEM_ORDER'],
            'ITEM_STATUS' => 1,
            'ITEM_URL' => '',
            'ITEM_TITLE' => '',
            'ITEM_IMG' => $data['ITEM_IMG']
        );
        $result = $this->add($data);
        return $result;
    }

    /**
     * 更新banner项
     *
     * @param $data
     * @return array
     */
    public function updateItem($data)
    {
        try {
            $return = array('status'=>true);
            $this->startTrans();
            $where = array(
                'BANNER_ID' => $data['BANNER_ID']
            );
            $list = $this->field('ITEM_ID')
                ->where($where)
                ->select();
            $list = $list ? $list : array();
            $temp = array();
            if (is_array($data['ITEMS'])) {
                foreach ($data['ITEMS'] as $k => $v) {
                    $temp[$v['ITEM_ID']] = $v;
                }
            }
            $i = 0;
            //判断哪些项是更新的
            foreach ($list as $k => $v) {
                if (!isset($temp[$v['ITEM_ID']])) {
                    $result = $this->delete($v['ITEM_ID']);
                    if (!$result) {
                        throw new \Exception('删除失败', 200);
                    }
                } else {
                    if ($v == $temp[$v['ITEM_ID']]) {
                        continue;
                    }
                    $i++;
                    $temp[$v['ITEM_ID']]['MODIFIED_TIME'] = array('exp', 'NOW()');
                    $result = $this->where(array('ITEM_ID' => $v['ITEM_ID']))->save($temp[$v['ITEM_ID']]);
                    if (!$result) {
                        throw new \Exception('更新失败', 201);
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
