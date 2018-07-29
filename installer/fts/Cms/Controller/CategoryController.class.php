<?php

namespace Cms\Controller;

use Cms\Common\Validator;
use Think\Controller;

class CategoryController extends Controller
{
    /**
     * 查看栏目信息
     */
    public function index()
    {
        $model = D('Category');
        $items = $model->getAll();
        $this->assign('items', $items);
        $this->display();
    }

    /**
     * 删除栏目
     */
    public function delete()
    {
        if (IS_AJAX) {
            try {
                $return = array('status' => true, 'msg' => '删除成功');
                //输出获取并验证数据格式
                $id = I('post.id', false, 'int');
                $validator = Validator::make(
                    array('id' => $id),
                    array('id' => 'required|int'),
                    array('id' => 'id参数不正确')
                );
                if ($validator->isFails()) {
                    throw new \Exception($validator->getFirstError(), 100);
                }
                $model = D('Category');
                //判断是否有子栏目
                if ($model->hasChild($id)) {
                    throw new \Exception('该栏目底下还有子栏目，请先删除子栏目内容！', 101);
                }
                //删除操作
                $result = $this->delete($id);
                if (!$result) {
                    throw new \Exception('删除失败！', 102);
                }
            } catch (\Exception $e) {
                $return = array(
                    'status' => false,
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode()
                );
            }
            $this->ajaxReturn($return);
        }
    }

    /**
     * 更新栏目信息
     */
    public function update()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '更新成功');
            try {
                //整合输入
                $addItems = I('post.add_items');
                $items = I('post.items');
                //验证输入
                $validator = Validator::make(
                    array(
                        'addItems' => $addItems,
                        'items' => $items
                    ),
                    array(
                        'addItems' => 'categoryItem',
                        'items' => 'categoryItem'
                    ),
                    array(
                        'addItems' => '新添加的栏目项格式不正确',
                        'items' => '更新的栏目项格式不正确'
                    )
                );
                if ($validator->isFails()) {
                    throw new \Exception($validator->getFirstError(), 100);
                }
                $model = D('Category');
                //更新操作
                $result = $model->updateCategory($items, $addItems);
                if (!$result) {
                    throw new \Exception('更新失败', 101);
                }
            } catch (\Exception  $e) {
                $return = array(
                    'status' => false,
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode()
                );
            }
            $this->ajaxReturn($return);
        }
    }
}
