<?php

namespace Cms\Controller;

use Think\Controller;

class PostsController extends Controller
{
    /**
     * 查看post分页数据
     */
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
        //获取分页数据
        $list = $model->getAll($page->firstRow, $pageSize);
        $this->assign('list', $list);
        $this->assign('pagination', $pagination);
        $this->display();
    }

    /**
     * 添加post页面
     */
    public function add()
    {
        //获取栏目
        $model = D('Category');
        $categoryMap = $model->getAll();
        $this->assign('categoryMap', $categoryMap);
        //要翻译的文章id
        $translateID = I('get.translate');
        $this->assign('translateID', $translateID);
        //指定的language
        $this->assign('language', I('get.language'));
        //action
        $this->assign('action', 'create');
        //语言map
        $this->assign('languageMap', C('post.language'));
        //状态map
        $this->assign('statusMap', C('post.status'));
        $this->display('edit');
    }

    /**
     * 添加post
     */
    public function create()
    {
        if (IS_AJAX) {
            try {
                $return = array('status' => true, 'msg' => '添加成功');
                $model = D('Posts');
                //处理tags
                $tags = I('post.tags');
                $tags = implode(',', $tags);
                $data = array(
                    'POST_TITLE' => I('post.title'),
                    'POST_CATEGORY_ID' => I('post.category-id', false, 'int'),
                    'POST_TRANSLATE_ID' => I('post.translate-id'),
                    'POST_CONTENT' => I('post.content'),
                    'POST_LANG' => I('post.language'),
                    'POST_STATUS' => I('post.status'),
                    'POST_TAGS_ID' => $tags,
                    'POST_AUTHOR_ID' => I('session.uid'),
                    'SEO_TITLE' => I('post.seo-keyword'),
                    'SEO_KEYWORD' => I('post.seo-keyword'),
                    'SEO_DESCRIPTION' => I('post.seo-description'),
                    'PUBLISHED_TIME' => I('post.published-time')
                );
                //添加操作
                $result = $model->addPost($data);
                if (!$result) {
                    throw new \Exception('添加失败', 100);
                }
                if($data['POST_STATUS'] == 2){
                    //添加定时任务
                    $slug = $model->getCategorySlug($result);
                    $this->addRedisList($slug);
                }
            } catch (\Exception $e) {
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
     * 编辑post页面
     */
    public function edit()
    {
        try {
            $model = D('Posts');
            $categoryModel = D('Category');
            $tagModel = D('Tags');
            //判断id是否存在
            $id = I('get.id', false, 'int');
            if (!$result = $model->get($id)) {
                throw new \Exception('该post id不存在', 100);
            }
            //获取栏目
            $category = $categoryModel->getAll();
            //获取tags信息
            $tags = explode(',', $result['POST_TAGS_ID']);
            if (!empty($tags)) {
                $tags = $tagModel->where(array('TAG_ID' => array('in', $tags)))->select();
            }
            //获取对照文章信息
            $translate = $model->getTranslate($result['POST_TRANSLATE_ID'], $id);
            $this->assign('translateID', $result['TRANSLATE_ID'] == 0 ? $id : $result['TRANSLATE_ID']);
            $this->assign('translate', $translate);

            $this->assign('tags', $tags);
            $this->assign('id', $id);
            $this->assign('result', $result);
            $this->assign('categoryMap', $category);
            //action
            $this->assign('action', 'update');
            //语言map
            $this->assign('languageMap', C('post.language'));
            //状态map
            $this->assign('statusMap', C('post.status'));
            $this->display();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 更新post
     */
    public function update()
    {
        if (IS_AJAX) {
            try {
                $return = array('status' => true, 'msg' => '修改成功');
                $model = D('Posts');
                //判断id是否存在
                $id = I('post.id', false, 'int');
                if (!$slug = $model->getCategorySlug($id)) {
                    throw new \Exception('该post id不存在', 100);
                }
                //tags处理
                $tags = I('post.tags');
                $tags = implode(',', $tags);
                $data = array(
                    'POST_CATEGORY_ID' => I('post.category-id', false, 'int'),
                    'POST_TITLE' => I('post.title'),
                    'POST_CONTENT' => I('post.content'),
                    'POST_LANG' => I('post.language'),
                    'POST_STATUS' => I('post.status'),
                    'POST_TAGS_ID' => $tags,
                    'SEO_TITLE' => I('post.seo-title'),
                    'SEO_KEYWORD' => I('post.seo-keyword'),
                    'SEO_DESCRIPTION' => I('post.seo-description'),
                    'PUBLISHED_TIME' => I('post.published-time')
                );
                //修改操作
                $result = $model->editPost($id, $data);
                if (!$result) {
                    throw new \Exception('修改失败', 101);
                }
                //添加定时任务
                $this->addRedisList($slug);
            } catch (\Exception $e) {
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
     * 删除post
     */
    public function delete()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '删除成功');
            try {
                $model = D('Posts');
                $id = I('post.id', false, 'int');
                //判断id是否存在
                if (!$slug = $model->getCategorySlug($id)) {
                    throw new \Exception('该post id不存在', 100);
                }
                //删除操作
                $result = $model->delete($id);
                if (!$result) {
                    throw new \Exception('删除失败', 101);
                }
                //添加定时任务
                $this->addRedisList($slug);
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
     * 添加要删除cache的页面到redis
     *
     * @param $slug
     */
    private function addRedisList($slug){
        //添加定时任务
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->ZADD('www_page_cache_clear', time(), $slug . '/index.html');
    }
}
