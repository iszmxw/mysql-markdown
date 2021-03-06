# MySQL-Markdown

Mysql通过PHP脚本快速生成数据库文档，避免每次手动维护文档，只用维护好线上数据库的备注以及说明即可。

## 使用说明

> 将该脚本放到服务器中，然后通过域名或者IP进行访问即可看到效果

![效果图](/static/1.png)
![效果图](/static/2.png)
![效果图](/static/3.png)

---

**安装**

```shell script
# 安装
composer require iszmxw/mysql-markdown
```
---

## 测试

```php
<?php

require_once './vendor/autoload.php'; // 加载自动加载文件
use Iszmxw\MysqlMarkdown\Mysql;

// 配置数据库参数
$config = [
    'dbs'      => 'mysql',
    'host'     => '127.0.0.1',
    'port'     => 3306,
    'charset'  => 'utf8',
    'name'     => 'basicsapi_test',
    'user'     => 'basicsapi_test',
    'password' => 'basicsapi_test',
];
Mysql::markdown($config);
```
