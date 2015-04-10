<?php
        	
namespace Addons\GameCollege\Model;
use Home\Model\WeixinModel;
        	
/**
 * GameCollege的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	public function reply($dataArr, $keywordArr = array()) {
        // 获取后台插件的配置参数
		$config = getAddonConfig('GameCollege');
	} 

	// 关注公众号事件
	public function subscribe() {
        // 显示topnews的文章内容(多图文回复)
        $map = array();
        $map['token'] = get_token();
        $map['keyword'] = 'topnews';
        $mult = M('custom_reply_mult')->where($map)->find();
        // 当数据不存在时，显示默认信息
        if (empty($mult)) {
            $this->replyText('欢迎您来到游戏学院的世界-_-');
            return false;
        }
        
        $map_news['id'] = array('in', $mult['mult_ids']);
        $list = M('custom_reply_news')->where($map_news)->order("FIELD(id,{$mult['mult_ids']})")->select();

        $articles = array();
        $count = 0;
        foreach ($list as $info) {
            if ($count > 8) break;
            $articles[] = array(
                'Title' => $info['title'],
                'Description' => $info['intro'],
                'PicUrl' => get_cover_url($info['cover']),
                'Url' => $this->getNewsUrl($info)
            );
            $count++;
        }

        $this->replyNews($articles);
        return true;
	}
	
	// 取消关注公众号事件
	public function unsubscribe() {
		return true;
	}
	
	// 扫描带参数二维码事件
	public function scan() {
		return true;
	}
	
	// 上报地理位置事件
	public function location() {
		return true;
	}
	
	// 自定义菜单事件
	public function click() {
		return true;
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