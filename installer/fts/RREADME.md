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
    
    # 监听443端口
    listen 443;
    # 开启ssl
    ssl on;
    # ssl证书位置
    ssl_certificate      D:\dtg\certs\certificate.crt;
    # ssl证书私钥
    ssl_certificate_key  D:\dtg\certs\private.key;

    # 错误页面配置
    error_page 404 = http://test.xxxxx.com/error/404.html;
    
    # 移动端判断
    set $isMobile 0;

    if ($http_user_agent ~* "(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino") {
      set $isMobile 1;
    }

    if ($http_user_agent ~* "^(1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-)") {
      set $isMobile 1;
    }

    set $isMobileDomain "${isMobile}0";
    if ($host = 'm.test.xxxxx.com') {
        set $isMobileDomain "${isMobile}1";
    }
    if ($isMobileDomain = "10") {
      rewrite ^ http://m.test.xxxxx.com$uri redirect;
      break;
    }
    
    # 404链接，判断静态文件是否存在，存在返回html，不存在走php
    location = /error/404 {
        try_files /static/error/404.html /index.php?$query_string;
    }
    
    # 默认首页，判断静态文件是否存在，存在返回html，不存在走php
    location = / {
        try_files /static/index.html /index.php?$query_string;
    }

    # 如果是关于我们旗下页面，允许访问
    location ~* ^/about/(advantage|authentication|guarantee|notice|contactUs|introduction)/?$ {
        # 判断静态文件是否存在，存在返回html，不存在走php
        try_files $uri $uri/ /static/$uri.html /index.php?$query_string;
    }

    # 如果是开户交易旗下页面，允许访问
    location ~* ^/transaction/(real|simulation|rule|interest|guide)/?$ {
        # 判断静态文件是否存在，存在返回html，不存在走php
        try_files $uri $uri/ /static/$uri.html /index.php?$query_string;
    }

    # 如果是平台下载旗下页面，允许访问
    location ~* ^/platform/(pc|mobile)/?$ {
        # 判断静态文件是否存在，存在返回html，不存在走php
        try_files $uri $uri/ /static/$uri.html /index.php?$query_string;
    }

    # 如果是新闻咨询旗下页面，允许访问
    location ~* ^/news/(comment|headline|realtime|information|data|calendar)/?$ {
        # 判断静态文件是否存在，存在返回html，不存在走php
        try_files $uri $uri/ /static/$uri.html /index.php?$query_string;
    }

    # 如果是学院旗下页面，允许访问
    location ~* ^/college/(novice|skill|teacher|rule|investment|wiki)/?$ {
        # 判断静态文件是否存在，存在返回html，不存在走php
        try_files $uri $uri/ /static/$uri.html /index.php?$query_string;
    }

    # 如果是学院旗下文章，允许访问
    location ~* ^/college/([0-9]+)/?$ {
        # 判断静态文件是否存在，存在返回html，不存在走php
        try_files $uri $uri/ /static/$uri.html /index.php?$query_string;
    }

    # 如果是新闻旗下文章，允许访问
    location ~* ^/news/([0-9][0-9][0-9][0-9])\-([0-9][0-9])\-([0-9][0-9])-([0-9]+)/?$ {
        # 判断静态文件是否存在，存在返回html，不存在走php
        try_files $uri $uri/ /static/$uri.html /index.php?$query_string;
    }
    
    # 标签
    location ~* ^/tags/([A-Za-z0-9][A-Za-z0-9_]?[A-Za-z0-9_]?[A-Za-z0-9_]?[A-Za-z0-9_]?[A-Za-z0-9_]?[A-Za-z0-9_]?[A-Za-z0-9_]?[A-Za-z0-9_]?[A-Za-z0-9_]?)/?$ {
        # 判断静态文件是否存在，存在返回html，不存在走php
        try_files $uri $uri/ /static/$uri.html /index.php?$query_string;
    }

    # api
    location ~* ^/api/cache/(create|clear)/?$ {
        # 判断静态文件是否存在，存在返回html，不存在走php
        try_files $uri $uri/ /static/$uri.html /index.php?$query_string;
    }

### 定时任务

日志会生成在storage/logs/cron.log

#### 清除过期的页面静态文件
* 每5分钟执行1次
* 获取到发布时间的状态为等待发布的文章所属栏目别名
  * 更新发布时间的状态为等待发布的文章状态为发布
  * 将栏目别名标识push入数组
* 获取redis有序集合里到到期的要清除的栏目别名
  * 将栏目别名标识push入数组
* 搜索静态目录创建时间是10分钟前的文件
  * 将文件标识push入数组
* 去除数组的重复项
* 执行删除操作，遍历数组执行删除操作

#### 生成site map
* 每天00:00执行1次

### 命令

    发布文件
    php artisan vendor:publish --force
    
    执行调度任务
    php artisan schedule:run
    
    生成site map
    php artisan site-map:create
    
    清空page cache
    php artisan page-cache:clear
    
    生成page cache
    php artisan page-cache:create
    
    page cache 管理
    php artisan cache-manage
    
    生成路由缓存
    php artisan route:cache

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

### 日志

#### 错误日志
* 写入mongodb里
* storage/logs目录下生成日志文件（即使mongodb链接不上，也能查看错误信息）

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
      `MENU_LANG` varchar(10) DEFAULT NULL COMMENT '菜单所属语言',
      `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
      `MODIFIED_TIME` datetime DEFAULT NULL,
      PRIMARY KEY (`MENU_ID`),
      KEY `NAME` (`MENU_NAME`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='保存菜单信息';
        
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
    ) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COMMENT='保存菜单项信息';

### banner管理
* banner-banner图片是一个一对多的关系
* banner名称：1-10个中文字符
* 排序方式为降序，数字越大优先级越高
* banner项状态 0：下架 1：上架
* banner项title 15个中文字符


    CREATE TABLE `banner` (
      `BANNER_ID` int(11) NOT NULL AUTO_INCREMENT,
      `BANNER_NAME` varchar(30) DEFAULT NULL COMMENT 'banner名称',
      `BANNER_LANG` varchar(10) DEFAULT NULL COMMENT 'bannner所属语言',
      `CREATED_TIEM` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
      `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '修改时间',
      PRIMARY KEY (`BANNER_ID`),
      KEY `BANNER_NAME` (`BANNER_NAME`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='存放banner信息';
    
    CREATE TABLE `banner_item` (
      `ITEM_ID` int(11) NOT NULL AUTO_INCREMENT,
      `BANNER_ID` int(11) DEFAULT NULL COMMENT '所属banner id',
      `ITEM_IMG` varchar(255) DEFAULT NULL COMMENT 'banner 项图片',
      `ITEM_URL` varchar(255) DEFAULT NULL COMMENT 'banner 项url',
      `ITEM_TITLE` varchar(45) DEFAULT NULL COMMENT 'banner项小标题',
      `ITEM_STATUS` tinyint(1) DEFAULT NULL COMMENT '项状态',
      `ITEM_ORDER` tinyint(3) DEFAULT NULL COMMENT '图片排序',
      `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
      `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
      PRIMARY KEY (`ITEM_ID`),
      KEY `BANNER_ID` (`BANNER_ID`) USING BTREE,
      KEY `ITEM_STATUS` (`ITEM_STATUS`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='保存banner图片项信息\r\n状态\r\n0：下架\r\n1：上架';

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
      `CATEGORY_SLUG` varchar(30) DEFAULT NULL COMMENT '栏目别名',
      `CATEGORY_PARENT` int(11) DEFAULT NULL COMMENT '栏目父类',
      `CATEGORY_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT '栏目描述',
      `CATEGORY_LANG` varchar(10) DEFAULT NULL COMMENT '栏目语言',
      `SEO_TITLE` varchar(150) DEFAULT NULL COMMENT 'seo标题',
      `SEO_KEYWORD` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
      `SEO_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT 'seo描述',
      `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
      `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
      PRIMARY KEY (`CATEGORY_ID`),
      KEY `CATEGORY_NAME` (`CATEGORY_NAME`),
      KEY `CATEGORY_SLUG` (`CATEGORY_SLUG`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='文章栏目信息';

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
      `POST_TITLE` varchar(150) DEFAULT NULL,
      `POST_CONTENT` text COMMENT '文章正文',
      `POST_LANG` varchar(10) DEFAULT NULL COMMENT '文章语言',
      `POST_AUTHOR_ID` int(11) DEFAULT NULL COMMENT '作者用户ID',
      `POST_STATUS` tinyint(1) DEFAULT NULL COMMENT '文章状态',
      `POST_LAST_STATUS` tinyint(1) DEFAULT NULL COMMENT 'post删除前最后的状态',
      `POST_ORDER` tinyint(3) DEFAULT '0' COMMENT '文章排序',
      `SEO_TITLE` varchar(50) DEFAULT NULL COMMENT 'seo标题',
      `SEO_KEYWORD` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
      `SEO_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT 'seo描述',
      `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
      `PUBLISHED_TIME` datetime DEFAULT NULL COMMENT '发布时间',
      `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
      `DELETED_TIME` datetime DEFAULT NULL COMMENT '删除时间',
      PRIMARY KEY (`POST_ID`),
      KEY `POST_TRANSLATE_ID` (`POST_TRANSLATE_ID`) USING BTREE,
      KEY `POST_TITLE` (`POST_TITLE`) USING BTREE,
      KEY `POST_STATUS` (`POST_STATUS`) USING BTREE,
      KEY `PUBLISHED_TIME` (`PUBLISHED_TIME`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 COMMENT='存放文章信息\r\n状态\r\n0：草稿\r\n1：等待发布\r\n2：发布\r\n3：删除';

### 文章修改历史
* 记录用户什么时候修改过哪编文章

    
    CREATE TABLE `posts_revision_history` (
      `ROW_ID` int(11) NOT NULL AUTO_INCREMENT,
      `POST_ID` int(11) DEFAULT NULL COMMENT '文章id',
      `POST_AUTHOR_ID` int(11) DEFAULT NULL COMMENT '修改作者',
      `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`ROW_ID`),
      KEY `POST_ID` (`POST_ID`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='文章修改历史记录';

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
      `TAG_LANG` varchar(10) DEFAULT NULL COMMENT '标签所属语言',
      `TAG_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT '标签描述',
      `SEO_TITLE` varchar(50) DEFAULT NULL COMMENT 'seo标题',
      `SEO_KEYWORD` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
      `SEO_DESCRIPTION` varchar(1024) DEFAULT NULL COMMENT 'seo描述',
      `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
      `MODIFIED_TIME` datetime DEFAULT NULL COMMENT '更新时间',
      PRIMARY KEY (`TAG_ID`),
      KEY `TAG_NAME` (`TAG_NAME`) USING BTREE,
      KEY `TAG_SLUG` (`TAG_SLUG`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8 COMMENT='存放文章标签信息';


### 文章和标签对应关系

    CREATE TABLE `posts_tags_relation` (
      `ROW_ID` int(11) NOT NULL AUTO_INCREMENT,
      `POST_ID` int(11) DEFAULT NULL COMMENT '文章id',
      `TAG_ID` int(11) DEFAULT NULL COMMENT '标签id',
      `CREATED_TIME` datetime DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`ROW_ID`),
      KEY `POST_ID` (`POST_ID`) USING BTREE,
      KEY `TAG_ID` (`TAG_ID`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='保存文章和标签的对应关系';

### 页面管理
* 页面名称：1-10个中文字符
* 页面别名：1-30个英文数字字符
* Seo标题：1-50个中文字符和特殊符号
* Seo关键词：1-85个中文字符和特殊符号
* Seo描述：1-300个中文字符和特殊符号


    CREATE TABLE `pages` (
      `PAGE_ID` int(11) NOT NULL AUTO_INCREMENT,
      `PAGE_NAME` varchar(30) DEFAULT NULL COMMENT '页面名称',
      `PAGE_SLUG` varchar(30) DEFAULT NULL COMMENT '页面别名',
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
    ) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='存放页面信息';

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

### 权限

    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
        (
            'Cms/Menu/index',
            '列表页',
            'Cms/Menu',
            '1',
            '1',
            ''
        );
    
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
        (
            'Cms/Menu/addMenu',
            '添加菜单组',
            'Cms/Menu',
            '1',
            '1',
            ''
        );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
        (
            'Cms/Menu/editMenu',
            '修改菜单组',
            'Cms/Menu',
            '1',
            '1',
            ''
        );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
        (
            'Cms/Menu/deleteMenu',
            '删除菜单组',
            'Cms/Menu',
            '1',
            '1',
            ''
        );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
        (
            'Cms/Menu/showItem',
            '查看菜单项',
            'Cms/Menu',
            '1',
            '1',
            ''
        );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
        (
            'Cms/Menu/addItem',
            '添加菜单项',
            'Cms/Menu',
            '1',
            '1',
            ''
        );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
        (
            'Cms/Menu/updateItem',
            '更新菜单项',
            'Cms/Menu',
            '1',
            '1',
            ''
        );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
        (
            'Cms/Banner/index',
            '列表页',
            'Cms/Banner',
            '1',
            '1',
            ''
        );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
        (
            'Cms/Banner/addBanner',
            '添加banner组',
            'Cms/Banner',
            '1',
            '1',
            ''
        );
        
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
        (
            'Cms/Banner/editBanner',
            '修改banner组',
            'Cms/Banner',
            '1',
            '1',
            ''
        );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
        (
            'Cms/Banner/deleteBanner',
            '删除banner组',
            'Cms/Banner',
            '1',
            '1',
            ''
        );
        
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
        (
            'Cms/Banner/showItem',
            '查看banner项',
            'Cms/Banner',
            '1',
            '1',
            ''
        );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
        (
            'Cms/Banner/updateItem',
            '更新banner项',
            'Cms/Banner',
            '1',
            '1',
            ''
        );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
        (
            'Cms/Banner/uploadImage',
            '上传banner',
            'Cms/Banner',
            '1',
            '1',
            ''
        );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
        (
            'Cms/Category/index',
            '列表页',
            'Cms/Category',
            '1',
            '1',
            ''
        );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
        (
            'Cms/Category/add',
            '添加',
            'Cms/Category',
            '1',
            '1',
            ''
        );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
        (
            'Cms/Category/edit',
            '修改',
            'Cms/Category',
            '1',
            '1',
            ''
        );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
    (
        'Cms/Category/delete',
        '删除',
        'Cms/Category',
        '1',
        '1',
        ''
    );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
    (
        'Cms/Pages/index',
        '列表页',
        'Cms/Pages',
        '1',
        '1',
        ''
    );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
    (
        'Cms/Pages/add',
        '添加',
        'Cms/Pages',
        '1',
        '1',
        ''
    );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
    (
        'Cms/Pages/edit',
        '修改',
        'Cms/Pages',
        '1',
        '1',
        ''
    );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
    (
        'Cms/Pages/delete',
        '删除',
        'Cms/Pages',
        '1',
        '1',
        ''
    );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
    (
        'Cms/Posts/index',
        '列表页',
        'Cms/Posts',
        '1',
        '1',
        ''
    );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
    (
        'Cms/Posts/recycle',
        '回收站',
        'Cms/Posts',
        '1',
        '1',
        ''
    );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
    (
        'Cms/Posts/add',
        '添加',
        'Cms/Posts',
        '1',
        '1',
        ''
    );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
    (
        'Cms/Posts/edit',
        '修改',
        'Cms/Posts',
        '1',
        '1',
        ''
    );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
    (
        'Cms/Posts/softDelete',
        '软删除',
        'Cms/Posts',
        '1',
        '1',
        ''
    );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
    (
        'Cms/Posts/uploadImage',
        '上传图片',
        'Cms/Posts',
        '1',
        '1',
        ''
    );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
    (
        'Cms/Posts/delete',
        '硬删除',
        'Cms/Posts',
        '1',
        '1',
        ''
    );
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
    (
        'Cms/Posts/restore',
        '还原',
        'Cms/Posts',
        '1',
        '1',
        ''
    );
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
    (
        'Cms/Tags/index',
        '列表页',
        'Cms/Tags',
        '1',
        '1',
        ''
    );
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
    (
        'Cms/Tags/add',
        '添加',
        'Cms/Tags',
        '1',
        '1',
        ''
    );
    
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
    (
        'Cms/Tags/edit',
        '修改',
        'Cms/Tags',
        '1',
        '1',
        ''
    );
    INSERT INTO `auth_rule` (
        `name`,
        `title`,
        `controller`,
        `type`,
        `status`,
        `condition`
    )
    VALUES
    (
        'Cms/Tags/delete',
        '删除',
        'Cms/Tags',
        '1',
        '1',
        ''
    );