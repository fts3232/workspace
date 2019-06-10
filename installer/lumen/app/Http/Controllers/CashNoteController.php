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
    public function fetch(Request $request)
    {
        $returnData = [];
        $getMonthData = $request->input('getMonthData', 0);
        $getTotalExpenditure = $request->input('getTotalExpenditure', 0);
        $getGrossIncome = $request->input('getGrossIncome', 0);
        $getRows = $request->input('getRows', 0);
        $getPieData = $request->input('getPieData', 0);
        $date = $request->input('date', false);
        $category = $request->input('category', false);
        $search = [];
        if ($date) {
            $search['date'] = $date;
        }
        if ($category) {
            $search['category'] = $category;
        }
        if ($getMonthData) {
            $returnData['monthData'] = CashNote::getMonthData();
        }
        if ($getTotalExpenditure) {
            $returnData['totalExpenditure'] = CashNote::getTotalExpenditure($search);
        }
        if ($getGrossIncome) {
            $returnData['grossIncome'] = CashNote::getGrossIncome($search);
        }
        if ($getRows) {
            $page = $request->input('page', 1);
            $size = $request->input('size', 10);
            $returnData['rows'] = CashNote::fetch($page, $size, $search);
            $returnData['count'] = CashNote::getCount($search);
        }
        if ($getPieData) {
            $returnData['pieData'] = CashNote::getPieData($search);
        }
        /*$list = CashNote::get($offset, $size);
        $count = CashNote::getCount();*/
        return response()->json($returnData);
    }

    public function add(Request $request)
    {
        $return = ['status' => true, 'msg' => '添加成功'];
        $data = [
            'AMOUNT' => $request->input('amount'),
            'TYPE' => $request->input('type'),
            'CATEGORY' => $request->input('category'),
            'REMARK' => $request->input('remark'),
            'DATE' => $request->input('date'),
        ];
        if (!CashNote::add($data)) {
            $return = ['status' => false, 'msg' => '添加失败'];
        }
        return response()->json($return);
    }
}
