<?php

namespace App\Http\Controllers;

use App\Models\CashBook;
use Illuminate\Http\Request;

class CashBookController extends Controller
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
        $list = CashBook::get($offset, $size);
        $count = CashBook::getCount();
        return response()->json(['status'=>true,'list' => $list, 'count' => $count]);
    }

    public function add(Request $request)
    {
        $return = ['status' => true, 'msg' => '添加成功'];
        $data = [
            'AMOUNT' => $request->input('amount'),
            'TYPE' => $request->input('type'),
            'TAGS' => $request->input('tags'),
            'DESCRIPTION' => $request->input('description'),
            'DATE' => $request->input('date'),
        ];
        if (!CashBook::add($data)) {
            $return = ['status' => false, 'msg' => '添加失败'];
        }
        return response()->json($return);
    }
}
