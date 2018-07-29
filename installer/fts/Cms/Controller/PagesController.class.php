<?php

namespace Cms\Controller;

use Cms\Common\Validator;
use Think\Controller;

class PagesController extends Controller
{
    /**
     * 查看栏目信息
     */
    public function index()
    {
        //整合搜索条件
        $whereData = array(
            'title' => I('get.title'),
            'category' => I('get.category'),
            'status' => I('get.status'),
            'language' => I('get.language'),
            'time' => I('get.time')
        );
        //状态map
        $statusMap = C('post.status');
        if (ACTION_NAME == 'index') {
            unset($statusMap[3]);
            $deleteUrl = U('softDelete');
        } else {
            unset($statusMap[0], $statusMap[1], $statusMap[2]);
            $whereData['status'] = 3;
            $deleteUrl = U('delete');
        }
        $this->assign('deleteUrl',$deleteUrl);
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
                $model = D('Pages');
                //判断id是否存在
                if (!$model->isExists($id)) {
                    throw new \Exception('该page id不存在', 101);
                }
                //判断id是否存在
                if ($model->hasChild($id)) {
                    throw new \Exception('该page 存在子页面，请先把子页面删除', 101);
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

    public function add(){
        //获取栏目
        $model = D('Pages');
        $parentMap = $model->getParent();
        $this->assign('parentMap', $parentMap);
        //action
        $this->assign('action', 'create');
        $this->display('edit');
    }

    public function create(){}

    public function edit(){}

    public function update(){}
}
