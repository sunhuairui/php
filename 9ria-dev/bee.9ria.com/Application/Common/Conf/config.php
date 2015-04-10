<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return array(
    /* 模块相关配置 */
    'AUTOLOAD_NAMESPACE' => array('Addons' => ONETHINK_ADDON_PATH), //扩展模块列表
    'DEFAULT_MODULE' => 'Home',
    'MODULE_DENY_LIST' => array('Common', 'User'),
    //'MODULE_ALLOW_LIST'  => array('Home','Admin'),

    /* 系统数据加密设置 */
    'DATA_AUTH_KEY' => 'QOne30VNPoY&-dwH7/}G6E`]RzisWJx,1|_#q.4t', //默认数据加密KEY

    /* 调试配置 */
    'SHOW_PAGE_TRACE' => true,
    /* 用户相关设置 */
    'USER_MAX_CACHE' => 1000, //最大缓存用户数
    'USER_ADMINISTRATOR' => 1, //管理员用户ID

    /* URL配置 */
    'URL_CASE_INSENSITIVE' => false, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL' => 3, //URL模式
    'VAR_URL_PARAMS' => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR' => '/', // PATHINFO URL分割符
    'URL_PARAMS_BIND' => true, // URL变量绑定到Action方法参数
    'URL_PARAMS_BIND_TYPE' => 0, // URL变量绑定的类型 0 按变量名绑定 1 按变量顺序绑定
    /* 全局过滤配置 */
    //'DEFAULT_FILTER' => '', //全局过滤函数

    /* 数据库配置 */
    'DB_TYPE' => 'mysqli', // 数据库类型
    'DB_HOST' => '127.0.0.1', // 服务器地址
    'DB_NAME' => 'manong', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => '', // 密码
    'DB_PORT' => '3306', // 端口
    'DB_PREFIX' => 'wp_', // 数据库表前缀
    'VAR_SESSION_ID' => 'bee_sid',     //sessionID的提交变量
    
    /* REDIS配置 */
    'REDIS_HOST'=>'10.127.129.219',
    'REDIS_PORT'=>'6379',
    'REDIS_PASSWORD'=>'L2H8765!%&Kjds',
    /* 文档模型配置 (文档模型核心配置，请勿更改) */
    'DOCUMENT_MODEL_TYPE' => array(2 => '主题', 1 => '目录', 3 => '段落'),
    /* 日志的处理工作是由系统自动进行的，在开启日志记录的情况下，会记录下允许的日志级别的所有日志信息。 */
    'LOG_RECORD' => true, // 开启日志记录
    'LOG_LEVEL' =>'EMERG,ALERT,CRIT,ERR', // 只记录EMERG ALERT CRIT ERR 错误
    'LOG_TYPE' =>  'File', // 日志记录类型 默认为文件方式
);