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
Route::group(['middleware' => 'page-cache'], function () {
    //首页
    Route::get('/', function () {
        return view('index');
    });
    //关于我们
    Route::group(['prefix' => '/about'], function () {
        //集团概况
        Route::get('/', function () {
            return view('about/about');
        });
        //优势
        Route::get('/advantage', function () {
            return view('about/advantage');
        });
        //集团认证
        Route::get('/authentication', function () {
            return view('about/authentication');
        });
        //投资者保障
        Route::get('/guarantee', function () {
            return view('about/guarantee');
        });
        //公告
        Route::get('/notice', function () {
            return view('about/notice');
        });
        //联系我们
        Route::get('/contactUs', function () {
            return view('about/contact');
        });
    });
    //开户交易
    Route::group(['prefix' => '/transaction'], function () {
        //真实账户
        Route::get('/real', function () {
            return view('transaction/real');
        });
        //模拟账户
        Route::get('/simulation', function () {
            return view('transaction/simulation');
        });
        //合约细则
        Route::get('/rule', function () {
            return view('transaction/rule');
        });
        //合约利息
        Route::get('/interest', function () {
            return view('transaction/interest');
        });
        //交易指南
        Route::get('/guide', function () {
            return view('transaction/guide');
        });
    });
    //平台下载
    Route::group(['prefix' => '/platform'], function () {
        //电脑交易平台
        Route::get('/pc', function () {
            return view('platform/pc');
        });
        //手机交易平台
        Route::get('/mobile', function () {
            return view('platform/mobile');
        });
    });
    //新闻咨询
    Route::group(['prefix' => '/news'], function () {
        //每日金评
        Route::get('/comment', function () {
            return view('news/comment');
        });
        //黄金头条
        Route::get('/headline', function () {
            return view('news/headline');
        });
        //汇市新闻
        Route::get('/market', function () {
            return view('news/market');
        });
        //行业资讯
        Route::get('/information', function () {
            return view('news/information');
        });
        //即时数据
        Route::get('/data', function () {
            return view('news/data');
        });
        //财经日历
        Route::get('/calendar', function () {
            return view('news/calendar');
        });
    });
    //学院
    Route::group(['prefix' => '/college'], function () {
        //新手入门
        Route::get('/novice', function () {
            return view('college/novice');
        });
        //实战技巧
        Route::get('/skill', function () {
            return view('college/skill');
        });
        //名师指路
        Route::get('/teacher', function () {
            return view('college/teacher');
        });
        //黄金法则
        Route::get('/rule', function () {
            return view('college/rule');
        });
        //外汇投资
        Route::get('/investment', function () {
            return view('college/investment');
        });
        //投资百科
        Route::get('/wiki', function () {
            return view('college/wiki');
        });
    });
    //错误页面
    Route::group(['prefix' => '/error'], function () {
        //404
        Route::get('/404', function () {
            return view('error/404');
        });
    });
});

Route::get('img', function () {
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
    echo $asd;
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
});
