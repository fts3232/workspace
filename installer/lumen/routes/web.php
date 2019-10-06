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
    $app->get('/cashNote/fetch', 'CashNoteController@fetch');
    $app->post('/cashNote/add', 'CashNoteController@add');
    //av
    $app->get('/av/get', 'AVController@get');
    $app->get('/av/getPic', 'AVController@getPic');
    $app->get('/av/delete', 'AVController@delete');
    $app->get('/av/openPath', 'AVController@openPath');
    $app->post('/av/setCover', 'AVController@setCover');
    $app->post('/av/setting/url', 'AVController@setting');
    //setting
    $app->post('/setting/createDB', 'SettingController@createDB');
});
