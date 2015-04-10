<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
error_reporting(E_ERROR);
date_default_timezone_set('PRC');
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
    die('Your PHP Version is ' . PHP_VERSION . ', But require PHP > 5.3.0 !');
}

echo 'PHP version ok<br/>';

