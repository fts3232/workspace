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

        $this->languageMap = C('languageMap');
        $this->currentLanguage = $this->getCurrentLanguage();
        $this->assign('currentLanguage', $this->currentLanguage);
        $this->assign('languageMap', $this->languageMap);
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
