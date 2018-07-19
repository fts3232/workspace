<?php
namespace Cms\Controller;
use Think\Controller;

class MenuController extends Controller {
    //查
    function index(){
        $count=M('Calendar','','DB_CONFIG1')->count();
        $Page = new \Think\Page($count,10);
        $show = $Page->show();
        $this->list = M('Calendar','','DB_CONFIG1')->order('created_at desc,id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('page',$show);
        $this->display();
    }
    //搜索
    function search(){
        $count=M('Calendar','','DB_CONFIG1')->count();
        $Page = new \Think\Page($count,10);
        $show = $Page->show();
        $where=array(
            'title'=>array('like','%'.I('field').'%')
        );
        $this->list = M('Calendar','','DB_CONFIG1')->where($where)->order('created_at desc,id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('page',$show);
        $this->display('index');
    }
    //增
    function add(){
        if(IS_POST){
            $date=date('Y-m-d H:i:s',time());
            $_POST['post']['created_at']=$date;
            $result=M('Calendar','','DB_CONFIG1')->add(I('post.post'));
            if($result){
                $this->success('添加成功',U('index'));
            }
            else{
                $this->error('添加失败'.M('Calendar','','DB_CONFIG1')->getLastSql());
            }
            
        }
        else{
            $this->display();
        }
    }
    //改
    function edit(){
        if(IS_POST){
            M('Calendar','','DB_CONFIG1')->save(I('post.post'));
            $this->success('修改成功',U('index'));
        }
        else{
            $result= M('Calendar','','DB_CONFIG1')->where(array('id'=>I('id')))->find();
            $this->assign('result',$result);
            $this->display();
        }
    }
    //删
    function delete(){
        header('Content-type:application/json');
        $result=M('Calendar','','DB_CONFIG1')->delete(I('id'));
        if($result){
            echo json_encode(array('status'=>0));
        }
        else{
            echo json_encode(array('status'=>1,'msg'=>'删除失败'));
        }
        
    }
}
?>