<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------

namespace Home\Controller;
use Common\Controller\Controller;

/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class HomeController extends Controller {

    protected $mid = 0;
    protected $uid = 0;
    protected $user = array();
    protected $top_more_button = array();

    // 空操作，用于输出404页面
    public function _empty() {
        $this->redirect('Index/index');
    }

    //初始化操作
    protected function _initialize() {
        $this->initSite();
        $this->initUser();
    }

    /**
     * 应用信息初始化
     *
     * @access private
     * @return void
     */
    private function initSite() {
        /* 读取数据库中的配置 */
        $config = S('DB_CONFIG_DATA');
        if (!$config) {
            $config = api('Config/lists');
            S('DB_CONFIG_DATA', $config);
        }
        C($config); // 添加配置
        if (!C('WEB_SITE_CLOSE')) {
            $this->error('站点已经关闭，请稍后访问~');
        }

        // 通用表单的控制开关
        $this->assign('add_button', true);
        $this->assign('del_button', true);
        $this->assign('search_button', true);
        $this->assign('check_all', true);
        $this->assign('top_more_button', $this->top_more_button);

        // js,css的版本
        if (APP_DEBUG) {
            defined('SITE_VERSION') or define('SITE_VERSION', time());
        } else {
            defined('SITE_VERSION') or define('SITE_VERSION', C('SYSTEM_UPDATRE_VERSION'));
        }

        // 版权信息
        $this->assign('system_copy_right', C('COPYRIGHT'));
    }

    /**
     * 系统管理员信息初始化
     *
     * @access private
     * @return void
     */
    private function initUser() {
        $is_follow_login = session('is_follow_login');
        if ($is_follow_login == 1) {
            return true;
        }

        $user = session('user_auth');
        // 当前登录者
        $GLOBALS['mid'] = $this->mid = intval($user ['uid']);
        $GLOBALS['user'] = $this->user = $user;

        // 当前访问对象的uid
        $GLOBALS['uid'] = $this->uid = intval($_REQUEST ['uid'] == 0 ? $this->mid : $_REQUEST ['uid'] );
        $this->assign('mid', $this->mid); // 登录者
        $this->assign('uid', $this->uid); // 访问对象
    }

    /* 用户登录检测 */
    protected function login() {
        /* 用户登录检测 */
        is_login() || $this->error('您还没有登录，请先登录！', U('User/login'));
    }
    
    // 是否是超级管理员
    protected function isAdmin() {
    	return $this->mid == 1 ? true : false;
    }
    
    protected function ajaxOutput($data, $code=0, $msg='success') {
        $res = array();
        $res['code'] = $code;
        $res['msg'] = $msg;
        $res['data'] = $data;
        $this->ajaxReturn($res);
    }
}