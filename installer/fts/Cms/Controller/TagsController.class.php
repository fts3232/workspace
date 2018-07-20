<?php

namespace Cms\Controller;

use Think\Controller;

class TagsController extends Controller
{
    public function index()
    {
        $model = D('Tags');
        //每页显示多少条
        $pageSize = C('PAGE');
        //获取总条数
        $count = $model->count();
        //分页器
        $page = new \Think\Page($count, $pageSize);
        $pagination = $page->show();
        $list = $model->getList($page->firstRow, $pageSize);
        $this->assign('list', $list);
        $this->assign('pagination', $pagination);
        $this->display();
    }

    public function edit()
    {
        $model = D('Tags');
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '修改成功');
            try {
                $name = I('post.name');
                $model = D('Tags');
                $title = I('post.title');
                $description = I('post.description');
                $keyword = I('post.keyword');
                $id = I('post.id', false, 'int');
                $data = array(
                    'title' => $title,
                    'name' => $name,
                    'description' => $description,
                    'keyword' => $keyword,
                    'id'=>$id
                );
                $result = $model->updateTag($data);
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
        } else {
            $id = I('get.id',false,'int');
            $result = $model->get($id);
            $this->assign('id',$id);
            $this->assign('result',$result);
            $this->assign('action','edit');
            $this->display();
        }
    }

    public function delete()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '删除成功');
            try {
                $id = I('post.id', false, 'int');
                $model = D('Tags');
                $result = $model->delete($id);
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

    public function add()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '添加成功');
            try {
                $name = I('post.name');
                $model = D('Tags');
                $title = I('post.title');
                $description = I('post.description');
                $keyword = I('post.keyword');
                $data = array(
                    'title' => $title,
                    'name' => $name,
                    'description' => $description,
                    'keyword' => $keyword
                );
                $id = $model->addTag($data);
                if (!$id) {
                    throw new \Exception('添加失败', 100);
                }
                $return['id'] = $id;
            } catch (\Exception  $e) {
                $return = array(
                    'status' => false,
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode()
                );
            }
            $this->ajaxReturn($return);
        } else {
            $this->assign('action','add');
            $this->display('edit');
        }
    }
}

?>