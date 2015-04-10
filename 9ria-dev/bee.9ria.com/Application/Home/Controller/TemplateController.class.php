<?php

namespace Home\Controller;

class TemplateController extends HomeController {
    protected $pagesize = 20;

    // 模板显示页
    public function index() {
        $map = array('is_show'=>1);
        if (APP_STATUS == 'production') {
            if ($this->mid == 1) {
					// 超级管理员可以看到发布和预发布的模板
					$map['status'] = array('in', '2,3');
				} else {
					$map['status'] = 2;
				}
        } else {
            $map['status'] = array('neq', 0);
        }

        $pageno = I('p', 1, 'intval');
        $row = I('list_row', $this->pagesize, 'intval');

        $template = D('Template');
        $templates = $template->where($map)
            ->order('sort desc, id desc')
            ->page($pageno, $row)
            ->select();
        foreach ($templates as $key=>$val) {
            if (empty($val['apptoken'])) {
                $token = generate_nonce_str(8);
                $time = time();
                $insertdata = array(
                    'name'=>$val['name'],
                    'title'=>$val['title'],
                    'desc'=>$val['desc'],
                    'uid'=>'0',
                    'username'=>'游戏模板',
                    'token'=>$token,
                    'template_id'=>$val['id'],
                    'create_time'=>$time,
                    'modify_time'=>0,
                    'status'=>2,
                    'icon_url'=>$val['icon_url'],
                    'appsecret'=>'',
                    'is_diy'=>2
                );
                D('Project')->add($insertdata);
                $template->where(array('id'=>$val['id']))->save(array('apptoken'=>$token));
                $templates[$key]['codeurl'] = "http://".SITE_DOMAIN.'/Public/gamecreator/templates/'.$val['name'].'/?appid='.$token;
            } else {
                $templates[$key]['codeurl'] = "http://".SITE_DOMAIN.'/Public/gamecreator/templates/'.$val['name'].'/?appid='.$val['apptoken'];
            }
        }

        $count = $template->where($map)->count();
//         print_r($template->getLastSql());exit;
        $tags = D('Tag')->where(array('status'=>1))
            ->order('sort desc, id desc')
            ->page($pageno, $row)
            ->select();
        
        $pagenum = ceil($count / $row);
        if ($pagenum > $pageno) {
            $this->assign('is_more', true);
        }
        
        $this->assign('tags', $tags);
        $this->assign('templates', $templates);
        
        $categorys = D('CategoryBee')->where(array('status'=>1))
            ->order('sort desc, id desc')
            ->select();
        
        $this->assign('categorys', $categorys);
		$this->display('Bee1/template');
    }
    
    // 模板显示页
    public function template_ajax() {
        $map = array('is_show'=>1);
        if (APP_STATUS == 'production') {
            if ($this->mid == 1) {
				// 超级管理员可以看到发布和预发布的模板
				$map['status'] = array('in', '2,3');
			} else {
				$map['status'] = 2;
			}
        } else {
            $map['status'] = array('neq', 0);
        }
        
        //查询条件
         $s_cate=!empty($_POST['s_cate'])?$_POST['s_cate']:'';
         $s_tag=!empty($_POST['s_tag'])?$_POST['s_tag']:'';
         $s_new=!empty($_POST['s_new'])?$_POST['s_new']:'';
         $s_hot=!empty($_POST['s_hot'])?$_POST['s_hot']:'';
         $order='sort desc, create_time desc';
         if($s_cate){
         	$map['_string']="FIND_IN_SET($s_cate, category)";
         
         }
         if($s_tag){
         	$map['_string']="FIND_IN_SET($s_tag, tag)";
          }
         
         if($s_hot){
         	$order='used_times desc ';
         }
          if($s_new){
         	$order='sort desc, create_time desc';
         }
        $pageno = !empty($_POST['page']) ? $_POST['page'] : 1;
        $row = !empty($_POST['row']) ? $_POST['row'] : $this->pagesize;

        $template = D('Template');
        $templates = $template->where($map)
            ->order($order)
            ->page($pageno, $row)
            ->select();
        
        $count = $template->where($map)->count();
        foreach ($templates as $key=>$val) {
            $templates[$key]['imgurl'] = get_production_cover_url($val['icon_url']);
        	$templates[$key]['sw'] = U('demo', 'name='.$val['name']);
        	$templates[$key]['create'] = U('project/create', 'name='.$val['name']);
            
            if (empty($val['apptoken'])) {
                $token = generate_nonce_str(8);
                $time = time();
                $insertdata = array(
                    'name'=>$val['name'],
                    'title'=>$val['title'],
                    'desc'=>$val['desc'],
                    'uid'=>'0',
                    'username'=>'游戏模板',
                    'token'=>$token,
                    'template_id'=>$val['id'],
                    'create_time'=>$time,
                    'modify_time'=>0,
                    'status'=>2,
                    'icon_url'=>$val['icon_url'],
                    'appsecret'=>'',
                    'is_diy'=>2
                );

                D('Project')->add($insertdata);
                $template->where(array('id'=>$val['id']))->save(array('apptoken'=>$token));
                $templates[$key]['codeurl'] = "http://".SITE_DOMAIN.'/Public/gamecreator/templates/'.$val['name'].'/?appid='.$token;
            } else {
                $templates[$key]['codeurl'] = "http://".SITE_DOMAIN.'/Public/gamecreator/templates/'.$val['name'].'/?appid='.$val['apptoken'];
            }
        }
        
        $pagenum = ceil($count/$row);
        $is_page = $pagenum<=$pageno ? 1 : 0;
        $ret=array('page'=>$pageno, 'data'=>$templates, 'ispage'=>$is_page);
        $this->ajaxReturn($ret);
    }
    
    public function demo($name) {
        $project = D('Project');
        $env = (APP_STATUS == 'production') ? 1 : 0;
        $projects = $project->where(array('name'=>$name, 'is_diy'=>2, 'env'=>$env))->select();
        $template = D('Template');
        $rows = $template->where(array('name'=>$name,'is_show'=>1))->select();
        $mode = $rows[0]['mode'];
        if (empty($projects)) {
            if (!empty($rows)) {
                $row = $rows[0];
                $token = generate_nonce_str(8);
                $insertdata = array(
                    'name'=>$name,
                    'title'=>$row['title'],
                    'desc'=>$row['desc'],
                    'uid'=>'',
                    'username'=>'',
                    'token'=>$token,
                    'template_id'=>$row['id'],
                    'create_time'=>$row['create_time'],
                    'modify_time'=>$row['modify_time'],
                    'status'=>2,
                    'icon_url'=>$row['icon_url'],
                    'appsecret'=>'',
                    'is_diy'=>2
                );
                $project->add($insertdata);
                $appid = $token;
            } else {
                $appid = 0;
            }
        } else {
            $appid = $projects[0]['token'];
        }
        
        if($appid){
            $url = "http://".SITE_DOMAIN.'/Public/gamecreator/templates/'.$name.'/?appid='.$appid;
        }else{
            $url = '';
        }

        $this->assign('mode', $mode);
        $this->assign('template_name', $name);
        $this->assign('pc_url', $url.'&openid=otuWJjvQKhb9nn1xL8v-IRrgxct8');
        $this->assign('url', $url);
        //$qr_svg = "http://".SITE_DOMAIN."/index.php?s=/Home/Bee1/demoSvg/appid/{$appid}/name/{$name}";
        $qr_svg = U('demoSvg', array('appid'=>$appid, 'name'=>$name));
        $this->assign('qr_svg', $qr_svg);
        
        $categorys = D('CategoryBee')->where(array('status'=>1))
            ->order('sort desc, id desc')
            ->select();
        
        $this->assign('categorys', $categorys);
        if ($mode == 1) {
            $this->display('Bee1/demo2');
        } else {
            $this->display('Bee1/demo');
        }
    }
    
    public function demoSvg($appid, $name) {
        vendor('phpqrcode.phpqrcode');
        $publish_url = "http://".SITE_DOMAIN.'/Public/gamecreator/templates/'.$name.'/?appid='.$appid;
        header("content-disposition: attachment; filename=qrcode.png");
        \QRcode::png($publish_url, false, QR_ECLEVEL_L, 8);
    }
}