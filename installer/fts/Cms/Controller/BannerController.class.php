<?php

namespace Cms\Controller;

/**
 * banner管理
 *
 * Class BannerController
 * @package Cms\Controller
 */
class BannerController extends CommonController
{
    use Validate;

    //验证规则
    protected $validateRule = array(
        'BANNER_NAME' => 'required|itemName',
        'BANNER_ID' => 'required|int'
    );

    //验证错误信息
    protected $validateMsg = array(
        'BANNER_NAME' => 'banner名称格式不正确',
        'BANNER_ID' => 'bannerID格式不正确'
    );

    /**
     * 查看banner
     */
    public function index()
    {
        //查询条件
        $whereData = array(
            'language' => $this->currentLanguage
        );
        $model = D('Banner');
        //每页显示多少条
        $pageSize = C('pageSize');
        //获取总条数
        $count = $model->getCount($whereData);
        //分页器
        $page = new \Think\Page($count, $pageSize);
        $pagination = $page->show();
        $this->assign('pagination', $pagination);
        //获取分页信息
        $list = $model->getList($whereData, $page->firstRow, $pageSize);
        $this->assign('list', $list);
        $this->display();
    }

    /**
     * 添加banner
     */
    public function addBanner()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '添加成功');
            try {
                //获取输入
                $data = array(
                    'BANNER_NAME' => I('post.name'),
                    'BANNER_LANG' => $this->currentLanguage
                );
                //验证输入格式
                $this->validate($data);
                //模型实例化
                $model = D('Banner');
                //添加操作
                $result = $model->addBanner($data);
                if (!$result['status']) {
                    throw new \Exception($result['msg'], $result['code']);
                }
                $return['id'] = $result['id'];
                $return['url'] = U('showItem', array('id' => $result['id']));
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
     * 修改banner
     */
    public function editBanner()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '修改成功');
            try {
                //获取输入
                $data = array(
                    'BANNER_NAME' => I('post.name'),
                    'BANNER_ID' => I('post.id', false, 'int')
                );
                //验证输入格式
                $this->validate($data);
                //模型实例化
                $model = D('Banner');
                //修改banner
                $result = $model->updateBanner($data);
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
     * 删除banner
     */
    public function deleteBanner()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '删除成功');
            try {
                //获取输入
                $data = array(
                    'BANNER_ID' => I('post.id', false, 'int')
                );
                //验证输入格式
                $this->validate($data);
                //模型实例化
                $model = D('Banner');
                //删除操作
                $result = $model->deleteBanner($data['BANNER_ID']);
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
     * 显示菜单项
     */
    public function showItem()
    {
        try {
            //获取输入
            $data = array(
                'BANNER_ID' => I('get.id', false, 'int')
            );
            //验证输入格式
            $this->validate($data);
            $this->assign('bannerID', $data['BANNER_ID']);
            $model = D('Banner');
            $bannerName = $model->getName($data['BANNER_ID']);
            if (empty($bannerName)) {
                throw new Exception('该bannerID不存在', 101);
            }
            $this->assign('bannerName', $bannerName);
            //模型实例化
            $model = D('BannerItem');
            //获取banner项
            $items = $model->getItem($data['BANNER_ID']);
            $this->assign('items', $items);
            //status
            $this->assign('statusMap', C('banner.statusMap'));
            $this->display();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 上传图片
     */
    public function uploadImage()
    {
        if (IS_AJAX) {
            try {
                $return = array('status' => true, 'msg' => '上传成功');
                //获取输入
                $data = array(
                    'BANNER_ID' => I('post.banner_id', false, 'int')
                );
                //验证输入格式
                $this->validate($data);
                //判断banner是否存在
                if (!D('Banner')->isExists($data['BANNER_ID'])) {
                    throw new \Exception('该bannerID不存在', 101);
                }
                //上传
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = 204800;// 设置附件上传大小
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg', 'pdf');// 设置附件上传类型
                $upload->rootPath = './Uploads'; // 设置附件上传根目录
                $upload->savePath = 'cms_banner/'; // 设置附件上传（子）目录
                // 上传文件
                $info = $upload->uploadOne($_FILES['file']);
                //print_r($info);
                if (!$info) {// 上传错误提示错误信息
                    throw new \Exception($upload->getError(), 102);
                }
                $return['img'] = '/Uploads/' . $info['savepath'] . $info['savename'];
                //添加菜单项
                $model = D('BannerItem');
                $result = $model->addItem($data['BANNER_ID'], $return['img']);
                if (!$result) {
                    throw new \Exception('添加失败', 103);
                }
                $return['id'] = $result;
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
     * 更新banner项
     */
    public function updateItem()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '更新成功');
            try {
                //获取输入
                $data = array(
                    'BANNER_ID' => I('post.banner_id', false, 'int'),
                    'ITEMS' => I('post.items')
                );
                //验证输入格式
                $this->validate($data);
                //判断id是否存在
                if (!D('Banner')->isExists($data['BANNER_ID'])) {
                    throw new \Exception('该bannerID不存在', 101);
                }
                $model = D('BannerItem');
                //更新操作
                $result = $model->updateItem($data);
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
}
