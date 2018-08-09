<?php

namespace Cms\Controller;

/**
 * 页面管理
 *
 * Class PagesController
 * @package Cms\Controller
 */
class PagesController extends CommonController
{
    use Validate;

    //验证规则
    protected $validateRule = array(
        'PAGE_ID' => 'required|int',
        'PAGE_NAME' => 'required|itemName',
        'PAGE_SLUG' => 'required|itemSlug',
        'PAGE_PARENT' => 'required|int',
        'SEO_TITLE' => 'seoTitle',
        'SEO_KEYWORD' => 'seoKeyword',
        'SEO_DESCRIPTION' => 'seoDescription',
    );

    //验证错误信息
    protected $validateMsg = array(
        'PAGE_ID' => '页面id不正确',
        'PAGE_NAME' => '页面名称格式不正确',
        'PAGE_SLUG' => '页面别名格式不正确',
        'PAGE_PARENT' => '页面父类不正确',
        'SEO_TITLE' => 'SEO标题格式不正确',
        'SEO_KEYWORD' => 'SEO关键词格式不正确',
        'SEO_DESCRIPTION' => 'SEO描述格式不正确',
    );

    /**
     * 页面列表页
     */
    public function index()
    {
        //整合搜索条件
        $whereData = array(
            'name' => I('get.name', false),
            'language' => $this->currentLanguage,
            'time' => I('get.time', false)
        );
        $this->assign('whereData', $whereData);
        $model = D('Pages');
        //每页显示多少条
        $pageSize = C('pageSize');
        //获取总条数
        $count = $model->getCount($whereData);
        //分页器
        $page = new \Think\Page($count, $pageSize);
        $pagination = $page->show();
        $this->assign('pagination', $pagination);
        //获取分页数据
        $list = $model->getList($whereData, $page->firstRow, $pageSize);
        $this->assign('list', $list);
        $this->display();
    }

    /**
     * 删除页面
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
        $parentMap = $model->getParent($this->currentLanguage);
        $this->assign('parentMap', $parentMap);
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
                    'PAGE_DIRECTING' => I('post.directing'),
                    'PAGE_LANG' => $this->currentLanguage,
                    'SEO_TITLE' => I('post.seo_keyword'),
                    'SEO_KEYWORD' => I('post.seo_keyword'),
                    'SEO_DESCRIPTION' => I('post.seo_description')
                );
                //验证输入格式
                $this->validate($data);
                //添加操作
                $result = $model->addPage($data);
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
            $this->assign('result', $result);
            //id
            $this->assign('id', $data['PAGE_ID']);
            //action
            $this->assign('action', 'update');
            //获取父页面
            $parentMap = $model->getParent($result['PAGE_LANG'], $data['PAGE_ID']);
            $this->assign('parentMap', $parentMap);
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
                    'PAGE_DIRECTING' => I('post.directing'),
                    'SEO_TITLE' => I('post.seo_keyword'),
                    'SEO_KEYWORD' => I('post.seo_keyword'),
                    'SEO_DESCRIPTION' => I('post.seo_description')
                );
                //验证输入格式
                $this->validate($data);
                //更新操作
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
