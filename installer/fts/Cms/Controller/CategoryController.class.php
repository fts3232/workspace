<?php

namespace Cms\Controller;

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
        if(IS_AJAX){
            $model = D('Category');
            $id = I('post.id');
            $result = $model->deleteCategory($id);
            $this->ajaxReturn($result);
        }
    }

    /**
     * 更新栏目信息
     */
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
