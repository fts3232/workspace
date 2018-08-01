# site-map
[![Latest Stable Version](https://poser.pugx.org/fts/site-map/v/stable)](https://packagist.org/packages/fts/site-map)
[![Total Downloads](https://poser.pugx.org/fts/site-map/downloads)](https://packagist.org/packages/fts/site-map)
[![License](https://poser.pugx.org/fts/site-map/license)](https://packagist.org/packages/fts/site-map)

# 功能
* 构建网站site map
* 检查验证码
# 安装
    composer require fts/site-map
### 发布配置文件
     php artisan vendor:publish
### 添加服务提供者
打开 `config/app.php` 并添加以下内容到 providers 数组:
    
    fts\SiteMap\SiteMapServiceProvider.php::class
# 命令行

    php artisan site-map:build