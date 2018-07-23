<?php

namespace Cms\Controller;

use Cms\Common\OAuth2;
use Think\Controller;

class ApiController extends Controller
{
    /**
     * 范围map
     *
     * @var array
     */
    protected $scopeMap = array(
        'getImage',
        'uploadImage'
    );

    /**
     * 客户端map
     *
     * @var array
     */
    protected $clientIDMap = array(
        'www.xxx.com'
    );

    public function __construct()
    {
        parent::__construct();
        $this->verify();
    }

    /**
     * 验证签名
     */
    private function verify()
    {
        try {
            $sign = I('sign');
            $scope = I('scope');
            $time = I('time');
            $clientID = I('client_id');
            $key = "{$clientID}-{$scope}-{$time}-" . "&J$#KF(S(K@@L";
            if (md5($key) != $sign) {
                throw new \Exception('该sign无效', 100);
            }
            if ($time < time() - 600) {//过期时间10分钟
                throw new \Exception('该sign已过期', 101);
            }
            if (!in_array($scope, $this->scopeMap)) {
                throw new \Exception('该scope不在有效范围内', 102);
            }
            if (!in_array($clientID, $this->clientIDMap)) {
                throw new \Exception('该clientID不在有效范围内', 103);
            }
        } catch (\Exception $e) {
            $return = array(
                'status'=>false,
                'code'=>$e->getCode(),
                'msg'=>$e->getMessage()
            );
            $this->ajaxReturn($return);
            exit();
        }
    }

    /**
     * 获取用户图片
     */
    public function getImage()
    {
        $uid = I('uid');
        $pic = I('type');
        header('Content-type:image/png');
        $im = imagecreatefromjpeg('./Uploads/cms_user/' . $uid . '/' . $pic . '.jpg');
        imagepng($im);
        imagedestroy($im);
    }

    /**
     * 上传用户图片
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
                $upload->savePath = 'cms_user/'; // 设置附件上传（子）目录
                $upload->saveName = I('type');
                $upload->saveExt = 'jpg';
                $upload->subName = I('uid');
                $upload->replace = true;
                // 上传文件
                $info = $upload->upload();
                //print_r($info);
                if (!$info) {// 上传错误提示错误信息
                    throw new \Exception($upload->getError(), 100);
                }
                foreach ($info as $file) {
                    $return['location'] = '/Uploads/' . $file['savepath'] . $file['savename'];
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
