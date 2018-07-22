<?php

namespace Cms\Controller;

use Think\Controller;

class TagsController extends Controller
{
    /**
     * 查看tag分页数据
     */
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
        //获取分页数据
        $list = $model->getAll($page->firstRow, $pageSize);
        $this->assign('list', $list);
        $this->assign('pagination', $pagination);
        $this->display();
    }

    /**
     * 编辑tag页面
     */
    public function edit()
    {
        $model = D('Tags');
        try {
            $id = I('get.id', false, 'int');
            //判断id是否存在
            if (!$result = $model->get($id)) {
                throw new \Exception('该tag id不存在', 100);
            }
            $result = $model->get($id);
            $this->assign('id', $id);
            $this->assign('result', $result);
            $this->assign('action', 'update');
            $this->display();
        } catch (\Exception  $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 修改tag
     */
    public function update()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '修改成功');
            try {
                $model = D('Tags');
                //判断id是否存在
                $id = I('post.id', false, 'int');
                if (!$model->get($id)) {
                    throw new \Exception('该tag id不存在', 100);
                }
                $data = array(
                    'name' => I('post.name'),
                    'description' => I('post.description'),
                    'seo-title' => I('post.seo-title'),
                    'seo-description' => I('post.seo-description'),
                    'seo-keyword' => I('post.seo-keyword'),
                    'id' => $id
                );
                //更新操作
                $result = $model->updateTag($data);
                if (!$result) {
                    throw new \Exception('修改失败', 101);
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
     * 删除tag
     */
    public function delete()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '删除成功');
            try {
                $model = D('Tags');
                $id = I('post.id', false, 'int');
                //判断id是否存在
                if (!$model->get($id)) {
                    throw new \Exception('该tag id不存在', 100);
                }
                //删除操作
                $result = $model->delete($id);
                if (!$result) {
                    throw new \Exception('删除失败', 101);
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
     * 添加tag
     */
    public function create()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '添加成功');
            try {
                $model = D('Tags');
                $data = array(
                    'name' => I('post.name'),
                    'description' => I('post.description'),
                    'seo-title' => I('post.seo-title'),
                    'seo-description' => I('post.seo-description'),
                    'seo-keyword' => I('post.seo-keyword')
                );
                //判断tag 名称是否存在
                if ($tag = $model->isExists($data['name'])) {
                    throw new \Exception('该tag id已存在', 100);
                }
                //添加tag操作
                $id = $model->addTag($data);
                if (!$id) {
                    throw new \Exception('添加失败', 101);
                }
                $return['id'] = $id;
            } catch (\Exception  $e) {
                $return = array(
                    'status' => false,
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                );
                isset($tag) && $return['id'] = $tag['TAG_ID'];
            }
            $this->ajaxReturn($return);
        }
    }

    /**
     * 添加tag页面
     */
    public function add()
    {
        $this->assign('action', 'create');
        $this->display('edit');
    }
}
