<?php
//
//require_once './vendor/autoload.php'; // 加载自动加载文件
//use Iszmxw\MysqlMarkdown\Mysql;
//
//// 配置数据库参数
//$config = [
//    'dbs'      => 'mysql',
//    'host'     => '127.0.0.1',
//    'port'     => 3306,
//    'charset'  => 'utf8',
//    'name'     => 'basicsapi_test',
//    'user'     => 'basicsapi_test',
//    'password' => 'basicsapi_test',
//];
//Mysql::markdown($config);
require_once './vendor/autoload.php'; // 加载自动加载文件
use Iszmxw\MysqlMarkdown\Mysql;

// 配置数据库参数
$config = [
    'dbs'      => 'mysql',
    'host'     => '10.10.10.115',
    'port'     => 3306,
    'charset'  => 'utf8',
    'name'     => 'tftpay',
    'user'     => 'yjt',
    'password' => 'Yjt@2019',
];

$result = [];
Mysql::markdown($config);
