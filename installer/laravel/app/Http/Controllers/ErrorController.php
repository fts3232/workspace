<?php

namespace App\Http\Controllers;

class ErrorController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function notFound()
    {
        return view('error/404');
    }
}
