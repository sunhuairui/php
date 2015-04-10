<?php

namespace Addons\GameCollege\Controller;
use Addons\GameCollege\Controller\BaseController;

class GameCollegeController extends BaseController {
    // 微官网配置
    public function config() {
        // 使用提示
        $normal_tips = '在这里可以配置17173游戏学院插件';
        $this->assign('normal_tips', $normal_tips);

        if (IS_POST) {
            $flag = D('Common/AddonConfig')->set(_ADDONS, $_POST['config']);
            if ($flag !== false) {
                $this->success('保存成功', Cookie('__forward__'));
            } else {
                $this->error('保存失败');
            }
            
            exit();
        }

        parent::config();
    }    
}
