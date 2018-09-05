<?php

namespace App\Http\Controllers;

use App\Models\CashBookTags;
use Illuminate\Http\Request;

class CashBookTagsController extends Controller
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
        $all = $request->input('all', false);
        if ($all) {
            $list = CashBookTags::get();
            return response()->json(['status' => true, 'list' => $list]);
        } else {
            $offset = ($page - 1) * $size;
            $list = CashBookTags::get($offset, $size);
            $count = CashBookTags::getCount();
            return response()->json(['status' => true, 'list' => $list, 'count' => $count]);
        }
    }

    public function add(Request $request)
    {
        $return = ['status' => true, 'msg' => '添加成功'];
        $data = [
            'NAME' => $request->input('name')
        ];
        if (!CashBookTags::add($data)) {
            $return = ['status' => false, 'msg' => '添加失败'];
        }
        return response()->json($return);
    }
}
