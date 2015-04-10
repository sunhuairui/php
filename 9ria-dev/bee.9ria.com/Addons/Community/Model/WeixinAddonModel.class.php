<?php
        	
namespace Addons\Community\Model;
use Home\Model\WeixinModel;
        	
/**
 * Community的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	public function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ('Community'); // 获取后台插件的配置参数	
		//dump($config);
	}
}    	