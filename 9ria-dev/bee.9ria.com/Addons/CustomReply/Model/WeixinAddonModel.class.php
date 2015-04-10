<?php

namespace Addons\CustomReply\Model;
use Home\Model\WeixinModel;

/**
 * CustomReply的微信模型
 */
class WeixinAddonModel extends WeixinModel {
    public function reply($dataArr, $keywordArr = array()) {
        $map = array();
        $map['id'] = $keywordArr['aim_id'];
        if ($keywordArr['extra_text'] == 'custom_reply_mult') {
            // 多图文回复
            $mult = M('custom_reply_mult')->where($map)->find();
            $map_news['id'] = array('in', $mult['mult_ids']);
            $list = M('custom_reply_news')->where($map_news)->order("FIELD(id,{$mult['mult_ids']})")->select();

            $articles = array();
            $count = 0;
            foreach ($list as $info) {
                if ($count > 8) break;
                $articles[] = array(
                    'Title' => $info ['title'],
                    'Description' => $info ['intro'],
                    'PicUrl' => get_cover_url($info ['cover']),
                    'Url' => $this->getNewsUrl($info)
                );
                $count++;
            }

            $res = $this->replyNews($articles);
        } elseif ($keywordArr['extra_text'] == 'custom_reply_news') {
            // 单条图文回复
            $info = M('custom_reply_news')->where($map)->find();
            // 组装微信需要的图文数据，格式是固定的
            $articles[0] = array(
                'Title' => $info ['title'],
                'Description' => $info ['intro'],
                'PicUrl' => get_cover_url($info ['cover']),
                'Url' => $this->getNewsUrl($info)
            );

            $res = $this->replyNews($articles);
        } else {
            // 增加积分
            add_credit('custom_reply', 300);

            // 文本回复
            $info = M('custom_reply_text')->where($map)->find();
            $this->replyText(htmlspecialchars_decode($info ['content']));
        }
    }

    private function getNewsUrl($info) {
        // 如果已经包含了跳转地址，则使用跳转地址
        if (!empty($info['jump_url'])) {
            $url = $info['jump_url'];
        } else {
            $param['id'] = $info['id'];
            $param['token'] = get_token();
            $param['openid'] = get_openid();
            $url = wx_addons_url('CustomReply://CustomReply/detail', $param);
        }
        return $url;
    }
}