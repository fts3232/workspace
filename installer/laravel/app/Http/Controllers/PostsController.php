<?php

namespace App\Http\Controllers;

/**
 * 文章
 *
 * Class TransactionController
 * @package App\Http\Controllers
 */
class PostsController extends Controller
{

    /**
     * 新闻
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function news()
    {
        return 'news';
    }

    /**
     * 学院
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function college()
    {
        return 'college';
    }
}
