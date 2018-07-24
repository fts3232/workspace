<?php

namespace Cms\Controller;

use Cms\Common\Validator;
use Think\Controller;

/**
 * 菜单控制器
 *
 * Class MenuController
 * @package Cms\Controller
 */
class MenuController extends Controller
{
    /**
     * 查看菜单
     */
    public function index()
    {
        $model = D('Menu');
        //每页显示多少条
        $pageSize = C('PAGE');
        //获取总条数
        $count = $model->count();
        //分页器
        $page = new \Think\Page($count, $pageSize);
        $pagination = $page->show();
        //获取菜单分页信息
        $list = $model->getAll($page->firstRow, $pageSize);
        $this->assign('list', $list);
        $this->assign('pagination', $pagination);
        $this->display();
    }

    /**
     * 添加菜单
     */
    public function addMenu()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '添加成功');
            try {
                //输出获取并验证数据格式
                $name = I('post.name');
                $validator = Validator::make(
                    array('name' => $name),
                    array('name' => 'required|bannerName'),
                    array('name' => '名称格式不正确')
                );
                if ($validator->isFails()) {
                    throw new \Exception($validator->getFirstError(), 100);
                }
                //添加操作
                $model = D('Menu');
                $id = $model->addMenu($name);
                if (!$id) {
                    throw new \Exception('添加失败', 101);
                }
                $return['id'] = $id;
                $return['url'] = U('edit', array('id' => $id));
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

    /**
     * 修改菜单
     */
    public function editMenu()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '修改成功');
            try {
                //输出获取并验证数据格式
                $name = I('post.name');
                $id = I('post.id', false, 'int');
                $validator = Validator::make(
                    array(
                        'name' => $name,
                        'id' => $id
                    ),
                    array(
                        'name' => 'required|bannerName',
                        'id' => 'required|int'
                    ),
                    array(
                        'name' => '名称格式不正确',
                        'id' => 'id参数不正确'
                    )
                );
                if ($validator->isFails()) {
                    throw new \Exception($validator->getFirstError(), 100);
                }
                $model = D('Menu');
                //判断id是否存在
                if (!$model->isExists($id)) {
                    throw new \Exception('该menu id不存在', 101);
                }
                $result = $model->updateMenu($id, $name);
                if (!$result) {
                    throw new \Exception('修改失败', 102);
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

    /**
     * 删除菜单
     */
    public function deleteMenu()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '删除成功');
            try {
                //输出获取并验证数据格式
                $id = I('post.id', false, 'int');
                $validator = Validator::make(
                    array(
                        'id' => $id
                    ),
                    array(
                        'id' => 'required|int'
                    ),
                    array(
                        'id' => 'id参数不正确'
                    )
                );
                if ($validator->isFails()) {
                    throw new \Exception($validator->getFirstError(), 100);
                }
                $model = D('Menu');
                //判断id是否存在
                if (!$model->isExists($id)) {
                    throw new \Exception('该menu id不存在', 101);
                }
                //删除操作
                $result = $model->deleteMenu($id);
                if (!$result) {
                    throw new \Exception('删除失败', 102);
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

    /**
     * 显示菜单项
     */
    public function showItem()
    {
        $model = D('MenuItem');
        $id = I('get.id', false, 'int');
        $items = $model->getItem($id);
        $this->assign('items', $items);
        $this->assign('menuID', $id);
        $this->display();
    }

    /**
     * 修改菜单项
     */
    public function updateItem()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '更新成功');
            try {
                //整合输入
                $items = I('post.items');
                $menuID = I('post.menu_id', false, 'int');
                $addItems = I('post.add_items');
                //验证输入
                $validator = Validator::make(
                    array(
                        'id' => $menuID,
                        'addItems' => $addItems,
                        'items' => $items
                    ),
                    array(
                        'id' => 'required|int',
                        'addItems' => 'menuItem',
                        'items' => 'menuItem'
                    ),
                    array(
                        'id' => 'id参数不正确',
                        'addItems' => '新添加的菜单项格式不正确',
                        'items' => '更新的菜单项格式不正确'
                    )
                );
                if ($validator->isFails()) {
                    throw new \Exception($validator->getFirstError(), 100);
                }
                $model = D('MenuItem');
                //判断id是否存在
                if (!D('Menu')->isExists($menuID)) {
                    throw new \Exception('该menu id不存在', 101);
                }
                $result = $model->updateItem($menuID, $items, $addItems);
                if (!$result) {
                    throw new \Exception('更新失败', 102);
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
