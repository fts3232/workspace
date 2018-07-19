<?php

namespace Cms\Model;

use Think\Model;

class BannerItemModel extends Model
{
    protected $connection = 'DB_CONFIG_TEST';

    public function getItem($bannerID)
    {
        $where = array(
            'BANNER_ID' => $bannerID
        );
        $list = $this->field('ITEM_ID, ITEM_IMG, ITEM_URL')
            ->where($where)
            ->order('ITEM_ORDER ASC')
            ->select();
        $list = $list ? $list : array();
        return json_encode($list);
    }

    public function updateItem($menuID, $items, $addItems)
    {
        try {
            $return = true;
            $this->startTrans();
            $where = array(
                'BANNER_ID' => $menuID
            );
            $list = $this->field('ITEM_ID, ITEM_URL, ITEM_IMG, ITEM_ORDER')
                ->where($where)
                ->select();
            $temp = array();
            foreach ($items as $k => $v) {
                $temp[$v['ITEM_ID']] = $v;
            }
            foreach ($addItems as $v) {
                $v['BANNER_ID'] = $menuID;
                $result = $this->add($v);
                if (!$result) {
                    throw new \Exception('添加失败');
                }
            }
            $i = 0;
            foreach ($list as $k => $v) {
                if (!isset($temp[$v['ITEM_ID']])) {
                    $result = $this->delete($v['ITEM_ID']);
                    if (!$result) {
                        throw new \Exception('删除失败');
                    }
                } else {
                    if ($v == $temp[$v['ITEM_ID']]) {
                        continue;
                    }
                    $i++;
                    $temp[$v['ITEM_ID']]['MODIFIED_TIME'] = array('exp', 'NOW()');
                    $result = $this->where(array('ITEM_ID' => $v['ITEM_ID']))->save($temp[$v['ITEM_ID']]);
                    if (!$result) {
                        throw new \Exception('更新失败');
                    }
                }
            }
            $this->commit();
        } catch (\Exception $e) {
            $this->rollback();
            $return = false;
        }
        return $return;
    }
}