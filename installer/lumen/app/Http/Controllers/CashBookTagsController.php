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

    public function edit(Request $request)
    {
        $return = ['status' => true, 'msg' => '修改成功'];
        $data = [
            'ID' => $request->input('id'),
            'NAME' => $request->input('name'),
        ];
        if (!CashBookTags::edit($data)) {
            $return = ['status' => false, 'msg' => '修改失败'];
        }
        return response()->json($return);
    }

    public function delete(Request $request)
    {
        $return = ['status' => true, 'msg' => '删除成功'];
        $data = [
            'ID' => $request->input('id')
        ];
        if (!CashBookTags::deleteTag($data)) {
            $return = ['status' => false, 'msg' => '删除失败'];
        }
        return response()->json($return);
    }
}
