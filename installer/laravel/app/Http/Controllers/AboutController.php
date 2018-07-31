<?php

namespace App\Http\Controllers;

/**
 * 关于我们
 *
 * Class AboutController
 * @package App\Http\Controllers
 */
class AboutController extends Controller
{
    /**
     * 集团概况
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function introduction()
    {
        return view('about/introduction');
    }

    /**
     * 优势
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function advantage()
    {
        return view('about/advantage');
    }

    /**
     * 集团认证
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function authentication()
    {
        return view('about/authentication');
    }

    /**
     * 投资者保障
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function guarantee()
    {
        return view('about/guarantee');
    }

    /**
     * 公告
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function notice()
    {
        return view('about/notice');
    }

    /**
     * 联系我们
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact()
    {
        return view('about/contact');
    }
}
