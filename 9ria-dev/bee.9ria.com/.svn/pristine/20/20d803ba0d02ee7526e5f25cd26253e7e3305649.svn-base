<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
error_reporting(E_ERROR);
date_default_timezone_set('PRC');

/**
 * 微信接入验证，验证通过之后，可以注意相关验证代码
 * 在入口进行验证而不是放到框架里验证，主要是解决验证URL超时的问题
 */
//define(WEIXIN_TOKEN, 'gamecollege');
//if (!empty($_GET ['echostr']) && !empty($_GET ["signature"]) && !empty($_GET ["nonce"])) {
//    $signature = $_GET ["signature"];
//    $timestamp = $_GET ["timestamp"];
//    $nonce = $_GET ["nonce"];
//
//    $tmpArr = array(WEIXIN_TOKEN, $timestamp, $nonce);
//    sort($tmpArr, SORT_STRING);
//    $tmpStr = sha1(implode($tmpArr));
//
//    if ($tmpStr == $signature) {
//        header('Content-Length: ' . strlen($_GET['echostr']));
//        echo $_GET ["echostr"];
//    }
//    exit();
//}

/**
 * 系统调试设置
 * 项目正式部署后请设置为false
 */
define('APP_DEBUG', false);

// 网站根路径设置
define('SITE_PATH', dirname(dirname(__FILE__)));

/**
 * 应用目录设置
 */
define('APP_PATH', SITE_PATH . '/Application/');

/**
 * 缓存目录设置
 * 此目录必须可写，建议移动到非WEB目录
 */
define('RUNTIME_PATH', SITE_PATH . '/Runtime/');

// 入口绑定是指在应用的入口文件中绑定某个模块，甚至还可以绑定某个控制器和操作，用来简化URL地址的访问。
$_GET['m'] = 'Home';
$_GET['c'] = 'Weixin';

/**
 * 引入核心入口
 * ThinkPHP亦可移动到WEB以外的目录
 */
require SITE_PATH . '/ThinkPHP/ThinkPHP.php';