<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------

namespace Addons\CustomMenu\Model;

use Home\Model\WeixinModel;

/**
 * CustomMenu的微信模型
 */
class WeixinAddonModel extends WeixinModel {
    public function reply($dataArr, $keywordArr = array()) {
        $config = getAddonConfig('CustomMenu'); // 获取后台插件的配置参数
        // dump($config);
    }

    // 自定义菜单连接事件
    public function view($data) {
        redirect($data['EventKey']);
    }
}