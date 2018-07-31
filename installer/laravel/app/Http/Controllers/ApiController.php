<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class ApiController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function cacheCreate()
    {
        return Artisan::call('page-cache:create');
    }

    public function cacheClear()
    {
        return Artisan::call('page-cache:clear');
    }
}
