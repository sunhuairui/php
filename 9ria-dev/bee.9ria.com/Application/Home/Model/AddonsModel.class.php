<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
namespace Home\Model;
use Think\Model;

/**
 * 插件模型
 */
class AddonsModel extends Model {

    /**
     * 获取微信插件列表
     *
     * @param string $addon_dir        	
     */
    public function getWeixinList($isAll = false, $token_status = array(), $is_admin = false) {
        $addons = array();

        $where = array();
        $where['status'] = 1;
        $where['type'] = 1; // 1表示微信插件
        $list = $this->where($where)->select();

        $isAll || $token_status = D('Common/AddonStatus')->getList($is_admin);
        foreach ($list as $addon) {
            $addon_name = $addon['name'];
            if (!$isAll && isset($token_status[$addon_name]) && $token_status[$addon_name] < 1) {
                continue;
            }
            
            // 插件地址
            if ($addon['has_adminlist']) {
                $addon['addons_url'] = wx_addons_url($addon_name . '://' . $addon_name . '/lists');
            } elseif (file_exists(ONETHINK_ADDON_PATH . $addon_name . '/config.php')) {
                $addon['addons_url'] = wx_addons_url($addon_name . '://' . $addon_name . '/config');
            } else {
                $addon['addons_url'] = wx_addons_url($addon_name . '://' . $addon_name . '/nulldeal');
            }

            $addons[$addon_name] = $addon;
        }

        return $addons;
    }
}