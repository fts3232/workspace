<?php

namespace Cms\Controller;

/**
 * menu管理
 *
 * Class MenuController
 * @package Cms\Controller
 */
class MenuController extends CommonController
{
    use Validate;

    //验证规则
    protected $validateRule = array(
        'MENU_NAME' => 'required|itemName',
        'MENU_ID' => 'required|int',
        'ITEMS' => 'menuItem',
        'ITEM_NAME' => 'itemName',
        'ITEM_URL' => 'required',
    );

    //验证错误信息
    protected $validateMsg = array(
        'MENU_NAME' => '菜单名称格式不正确',
        'MENU_ID' => '菜单ID格式不正确',
        'ITEMS' => '更新的菜单项格式不正确',
        'ITEM_NAME' => '菜单名称不正确',
        'ITEM_URL' => '菜单url格式不正确',
    );

    /**
     * 查看菜单
     */
    public function index()
    {
        //查询条件
        $whereData = array(
            'language' => $this->currentLanguage
        );
        $model = D('Menu');
        //每页显示多少条
        $pageSize = C('pageSize');
        //获取总条数
        $count = $model->getCount($whereData);
        //分页器
        $page = new \Think\Page($count, $pageSize);
        $pagination = $page->show();
        $this->assign('pagination', $pagination);
        //获取菜单分页信息
        $list = $model->getList($whereData, $page->firstRow, $pageSize);
        $this->assign('list', $list);
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
                    'MENU_NAME' => I('post.name'),
                    'MENU_LANG' => $this->currentLanguage
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
            //菜单名
            $menuName = $model->getName($data['MENU_ID']);
            if (empty($menuName)) {
                throw new Exception('该菜单ID不存在', 100);
            }
            $this->assign('menuName', $menuName);
            //模型实例化
            $model = D('MenuItem');
            $items = $model->getItem($data['MENU_ID']);
            $this->assign('items', $items);
            //菜单id
            $this->assign('menuID', $data['MENU_ID']);
            $this->display();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 添加菜单项
     */
    public function addItem()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '添加成功');
            try {
                //获取输入
                $data = array(
                    'MENU_ID' => I('post.menu_id', false, 'int'),
                    'ITEM_NAME' => I('post.name'),
                    'ITEM_URL' => I('post.url'),
                    'ITEM_ORDER' => I('post.order', false, 'int')
                );
                //验证输入格式
                $this->validate($data);
                $model = D('MenuItem');
                //添加操作
                $result = $model->addItem($data);
                if (!$result['status']) {
                    throw new \Exception($result['msg'], $result['code']);
                }
                $return['id'] = $result['id'];
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
                    'ITEMS' => I('post.items')
                );
                //验证输入格式
                $this->validate($data);
                //判断id是否存在
                if (!D('Menu')->isExists($data['MENU_ID'])) {
                    throw new \Exception('该菜单ID不存在', 101);
                }
                $model = D('MenuItem');
                //更新操作
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
