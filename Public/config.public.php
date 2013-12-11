<?php
if (!defined('THINK_PATH')) exit();
return array(
    'SHOW_PAGE_TRACE' => false, // 显示页面Trace信息
    'OUTPUT_ENCODE' => true, // 页面压缩输出

    'URL_CASE_INSENSITIVE' => true,

    'LANG_SWITCH_ON' => true,  //开启语言包
    'DEFAULT_LANG' => 'zh-cn', // 默认语言

    'TMPL_L_DELIM' => '<-{',  //模板左分隔符
    'TMPL_R_DELIM' => '}->',  //模板右分隔符

    'DB_TYPE' => 'mysql',  //数据库类型
    'DB_HOST' => 'localhost',  //服务器地址
    'DB_NAME' => 'windows81',  //数据库名
    'DB_USER' => 'root',  //用户名
    'DB_PWD' => 'jilexingqiu',  //密码
    'DB_PORT' => '3306',  //端口
    'DB_PREFIX' => 'windows8_',  //数据库表前缀

    'UPLOAD_PATH' => './Upload', //文件上传地址
    'TMPL_PARSE_STRING'  =>array(
        '__UPLOAD__' => __ROOT__ . '/Upload',
    ),

    'WB_AKEY' => '321965248',

);