<?php

require_once './vendor/autoload.php'; // 加载自动加载文件
use Iszmxw\MysqlMarkdown\Mysql;

// 配置数据库参数
$config = [
    'dbs'      => 'mysql',
    'host'     => '192.168.26.134',
    'port'     => 3306,
    'charset'  => 'utf8',
    'name'     => 'basicsapi_test',
    'user'     => 'root',
    'password' => 'root',
];
Mysql::markdown($config);
