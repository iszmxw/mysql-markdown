<?php


namespace Iszmxw\MysqlMarkdown;


class Tools
{
/**
 *
 * @param $string
 * @param bool $newline
 * @author: iszmxw <mail@54zm.com>
 * @Date：2020/4/30 18:02
 */
public static function markdown_append($string, $newline = false)
{
    global $markdown;
    $markdown .= $string;
    if ($newline) {
        $markdown .= PHP_EOL;
    }
}

/**
 *
 * @param $tables
 * @author: iszmxw <mail@54zm.com>
 * @Date：2020/4/30 18:05
 */
public static function markdown_format_table_list_markdown($tables)
{
    self::markdown_append('|表名|说明', true);
    self::markdown_append('|---|---|', true);
    foreach ($tables as $table) {
        self::markdown_append('|' . sprintf('[%s](#%s)', $table['table_name'], $table['table_name']) . '|');
        self::markdown_append($table['table_comment'] . '|', true);
    }
}

/**
 * @param array $tables List of table names
 */
public static function markdown_format_table_list_html($tables)
{
    self::markdown_append_html('<table>', true);
    self::markdown_append_html('<thead>', true);
    self::markdown_append_html('<tr><th>表名</th><th>备注</th></tr>', true);
    self::markdown_append_html('</thead>', true);

    self::markdown_append_html('<tbody>', true);
    foreach ($tables as $table) {
        self::markdown_append_html('<tr>', true);
        self::markdown_append_html('<td>' . sprintf('<a href="#%s">%s</a>', $table['table_name'], $table['table_name']) . '</td>', true);
        self::markdown_append_html('<td>' . $table['table_comment'] . '</td>', true);
        self::markdown_append_html('</tr>', true);
    }
    self::markdown_append_html('</tbody>', true);
    self::markdown_append_html('</table>', true);
}

/**
 * @param string $string
 * @param bool $newline
 */
public static function markdown_append_html($string, $newline = false)
{
    global $markdown_html;
    $markdown_html .= $string;
    if ($newline) {
        $markdown_html .= PHP_EOL;
    }
}

/**
 * @param string $table Table name
 */
public static function markdown_format_table_heading_markdown($table)
{
    self::markdown_append('', true);
    self::markdown_append('# ' . $table, true);
    self::markdown_append('', true);
}


/***
 *
 * @param $table
 * @author: iszmxw <mail@54zm.com>
 * @Date：2020/4/30 18:11
 */
public static function markdown_format_table_heading_html($table)
{
    self::markdown_append_html(sprintf('<h1 id="%s">%s</h1>', $table, $table), true);
}


/**
 * @param array $data Results from SHOW FULL COLUMNS
 */
public static function markdown_format_table_markdown($data)
{
    global $config;
    // markdown 的字段标题
    $title = array_keys($data[0]);
    //实例二：字符串替换数组键值
    $title = str_replace("Field", "字段", $title, $i);
    $title = str_replace("Type", "数据类型", $title, $i);
    $title = str_replace("Collation", "字符集", $title, $i);
    $title = str_replace("Null", "允许空值", $title, $i);
    $title = str_replace("Key", "主键", $title, $i);
    $title = str_replace("Default", "默认值", $title, $i);
    $title = str_replace("Extra", "额外（是否自动递增）", $title, $i);
    $title = str_replace("Privileges", "权限", $title, $i);
    $title = str_replace("Comment", "说明", $title, $i);
    self::markdown_append('|' . implode('|', $title) . '|', true);
    self::markdown_append('|');

    for ($i = 0; $i < count($data[0]); $i++) {
        self::markdown_append('---|');
    }

    self::markdown_append('', true);

    foreach ($data as $result) {
        self::markdown_append('|');
        foreach ($result as $column_name => $column_data) {
            if ($config['reverse_null'][0] == 1 && $column_name == "Required") {
                $column_data = $column_data == "N" ? "Y" : "N";
            }
            self::markdown_append($column_data . '|');
        }
        self::markdown_append('', true);
    }
}


/**
 *
 * @param $data
 * @author: iszmxw <mail@54zm.com>
 * @Date：2020/4/30 18:14
 */
public static function markdown_format_table_html($data)
{
    $data = self::array_rename_key($data, 'Field', '字段名称');
    $data = self::array_rename_key($data, 'Type', '数据类型');
    $data = self::array_rename_key($data, 'Null', '允许空值');
    $data = self::array_rename_key($data, 'Key', '主键');
    $data = self::array_rename_key($data, 'Extra', '额外（是否自动递增）');
    $data = self::array_rename_key($data, 'Comment', '字段说明');
    self::markdown_append_html('<table>', true);
    self::markdown_append_html('<thead>', true);
    self::markdown_append_html('<tr><th>' . implode('</th><th>', array_keys($data[0])) . '</th></tr>', true);
    self::markdown_append_html('</thead>', true);

    self::markdown_append_html('<tbody>', true);

    foreach ($data as $key => $result) {
        self::markdown_append_html('<tr>', true);

        foreach ($result as $column_key => $column_data) {
            self::markdown_append_html('<td>' . $column_data . '</td>', true);
        }

        self::markdown_append_html('</tr>', true);
    }

    self::markdown_append_html('</tbody>', true);
    self::markdown_append_html('</table>', true);
}


/**
 *
 * @param $markdown
 * @author: iszmxw <mail@54zm.com>
 * @Date：2020/4/30 18:15
 */
public static function markdown_result_template($markdown) {
global $markdown_html;
?><!DOCTYPE html>
<html>
<head>
    <title>MySQL Markdown</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#tabs a').click(function (e) {
                // e.preventDefault();
                $(this).tab('show')
            });
            $("#html_preview table").addClass("table");
        });
    </script>
</head>
<body>
<div class="container" style="margin-top:40px">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">MySQL转换Markdown文档</h2>
                </div>
                <div class="panel-body">
                    <a href="#" onclick="location.reload(true)" class="btn btn-default">重新生成</a>
                    <h3>Markdown 结果</h3>
                    <div id="tabs" role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#html_preview" role="tab" data-toggle="tab">HTML预览</a>
                            </li>
                            <li role="presentation"><a href="#markdown" role="tab" data-toggle="tab">Markdown</a></li>
                            <li role="presentation"><a href="#html" role="tab" data-toggle="tab">HTML</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="html_preview">
                                <?php echo $markdown_html ?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="markdown">
                                <textarea rows="30" class="form-control">
                                    <?php echo $markdown ?>
                                </textarea>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="html">
                                <textarea rows="30" class="form-control">
                                    <?php echo $markdown_html ?>
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php
}

/**
 * 更改键名
 * @param $array
 * @param $old_key
 * @param $new_key
 * @return mixed
 * @author: iszmxw <mail@54zm.com>
 * @Date：2020/5/9 14:19
 */
public static function array_rename_key($array, $old_key, $new_key)
{
    $array[0][$new_key] = $array[0][$old_key];
    unset($array[0][$old_key]);
    return $array;
}
}