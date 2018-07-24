<?php

namespace Cms\Controller;

use Cms\Common\Validator;
use Think\Controller;

class BannerController extends Controller
{
    /**
     * 查看banner
     */
    public function index()
    {
        $model = D('Banner');
        //每页显示多少条
        $pageSize = C('PAGE');
        //获取总条数
        $count = $model->count();
        //分页器
        $page = new \Think\Page($count, $pageSize);
        $pagination = $page->show();
        //获取分页信息
        $list = $model->getAll($page->firstRow, $pageSize);
        $this->assign('list', $list);
        $this->assign('pagination', $pagination);
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
                //输出获取并验证数据格式
                $name = I('post.name');
                $validator = Validator::make(
                    array('name' => $name),
                    array('name' => 'required|bannerName'),
                    array('name' => '名称格式不正确')
                );
                if ($validator->isFails()) {
                    throw new \Exception($validator->getFirstError(), 100);
                }
                $model = D('Banner');
                //添加操作
                $id = $model->addBanner($name);
                if (!$id) {
                    throw new \Exception('添加失败', 101);
                }
                $return['id'] = $id;
                $return['url'] = U('edit', array('id' => $id));
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
                //输出获取并验证数据格式
                $name = I('post.name');
                $id = I('post.id', false, 'int');
                $validator = Validator::make(
                    array(
                        'name' => $name,
                        'id' => $id
                    ),
                    array(
                        'name' => 'required|bannerName',
                        'id' => 'required|int'
                    ),
                    array(
                        'name' => '名称格式不正确',
                        'id' => 'id参数不正确'
                    )
                );
                if ($validator->isFails()) {
                    throw new \Exception($validator->getFirstError(), 100);
                }
                $model = D('Banner');
                //判断id是否存在
                if (!$model->isExists($id)) {
                    throw new \Exception('该banner id不存在', 101);
                }
                //修改banner
                $result = $model->updateBanner($id, $name);
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
     * 删除banner
     */
    public function deleteBanner()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '删除成功');
            try {
                //输出获取并验证数据格式
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
                $model = D('Banner');
                //判断id是否存在
                if (!$model->isExists($id)) {
                    throw new \Exception('该banner id不存在', 101);
                }
                //删除操作
                $result = $model->deleteBanner($id);
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
     * 显示菜单项
     */
    public function showItem()
    {
        $model = D('BannerItem');
        $id = I('get.id', false, 'int');
        $items = $model->getItem($id);
        $this->assign('items', $items);
        $this->assign('bannerID', $id);
        $this->display();
    }

    /**
     * 上传图片
     */
    public function uploadImage()
    {
        if (IS_AJAX) {
            try {
                $return = array('status' => true, 'msg' => '上传成功');
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = 102400;// 设置附件上传大小
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg', 'pdf');// 设置附件上传类型
                $upload->rootPath = './Uploads'; // 设置附件上传根目录
                $upload->savePath = 'cms_banner/'; // 设置附件上传（子）目录
                // 上传文件
                $info = $upload->upload();
                //print_r($info);
                if (!$info) {// 上传错误提示错误信息
                    throw new \Exception($upload->getError(), 100);
                }
                foreach ($info as $file) {
                    $return['img'] = '/Uploads/' . $file['savepath'] . $file['savename'];
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
     * 更新banner项
     */
    public function updateItem()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '更新成功');
            try {
                //输出获取并验证数据格式
                $items = I('post.items');
                $bannerID = I('post.banner_id', false, 'int');
                $addItems = I('post.add_items');
                $validator = Validator::make(
                    array(
                        'bannerID' => $bannerID
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
                $model = D('BannerItem');
                //判断id是否存在
                if (!D('Banner')->isExists($bannerID)) {
                    throw new \Exception('该banner id不存在', 101);
                }
                //更新操作
                $result = $model->updateItem($bannerID, $items, $addItems);
                if (!$result) {
                    throw new \Exception('更新失败', 102);
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
