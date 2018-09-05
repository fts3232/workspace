<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->group(['prefix' => '/api'], function ($app) {
    //cashbook
    $app->get('/cashBook/get', 'CashBookController@get');
    $app->post('/cashBook/add', 'CashBookController@add');
    $app->get('/cashBookTags/get', 'CashBookTagsController@get');
    $app->post('/cashBookTags/add', 'CashBookTagsController@add');
    //setting
    $app->post('/setting/createDB', 'SettingController@createDB');
});
