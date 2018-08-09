<?php

namespace Cms\Controller;

/**
 * 文章管理
 *
 * Class PostsController
 * @package Cms\Controller
 */
class PostsController extends CommonController
{
    use Validate;

    //验证规则
    protected $validateRule = array(
        'POST_ID' => 'required|int',
        'POST_TITLE' => 'required|postTitle',
        'POST_CATEGORY_ID' => 'required|int',
        'POST_TRANSLATE_ID' => 'int',
        'POST_STATUS' => 'int',
        'POST_LANG' => 'required|lang',
        //'POST_AUTHOR_ID' => 'required|int',
        'POST_ORDER' => 'int',
        'SEO_TITLE' => 'seoTitle',
        'SEO_KEYWORD' => 'seoKeyword',
        'SEO_DESCRIPTION' => 'seoDescription',
    );

    //验证错误信息
    protected $validateMsg = array(
        'POST_ID' => '文章id不正确',
        'POST_TITLE' => '文章标题不正确',
        'POST_CATEGORY_ID' => '文章栏目不正确',
        'POST_TRANSLATE_ID' => '文章对照id不正确',
        'POST_LANG' => '文章语言不正确',
        'POST_STATUS' => '文章状态不正确',
        'POST_ORDER' => '文章排序参数不正确',
        'POST_AUTHOR_ID' => '作者id不正确',
        'SEO_TITLE' => 'SEO标题格式不正确',
        'SEO_KEYWORD' => 'SEO关键词格式不正确',
        'SEO_DESCRIPTION' => 'SEO描述格式不正确',
    );

    /**
     * 文章列表页
     */
    public function index()
    {
        $this->showList();
        $this->display();
    }

    /**
     * 回收站列表页
     */
    public function recycle()
    {
        $this->showList();
        $this->display('index');
    }

    /**
     * 获取文章分页数据
     */
    private function showList()
    {
        //当前语言
        $currentLanguage = $this->currentLanguage;
        //状态map
        $statusMap = C('post.statusMap');
        if (ACTION_NAME == 'index') {
            unset($statusMap[3]);
            $deleteUrl = U('softDelete');
        } else {
            unset($statusMap[0], $statusMap[1], $statusMap[2]);
            $deleteUrl = U('delete');
        }
        $this->assign('deleteUrl', $deleteUrl);
        $this->assign('statusMap', $statusMap);
        //过滤出文章状态数组
        $statusIDList = array_keys($statusMap);
        //整合搜索条件
        $whereData = array(
            'title' => I('get.title'),
            'category' => I('get.category', false, 'int'),
            'getOrder' => I('get.getOrder', false, 'int'),
            'status' => I('get.status', array('in', $statusIDList), 'int'),
            'language' => $currentLanguage,
            'time' => I('get.time')
        );
        $model = D('Posts');
        //每页显示多少条
        $pageSize = C('pageSize');
        //获取总条数
        $count = $model->getCount($whereData);
        $this->assign('count', $count);
        //分页器
        $page = new \Think\Page($count, $pageSize);
        $pagination = $page->show();
        $this->assign('pagination', $pagination);
        //获取分页数据
        $list = $model->getList($whereData, $page->firstRow, $pageSize);
        $this->assign('list', $list);
        //过滤出文章id数组
        $postIDList = array_reduce($list, function ($carry, $item) {
            $carry[] = $item['POST_ID'];
            return $carry;
        });
        //获取文章tags
        $tagsList = array();
        if (!empty($postIDList)) {
            $tagsList = $model->getTagsList($postIDList);
        }
        $this->assign('tagsList', $tagsList);
        //获取各个文章状态数量
        $statusCount = $model->getStatusCount($currentLanguage, $statusIDList);
        $this->assign('statusCount', $statusCount);
        //获取置顶文章数量
        $orderCount = $model->getOrderPostsCount($currentLanguage);
        $this->assign('orderCount', $orderCount);
        //获取栏目
        $categoryMap = D('Category')->getAll($currentLanguage);
        $this->assign('categoryMap', $categoryMap);
        $this->assign('whereData', $whereData);
    }

    /**
     * 添加文章
     */
    public function add()
    {
        //要翻译的文章id
        $translateID = I('get.translate', 0, 'int');
        $this->assign('translateID', $translateID);
        //指定的language
        if ($translateID) {
            $language = I('get.language', $this->currentLanguage);
            if (!isset($this->languageMap[$language])) {
                $this->error('指定语言错误');
            }
        } else {
            $language = $this->currentLanguage;
        }
        $this->assign('language', $language);
        //获取栏目
        $categoryMap = D('Category')->getAll($language);
        $this->assign('categoryMap', $categoryMap);

        //action
        $this->assign('action', 'create');
        //状态map
        $this->assign('statusMap', C('post.statusMap'));
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
                $model = D('Posts');
                //整合输入
                $data = array(
                    'POST_TITLE' => I('post.title'),
                    'POST_CATEGORY_ID' => I('post.category_id', false, 'int'),
                    'POST_TRANSLATE_ID' => I('post.translate_id', false, 'int'),
                    'POST_CONTENT' => I('post.content'),
                    'POST_LANG' => I('post.language', $this->currentLanguage),
                    'POST_STATUS' => I('post.status', false, 'int'),
                    'POST_TAGS_ID' => I('post.tags'),
                    'POST_AUTHOR_ID' => I('session.uid'),
                    'POST_ORDER' => I('post.order', false, 'int'),
                    'SEO_TITLE' => I('post.seo_keyword'),
                    'SEO_KEYWORD' => I('post.seo_keyword'),
                    'SEO_DESCRIPTION' => I('post.seo_description'),
                    'PUBLISHED_TIME' => I('post.published_time')
                );
                //验证输入格式
                $this->validate($data);
                //添加操作
                $result = $model->addPost($data);
                if (!$result['status']) {
                    throw new \Exception($result['msg'], $result['code']);
                }
                $return['id'] = $result['id'];
                if ($data['POST_STATUS'] == 2) {
                    //添加定时任务
                    $slug = D('Category')->getParentSlug($data['POST_CATEGORY_ID']);
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
     * 编辑文章
     */
    public function edit()
    {
        try {
            $model = D('Posts');
            //获取输入
            $data = array(
                'POST_ID' => I('get.id', false, 'int')
            );
            //验证输入
            $this->validate($data);
            if (!$result = $model->get($data['POST_ID'])) {
                throw new \Exception('该文章id不存在', 100);
            }
            $this->assign('result', $result);
            $categoryModel = D('Category');
            //获取栏目
            $category = $categoryModel->getAll($this->currentLanguage);
            $this->assign('categoryMap', $category);
            //获取tags信息
            $tags = D('PostsTagsRelation')->getTags($data['POST_ID']);
            $this->assign('tags', $tags);
            //获取对照文章信息
            $translate = $model->getTranslate($result['POST_TRANSLATE_ID'], $data['POST_ID']);
            $this->assign('translateID', $result['POST_TRANSLATE_ID'] == 0 ? $data['POST_ID'] : $result['TRANSLATE_ID']);
            $this->assign('translate', $translate);
            //获取历史修改记录
            $revisionHistory = D('PostsRevisionHistory')->getHistory($data['POST_ID']);
            $this->assign('revisionHistory', $revisionHistory);
            //id
            $this->assign('id', $data['POST_ID']);
            //action
            $this->assign('action', 'update');
            //状态map
            $this->assign('statusMap', C('post.statusMap'));
            $this->display();
        } catch (\Exception $e) {
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
                //整合输入
                $data = array(
                    'POST_ID' => I('post.id', false, 'int'),
                    'POST_CATEGORY_ID' => I('post.category_id', false, 'int'),
                    'POST_TITLE' => I('post.title'),
                    'POST_CONTENT' => I('post.content'),
                    'POST_STATUS' => I('post.status', false, 'int'),
                    'POST_AUTHOR_ID' => I('session.uid'),
                    'POST_TAGS_ID' => I('post.tags'),
                    'POST_ORDER' => I('post.order', false, 'int'),
                    'SEO_TITLE' => I('post.seo_title'),
                    'SEO_KEYWORD' => I('post.seo_keyword'),
                    'SEO_DESCRIPTION' => I('post.seo_description'),
                    'PUBLISHED_TIME' => I('post.published_time')
                );
                //验证输入格式
                $this->validate($data);
                $model = D('Posts');
                //修改操作
                $result = $model->editPost($data);
                if (!$result['status']) {
                    throw new \Exception($result['msg'], $result['code']);
                }
                //添加定时任务
                if ($data['POST_STATUS'] == 2) {
                    //添加定时任务
                    $slug = D('Category')->getParentSlug($result['POST_CATEGORY_ID']);
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
     * 软删除
     */
    public function softDelete()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '删除成功');
            try {
                //验证输入
                $data = array(
                    'POST_ID' => I('post.id', false, 'int')
                );
                $this->validate($data);
                $model = D('Posts');
                //删除操作
                $result = $model->softDeletePost($data['POST_ID']);
                if (!$result['status']) {
                    throw new \Exception($result['msg'], $result['code']);
                }
                //添加定时任务
                $result = $model->get($data['POST_ID']);
                $slug = D('Category')->getParentSlug($result['POST_CATEGORY_ID']);
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
                //验证输入
                $data = array(
                    'POST_ID' => I('post.id', false, 'int')
                );
                $this->validate($data);
                $model = D('Posts');
                //删除操作
                $result = $model->deletePost($data['POST_ID']);
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
     * 添加要删除cache的页面到redis
     *
     * @param $slug
     * @throws \Exception
     */
    private function addRedisList($slug)
    {
        //添加定时任务
        $redis = new \Redis();
        if (!$redis->connect('127.0.0.1', 6379)) {
            throw new \Exception('操作成功，但写入redis失败', 103);
        }
        $redis->ZADD('www_page_cache_clear', time(), $slug . '/index.html');
    }

    /**
     * 上传图片
     */
    public function uploadImage()
    {
        if (IS_POST) {
            try {
                $return = array('status' => true, 'msg' => '上传成功');
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = 102400;// 设置附件上传大小
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg', 'pdf');// 设置附件上传类型
                $upload->rootPath = './Uploads'; // 设置附件上传根目录
                $upload->savePath = 'cms_upload_images/'; // 设置附件上传（子）目录
                // 上传文件
                $info = $upload->uploadOne($_FILES['file']);
                //print_r($info);
                if (!$info) {// 上传错误提示错误信息
                    throw new \Exception($upload->getError(), 100);
                }
                $return['location'] = '/Uploads/' . $info['savepath'] . $info['savename'];
                if (strpos($info['name'], 'no_wm') === false) {
                    $image = new \Think\Image();
                    // 在图片左上角添加水印（水印文件位于./logo.png） 并保存为water.jpg
                    $image->open('.' . $return['location'])
                        ->water('./Public/images/watermark.png', \Think\Image::IMAGE_WATER_SOUTHEAST)
                        ->save('.' . $return['location']);
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
     * 还原文章
     */
    public function restore()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '恢复成功');
            try {
                //验证输入
                $data = array(
                    'POST_ID' => I('post.id', false, 'int')
                );
                $this->validate($data);
                $model = D('Posts');
                //删除操作
                $result = $model->restorePost($data['POST_ID']);
                if (!$result['status']) {
                    throw new \Exception($result['msg'], $result['code']);
                }
                //添加定时任务
                $result = $model->get($data['POST_ID']);
                $slug = D('Category')->getParentSlug($result['POST_CATEGORY_ID']);
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
}
