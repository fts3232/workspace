<?php

namespace Cms\Controller;

use Think\Controller;

class BannerController extends Controller
{
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
        $list = $model->getAll($page->firstRow, $pageSize);
        $this->assign('list', $list);
        $this->assign('pagination', $pagination);
        $this->display();
    }

    public function addBanner()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '添加成功');
            try {
                $name = I('post.name');
                $model = D('Banner');
                $id = $model->addBanner($name);
                if (!$id) {
                    throw new \Exception('添加失败', 100);
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

    public function editBanner()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '修改成功');
            try {
                $name = I('post.name');
                $id = I('post.id', false, 'int');
                $model = D('Banner');
                $result = $model->updateBanner($id, $name);
                if (!$result) {
                    throw new \Exception('修改失败', 100);
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

    public function deleteBanner()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '删除成功');
            try {
                $id = I('post.id', false, 'int');
                $model = D('Banner');
                $result = $model->deleteBanner($id);
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
                    throw \Exception($upload->getError(), 100);
                }
                foreach ($info as $file) {
                    $return['img'] = '/Uploads/'.$file['savepath'] . $file['savename'];
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

    public function updateItem()
    {
        if (IS_AJAX) {
            $return = array('status' => true, 'msg' => '更新成功');
            try {
                $items = I('post.items');
                $bannerID = I('post.bannerID', false, 'int');
                $addItems = I('post.addItems');
                $model = D('BannerItem');
                $result = $model->updateItem($bannerID, $items, $addItems);
                if (!$result) {
                    throw new \Exception('更新失败', 100);
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
