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
    $app->post('/cashBookTags/edit', 'CashBookTagsController@edit');
    $app->post('/cashBookTags/delete', 'CashBookTagsController@delete');
    //av
    $app->get('/av/get', 'AVController@get');
    $app->get('/av/getPic', 'AVController@getPic');
    $app->get('/av/delete', 'AVController@delete');
    $app->post('/av/setting/url', 'AVController@setting');
    //setting
    $app->post('/setting/createDB', 'SettingController@createDB');
});
