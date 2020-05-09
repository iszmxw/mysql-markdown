<?php
/**
 * 用于从MySQL数据库元数据生成markdown（特定于Github）的脚本
 *
 * 如何使用：
 * 将此文件放在服务器上，然后通过Web浏览器访问它。
 * 输入数据库信息，然后开始运行
 */

namespace Iszmxw\MysqlMarkdown;

class Mysql
{
    public static function markdown($config)
    {
        global $markdown;
        // 需要取出的字段
        $config['columns'] = ['Field', 'Type', 'Null', 'Key', 'Extra', 'Comment'];
        Tools::markdown_append('## 表', true);
        try {
            $dbms    = $config['dbs'] ? $config['dbs'] : 'mysql';        //数据库类型
            $host    = $config['host'];                                  //数据库主机名
            $port    = $config['port'] ? $config['port'] : 3306;         //端口
            $charset = $config['charset'] ? $config['charset'] : 'utf8'; //字符类型
            $dbName  = $config['name'];                                  //使用的数据库
            $user    = $config['user'];                                  //数据库连接用户名
            $pass    = $config['password'];                              //对应的密码
            $dsn     = "$dbms:host=$host;port=$port;dbname=$dbName;charset=$charset";
            $DB      = new \PDO($dsn, $user, $pass);
            $table   = $config['name'];
            $query   = $DB->prepare('SELECT table_name, table_comment FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = :table');
            $query->bindParam(':table', $table, \PDO::PARAM_STR);
            $query->execute();
            $tables = $query->fetchAll(\PDO::FETCH_ASSOC);
            Tools::markdown_format_table_list_markdown($tables);
            Tools::markdown_format_table_list_html($tables);
            foreach ($tables as $table) {
                $table = array_values($table)[0];
                Tools::markdown_format_table_heading_markdown($table);
                Tools::markdown_format_table_heading_html($table);
                $info_sql = 'SHOW FULL COLUMNS FROM ' . $table;
                $query    = $DB->prepare($info_sql);
                $query->execute();
                $results = $query->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($results as &$result) {
                    foreach ($result as $column_name => $column) {
                        if (@!in_array($column_name, $config['columns'])) {
                            unset($result[$column_name]);
                        }
                    }
                }
                Tools::markdown_format_table_markdown($results);
                Tools::markdown_format_table_html($results);
            }
            $now = '文档生成于：' . (new \DateTime('now'))->format('Y-m-d H:i:s');
            Tools::markdown_append($now);
            Tools::markdown_append_html($now);
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die();
        }
        Tools::markdown_result_template($markdown);
    }
}