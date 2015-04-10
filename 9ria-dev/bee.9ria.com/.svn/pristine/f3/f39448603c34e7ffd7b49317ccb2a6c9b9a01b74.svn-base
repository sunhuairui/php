<?php

namespace Addons\GameCollege\Controller;
use Addons\GameCollege\Controller\BaseController;

class TeacherController extends BaseController {
    protected $model;

    protected function _initialize() {
        $this->model = $this->getModel('gc_teacher');
        parent::_initialize();
        
        // 使用提示
        $normal_tips = '这里添加的讲师数据仅限使用于17173游戏学院插件';
        $this->assign('normal_tips', $normal_tips);
    }
    
    // 通用插件的列表模型
    public function lists() {
        session('common_condition', array('token'=>get_token()));

        $list_data = $this->_get_model_list($this->model);
        foreach ($list_data['list_data'] as &$vo) {
            $src = get_cover_url($vo['cover_url']);
            $vo['cover_url'] = empty($src) ? '' : '<img style="background:#ddd" src="' . $src . '" width="50px" >';
        }
        
        $this->assign($list_data);
        $templateFile = $this->model['template_list'] ? $this->model['template_list'] : '';
        $this->display($templateFile);
    }

    // 通用插件的编辑模型
    public function edit() {
        parent::common_edit($this->model);
    }

    // 通用插件的增加模型
    public function add() {
        parent::common_add($this->model);
    }

    // 通用插件的删除模型
    public function del() {
        parent::common_del($this->model);
    }    
}