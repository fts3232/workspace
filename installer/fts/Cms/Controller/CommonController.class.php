<?php

namespace Cms\Controller;

use Think\Controller;

/**
 * 共用控制器
 *
 * Class CommonController
 * @package Cms\Controller
 */
class CommonController extends Controller
{

    protected $languageMap;

    protected $currentLanguage;

    /**
     * 全局赋值
     */
    public function __construct()
    {
        parent::__construct();
        //检查权限
        if (!$this->checkPermissions()) {
            if (IS_POST) {
                $this->ajaxReturn(['status' => false, 'msg' => '您没有权限访问当前页面！']);
            } else {
                $this->error('您没有权限访问当前页面！');
            }
        }
        //设置当前语言
        $this->languageMap = C('languageMap');
        $this->currentLanguage = $this->getCurrentLanguage();
        $this->assign('currentLanguage', $this->currentLanguage);
        $this->assign('languageMap', $this->languageMap);
        //只显示有权限的菜单项
        $menuMap = C('menuMap');
        foreach ($menuMap as $k => $v) {
            if (!empty($v['child'])) {
                foreach ($v['child'] as $childKey => $childVal) {
                    if (!authcheck($childVal['controller'])) {
                        unset($menuMap[$k]['child'][$childKey]);
                    }
                }
                if (empty($menuMap[$k]['child'])) {
                    unset($menuMap[$k]);
                }
            } else {
                if (!authcheck($v['controller'])) {
                    unset($menuMap[$k]);
                }
            }
        }
        $this->assign('leftMenu', $menuMap);
    }

    /**
     * 检查当前权限
     *
     * @return bool
     */
    protected function checkPermissions()
    {
        $action = ACTION_NAME;
        $action = $action == 'create' ? 'add' : $action;
        $action = $action == 'update' ? 'edit' : $action;
        $paths = [MODULE_NAME, CONTROLLER_NAME, $action];
        $path = implode('/', $paths);
        return authcheck($path);
    }

    /**
     * 获取当前语言
     *
     * @return mixed|\Symfony\Component\HttpFoundation\Cookie
     */
    protected function getCurrentLanguage()
    {
        $defaultLanguage = C('defaultLanguage');
        $currentLanguage = cookie('language');
        $currentLanguage = $currentLanguage ? $currentLanguage :  $defaultLanguage;
        if (!isset($this->languageMap[$currentLanguage])) {
            $currentLanguage =  $defaultLanguage;
        }
        return $currentLanguage;
    }
}
