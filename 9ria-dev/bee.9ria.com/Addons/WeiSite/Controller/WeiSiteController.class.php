<?php

namespace Addons\WeiSite\Controller;
use Addons\WeiSite\Controller\BaseController;

class WeiSiteController extends BaseController {
    // 微官网配置
    public function config() {
        // 使用提示
        $normal_tips = '在微信里回复“微官网”即可以查看效果，也可点击<a target="_blank" href="' . U('index') . '">这里</a>在预览';
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

    // 首页
    public function index() {
        $map = array();
        $map['token'] = get_token();
        $map['is_show'] = 1;

        // 幻灯片
        $slideshow = M('weisite_slideshow')->where($map)->order('sort asc, id desc')->select();
        foreach ($slideshow as &$vo) {
            $vo['img'] = get_cover_url($vo['img']);
        }
        $this->assign('slideshow', $slideshow);
        
        // 分类
        $category = M('weisite_category')->where($map)->order('sort asc, id desc')->select();
        foreach ($category as &$vo) {
            $vo['icon'] = get_cover_url($vo['icon']);
            // 如果没有指定分类的链接地址，那默认是跳到分类的列表地址
            empty($vo['url']) && $vo['url'] = wx_addons_url('WeiSite://WeiSite/lists', array('token'=>$map['token'],'cate_id' => $vo['id']));
        }
        $this->assign('category', $category);
        
        // 增加积分
        add_credit('weisite', 86400);
        $this->_footer();
        $this->display(ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $this->config ['template_index'] . '/index.html');
    }

    // 分类列表
    public function lists() {
        $map = array();
        $map['token'] = get_token();
        if (isset($_REQUEST['cate_id'])) {
            $map['cate_id'] = intval($_REQUEST['cate_id']);
        }

        $pageno = I('p', 1, 'intval');
        $row = isset($_REQUEST['list_row']) ? intval($_REQUEST['list_row']) : 20;
        $data = M('custom_reply_news')->where($map)->order('sort asc, id DESC')->page($pageno, $row)->select();
        $count = M('custom_reply_news')->where($map)->count();
        
        $list_data = array();
        $list_data['list_data'] = $data;

        // 分页
        if ($count > $row) {
            $page = new \Think\Page($count, $row);
            $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
            $list_data['_page'] = $page->show();
        }

        $this->assign($list_data);
        $this->_footer();
        $this->display(ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateLists/' . $this->config ['template_lists'] . '/lists.html');
    }

    // 详情
    public function detail() {
        $map = array();
        $map['id'] = I('get.id', 0, 'intval');
        $info = M('custom_reply_news')->where($map)->find();
        $this->assign('info', $info);

        M('custom_reply_news')->where($map)->setInc('view_count');

        $this->_footer();
        $this->display(ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateDetail/' . $this->config['template_detail'] . '/detail.html');
    }

    // 3G页面底部导航
    private function _footer() {
        $list = D('Addons://WeiSite/Footer')->get_list();
        // 取一级菜单
        foreach ($list as $k => $vo) {
            if ($vo['pid'] != 0) continue;

            $one_arr[$vo['id']] = $vo;
            unset($list[$k]);
        }

        foreach ($one_arr as &$p) {
            $two_arr = array();
            foreach ($list as $key => $l) {
                if ($l ['pid'] != $p ['id']) continue;
                $two_arr [] = $l;
                unset($list [$key]);
            }

            $p['child'] = $two_arr;
        }

        $this->assign('footer', $one_arr);
        $html = $this->fetch(ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateFooter/' . $this->config ['template_footer'] . '/footer.html');
        $this->assign('footer_html', $html);
    }
}