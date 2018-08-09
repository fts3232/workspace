<?php

namespace Cms\Controller;

class TagsController extends CommonController
{
    use Validate;

    //验证规则
    protected $validateRule = array(
        'TAG_ID' => 'required|int',
        'TAG_NAME'=>'required|itemName',
        'TAG_SLUG'=>'required|itemSlug',
        'SEO_TITLE' => 'seoTitle',
        'SEO_KEYWORD' => 'seoKeyword',
        'SEO_DESCRIPTION' => 'seoDescription',
    );

    //验证错误信息
    protected $validateMsg = array(
        'TAG_ID' => '标签id不正确',
        'TAG_NAME' => '标签名称不正确',
        'TAG_SLUG' => '标签别名不正确',
        'SEO_TITLE' => 'SEO标题格式不正确',
        'SEO_KEYWORD' => 'SEO关键词格式不正确',
        'SEO_DESCRIPTION' => 'SEO描述格式不正确',
    );

    /**
     * 查看tag分页数据
     */
    public function index()
    {
        //整合搜索条件
        $whereData = array(
            'name' => I('get.name'),
            'language' => $this->currentLanguage
        );
        $model = D('Tags');
        //每页显示多少条
        $pageSize = C('pageSize');
        //获取总条数
        $count = $model->getCount($whereData);
        //分页器
        $page = new \Think\Page($count, $pageSize);
        $pagination = $page->show();
        //获取分页数据
        $list = $model->getList($whereData, $page->firstRow, $pageSize);
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
            $data = array(
                'TAG_ID' => I('get.id', false, 'int')
            );
            //判断id是否存在
            if (!$result = $model->get($data['TAG_ID'])) {
                throw new \Exception('该标签id不存在', 100);
            }
            $this->assign('id', $data['TAG_ID']);
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
                $data = array(
                    'TAG_ID' =>  I('post.id', false, 'int'),
                    'TAG_NAME'=> I('post.name'),
                    'TAG_SLUG'=> I('post.slug'),
                    'TAG_DESCRIPTION' => I('post.description'),
                    'SEO_TITLE' => I('post.seo_title'),
                    'SEO_DESCRIPTION' => I('post.seo_description'),
                    'SEO_KEYWORD' => I('post.seo_keyword'),
                );
                $this->validate($data);
                $model = D('Tags');
                //更新操作
                $result = $model->updateTag($data);
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
     * 删除tag
     */
    public function delete()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '删除成功');
            try {
                //验证输入格式
                $data =array(
                    'TAG_ID' => I('post.id', false, 'int')
                );
                $this->validate($data);
                $model = D('Tags');
                //删除操作
                $result = $model->deleteTag($data['TAG_ID']);
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
     * 来自文章模块的创建操作
     */
    public function createFromPost()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '添加成功');
            try {
                //验证输入格式
                $name = I('post.name');
                $language = I('post.language');
                $data = array(
                    'TAG_NAME' => $name,
                    'TAG_SLUG' => $name,
                    'TAG_LANG' => $language
                );
                $this->validate($data);
                $model = D('Tags');
                //判断tag 名称是否存在
                $tagID = $model->isSlugExists($data['TAG_LANG'], $data['TAG_SLUG']);
                if (!$tagID) {
                    //添加tag操作
                    $tagID = $model->add($data);
                    if (!$tagID) {
                        throw new \Exception('添加失败', 101);
                    }
                }
                $return['id'] = $tagID;
            } catch (\Exception $e) {
                $return = array(
                    'status' => false,
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
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
                //验证输入格式
                $data = array(
                    'TAG_NAME' => I('post.name'),
                    'TAG_SLUG' => I('post.slug'),
                    'TAG_DESCRIPTION' => I('post.description'),
                    'TAG_LANG' => $this->currentLanguage,
                    'SEO_TITLE' => I('post.seo_title'),
                    'SEO_DESCRIPTION' => I('post.seo_description'),
                    'SEO_KEYWORD' => I('post.seo_keyword')
                );
                $this->validate($data);
                $model = D('Tags');
                //添加tag操作
                $result = $model->addTag($data);
                if (!$result['status']) {
                    throw new \Exception($result['msg'], $result['code']);
                }
                $return['id'] = $result['id'];
            } catch (\Exception  $e) {
                $return = array(
                    'status' => false,
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                );
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
