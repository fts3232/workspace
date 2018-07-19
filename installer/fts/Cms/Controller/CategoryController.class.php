<?php

namespace Cms\Controller;

use Think\Controller;

class CategoryController extends Controller
{
    /**
     * 查看菜单
     */
    public function index()
    {
        $model = D('Category');
        $list = $model->get();
        $this->assign('items', $list);
        $this->display();
    }

    public function delete()
    {
        $model = D('Category');
        $id = I('post.id');
        $result = $model->deleteCategory($id);
        $this->ajaxReturn($result);
    }

    public function update(){
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '更新成功');
            try {
                $model = D('Category');
                $addItems = I('post.addItems');
                $items = I('post.items');
                $result = $model->updateCategory($items,$addItems);
                if (!$result) {
                    throw new \Exception('更新失败', 100);
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
