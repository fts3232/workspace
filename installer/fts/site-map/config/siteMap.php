<?php

return [
    'ignoreMap' => [
        'captcha/{config?}'
    ],
    'postControllerName' => 'App\Http\Controllers\PostsController',
    'tagControllerName' => '',
    'categoryTable' => [
        'tableName'=>'category',
        'primaryKey'=>'CATEGORY_ID',
        'parentField' => 'CATEGORY_PARENT',
        'slugField'=>'CATEGORY_SLUG'
    ],
    'postTable' => [
        'tableName'=>'posts',
        'primaryKey'=>'POST_ID',
        'categoryField' => 'POST_CATEGORY_ID',
        'publishedTimeField' => 'PUBLISHED_TIME',
        'titleField'=>'POST_TITLE'
    ],
    'uriFormat' => [
        'news'=>'news/{date}/{id}',
        'college'=>'college/{id}'
    ]
];
