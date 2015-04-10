<?php

namespace Addons\Community;
use Common\Controller\Addon;

/**
 * 微社区插件
 * @author 阿炳
 */
class CommunityAddon extends Addon{
    public $info = array(
        'name'=>'Community',
        'title'=>'微社区',
        'description'=>'专为微信公众平台打造的微社区',
        'status'=>0,
        'author'=>'阿炳',
        'version'=>'0.1',
        'has_adminlist'=>0,
        'type'=>1         
    );

	public function install() {
		$install_sql = ONETHINK_ADDON_PATH.'Community/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = ONETHINK_ADDON_PATH.'Community/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

    //实现的weixin钩子方法
    public function weixin($param){

    }

}