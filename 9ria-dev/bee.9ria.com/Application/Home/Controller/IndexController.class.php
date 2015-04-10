<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
namespace Home\Controller;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController {
    // 系统首页
    public function index() {
        redirect(U('template/index'));
        // $this->display();
    }

    // 常见问题Q&A
    public function qa() {
    	$this->display('Bee1/qa');
    }
}