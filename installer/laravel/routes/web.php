<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('sss/bbb', function () {
    return 'bbbb';
    //var_dump(app('captcha'));
    //return view('welcome');
})->middleware('cache');

Route::get('sss/ccc', function () {
    return 'ccc';
    //return view('welcome');
    //var_dump(app('captcha'));
    //return view('welcome');
})->middleware('cache');
