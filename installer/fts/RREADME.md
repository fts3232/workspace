# 前端网站

### url


    首页 /
        关于我们 
            集团概况     /about/introduction
            优势        /about/advantage
            集团认证     /about/authentication
            投资者保障   /about/guarantee
            公告        /about/notice
            联系我们     /about/contact
        开户交易
            真实账户    /transaction/real
            模拟账户    /transaction/simulation
            合约细则    /transaction/rule
            合约利息    /transaction/interest
            交易指南    /transaction/guide
        平台下载
            电脑交易平台  /platform/pc
            手机交易平台  /platform/mobile
        新闻咨询
            每日金评    /news/comment
            黄金头条    /news/headline
            汇市新闻    /news/market
            行业资讯    /news/information
            即时数据    /news/data
            财经日历    /news/calendar
        学院
            新手入门    /college/novice
            实战技巧    /college/skill
            名师指路    /college/teacher
            黄金法则    /college/rule
            外汇投资    /college/investment
            投资百科    /college/wiki
        
        文章
            新闻栏目 /{date}/{id}
            学院栏目 /{id}

### 静态化

    1.nginx判断uri是否符合格式，不符合返回404
    2.nginx判断静态文件是否存在，存在返回静态html，不存在走php
    3.php判断静态文件是否存在，存在返回html，不存在生成静态html文件
### nginx配置

    #错误页面配置
    error_page 404 = http://text.xxxx.com/error/404.html;
    
    #404链接，判断静态文件是否存在，存在返回html，不存在走php
    location = /error/404 {
        try_files /static/error/404.html /index.php?$query_string;
    }
    
    #默认首页，判断静态文件是否存在，存在返回html，不存在走php
    location = / {
        try_files /static/index.html /index.php?$query_string;
    }
    
    location / {
    	#设置变量
        set $flag 0;
    
        #如果是关于我们旗下页面，允许访问
        if ( $request_uri ~* ^/about/(introduction|advantage|authentication|guarantee|notice|contactUs)/?$) {
            set $flag 1;
        }
    
        #如果是开户交易旗下页面，允许访问
        if ( $request_uri ~* ^/transaction/(real|simulation|rule|interest|guide)/?$) {
            set $flag 1;
        }
    
        #如果是平台下载旗下页面，允许访问
        if ( $request_uri ~* ^/platform/(pc|mobile)/?$) {
            set $flag 1;
        }
    
        #如果是新闻咨询旗下页面，允许访问
        if ( $request_uri ~* ^/news/(comment|headline|realtime|information|data|calendar)/?$) {
            set $flag 1;
        }
    
        #如果是学院旗下页面，允许访问
        if ( $request_uri ~* ^/college/(novice|skill|teacher|rule|investment|wiki)/?$) {
            set $flag 1;
        }
        
        #如果是学院旗下文章，允许访问
        if ( $request_uri ~* ^/college/([0-9]+)/?$) {
            set $flag 1;
        }
    
        #如果是新闻旗下文章，允许访问
        if ( $request_uri ~* ^/news/([0-9][0-9][0-9][0-9])\-([0-9][0-9])\-([0-9][0-9])/([0-9]+)/?$) {
            set $flag 1;
        }
        
        #api
        if ( $request_uri ~* ^/api/cache/(create|clear)/?$) {
            set $flag 1;
        }
    
        #如果uri是不允许的格式，返回404
        if ($flag = "0") {
            return 404;
        }
    
        #判断静态文件是否存在，存在返回html，不存在走php
        try_files $uri $uri/ /static/$uri.html /index.php?$query_string;
    }

### 定时任务

日志会生成在storage/logs/cron.log

每5分钟执行1次

* 获取到发布时间的状态为等待发布的文章所属栏目别名
  * 更新发布时间的状态为等待发布的文章状态为发布
  * 将栏目别名标识push入数组
* 获取redis有序集合里到到期的要清除的栏目别名
  * 将栏目别名标识push入数组
* 搜索静态目录创建时间是10分钟前的文件
  * 将文件标识push入数组
* 去除数组的重复项
* 执行删除操作，遍历数组执行删除操作

每天00:00执行1次

* 生成site map

### 命令

    php artisan vendor:publish --force
    
    php artisan schedule:run
    
    php artisan site-map:create
    
    php artisan page-cache:clear
    
    php artisan page-cache:create
    
    php artisan cache-manage

### 接口api

    /api/cache/create - 创建所有缓存
    /api/cache/clear - 清除所有缓存

入参

    sign - 签名 生成：时间戳+范围+客户端标识+难记串 md5加密
    time - 时间戳
    scope - 请求的范围
    client_id - 客户端标识

出参

    status - 调用的结果状态 
    msg - 返回信息
    code - 错误号

判断

    1.签名是否一致
    2.请求的时间戳是否已过期（10分钟过期时间）
    3.scope是否在允许的范围内
    4.clent_id是否在允许的范围内

调用方式

    php curl发送请求,不暴露api接口

# cms

### 错误号

    contorller层 - 1xx开始
        输入验证失败错误号为100
    model层 - 2xx开始

### 菜单管理
* 菜单-菜单项是一个一对多的关系
* 菜单名称：1-10个中文字符
* 排序方式为降序，数字越大优先级越高


    CREATE TABLE `menu` (
      `MENU_ID` int(11) NOT NULL AUTO_INCREMENT,
      `MENU_NAME` varchar(30) DEFAULT NULL COMMENT '菜单名',
      `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
      `MODIFIED_TIME` datetime DEFAULT NULL,
      PRIMARY KEY (`MENU_ID`),
      KEY `NAME` (`MENU_NAME`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='保存菜单信息';
        
    CREATE TABLE `menu_item` (
      `ITEM_ID` int(11) NOT NULL AUTO_INCREMENT,
      `MENU_ID` int(11) DEFAULT NULL COMMENT '所属菜单id',
      `ITEM_NAME` varchar(30) DEFAULT NULL COMMENT '菜单项名字',
      `ITEM_URL` varchar(255) DEFAULT NULL COMMENT '菜单项url',
      `ITEM_PARENT` int(11) DEFAULT NULL COMMENT '所属父类id',
      `ITEM_ORDER` tinyint(3) DEFAULT NULL COMMENT '排序',
      `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
      `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
      PRIMARY KEY (`ITEM_ID`),
      KEY `MENU_ID` (`MENU_ID`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='保存菜单项信息';

### banner管理
* banner-banner图片是一个一对多的关系
* banner名称：1-10个中文字符
* 排序方式为降序，数字越大优先级越高
* banner项状态 0：下架 1：上架


    CREATE TABLE `banner` (
      `BANNER_ID` int(11) NOT NULL AUTO_INCREMENT,
      `BANNER_NAME` varchar(30) DEFAULT NULL COMMENT 'banner名称',
      `CREATED_TIEM` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
      `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '修改时间',
      PRIMARY KEY (`BANNER_ID`),
      KEY `BANNER_NAME` (`BANNER_NAME`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='存放banner信息';
    
    CREATE TABLE `banner_item` (
      `ITEM_ID` int(11) NOT NULL AUTO_INCREMENT,
      `BANNER_ID` int(11) DEFAULT NULL COMMENT '所属banner id',
      `ITEM_IMG` varchar(255) DEFAULT NULL COMMENT 'banner 项图片',
      `ITEM_URL` varchar(255) DEFAULT NULL COMMENT 'banner 项url',
      `ITEM_STATUS` tinyint(1) DEFAULT NULL COMMENT '项状态',
      `ITEM_ORDER` tinyint(3) DEFAULT NULL COMMENT '图片排序',
      `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
      `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
      PRIMARY KEY (`ITEM_ID`),
      KEY `BANNER_ID` (`BANNER_ID`) USING BTREE,
      KEY `ITEM_STATUS` (`ITEM_STATUS`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='保存banner图片项信息\r\n状态\r\n0：下架\r\n1：上架';

### 栏目管理
* 存放文章栏目信息
* 栏目名称：1-10个中文字符
* 栏目别名：1-30个英文数字字符
* 栏目描述：1-300个中文字符和特殊符号
* Seo标题：1-50个中文字符和特殊符号
* Seo关键词：1-85个中文字符和特殊符号
* Seo描述：1-300个中文字符和特殊符号


    CREATE TABLE `category` (
      `CATEGORY_ID` int(11) NOT NULL AUTO_INCREMENT,
      `CATEGORY_NAME` varchar(30) DEFAULT NULL COMMENT '栏目名称',
      `CATEGORY_SLUG` varchar(10) DEFAULT NULL COMMENT '栏目别名',
      `CATEGORY_PARENT` int(11) DEFAULT NULL COMMENT '栏目父类',
      `CATEGORY_ORDER` tinyint(3) DEFAULT NULL COMMENT '栏目排序',
      `CATEGORY_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT '栏目描述',
      `SEO_TITLE` varchar(150) DEFAULT NULL COMMENT 'seo标题',
      `SEO_KEYWORD` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
      `SEO_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT 'seo描述',
      `CRAETED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
      `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
      PRIMARY KEY (`CATEGORY_ID`),
      KEY `CATEGORY_NAME` (`CATEGORY_NAME`),
      KEY `CATEGORY_SLUG` (`CATEGORY_SLUG`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='文章栏目信息';

### 文章管理
* 文章标题：1-50个中文字符和特殊符号
* Seo标题：1-50个中文字符和特殊符号
* Seo关键词：1-85个中文字符和特殊符号
* Seo描述：1-300个中文字符和特殊符号
* 执行更新，删除，添加操作时，将所属栏目和当前时间戳写入redis有序集合
供前端网站定时任务清除指定栏目目录用
* 获取对照翻译版本，如果TRANSLATE_ID为0，获取TRANSLATE_ID = POST_ID 的文章，否则获取TRANSLATE_ID 相同和POST_ID = TRANSLATE_ID的文章
* 当文章有另一语言的版本的时候，该文章当前语言不能选择为已有版本的语言
* 和tag的关系保存在posts_tags_relation表内


    CREATE TABLE `posts` (
      `POST_ID` int(11) NOT NULL AUTO_INCREMENT,
      `POST_TRANSLATE_ID` int(11) DEFAULT '0' COMMENT '翻译的文章ID',
      `POST_CATEGORY_ID` int(11) DEFAULT NULL COMMENT '文章所属栏目',
      `POST_TITLE` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
      `POST_CONTENT` text COMMENT '文章正文',
      `POST_LANG` varchar(10) DEFAULT NULL COMMENT '文章语言',
      `POST_AUTHOR_ID` int(11) DEFAULT NULL COMMENT '作者用户ID',
      `POST_STATUS` tinyint(1) DEFAULT NULL COMMENT '文章状态 0:草稿 1:等待发布 2:发布',
      `POST_ORDER` tinyint(3) DEFAULT '0' COMMENT '文章排序',
      `SEO_TITLE` varchar(50) DEFAULT NULL COMMENT 'seo标题',
      `SEO_KEYWORD` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
      `SEO_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT 'seo描述',
      `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
      `PUBLISHED_TIME` datetime DEFAULT NULL COMMENT '发布时间',
      `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
      PRIMARY KEY (`POST_ID`),
      KEY `POST_TRANSLATE_ID` (`POST_TRANSLATE_ID`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COMMENT='存放文章信息';

### 标签管理
* Tag名称：1-10个中文字符
* Tag 别名：1-30个英文数字字符
* Tag描述：1-300个中文字符和特殊符号
* Seo标题：1-50个中文字符和特殊符号
* Seo关键词：1-85个中文字符和特殊符号
* Seo描述：1-300个中文字符和特殊符号
* 和post的关系保存在posts_tags_relation表内


    CREATE TABLE `tags` (
      `TAG_ID` int(11) NOT NULL AUTO_INCREMENT,
      `TAG_NAME` varchar(30) DEFAULT NULL COMMENT '标签名称',
      `TAG_SLUG` varchar(30) DEFAULT NULL COMMENT '标签别名',
      `TAG_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT '标签描述',
      `SEO_TITLE` varchar(50) DEFAULT NULL COMMENT 'seo标题',
      `SEO_KEYWORD` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
      `SEO_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT 'seo描述',
      `CRAETED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
      `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
      PRIMARY KEY (`TAG_ID`),
      KEY `TAG_NAME` (`TAG_NAME`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8 COMMENT='存放文章标签信息';


### 文章和标签对应关系

    CREATE TABLE `posts_tags_relation` (
      `ROW_ID` int(11) NOT NULL AUTO_INCREMENT,
      `POST_ID` int(11) DEFAULT NULL COMMENT '文章id',
      `TAG_ID` int(11) DEFAULT NULL COMMENT '标签id',
      `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`ROW_ID`),
      KEY `POST_ID` (`POST_ID`) USING BTREE,
      KEY `TAG_ID` (`TAG_ID`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='保存文章和标签的对应关系';

### 页面管理
* 页面名称：1-10个中文字符
* 页面别名：1-30个英文数字字符
* Seo标题：1-50个中文字符和特殊符号
* Seo关键词：1-85个中文字符和特殊符号
* Seo描述：1-300个中文字符和特殊符号


    CREATE TABLE `pages` (
      `PAGE_ID` int(11) NOT NULL AUTO_INCREMENT,
      `PAGE_NAME` varchar(30) DEFAULT NULL COMMENT '页面名称',
      `PAGE_SLUG` varchar(10) DEFAULT NULL COMMENT '页面别名',
      `PAGE_DIRECTING` varchar(50) DEFAULT NULL COMMENT '页面指向',
      `PAGE_PARENT` tinyint(3) DEFAULT NULL COMMENT '页面父类',
      `PAGE_LANG` varchar(10) DEFAULT NULL COMMENT '页面语言',
      `SEO_TITLE` varchar(50) DEFAULT NULL COMMENT 'seo标题',
      `SEO_KEYWORD` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
      `SEO_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT 'seo描述',
      `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
      `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
      PRIMARY KEY (`PAGE_ID`),
      KEY `POST_TRANSLATE_ID` (`PAGE_NAME`) USING BTREE,
      KEY `POST_TITLE` (`PAGE_DIRECTING`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='存放页面信息';

### 接口api

    /api/getImage - 获取图片
    /api/uploadImag - 上传图片


入参

    sign - 签名 生成：时间戳+范围+客户端标识+难记串 md5加密
    time - 时间戳
    scope - 请求的范围
    client_id - 客户端标识
    uid - 用户id
    type - 要获取/上传的图片类型
    file - 上传的图片

出参

    status - 调用的结果状态 
    msg - 返回信息
    code - 错误号

判断

    1.签名是否一致
    2.请求的时间戳是否已过期（10分钟过期时间）
    3.scope是否在允许的范围内
    4.clent_id是否在允许的范围内

调用方式

    php curl发送请求,不暴露api接口