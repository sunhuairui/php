<?php

namespace Addons\GameCollege\Controller;
use Addons\GameCollege\Controller\BaseController;

class SlideController extends BaseController {
    protected $model;

    protected function _initialize() {
        $this->model = $this->getModel('weisite_slideshow');
        parent::_initialize();
    }

    // 通用插件的列表模型
    public function lists() {
        $map = array();
        $map['token'] = get_token();
        session('common_condition', $map);

        $list_data = $this->_get_model_list($this->model);
        foreach ($list_data['list_data'] as &$vo) {
            $vo['img'] = '<img src="' . get_cover_url($vo['img']) . '" width="50px" >';
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