<?php

namespace Cms\Controller;

use Think\Controller;

class PostsController extends Controller
{
    public function index(){
        $model = D('Posts');
        $list = $model->get();
        $this->assign('list', $list);
        $this->display();
    }
}
