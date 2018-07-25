<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('cache/create', function (Request $request) {
    Artisan::call('page-cache:create');
})->middleware(['api', 'verifySign:createCache']);

Route::post('cache/clear', function (Request $request) {
    Artisan::call('page-cache:clear');
})->middleware(['api', 'verifySign:clearCache']);
