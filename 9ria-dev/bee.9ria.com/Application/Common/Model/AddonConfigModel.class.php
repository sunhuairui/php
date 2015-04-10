<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
namespace Common\Model;
use Think\Model;

/**
 * 插件配置操作集成
 */
class AddonConfigModel extends Model {
    // 操作addons表
    protected $tableName = 'addons';

    /**
     * 保存配置到该微信公众号下面
     */
    function set($addon, $config) {
        $map = array();
        $map['token'] = get_token();
        if (empty($map['token'])) return false;
        
        $info = M('member_public')->where($map)->find();
        if (!$info) {
            $map['uid'] = session('mid');
            $map['addon_config'] = json_encode(array($addon=>$config));
            $flag = M('member_public')->add($map);
        } else {
            $addon_config = json_decode($info ['addon_config'], true);
            $addon_config[$addon] = $config;
            $flag = M('member_public')->where($map)->setField('addon_config', json_encode($addon_config));
        }

        return $flag;
    }

    /**
     * 获取插件配置
     * 获取的优先级：当前公众号设置》后台默认配置》安装文件上的配置
     */
    function get($addon) {
        // 当前公众号的设置
        $token_config = M('member_public')->where(array('token'=> get_token()))->getField('addon_config');
        $token_config = json_decode($token_config, true);
        $token_config = (array) $token_config[$addon];

        // 后台默认的配置
        $addon = M('Addons')->where(array('name'=>$addon))->find();
        $addon_config = (array) json_decode($addon['config'], true);
        
        // 安装文件上的配置
        $file_config = array();
        $file = ONETHINK_ADDON_PATH . $addon . '/config.php';
        if (file_exists($file)) {
            $file_config = include $file;
        }

        return array_merge($file_config, $addon_config, $token_config);
    }
}