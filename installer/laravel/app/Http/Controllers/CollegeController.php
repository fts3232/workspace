<?php

namespace App\Http\Controllers;

/**
 * 学院
 *
 * Class CollegeController
 * @package App\Http\Controllers
 */
class CollegeController extends Controller
{
    /**
     * 新手入门
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function novice()
    {
        return view('college/novice');
    }

    /**
     * 实战技巧
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function skill()
    {
        return view('college/skill');
    }

    /**
     * 名师指路
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function teacher()
    {
        return view('college/teacher');
    }

    /**
     * 黄金法则
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rule()
    {
        return view('college/rule');
    }

    /**
     * 外汇投资
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function investment()
    {
        return view('college/investment');
    }

    /**
     * 投资百科
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function wiki()
    {
        return view('college/wiki');
    }
}
