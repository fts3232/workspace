<?php

namespace Cms\Controller;

use Think\Controller;

/**
 * menu
 *
 * Class MenuController
 * @package Cms\Controller
 */
class MenuController extends Controller
{
    use Validate;

    //验证规则
    protected $validateRule = array(
        'MENU_NAME' => 'required|itemName',
        'MENU_ID' => 'required|int',
        'ADD_ITEMS' => 'menuItem',
        'ITEMS' => 'menuItem'
    );

    //验证错误信息
    protected $validateMsg = array(
        'MENU_NAME' => '菜单名称格式不正确',
        'MENU_ID' => '菜单ID格式不正确',
        'ADD_ITEMS' => '新添加的菜单项格式不正确',
        'ITEMS' => '更新的菜单项格式不正确'
    );

    /**
     * 查看菜单
     */
    public function index()
    {
        $model = D('Menu');
        //每页显示多少条
        $pageSize = C('pageSize');
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
                //获取输入
                $data = array(
                    'MENU_NAME' => I('post.name')
                );
                //验证输入格式
                $this->validate($data);
                //模型实例化
                $model = D('Menu');
                //添加操作
                $result = $model->addMenu($data);
                if (!$result['status']) {
                    throw new \Exception($result['msg'], $result['code']);
                }
                $return['id'] = $result['id'];
                $return['url'] = U('showItem', array('id' =>  $result['id']));
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
                //获取输入
                $data = array(
                    'MENU_NAME' => I('post.name'),
                    'MENU_ID' => I('post.id', false, 'int')
                );
                //验证输入格式
                $this->validate($data);
                //模型实例化
                $model = D('Menu');
                //更新操作
                $result = $model->updateMenu($data);
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

    /**
     * 删除菜单
     */
    public function deleteMenu()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '删除成功');
            try {
                //获取输入
                $data = array(
                    'MENU_ID' => I('post.id', false, 'int')
                );
                //验证输入格式
                $this->validate($data);
                //模型实例化
                $model = D('Menu');
                //删除操作
                $result = $model->deleteMenu($data['MENU_ID']);
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

    /**
     * 显示菜单项
     */
    public function showItem()
    {
        try {
            //获取输入
            $data = array(
                'MENU_ID' => I('get.id', false, 'int')
            );
            //验证输入格式
            $this->validate($data);
            $model = D('Menu');
            $menuName = $model->getName($data['MENU_ID']);
            if (empty($menuName)) {
                throw new Exception('该菜单ID不存在', 100);
            }
            $model = D('MenuItem');
            $items = $model->getItem($data['MENU_ID']);
            $this->assign('items', $items);
            $this->assign('menuID', $data['MENU_ID']);
            $this->assign('menuName', $menuName);
            $this->display();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 修改菜单项
     */
    public function updateItem()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '更新成功');
            try {
                //获取输入
                $data = array(
                    'MENU_ID' => I('post.menu_id', false, 'int'),
                    'ADD_ITEMS' => I('post.add_items'),
                    'ITEMS' => I('post.items')
                );
                //验证输入格式
                $this->validate($data);
                $model = D('MenuItem');
                $result = $model->updateItem($data);
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
