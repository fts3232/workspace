<?php

namespace Cms\Controller;

use Think\Controller;

class PostsController extends Controller
{
    public function index(){
        $model = D('Posts');
        $list = $model->getList();
        $this->assign('list', $list);
        $this->display();
    }

    public function add(){
        if(IS_AJAX){
            $return = array('status' => true, 'msg' => '添加成功');
            $model = D('Posts');
            $category = I('post.category',false,'int');
            $title = I('post.title');
            $keyword = I('post.keyword');
            $description = I('post.description');
            $content = I('post.content');
            $result = $model->addPost($title,$keyword,$description,$category,$content);
            if(!$result){
                throw new \Exception('添加失败',100);
            }
            $this->ajaxReturn($return);
        }else{
            $model =D('Category');
            $category = $model->get();
            $this->assign('category',$category);
            $this->display('edit');
        }
    }

    public function edit(){
        $postModel = D('Posts');
        if(IS_AJAX){
            $return = array('status' => true, 'msg' => '添加成功');
            $model = D('Posts');
            $category = I('post.category',false,'int');
            $title = I('post.title');
            $keyword = I('post.keyword');
            $description = I('post.description');
            $content = I('post.content');
            $result = $model->addPost($title,$keyword,$description,$category,$content);
            if(!$result){
                throw new \Exception('添加失败',100);
            }
            $this->ajaxReturn($return);
        }else{
            $model =D('Category');
            $id = I('get.id',false,'int');
            $category = $model->get();
            $result = $postModel->get($id);
            $this->assign('result',$result);
            $this->assign('category',$category);
            $this->display('edit');
        }
    }

    public function delete(){
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '删除成功');
            try {
                $model = D('Posts');
                $id = I('post.id',false,'int');
                $result = $model->delete($id);
                if(!$result){
                    throw new \Exception('删除失败',100);
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
