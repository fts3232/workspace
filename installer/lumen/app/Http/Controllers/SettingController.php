<?php

namespace App\Http\Controllers;

use App\Models\CashBook;
use App\Models\CashBookTags;
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
                $ret2 = CashBookTags::createTable();
                $return = ['status'=>$ret && $ret2,'msg'=>$ret && $ret2 ? '创建成功':'创建失败'];
                break;
            case 'javBus':
                $ret = JavBus::createTable();
                break;
            default:
                $return = ['status'=>false,'msg'=>'参数错误'];
        }
        return response()->json($return);
    }
}
