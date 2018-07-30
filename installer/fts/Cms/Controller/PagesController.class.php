<?php

namespace Cms\Controller;

use Think\Controller;

class PagesController extends Controller
{
    use Validate;

    protected $validateRule = array(
        'PAGE_ID' => 'required|int',
        'PAGE_NAME' => 'required|itemName',
        'PAGE_SLUG' => 'required|itemSlug',
        'PAGE_PARENT' => 'required|int',
        'PAGE_LANG' => 'required|lang',
        'PAGE_DIRECTING' => 'required',
        'PAGE_TYPE' => 'required|pageType',
        'SEO_TITLE' => 'seoTitle',
        'SEO_KEYWORD' => 'seoKeyword',
        'SEO_DESCRIPTION' => 'seoDescription',
    );
    protected $validateMsg = array(
        'PAGE_ID' => '页面id不正确',
        'PAGE_NAME' => '页面名称格式不正确',
        'PAGE_SLUG' => '页面别名格式不正确',
        'PAGE_PARENT' => '页面父类不正确',
        'PAGE_LANG' => '页面语言不正确',
        'PAGE_DIRECTING' => '页面指向不正确',
        'PAGE_TYPE' => '页面类型不正确',
        'SEO_TITLE' => 'SEO标题格式不正确',
        'SEO_KEYWORD' => 'SEO关键词格式不正确',
        'SEO_DESCRIPTION' => 'SEO描述格式不正确',
    );

    /**
     * 查看栏目信息
     */
    public function index()
    {
        //整合搜索条件
        $whereData = array(
            'name' => I('get.name'),
            'language' => I('get.language')
        );
        //状态map
        $statusMap = C('post.status');
        $this->assign('statusMap', $statusMap);
        $model = D('Pages');
        //每页显示多少条
        $pageSize = C('pageSize');
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
        //获取语言map
        $this->assign('languageMap', C('languageMap'));
        $this->display();
    }

    /**
     * 删除page
     */
    public function delete()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '删除成功');
            try {
                //验证输入
                $data = array(
                    'PAGE_ID' => I('post.id', false, 'int')
                );
                //验证输入格式
                $this->validate($data);
                $model = D('Pages');
                //删除操作
                $result = $model->deletePage($data['PAGE_ID']);
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
     * 添加页面
     */
    public function add()
    {
        //获取栏目
        $model = D('Pages');
        //获取父页面
        $parentMap = $model->getParent();
        $this->assign('parentMap', $parentMap);
        //获取语言map
        $this->assign('languageMap', C('languageMap'));
        //获取页面类型Map
        $this->assign('typeMap', C('page.typeMap'));
        //action
        $this->assign('action', 'create');
        $this->display('edit');
    }

    /**
     * 添加流程
     */
    public function create()
    {
        if (IS_AJAX) {
            try {
                $return = array('status' => true, 'msg' => '添加成功');
                $model = D('Pages');
                //整合输入
                $data = array(
                    'PAGE_NAME' => I('post.name'),
                    'PAGE_SLUG' => I('post.slug'),
                    'PAGE_PARENT' => I('post.parent_id', false, 'int'),
                    'PAGE_TYPE' => I('post.type', false, 'int'),
                    'PAGE_DIRECTING' => I('post.directing'),
                    'PAGE_LANG' => I('post.language'),
                    'SEO_TITLE' => I('post.seo_keyword'),
                    'SEO_KEYWORD' => I('post.seo_keyword'),
                    'SEO_DESCRIPTION' => I('post.seo_description')
                );
                //验证输入格式
                $this->validate($data);
                //添加操作
                $result = $model->add($data);
                if (!$result) {
                    throw new \Exception('添加失败', 101);
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
     * 编辑页面
     */
    public function edit()
    {
        //获取栏目
        $model = D('Pages');
        try {
            $data = array(
                'PAGE_ID' => I('get.id', false, 'int')
            );
            //验证输入格式
            $this->validate($data);
            //判断id是否存在
            if (!$result = $model->get($data['PAGE_ID'])) {
                throw new \Exception('该页面id不存在', 101);
            }
            $this->assign('id', $data['PAGE_ID']);
            $this->assign('result', $result);
            $this->assign('action', 'update');
            //获取父页面
            $parentMap = $model->getParent($data['PAGE_ID']);
            $this->assign('parentMap', $parentMap);
            //获取语言map
            $this->assign('languageMap', C('languageMap'));
            //获取页面类型Map
            $this->assign('typeMap', C('page.typeMap'));
            $this->display();
        } catch (\Exception  $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 更新流程
     */
    public function update()
    {
        if (IS_AJAX) {
            try {
                $return = array('status' => true, 'msg' => '修改成功');
                $model = D('Pages');
                //整合输入
                $data = array(
                    'PAGE_ID' => I('post.id', false, 'int'),
                    'PAGE_NAME' => I('post.name'),
                    'PAGE_SLUG' => I('post.slug'),
                    'PAGE_PARENT' => I('post.parent_id', false, 'int'),
                    'PAGE_TYPE' => I('post.type', false, 'int'),
                    'PAGE_DIRECTING' => I('post.directing'),
                    'PAGE_LANG' => I('post.language'),
                    'SEO_TITLE' => I('post.seo_keyword'),
                    'SEO_KEYWORD' => I('post.seo_keyword'),
                    'SEO_DESCRIPTION' => I('post.seo_description')
                );
                //验证输入格式
                $this->validate($data);

                $result = $model->updatePage($data);
                if (!$result['status']) {
                    throw new \Exception($result['msg'], $result['code']);
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
}
