<?php

namespace App\Http\Controllers;

/**
 * 开户交易
 *
 * Class TransactionController
 * @package App\Http\Controllers
 */
class TransactionController extends Controller
{

    /**
     * 真实账户
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function real()
    {
        return view('transaction/real');
    }

    /**
     * 模拟账户
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function simulation()
    {
        return view('transaction/simulation');
    }

    /**
     * 合约细则
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rule()
    {
        return view('transaction/rule');
    }

    /**
     * 合约利息
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function interest()
    {
        return view('transaction/interest');
    }

    /**
     * 交易指南
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function guide()
    {
        return view('transaction/guide');
    }
}
