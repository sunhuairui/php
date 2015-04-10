<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

/**
 * 系统调试设置
 * 项目正式部署后请设置为false
 */
define('APP_DEBUG', false);
define('BIND_MODULE', 'Admin');

// development, testing, production
//define('APP_STATUS', 'development');
define('APP_STATUS', 'testing');

// 网站根路径设置
define('SITE_PATH', dirname(dirname(__FILE__)));
/**
 * 应用目录设置
 * 安全期间，建议安装调试完成后移动到非WEB目录
 */
define('APP_PATH', SITE_PATH . '/Application/');
if (!is_file(APP_PATH . 'User/Conf/config.php')) {
    header('Location: ./install.php');
    exit();
}

/**
 * 缓存目录设置
 * 此目录必须可写，建议移动到非WEB目录
 */
define('RUNTIME_PATH', SITE_PATH . '/Runtime/');

/**
 * 引入核心入口
 * ThinkPHP亦可移动到WEB以外的目录
 */
require SITE_PATH . '/ThinkPHP/ThinkPHP.php';