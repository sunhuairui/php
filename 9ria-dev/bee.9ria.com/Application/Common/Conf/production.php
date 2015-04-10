<?php

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return array(
    /* 数据库配置 */
    'DB_TYPE' => 'mysqli',              // 数据库类型
    'DB_HOST' => '10.127.65.219',       // 服务器地址
    'DB_NAME' => 'kingda_bee',       // 数据库名
    'DB_USER' => 'root',              // 用户名
    'DB_PWD' => '9ria888!',       // 密码
    'DB_PORT' => '3306',                // 端口
    'DB_PREFIX' => 'wp_',               // 数据库表前缀
    
    /* REDIS配置 */
    'REDIS_HOST'=>'10.127.131.192',
    'REDIS_PORT'=>'6379'
);