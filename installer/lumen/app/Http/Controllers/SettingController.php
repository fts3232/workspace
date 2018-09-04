<?php

namespace App\Http\Controllers;

use App\Models\CashBook;
use App\Models\JavBus;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    public function createDB(Request $request)
    {
        $type = $request->input('type', 'cashBook');
        switch ($type) {
            case 'cashBook':
                $ret = CashBook::createTable();
                break;
            case 'javBus':
                $ret = JavBus::createTable();
                break;
            default:
                $return = ['status'=>false,'msg'=>'参数错误'];
        }
        isset($ret) && $return = ['status'=>$ret,'msg'=>$ret ? '创建成功':'创建失败'];
        return response()->json($return);
    }
}
