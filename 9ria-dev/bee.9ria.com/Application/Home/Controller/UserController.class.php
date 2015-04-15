<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------

namespace Home\Controller;

use User\Api\UserApi;

/**
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class UserController extends HomeController {
    /* 用户中心首页 */

    public function index() {
        
    }

    /* 注册页面 */
    public function register($username = '', $password = '', $repassword = '', $email = '', $verify = '') {
        if (!C('USER_ALLOW_REGISTER')) {
            $this->error('注册已关闭');
        }
        if (IS_POST) { // 注册用户
            /* 检测验证码 */
            if (!check_verify($verify)) {
                $this->error('验证码输入错误！');
            }

            /* 检测密码 */
            if ($password != $repassword) {
                $this->error('密码和重复密码不一致！');
            }

            /* 调用注册接口注册用户 */
            $User = new UserApi ();
            $uid = $User->register($username, $password, $email);
            if (0 < $uid) { // 注册成功
                // TODO: 发送验证邮件
                // 关联默认可管理的公众号
                $public = C('DEFAULT_PUBLIC');
                $publicArr = array_filter(explode(',', $public));
                foreach ($publicArr as $p) {
                    $data ['uid'] = $uid;
                    $data ['mp_id'] = $p;
                    M('member_public_link')->add($data);
                }

                $this->success('注册成功，请登录', U('login'));
            } else { // 注册失败，显示错误信息
                $this->error($this->showRegError($uid));
            }
        } else { // 显示注册表单
            $this->display();
        }
    }


    public function ajaxregister($username = '', $password = '', $email = '', $brand_name='', $mobile = '', $category = '' ) {
        if (!C('USER_ALLOW_REGISTER')) {
            $this->error('注册已关闭');
        }
        if (IS_POST) { // 注册用户
            /* 检测验证码 */
            preg_match('/^1[358]\d{9}$/', $mobile, $matchs);
            if(empty($matchs)){
                $this->error('手机号填写错误');
            }


            /* 调用注册接口注册用户 */
            $User = new UserApi ();
            $uid = $User->register($username, $password, $email, $mobile, $brand_name, $category);
            if (0 < $uid) { // 注册成功
                // TODO: 发送验证邮件
                // 关联默认可管理的公众号
                $public = C('DEFAULT_PUBLIC');
                $publicArr = array_filter(explode(',', $public));
                foreach ($publicArr as $p) {
                    $data ['uid'] = $uid;
                    $data ['mp_id'] = $p;
                    M('member_public_link')->add($data);
                }

                $this->success('注册成功，请登录', U('login'));
            } else { // 注册失败，显示错误信息
                $this->error($this->showRegError($uid));
            }
        } else { // 显示注册表单
            $this->error('请求失败');
        }
    }

    /* 登录页面 */
    public function login($username = '', $password = '', $verify = '', $remember = '') {
        if (IS_POST) { // 登录验证
            /* 检测验证码 */
            if (C('WEB_SITE_VERIFY') && !check_verify($verify)) {
                $this->error('验证码输入错误！');
            }

            /* 调用UC登录接口登录 */
            $user = new UserApi();
            $uid = $user->login($username, $password);
            if (0 < $uid) { // UC登录成功
                /* 登录用户 */
                $Member = D('Member');
                if ($Member->login($uid, $remember == 'on')) { // 登录用户
                    $url = Cookie('__forward__');
                    if ($url) {
                        Cookie('__forward__', null);
                    } else {
                        $url = U('home/index/index');
                    }

                    session('is_follow_login', null);
                    $this->success('登录成功！', $url);
                } else {
                    $this->error($Member->getError());
                }
            } else { // 登录失败
                switch ($uid) {
                case - 1 :
                    $error = '用户不存在或被禁用！';
                    break; // 系统级别禁用
                case - 2 :
                    $error = '密码错误！';
                    break;
                default :
                    $error = '未知错误！';
                    break; // 0-接口参数错误（调试阶段使用）
                }
                $this->error($error);
            }
        } else { // 显示登录表单
            $html = 'login';
            $_GET['from'] == 'store' && $html = 'simple_login';
            $this->display($html);
        }
    }

    public function newlogin() {
        if(is_login()){
            redirect(U('project/view'));
        }else{
            $this->display();
        }
    }

    /*新版登录*/
    public function ajaxlogin($username, $password, $remember = ''){
        if(IS_POST){
            $user = new UserApi ();
            $uid = $user->login($username, $password, 2);
            if (0 < $uid) { // UC登录成功
                /* 登录用户 */
                $Member = D('Member');
                if ($Member->login($uid, $remember == 'on')) { // 登录用户
                    $url = Cookie('__forward__');
                    if ($url) {
                        Cookie('__forward__', null);
                    } else {
                        $url = U('home/index/index');
                    }

                    session('is_follow_login', null);
                    $this->success('登录成功！', $url);
                } else {
                    $this->error($Member->getError());
                }
            } else { // 登录失败
                switch ($uid) {
                case - 1 :
                    $error = '用户不存在或被禁用！';
                    break; // 系统级别禁用
                case - 2 :
                    $error = '密码错误！';
                    break;
                default :
                    $error = '未知错误！';
                    break; // 0-接口参数错误（调试阶段使用）
                }
                $this->error($error);
            }
        } else {
            $this->error('请求失败');
        }
    }

    /* 退出登录 */
    public function logout() {
        if (is_login()) {
            D('Member')->logout();
            $this->redirect('template/index');
        } else {
            $this->redirect('User/newlogin');
        }
    }

    public function ajaxlogout() {
        if (is_login()) {
            D('Member')->logout();
        }
        // 退出后，默认跳转到模板页面
        $this->success('退出成功！', U('User/newlogin'));
    }

    /* 验证码，用于登录和注册 */

    public function verify() {
        $verify = new \Think\Verify ();
        $verify->entry(1);
    }

    /**
     * 获取用户注册错误信息
     *
     * @param integer $code
     *        	错误编码
     * @return string 错误信息
     */
    private function showRegError($code = 0) {
        switch ($code) {
        case -1 :
            $error = '用户名长度必须在16个字符以内！';
            break;
        case -2 :
            $error = '用户名被禁止注册！';
            break;
        case -3 :
            $error = '用户名被占用！';
            break;
        case -4 :
            $error = '密码长度必须在6-30个字符之间！';
            break;
        case -5 :
            $error = '邮箱格式不正确！';
            break;
        case -6 :
            $error = '邮箱长度必须在1-32个字符之间！';
            break;
        case -7 :
            $error = '邮箱被禁止注册！';
            break;
        case -8 :
            $error = '邮箱被占用！';
            break;
        case -9 :
            $error = '手机格式不正确！';
            break;
        case -10 :
            $error = '手机被禁止注册！';
            break;
        case -11 :
            $error = '手机号被占用！';
            break;
        default :
            $error = '未知错误';
        }
        return $error;
    }

    /**
     * 修改密码提交
     */
    public function profile() {
        if (!is_login()) {
            $this->error('您还没有登陆', U('User/newlogin'));
        }
        
        if (IS_POST) {
            // 获取参数
            $uid = is_login();
            $password = I('post.old');
            $repassword = I('post.repassword');
            $data ['password'] = I('post.password');
            empty($password) && $this->error('请输入原密码');
            empty($data ['password']) && $this->error('请输入新密码');
            empty($repassword) && $this->error('请输入确认密码');

            if ($data ['password'] !== $repassword) {
                $this->error('您输入的新密码与确认密码不一致');
            }

            $Api = new UserApi ();
            $res = $Api->updateInfo($uid, $password, $data);
            if ($res ['status']) {
                $this->success('修改密码成功！');
            } else {
                $this->error($res ['info']);
            }
        } else {
            $this->display();
        }
    }

    public function relogin(){
        if(is_login()){
            D('Member')->logout();
        }
        echo U('User/newlogin');
        Header("HTTP/1.1 301 Moved Permanently");
        Header("Location: http://". $_SERVER['HTTP_HOST']  . U('User/newlogin'));
    }

    public function resetpwd() {
        if (!is_login()) {
            $this->error('您还没有登陆', U('User/newlogin'));
        }
        $this->assign("meta_title","修改密码");
        $this->display();
    }

    public function accountinfo(){
        if (!is_login()) {
            $this->error('您还没有登陆', U('User/newlogin'));
        }

        $uid = $this->user['uid'];

        $ret = array();

        $member = D('ucenter_member');
        $user = $member->where(array('id'=>$uid, 'status'=>1))->find();
        if(empty($user)){
            $this->error('用户不存在', U('User/newlogin'));
        }

        $ret =  array(
                'username'=>$user['username'],
                'category'=>$user['category'],
                'brand_name'=>$user['brand_name'],
                'mobile'=>$user['mobile']
            );

        $account =  D('account_info');

        $info = $account->where(array('uid'=>$uid, 'status'=>1))->find();

        if(is_array($info)){
            $ret = array_merge($ret, $info);
        }
        $this->assign("meta_title","账户资料设置");
        $this->assign("info", $ret);

        $this->display();
    }

    public function updateaccountinfo(){
        if(!is_login()){
            $this->error('您还没有登陆', U('User/newlogin'));
        }
        $uid = $this->user['uid'];
        $username = I('post.username');
        $category = I('post.category');
        $brand_name = I('post.brand_name');
        $mobile = I('post.mobile');        
        $contact = I('post.contact');
        $city = I('post.city');
        $turnover = I('post.turnover');
        $production = I('post.production');
        $qq = I('post.qq');
        $wechat = I('post.wechat');
        $customer = I('post.customer');
        $remarks = I('post.remarks'); 
               
        $member = D('ucenter_member');        
        $user = $member->where(array("id"=>$uid, "status"=>1))->find();
        if($user){
            $member->username = $username;
            $member->category = $category;
            $member->brand_name = $brand_name;
            $member->mobile = $mobile;
            $member->update_time = time();
            $res = $member->save();
        }else{
            $this->ajaxReturn(array("error"=>1,"message"=>"用户不存在"));
        }

        if(!$res){
            $this->ajaxReturn(array("error"=>1,"message"=>"更新数据错误"));
        }

        $account =  D('account_info');
        $accountinfo = $account->where(array("uid"=>$uid, "status"=>1))->find();

        if($accountinfo){
            $account->contact = $contact;
            $account->city = $city;
            $account->turnover = $turnover;
            $account->production = $production;
            $account->qq = $qq;
            $account->wechat = $wechat;
            $account->customer = $customer;
            $account->remarks = $remarks;
            $account->update_time = time();
            $res = $account->save();
        }else{
            $res = $account->add(
                    array(
                            "uid"=>$uid,
                            "contact"=>$contact,
                            "city"=>$city,
                            "turnover"=>$turnover,
                            "production"=>$production,
                            "qq"=>$qq,
                            "wechat"=>$wechat,
                            "customer"=>$customer,
                            "remarks"=>$remarks,
                            "status"=>1,
                            "create_time"=>time(),
                            "update_time"=>0
                        )
                );
        }

        if(!$res){
            $this->ajaxReturn(array("error"=>1,"message"=>"更新数据错误"));
        }

        $this->ajaxReturn(array("success"=>1,"message"=>"保存信息成功！"));
    }
}
