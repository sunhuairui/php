<?php

namespace Addons\GameCollege\Controller;
use Addons\GameCollege\Controller\BaseController;

class StudyController extends BaseController {

    protected $model;

    protected function _initialize() {
        $this->model = $this->getModel('gc_study');
        parent::_initialize();
    }

    // 通用插件的列表模型
    public function lists() {
        // 使用提示
        $normal_tips = '这里添加的数据仅限用于17173游戏学院插件，其他插件无法使用';
        $this->assign('normal_tips', $normal_tips);

        $map ['token'] = get_token();
        session('common_condition', $map);

        $list_data = $this->_get_model_list($this->model);

        // 分类数据
        $map ['is_show'] = 1;
        $list = M('weisite_category')->where($map)->field('id,title')->select();
        $cate [0] = '';
        foreach ($list as $vo) {
            $cate [$vo ['id']] = $vo ['title'];
        }

        foreach ($list_data ['list_data'] as &$vo) {
            $vo ['cate_id'] = intval($vo ['cate_id']);
            $vo ['cate_id'] = $cate [$vo ['cate_id']];
        }
        $this->assign($list_data);
        $templateFile = $this->model ['template_list'] ? $this->model ['template_list'] : '';
        $this->display($templateFile);
    }

    // 通用插件的编辑模型
    public function edit() {
        $model = $this->model;
        $id = I('id');

        if (IS_POST) {
            $Model = D(parse_name(get_table_name($model ['id']), 1));
            // 获取模型的字段信息
            $Model = $this->checkAttr($Model, $model ['id']);
            if ($Model->create() && $Model->save()) {
                D('Common/Keyword')->set($_POST ['keyword'], _ADDONS, $id, $_POST ['keyword_type'], 'custom_reply_news');

                $this->success('保存' . $model ['title'] . '成功！', U('lists?model=' . $model ['name']));
            } else {
                $this->error($Model->getError());
            }
        } else {
            $fields = get_model_attribute($model ['id']);

            $extra = $this->getCateData();
            if (!empty($extra)) {
                foreach ($fields [1] as &$vo) {
                    if ($vo ['name'] == 'cate_id') {
                        $vo ['extra'] .= "\r\n" . $extra;
                    }
                }
            }

            // 获取数据
            $data = M(get_table_name($model ['id']))->find($id);
            $data || $this->error('数据不存在！');

            $this->assign('fields', $fields);
            $this->assign('data', $data);
            $this->meta_title = '编辑' . $model ['title'];

            $this->display();
        }
    }

    // 通用插件的增加模型
    public function add() {
        $model = $this->model;
        $Model = D(parse_name(get_table_name($model ['id']), 1));

        if (IS_POST) {
            // 获取模型的字段信息
            $Model = $this->checkAttr($Model, $model ['id']);
            if ($Model->create() && $id = $Model->add()) {
                D('Common/Keyword')->set($_POST ['keyword'], _ADDONS, $id, $_POST ['keyword_type'], 'custom_reply_news');

                $this->success('添加' . $model ['title'] . '成功！', U('lists?model=' . $model ['name']));
            } else {
                $this->error($Model->getError());
            }
        } else {
            $fields = get_model_attribute($model ['id']);

            $extra = $this->getCateData();
            if (!empty($extra)) {
                foreach ($fields [1] as &$vo) {
                    if ($vo ['name'] == 'cate_id') {
                        $vo ['extra'] .= "\r\n" . $extra;
                    }
                }
            }

            $this->assign('fields', $fields);
            $this->meta_title = '新增' . $model ['title'];

            $this->display();
        }
    }

    // 通用插件的删除模型
    public function del() {
        parent::common_del($this->model);
    }

    // 获取所属分类
    private function getCateData() {
        $map ['is_show'] = 1;
        $map ['token'] = get_token();
        $list = M('weisite_category')->where($map)->select();
        foreach ($list as $v) {
            $extra .= $v ['id'] . ':' . $v ['title'] . "\r\n";
        }
        return $extra;
    }
}