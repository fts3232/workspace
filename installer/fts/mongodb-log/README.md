# mongodb-log
[![Latest Stable Version](https://poser.pugx.org/fts/mongodb-log/v/stable)](https://packagist.org/packages/fts/mongodb-log)
[![Total Downloads](https://poser.pugx.org/fts/mongodb-log/downloads)](https://packagist.org/packages/fts/mongodb-log)
[![License](https://poser.pugx.org/fts/mongodb-log/license)](https://packagist.org/packages/fts/mongodb-log)

# 功能
* 使用mongodb记录日志
* 入mongodb链接不上，日志使用file
# 安装
    composer require fts/mongodb-log
### 添加服务提供者
打开 `config/app.php` 并添加以下内容到 providers 数组:
    
    fts\MongoDBLog\LogServiceProvider.php::class