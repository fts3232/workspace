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
    $response = (http_request('post', 'http://localhost:8080/workspace/installer/laravel/public/oauth/token1', [
        'form_params' => [
            'grant_type' => 'password',
            'username'=>'demoapp',
            'password'=>'demopass',
            'client_id'=>'demoapp',
            'client_secret'=>'demopass',
            'scope'=>'cache'
        ]
    ]));
    var_dump($response);
    //$jwt_access_token = $response['access_token'];
    $a = '4e72d3003256da7292d680f9415c9e93127cbd35';

    $response = (http_request('post', 'http://localhost:8080/workspace/installer/laravel/public/api/a', [
        'form_params' => [
            'access_token' =>  'e4f60704a325b483ac543e7ec33a619042ea73e4',
            'client_id'=>'demoapp',
            'client_secret'=>'demopass',
        ]
    ]));
    var_dump($response);
    if (isset($response['error'])) {
        $response = (http_request('post', 'http://localhost:8080/workspace/installer/laravel/public/oauth/token', [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $a,
                'client_id' => 'demoapp',
                'client_secret' => 'demopass',
            ]
        ]));
        var_dump($response);
    }
    //return view('index');
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
