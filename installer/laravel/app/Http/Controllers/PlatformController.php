<?php

namespace App\Http\Controllers;

/**
 * 平台下载
 *
 * Class PlatformController
 * @package App\Http\Controllers
 */
class PlatformController extends Controller
{

    /**
     * 电脑交易平台
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pc()
    {
        return view('platform/pc');
    }

    /**
     * 手机交易平台
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mobile()
    {
        return view('platform/mobile');
    }
}
