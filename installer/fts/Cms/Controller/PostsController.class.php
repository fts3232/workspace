<?php

namespace Cms\Controller;

use Think\Controller;

class PostsController extends Controller
{
    public function index()
    {
        $model = D('Posts');
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

    public function add()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '添加成功');
            $model = D('Posts');
            $category = I('post.category', false, 'int');
            $title = I('post.title');
            $keyword = I('post.keyword');
            $description = I('post.description');
            $content = I('post.content');
            $language = I('post.language');
            $publishedTime = I('post.publishedTime');
            $status = I('post.status');
            $tags = I('post.tags');
            $translateID = I('post.translateID');
            $data = array(
                'CATEGORY_ID' => $category,
                'TITLE' => $title,
                'KEYWORD' => $keyword,
                'DESCRIPTION' => $description,
                'CONTENT' => $content,
                'LANG' => $language,
                'TRANSLATE_ID' => $translateID,
                'POST_STATUS' => $status,
                'AUTHOR' => I('session.uid'),
                'PUBLISHED_TIME' => $publishedTime ? $publishedTime : array('exp', 'NOW()'),
                'TAGS_ID' => implode(',', $tags)
            );
            $result = $model->addPost($data);
            if (!$result) {
                throw new \Exception('添加失败', 100);
            }
            $this->ajaxReturn($return);
        } else {
            $model = D('Category');
            $category = $model->get();
            $translateID = I('get.translate');
            $this->assign('translateID', $translateID);
            $this->assign('category', $category);
            $this->assign('action', 'add');
            $this->display('edit');
        }
    }

    public function edit()
    {
        $postModel = D('Posts');
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '修改成功');
            $model = D('Posts');
            $category = I('post.category', false, 'int');
            $title = I('post.title');
            $keyword = I('post.keyword');
            $description = I('post.description');
            $content = I('post.content');
            $language = I('post.language');
            $publishedTime = I('post.publishedTime');
            $status = I('post.status');
            $id = I('post.id', false, 'int');
            $tags = I('post.tags');
            $data = array(
                'CATEGORY_ID' => $category,
                'TITLE' => $title,
                'KEYWORD' => $keyword,
                'DESCRIPTION' => $description,
                'CONTENT' => $content,
                'LANG' => $language,
                'POST_STATUS' => $status,
                'TAGS_ID' => implode(',', $tags)
            );
            if ($publishedTime) {
                $data['PUBLISHED_TIME'] = $publishedTime;
            }
            $result = $model->editPost($id, $data);
            if (!$result) {
                throw new \Exception('修改失败', 100);
            }
            $this->ajaxReturn($return);
        } else {
            $model = D('Category');
            $id = I('get.id', false, 'int');
            $category = $model->get();
            $result = $postModel->get($id);
            $tags = explode(',', $result['TAGS_ID']);
            $tagModel = D('Tags');
            $tags = $tagModel->where(array('TAG_ID' => array('in', $tags)))->select();

            if ($result['TRANSLATE_ID'] == 0) {
                $translate = $postModel->where(array('TRANSLATE_ID' => $id))->select();
            } else {
                $where = array(
                    array('POST_ID' => array('neq', $id)),
                    array(
                        'TRANSLATE_ID' => $result['TRANSLATE_ID'],
                        'POST_ID' => $result['TRANSLATE_ID'],
                        '_logic' => 'or'
                    ),
                );
                $translate = $postModel
                    ->where($where)
                    ->select();
            }
            $this->assign('translateID', $result['TRANSLATE_ID'] == 0 ? $id : $result['TRANSLATE_ID']);
            $this->assign('translate', $translate);

            $this->assign('tags', $tags);
            $this->assign('id', $id);
            $this->assign('result', $result);
            $this->assign('category', $category);
            $this->assign('action', 'edit');
            $this->display('edit');
        }
    }

    public function delete()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '删除成功');
            try {
                $model = D('Posts');
                $id = I('post.id', false, 'int');
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
}
