<?php

namespace Cms\Controller;

use Cms\Common\Validator;
use Think\Controller;

class TagsController extends Controller
{
    /**
     * 查看tag分页数据
     */
    public function index()
    {
        //整合搜索条件
        $whereData = array(
            'name' => I('get.name')
        );
        $model = D('Tags');
        //每页显示多少条
        $pageSize = C('PAGE');
        //获取总条数
        $count = $model->getCount($whereData);
        //分页器
        $page = new \Think\Page($count, $pageSize);
        $pagination = $page->show();
        //获取分页数据
        $list = $model->getAll($whereData, $page->firstRow, $pageSize);
        $this->assign('list', $list);
        $this->assign('pagination', $pagination);
        $this->assign('whereData', $whereData);
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
                //整合输入
                $id = I('post.id', false, 'int');
                $data = array(
                    'name' => I('post.name'),
                    'slug' => I('post.slug'),
                    'description' => I('post.description'),
                    'seo_title' => I('post.seo_title'),
                    'seo_description' => I('post.seo_description'),
                    'seo_keyword' => I('post.seo_keyword'),
                    'id' => $id
                );
                //验证输入
                $validator = Validator::make(
                    $data,
                    array(
                        'id' => 'required|int',
                        'name' => 'required|bannerName',
                        'slug' => 'required|bannerName',
                        'seo_title' => 'seoTitle',
                        'seo_keyword' => 'seoKeyword',
                        'seo_description' => 'seoDescription',
                    ),
                    array(
                        'id' => 'id参数不正确',
                        'name' => '名称格式不正确',
                        'slug' => '别名格式不正确',
                        'seo_title' => 'SEO标题格式不正确',
                        'seo_keyword' => 'SEO关键词格式不正确',
                        'seo_description' => 'SEO描述格式不正确',
                    )
                );
                if ($validator->isFails()) {
                    throw new \Exception($validator->getFirstError(), 100);
                }
                $model = D('Tags');
                //判断id是否存在
                if (!$model->get($id)) {
                    throw new \Exception('该tag id不存在', 101);
                }
                //更新操作
                $result = $model->updateTag($data);
                if (!$result) {
                    throw new \Exception('修改失败', 102);
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
                //验证输入格式
                $id = I('post.id', false, 'int');
                $validator = Validator::make(
                    array(
                        'id' => $id
                    ),
                    array(
                        'id' => 'required|int'
                    ),
                    array(
                        'id' => 'id参数不正确'
                    )
                );
                if ($validator->isFails()) {
                    throw new \Exception($validator->getFirstError(), 100);
                }
                $model = D('Tags');
                //判断id是否存在
                if (!$model->get($id)) {
                    throw new \Exception('该tag id不存在', 101);
                }
                //删除操作
                $result = $model->delete($id);
                if (!$result) {
                    throw new \Exception('删除失败', 102);
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
     * 来自文章模块的创建操作
     */
    public function createFromPost()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '添加成功');
            try {
                //验证输入格式
                $name = I('post.name');
                $data = array(
                    'name' => $name,
                    'slug' => $name
                );
                $validator = Validator::make(
                    $data,
                    array(
                        'name' => 'required|bannerName',
                        'slug' => 'required|bannerName'
                    ),
                    array(
                        'name' => '名称格式不正确',
                        'slug' => '别名格式不正确'
                    )
                );
                if ($validator->isFails()) {
                    throw new \Exception($validator->getFirstError(), 100);
                }
                $model = D('Tags');
                //判断tag 名称是否存在
                if ($tag = $model->isExists($data['name'])) {
                    $return['id'] = $tag['TAG_ID'];
                } else {
                    //添加tag操作
                    $id = $model->addTag($data);
                    if (!$id) {
                        throw new \Exception('添加失败', 102);
                    }
                    $return['id'] = $id;
                }
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
     * 添加tag
     */
    public function create()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '添加成功');
            try {
                //验证输入格式
                $data = array(
                    'name' => I('post.name'),
                    'slug' => I('post.slug'),
                    'description' => I('post.description'),
                    'seo_title' => I('post.seo_title'),
                    'seo_description' => I('post.seo_description'),
                    'seo_keyword' => I('post.seo_keyword')
                );
                $validator = Validator::make(
                    $data,
                    array(
                        'name' => 'required|bannerName',
                        'slug' => 'required|bannerName',
                        'seo_title' => 'seoTitle',
                        'seo_keyword' => 'seoKeyword',
                        'seo_description' => 'seoDescription',
                    ),
                    array(
                        'name' => '名称格式不正确',
                        'slug' => '别名格式不正确',
                        'seo_title' => 'SEO标题格式不正确',
                        'seo_keyword' => 'SEO关键词格式不正确',
                        'seo_description' => 'SEO描述格式不正确',
                    )
                );
                if ($validator->isFails()) {
                    throw new \Exception($validator->getFirstError(), 100);
                }
                $model = D('Tags');
                //判断tag 名称是否存在
                if ($tag = $model->isExists($data['name'])) {
                    throw new \Exception('该tag id已存在', 101);
                }
                //添加tag操作
                $id = $model->addTag($data);
                if (!$id) {
                    throw new \Exception('添加失败', 102);
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
