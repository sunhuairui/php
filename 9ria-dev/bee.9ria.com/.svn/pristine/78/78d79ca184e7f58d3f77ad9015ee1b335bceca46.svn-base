<?php

namespace Addons\GameCollege\Controller;
use Home\Controller\AddonsController;

class BaseController extends AddonsController {
    protected $config;

    protected function _initialize() {
        parent::_initialize();
        $controller = strtolower(_CONTROLLER);
        $nav = array();
        
        $res = array();
        $res['title'] = '游戏学院设置';
        $res['url'] = wx_addons_url('GameCollege://GameCollege/config');
        $res['class'] = $controller == 'gamecollege' ? 'current' : '';
        $nav[] = $res;

        $res['title'] = '分类管理';
        $res['url'] = wx_addons_url('GameCollege://Category/lists');
        $res['class'] = $controller == 'category' ? 'current' : '';
        $nav[] = $res;
        
        $res['title'] = '游戏App';
        $res['url'] = wx_addons_url('GameCollege://Game/lists');
        $res['class'] = $controller == 'game' ? 'current' : '';
        $nav[] = $res;

        $res['title'] = '学习教程';
        $res['url'] = wx_addons_url('GameCollege://Study/lists');
        $res['class'] = $controller == 'study' ? 'current' : '';
        $nav[] = $res;
        
        $res['title'] = '幻灯片管理';
        $res['url'] = wx_addons_url('GameCollege://Slide/lists');
        $res['class'] = $controller == 'slide' ? 'current' : '';
        $nav[] = $res;
        
        $res['title'] = '官方资讯';
        $res['url'] = wx_addons_url('GameCollege://News/lists');
        $res['class'] = $controller == 'news' ? 'current' : '';
        $nav[] = $res;
        
        $res['title'] = '文章管理';
        $res['url'] = wx_addons_url('GameCollege://Article/lists');
        $res['class'] = $controller == 'article' ? 'current' : '';
        $nav[] = $res;
        
        $res['title'] = '讲师管理';
        $res['url'] = wx_addons_url('GameCollege://Teacher/lists');
        $res['class'] = $controller == 'teacher' ? 'current' : '';
        $nav[] = $res;
        
        $res['title'] = '活动管理';
        $res['url'] = wx_addons_url('GameCollege://Event/lists');
        $res['class'] = $controller == 'event' ? 'current' : '';
        $nav[] = $res;

        $this->assign('nav', $nav);

        $config = getAddonConfig('GameCollege');
        $this->config = $config;
        $this->assign('config', $config);
    }
}
