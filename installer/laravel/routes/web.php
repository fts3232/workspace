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
Route::group([/*'middleware' => 'page-cache'*/], function () {
    //首页
    Route::get('/', 'HomeController@index')->name('首页');
    //内页
    $pages = App\Models\Pages::getAll();
    foreach ($pages as $page) {
        foreach ($page->CHILD as $child) {
            $uri = "/{$page->PAGE_SLUG}/{$child->PAGE_SLUG}";
            Route::get($uri, $child->PAGE_DIRECTING)->name($child->PAGE_NAME);
        }
    }
    //错误页面
    Route::group(['prefix' => '/error'], function () {
        //404
        Route::get('/404', 'ErrorController@notFound')->name('404错误页面');
    });
    //文章
    Route::get('/news/{date}/{id}', 'PostsController@news')
        ->where(['id' => '[0-9]+', 'date' => '[0-9]{4}\-[0-9]{2}-[0-9]{2}']);
    Route::get('/college/{id}', 'PostsController@college')->where('id', '[0-9]+');
});

/*Route::get('img', function () {
    $time = time();
    $scope = 'getImage';
    $clientID = 'www.xxx.com';
    $key = "{$clientID}-{$scope}-{$time}-" . "&J$#KF(S(K@@L";
    $request = http_request('post', 'http://test.crm.dtg.hk/index.php/Cms/api/getImage', [
        'form_params' => [
            'client_id' => $clientID,
            'sign' => md5($key),
            'time' => $time,
            'scope' => $scope,
            'uid' => 1,
            'type' => 'card1'
        ]
    ]);
    $contentType = explode(';', $request['header']['Content-Type'][0]);
    $contentType = $contentType[0];
    return response($request['content'], 200, [
        'Content-Type' => $contentType,
    ]);
});

Route::get('test', function () {
    $token = csrf_field();
    echo <<<EOF
        <form method="post" action='http://localhost:8080/workspace/installer/laravel/public/upload' enctype="multipart/form-data" >
            <input type="file" name="file"/>
            {$token}
            <input type="submit"/>
        </form>
EOF;
});

Route::post('upload', function () {
    $time = time();
    $scope = 'getImage';
    $clientID = 'www.xxx.com';
    $key = "{$clientID}-{$scope}-{$time}-" . "&J$#KF(S(K@@L";
    $request = http_request('post', 'http://test.crm.dtg.hk/index.php/Cms/api/uploadImage', [
        'multipart' => [
            [
                'name' => 'file',
                'contents' => file_get_contents(app('request')->file('file')->getRealPath()),
                'filename' => app('request')->file('file')->getClientOriginalName()
            ],
            [
                'name' => 'client_id',
                'contents' => $clientID
            ],
            [
                'name' => 'scope',
                'contents' => $scope
            ],
            [
                'name' => 'time',
                'contents' => $time
            ],
            [
                'name' => 'sign',
                'contents' => md5($key)
            ],
            [
                'name' => 'uid',
                'contents' => 1
            ],
            [
                'name' => 'type',
                'contents' => 'card1'
            ],
        ]
    ]);
    return $request['content'];
});*/
