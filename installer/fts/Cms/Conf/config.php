<?php
return array(
    //'配置项'=>'配置值'
    'languageMap' => array(
        'zh_CN' => '简体中文',
        'zh_HK' => '繁体中文'
    ),
    'defaultLanguage' => 'zh_CN',
    'pageSize' => 20,
    'www' => [
        'domain'=>'xxxx.com',
        'protocol' => 'https'
    ],
    'menuMap' => array(
        'menu' => array(
            'controller' => 'Cms/Menu/index',
            'title' => '菜单管理'
        ),
        'banner' => array(
            'controller'=>'Cms/Banner/index',
            'title' => 'Banner管理'
        ),
        'category' => array(
            'controller' => 'Cms/Category/index',
            'title' => '栏目管理'
        ),
        'posts' => array(
            'title' => '文章管理',
            'child' => array(
                array(
                    'controller'=>'Cms/Posts/index',
                    'title'=>'文章列表'
                ),
                array(
                    'controller'=>'Cms/Posts/recycle',
                    'title'=>'回收站'
                )
            )
        ),
        'tags' => array(
            'controller' => 'Cms/Tags/index',
            'title' => '标签管理'
        ),
        'pages' => array(
            'controller' => 'Cms/Pages/index',
            'title' => '页面管理'
        )
    ),
    'post' => array(
        'statusMap' => array(
            '0' => '草稿',
            '1' => '等待发布',
            '2' => '发布',
            '3' => '已删除'
        )
    ),
    'banner' => array(
        'statusMap' => array(
            '0' => '下架',
            '1' => '上架',
        )
    ),
);