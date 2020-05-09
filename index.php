<?php

require_once './vendor/autoload.php'; // 加载自动加载文件
use Iszmxw\MysqlMarkdown\Mysql;

$config = [
    'host'     => '127.0.0.1',
    'name'     => 'basicsapi_test',
    'user'     => 'basicsapi_test',
    'password' => 'basicsapi_test',
];
// 需要取出的字段
$config['columns'] = [
    'Field',
    'Type',
    'Null',
    'Key',
    'Key',
    'Extra',
    'Comment',
];
Mysql::markdown($config);