<?php

namespace Cms\Controller;

use Think\Controller;

/**
 * 栏目
 *
 * Class CategoryController
 * @package Cms\Controller
 */
class CategoryController extends Controller
{
    use Validate;

    //验证规则
    protected $validateRule = array(
        'CATEGORY_ID' => 'required|int',
        'ITEMS' => 'categoryItem',
        'ADD_ITEMS' => 'categoryItem'
    );

    //验证错误信息
    protected $validateMsg = array(
        'CATEGORY_ID' => '栏目ID格式不正确',
        'ITEMS' => '更新的栏目项格式不正确',
        'ADD_ITEMS' => '新添加的栏目项格式不正确'
    );

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
                //获取输入
                $data = array(
                    'CATEGORY_ID' => I('post.id', false, 'int')
                );
                //验证输入格式
                $this->validate($data);
                $model = D('Category');
                //删除操作
                $result = $model->deleteCategory($data['CATEGORY_ID']);
                if (!$result['status']) {
                    throw new \Exception($result['msg'], $result['code']);
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
                //获取输入
                $data = array(
                    'ADD_ITEMS' => I('post.add_items'),
                    'ITEMS' => I('post.items')
                );
                //验证输入格式
                $this->validate($data);
                //模型实例化
                $model = D('Category');
                //更新操作
                $result = $model->updateCategory($data);
                if (!$result['status']) {
                    throw new \Exception($result['msg'], $result['code']);
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
