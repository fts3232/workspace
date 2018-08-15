<?php

namespace Cms\Controller;

/**
 * 栏目管理
 *
 * Class CategoryController
 * @package Cms\Controller
 */
class CategoryController extends CommonController
{
    use Validate;

    //验证规则
    protected $validateRule = array(
        'CATEGORY_ID' => 'required|int',
        'CATEGORY_NAME' => 'required|itemName',
        'CATEGORY_SLUG' => 'required|itemSlug',
        'CATEGORY_PARENT' => 'required|int',
        'CATEGORY_LANG' => 'required|lang',
        'SEO_TITLE' => 'seoTitle',
        'SEO_KEYWORD' => 'seoKeyword',
        'SEO_DESCRIPTION' => 'seoDescription',
    );

    //验证错误信息
    protected $validateMsg = array(
        'CATEGORY_ID' => '栏目id不正确',
        'CATEGORY_NAME' => '栏目名称格式不正确',
        'CATEGORY_SLUG' => '栏目别名格式不正确',
        'CATEGORY_PARENT' => '栏目父类不正确',
        'CATEGORY_LANG' => '栏目语言不正确',
        'SEO_TITLE' => 'SEO标题格式不正确',
        'SEO_KEYWORD' => 'SEO关键词格式不正确',
        'SEO_DESCRIPTION' => 'SEO描述格式不正确',
    );

    /**
     * 栏目列表页
     */
    public function index()
    {
        //整合搜索条件
        $whereData = array(
            'name' => I('get.name', false),
            'language' => $this->currentLanguage
        );
        $this->assign('whereData', $whereData);
        //实例化模型
        $model = D('Category');
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
     * 删除栏目
     */
    public function delete()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '删除成功');
            try {
                //验证输入
                $data = array(
                    'CATEGORY_ID' => I('post.id', false, 'int')
                );
                //验证输入格式
                $this->validate($data);
                $model = D('Category');
                //删除操作
                $result = $model->deleteCATEGORY($data['CATEGORY_ID']);
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
     * 添加栏目
     */
    public function add()
    {
        //获取栏目
        $model = D('Category');
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
                $model = D('Category');
                //整合输入
                $data = array(
                    'CATEGORY_NAME' => I('post.name'),
                    'CATEGORY_SLUG' => I('post.slug'),
                    'CATEGORY_PARENT' => I('post.parent_id', false, 'int'),
                    'CATEGORY_DESCRIPTION' => I('post.description'),
                    'CATEGORY_LANG' => $this->currentLanguage,
                    'SEO_TITLE' => I('post.seo_keyword'),
                    'SEO_KEYWORD' => I('post.seo_keyword'),
                    'SEO_DESCRIPTION' => I('post.seo_description')
                );
                //验证输入格式
                $this->validate($data);
                //添加操作
                $result = $model->addCategory($data);
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
     * 编辑栏目
     */
    public function edit()
    {
        //获取栏目
        $model = D('Category');
        try {
            $data = array(
                'CATEGORY_ID' => I('get.id', false, 'int')
            );
            //验证输入格式
            $this->validate($data);
            //判断id是否存在
            if (!$result = $model->get($data['CATEGORY_ID'])) {
                throw new \Exception('该栏目id不存在', 101);
            }
            $this->assign('result', $result);
            //id
            $this->assign('id', $data['CATEGORY_ID']);
            //action
            $this->assign('action', 'update');
            //获取父栏目
            $parentMap = $model->getParent($result['CATEGORY_LANG'], $data['CATEGORY_ID']);
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
                $model = D('Category');
                //整合输入
                $data = array(
                    'CATEGORY_ID' => I('post.id', false, 'int'),
                    'CATEGORY_NAME' => I('post.name'),
                    'CATEGORY_SLUG' => I('post.slug'),
                    'CATEGORY_PARENT' => I('post.parent_id', false, 'int'),
                    'CATEGORY_DESCRIPTION' => I('post.description'),
                    'SEO_TITLE' => I('post.seo_title'),
                    'SEO_KEYWORD' => I('post.seo_keyword'),
                    'SEO_DESCRIPTION' => I('post.seo_description')
                );
                //验证输入格式
                $this->validate($data);
                //更新操作
                $result = $model->updateCategory($data);
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
