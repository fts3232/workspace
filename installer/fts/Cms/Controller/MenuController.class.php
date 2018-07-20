<?php

namespace Cms\Controller;

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
                $name = I('post.name');
                $model = D('Menu');
                $id = $model->addMenu($name);
                if (!$id) {
                    throw new \Exception('添加失败', 100);
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
                $name = I('post.name');
                $id = I('post.id', false, 'int');
                $model = D('Menu');
                $result = $model->updateMenu($id, $name);
                if (!$result) {
                    throw new \Exception('修改失败', 100);
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
                $id = I('post.id', false, 'int');
                $model = D('Menu');
                $result = $model->deleteMenu($id);
                if (!$result) {
                    throw new \Exception('删除失败', 100);
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
                $items = I('post.items');
                $menuID = I('post.menuID', false, 'int');
                $addItems = I('post.addItems');
                $model = D('MenuItem');
                $result = $model->updateItem($menuID, $items, $addItems);
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
