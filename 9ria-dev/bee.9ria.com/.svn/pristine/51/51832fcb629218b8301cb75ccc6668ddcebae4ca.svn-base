<?php

namespace Addons\GameCollege;
use Common\Controller\Addon;

/**
 * 17173游戏学院插件
 * @author 阿炳
 */
class GameCollegeAddon extends Addon{
    public $info = array(
        'name'=>'GameCollege',
        'title'=>'17173游戏学院',
        'description'=>'17173游戏学院服务号插件',
        'status'=>1,
        'author'=>'阿炳',
        'version'=>'0.1',
        'has_adminlist'=>0,
        'type'=>1         
    );

	public function install() {
		$install_sql = ONETHINK_ADDON_PATH.'GameCollege/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = ONETHINK_ADDON_PATH.'GameCollege/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

    //实现的weixin钩子方法
    public function weixin($param){

    }

}