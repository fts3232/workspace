<?php

namespace App\Http\Controllers;

use App\Models\CashNote;
use Illuminate\Http\Request;

class CashNoteController extends Controller
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
    public function get(Request $request)
    {
        $page = $request->input('page', 1);
        $size = $request->input('size', 10);
        $offset = ($page - 1) * $size;
        $list = CashNote::get($offset, $size);
        $count = CashNote::getCount();
        return response()->json(['status'=>true,'list' => $list, 'count' => $count]);
    }

    public function add(Request $request)
    {
        $return = ['status' => true, 'msg' => '添加成功'];
        $data = [
            'AMOUNT' => $request->input('amount'),
            'TYPE' => $request->input('type'),
            'CATEGORY' => $request->input('category'),
            'REMARK' => $request->input('remark'),
            'CREATED_TIME' => $request->input('date'),
        ];
        if (!CashNote::add($data)) {
            $return = ['status' => false, 'msg' => '添加失败'];
        }
        return response()->json($return);
    }
}
