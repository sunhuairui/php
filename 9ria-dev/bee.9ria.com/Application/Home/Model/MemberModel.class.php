<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
namespace Home\Model;

use Think\Model;
use User\Api\UserApi;

/**
 * 文档基础模型
 */
class MemberModel extends Model {
    /* 用户模型自动完成 */

    protected $_auto = array(
        array('login', 0, self::MODEL_INSERT),
        array('reg_ip', 'get_client_ip', self::MODEL_INSERT, 'function', 1),
        array('reg_time', NOW_TIME, self::MODEL_INSERT),
        array('last_login_ip', 0, self::MODEL_INSERT),
        array('last_login_time', 0, self::MODEL_INSERT),
        array('update_time', NOW_TIME),
        array('status', 1, self::MODEL_INSERT)
    );

    /**
     * 登录指定用户
     *
     * @param integer $uid
     *        	用户ID
     * @return boolean ture-登录成功，false-登录失败
     */
    public function login($uid, $remember = false) {
        /* 检测是否在当前应用注册 */
        $user = $this->field(true)->find($uid);
        if (!$user) { // 未注册
            /* 在当前应用中注册用户 */
            $Api = new UserApi ();
            $info = $Api->info($uid);
            $user = $this->create(array(
                'nickname' => $info [1],
                'status' => 1
            ));
            $user['uid'] = $uid;
            if (!$this->add($user)) {
                $this->error = '前台用户信息注册失败，请重试！';
                return false;
            }
        } elseif (1 != $user ['status']) {
            $this->error = '用户未激活或已禁用！'; // 应用级别禁用
            return false;
        }

        /* 登录用户 */
        $this->autoLogin($user, $remember);

        // 记录行为
        action_log('user_login', 'member', $uid, $uid);

        return true;
    }

    /**
     * 注销当前用户
     *
     * @return void
     */
    public function logout() {
        session('mid', null);
        session('user_auth', null);
        session('user_auth_sign', null);
        session('token', null);
        session('openid', null);
        session('is_follow_login', null);
        cookie('logged_user', null);
    }

    /**
     * 自动登录用户
     *
     * @param integer $user
     *        	用户信息数组
     */
    public function autoLogin($user, $remember = false) {
        /* 更新登录信息 */
        $data = array(
            'uid' => $user['uid'],
            'login' => array('exp','`login`+1'),
            'last_login_time' => NOW_TIME,
            'last_login_ip' => get_client_ip(1)
        );
        $this->save($data);

        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid' => $user['uid'],
            'username' => get_username($user['uid']),
            'last_login_time' => $data['last_login_time']
        );

        session('mid', $user ['uid']);
        session('user_auth', $auth);
        session('user_auth_sign', data_auth_sign($auth));
        if ($remember) {
        	$token = build_auth_key();
        	$user1 = D('user_token')->where('uid=' . $user['uid'])->find();
        	$data['token'] = $token;
        	$data['time'] = time();;
        	if ($user1 == null) {
        		$data['uid'] = $user['uid'];
        		D('user_token')->add($data);
        	} else {
        		D('user_token')->where('uid=' . $user['uid'])->save($data);
        	}
        }
        
        if (!$this->getCookieUid() && $remember) {
        	// 默认保存一周
        	$expire = 3600 * 24 * 7;
        	cookie('logged_user', $this->auth_encode($this->change() . ".{$user['uid']}.{$token}"), $expire);
        }
    }
    
    public function need_login() {
    	if ($uid = $this->getCookieUid()) {
    		$this->login($uid);
    		return true;
    	}
    }
    
    // 获取缓存的uid
    public function getCookieUid() {
    	static $cookie_uid = null;
    	if (isset($cookie_uid) && $cookie_uid !== null) {
    		return $cookie_uid;
    	}
    	
    	$cookie = cookie('logged_user');
    	$cookie = explode(".", $this->auth_decode($cookie));
    	$map['uid'] = $cookie[1];
    	$user = D('user_token')->where($map)->find();
    	$cookie_uid = ($cookie[0] != $this->change()) || ($cookie[2] != $user['token']) ? false : $cookie[1];
    	$cookie_uid = ($user['time'] - time() >= 3600 * 24 * 7) ? false : $cookie_uid;
    	return $cookie_uid;
    }
    
    /**
     * 加密函数
     * @param string $txt 需加密的字符串
     * @param string $key 加密密钥，默认读取SECURE_CODE配置
     * @return string 加密后的字符串
     */
    private function auth_encode($txt, $key = null) {
    	empty($key) && $key = $this->change();
    
    	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=_";
    	$nh = rand(0, 64);
    	$ch = $chars[$nh];
    	$mdKey = md5($key . $ch);
    	$mdKey = substr($mdKey, $nh % 8, $nh % 8 + 7);
    	$txt = base64_encode($txt);
    	$tmp = '';
    	$i = 0;
    	$j = 0;
    	$k = 0;
    	for ($i = 0; $i < strlen($txt); $i++) {
    		$k = $k == strlen($mdKey) ? 0 : $k;
    		$j = ($nh + strpos($chars, $txt [$i]) + ord($mdKey[$k++])) % 64;
    		$tmp .= $chars[$j];
    	}
    	return $ch . $tmp;
    }
    
    /**
     * 解密函数
     * @param string $txt 待解密的字符串
     * @param string $key 解密密钥，默认读取SECURE_CODE配置
     * @return string 解密后的字符串
     */
    private function auth_decode($txt, $key = null) {
    	empty($key) && $key = $this->change();
    
    	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=_";
    	$ch = $txt[0];
    	$nh = strpos($chars, $ch);
    	$mdKey = md5($key . $ch);
    	$mdKey = substr($mdKey, $nh % 8, $nh % 8 + 7);
    	$txt = substr($txt, 1);
    	$tmp = '';
    	$i = 0;
    	$j = 0;
    	$k = 0;
    	for ($i = 0; $i < strlen($txt); $i++) {
    		$k = $k == strlen($mdKey) ? 0 : $k;
    		$j = strpos($chars, $txt[$i]) - $nh - ord($mdKey[$k++]);
    		while ($j < 0) {
    			$j += 64;
    		}
    		$tmp .= $chars[$j];
    	}
    
    	return base64_decode($tmp);
    }
    
    private function change() {
    	preg_match_all('/\w/', C('DATA_AUTH_KEY'), $sss);
    	$str1 = '';
    	foreach ($sss[0] as $v) {
    		$str1 .= $v;
    	}
    	return $str1;
    }

    /**
     * 获取用户全部信息
     */
    public function getMemberInfo($uid) {
        static $_memberInfo;
        if (isset($_memberInfo [$uid])) {
            return $_memberInfo [$uid];
        }

        $_memberInfo [$uid] = $this->find($uid);
        return $_memberInfo [$uid];
    }

}
