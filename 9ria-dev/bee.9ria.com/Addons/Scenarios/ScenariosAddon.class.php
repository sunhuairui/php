<?php

namespace Addons\Scenarios;
use Common\Controller\Addon;

/**
 * 场景应用插件
 * @author 无名
 */

    class ScenariosAddon extends Addon{

        public $info = array(
            'name'=>'Scenarios',
            'title'=>'场景应用',
            'description'=>'场景应用配置后台',
            'status'=>1,
            'author'=>'无名',
            'version'=>'0.1'
        );

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }


    }