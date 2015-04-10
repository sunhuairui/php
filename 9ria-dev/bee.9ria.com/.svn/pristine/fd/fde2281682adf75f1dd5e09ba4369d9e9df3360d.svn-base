<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------        	

namespace Addons\Coupon\Model;
use Home\Model\WeixinModel;

/**
 * Coupon的微信模型
 */
class WeixinAddonModel extends WeixinModel {
    public function reply($dataArr, $keywordArr = array()) {
        $map = array();
        $map['token'] = get_token();
        $keywordArr['aim_id'] && $map['id'] = $keywordArr['aim_id'];
        $data = M('coupon')->where($map)->find();

        // 其中token和openid这两个参数一定要传，否则程序不知道是哪个微信用户进入了系统
        $param['token'] = get_token();
        $param['openid'] = get_openid();
        $param['id'] = $data['id'];
        $url = wx_addons_url('Coupon://Coupon/prev', $param);

        $articles [0] = array(
            'Title' => $data ['title'],
            'Url' => $url
        );

        $now = time();
        if (empty($data ['end_time']) || $data ['end_time'] > $now) {
            $articles [0] ['Description'] = $data ['intro'];
            $articles [0] ['PicUrl'] = !empty($data ['cover']) ? get_cover_url($data ['cover']) : SITE_URL . '/Addons/Coupon/View/default/Public/cover_pic.jpg';
        } else {
            $articles [0] ['Description'] = $data ['end_tips'];
            $articles [0] ['PicUrl'] = !empty($data ['end_cover']) ? get_cover_url($data ['end_cover']) : SITE_URL . '/Addons/Coupon/View/default/Public/cover_pic_over.png';
        }

        $this->replyNews($articles);
    }
}