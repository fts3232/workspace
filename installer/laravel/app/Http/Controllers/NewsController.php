<?php

namespace App\Http\Controllers;

/**
 * 新闻咨询
 *
 * Class NewsController
 * @package App\Http\Controllers
 */
class NewsController extends Controller
{

    /**
     * 每日金评
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function comment()
    {
        return view('news/comment');
    }

    /**
     * 黄金头条
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function headline()
    {
        return view('news/headline');
    }

    /**
     * 汇市新闻
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function market()
    {
        return view('news/market');
    }

    /**
     * 行业资讯
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function information()
    {
        return view('news/information');
    }

    /**
     * 即时数据
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function data()
    {
        return view('news/data');
    }

    /**
     * 财经日历
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function calendar()
    {
        return view('news/calendar');
    }
}
