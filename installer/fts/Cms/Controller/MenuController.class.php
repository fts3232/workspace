<?php

namespace Cms\Controller;

use Think\Controller;

class MenuController extends Controller
{

    public function index()
    {
        $model = D('Menu');
        $list = $model->get();
        $this->assign('list', $list);
        $this->display();
    }

    public function addMenu()
    {
        $name = I('post.name');
        $model = D('Menu');
        $id = $model->addMenu($name);
        $this->ajaxReturn(array('id' => $id, 'url' => U('edit', array('id' => $id))), 'JSON');
    }

    public function deleteMenu()
    {
        $id = I('post.MENU_ID');
        $model = D('Menu');
        $id = $model->deleteMenu($id);
    }

    public function edit()
    {
        $model = D('MenuItem');
        $id = I('get.id', false, 'int');
        $list = $model->getItem($id);
        $this->assign('list', $list);
        $this->assign('menuID', $id);
        $this->display();
    }

    public function update()
    {
        $list = I('post.list');
        $menuID = I('post.MENU_ID');
        $add = I('post.add');
        $model = D('MenuItem');
        $model->updateItem($menuID, $list, $add);
    }
}
