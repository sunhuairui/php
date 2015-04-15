<?php

namespace Home\Controller;
use OT\File;

class ProjectController extends HomeController {
    protected $pagesize = 20;
    
    // 初始化操作
    protected function _initialize() {
        parent::_initialize();
        if (!is_login()) {
            redirect(U('User/newlogin'));
        }
    }
    
    // 检查应用名称
	public function checkName($name) {
        if (empty($name)) {
            $this->ajaxReturn(array('error'=>'项目名称不能为空！'));
        }
        
		$project = D('Project');
        $env = (APP_STATUS == 'production') ? 1 : 0;
        // 同一人在同一个环境的名称不能重复
        $map = array('title'=>$name, 'uid'=>$this->mid, 'status'=>array('neq', 0), 'env'=>$env);
        $ret = $project->where($map)->find();
		if ($ret) {
			$this->ajaxReturn(array('error'=>'该项目名称已经存在'));
		}
		$this->ajaxReturn(array('success'=>1));
	}  
    
    // 创建游戏
	public function create($name) {
		// 生成templete.json文件
        $env = (APP_STATUS == 'production') ? 1 : 0;
        if (empty($name)) {
            $name = $_POST['name'];
        }        
        $map = array('name'=>$name);
        if ($env === 1) {
            if ($this->mid == 1) {
				// 超级管理员可以看到发布和预发布的模板
				$map['status'] = array('in', '2,3');
			} else {
				$map['status'] = 2;
			}
        } else {
            $map['status'] = array('neq', 0);
        }
        
        $token = generate_nonce_str(8);
        $template = D('Template');
        $template->where($map)->find();
        
        if (empty($template->id)) {
            $this->error('模板'.$name.'不存在！');
        }
        
        $title = !empty($_POST['title']) ? $_POST['title'] : $template->title;
        $project = D('Project');
        // 同一人在同一个环境的名称不能重复
        $cond = array('uid'=>$this->mid, 'title'=>$title, 'env'=>$env, 'status'=>array('neq', 0));
        $projectinfo = $project->where($cond)->find();
        if (!empty($projectinfo)) {
        	$this->error('项目名称已存在！');
        }
        
        $category = !empty($_POST['category']) ? $_POST['category'] : 0;
        $project->create();
        $project->name = $name;
        $project->title =$title;
        $project->desc = $template->desc;
        $project->uid = $this->user['uid'];
        $project->username = $this->user['username'];
        $project->token = $token;
        $project->template_id = $template->id;
        $project->create_time = time();
        $project->modify_time = 0;
        $project->status = 2; // 开始项目的状态是已上线，先放在controller这里，后期需要移到model里面
        $project->icon_url = $template->icon_url;
        $project->env = \Home\Model\ProjectModel::getCurrentEnv();
        $project->category =$category;
        $settings = array();
        if(!empty($template->setting)){
            $settings = json_decode($template->setting,true);
        }
        
        $project->setting = json_encode($settings);
        $add_result = $project->add();
        if (!$add_result) {
            $this->error('模板'.$name.'创建失败！');
        }

        $template->used_times += 1;
        $template->save();
            
        $gamecreator_app_path = SITE_PATH.'/webroot/Public/gamecreator/app/';
        mkdir($gamecreator_app_path.$token, 0755, true);
        chmod($gamecreator_app_path.$token, 0755);
        $template_path = SITE_PATH.'/webroot/Public/gamecreator/templates/';
        File::copy_dir($template_path.'/'.$name, $gamecreator_app_path.$token);
        $this->success('创建成功', U('editor/editor', array('appid'=>$token)));
	}
    
    // 上下线
    public function setStatus($appid, $status) {
        $project = D('Project');
        $res = $project->updateStatusByToken($appid, $status);
        if ($res) {
            $this->ajaxOutput($res);
        } else {
            $this->ajaxOutput('', 1, $project->getError());
        }
    }
    
    // 删除
    public function delete($appid) {
        $project = D('Project');
        $res = $project->deleteByToken($appid);
        if ($res === false) {
            $this->ajaxOutput('', 1, $project->getError());
        } else {
            $this->ajaxOutput($res);
        }
    }

    // 取消删除
    public function canceldelete($appid){
        $project = D('Project');
        $env = (APP_STATUS == 'production') ? 1 : 0;
        $project->where(array('token'=>$appid, 'status'=>array('eq', -1), 'env'=>$env))->find();
        $project->status = 1;
        $project->save();
        $this->ajaxReturn(1);
    }
    
    // 查看自己的游戏
    public function index() {
        // 默认显示第一页数据
    	$page = I ( 'p', 1, 'intval' );
    	$row = I('list_row', $this->pagesize, 'intval');
        
        $project = D('Project');
        $order = '`status` DESC,`id` DESC';
        $uid = $this->mid;
        $gameArrs = $project->getInfoByUid($uid, '*', $page, $row, $order);    	
    	$appids = $games = array();
    	foreach ($gameArrs as $game) {
    		$appids[] = $game['id'];
    	}
    	
        $settingModel = D('Settings');
        $settings = $settingModel->getTotalData($appids);

        $iId = 0;
    	foreach ($gameArrs as $game) {
    		$id = $game['id'];
    		$games[$iId]['title'] = $game['title'];
    		$games[$iId]['token'] = $game['token'];
    		$games[$iId]['status'] = $game['status'];
    		$games[$iId]['pv'] = (int) $settings[$id]['pageview'];
    		$games[$iId]['uv'] = (int) $settings[$id]['userview'];
    		$games[$iId]['sc'] = (int) $settings[$id]['sharecount'];
            $games[$iId]['code_url'] = "http://".SITE_DOMAIN.'/play/'.$game['token'];
            $games[$iId]['publish_url'] = U('editor/publish', 'appid='. $game['token']);
            $games[$iId]['edit_url'] = U('editor/editor', 'appid='. $game['token']);
            $games[$iId]['icon_url'] = 'Public/gamecreator/app/'. $game['token'] .'/icon.png';
            $iId++;
    	}
    	
    	if (IS_POST) {
    		$this->success($games);
    	} else {
    	    $count = $project->getCountByUid($uid);
    		$userTotalData = $settingModel->getDataByUser($uid);
            $order = 'sort DESC, id DESC';
    		$categorys = D('CategoryBee')->getCategories('*', $page, $row, $order);
            $pagenum = ceil($count / $row);
            if ($pagenum > $page) {
                $this->assign('is_more', true);
            }

    		$this->assign('categorys', $categorys);
    		$this->assign('totalPage', $count);
    		$this->assign('listRow', $row);
    		$this->assign('games', $games);
    		$this->assign('gamecount', $userTotalData);
    		$this->display('Bee1/userview');
    	}
    }
    
    public function copyCreate($appid) {
    	$title || $title = I('title');
    	$category || $category = I('category');
    	
    	$Model = D('Project');
    	$token = $appid;
    	$data = $Model->getInfoByToken($appid);
    	if ($data) {
    		$time = time();
    		$id = $data['id'];
    		unset($data['id']);
    		$newToken = generate_nonce_str(8);
    		
    		$data['token'] = $newToken;
    		$data['title'] = $title ? $title : $data['title'];
    		$data['category'] = $category ? $category : $data['category'];
    		$newId = $Model->add($data);
    		if ($newId && is_numeric($newId)) {
    		    if($data['template_id'] > 0) {
    		        $Template = D('Template');
    		        $Template->where ( array('id' => $data['template_id'], 'env' => $env) )->find ();
    		        $Template->used_times += 1;
    		        $Template->save();
    		    }
    			
    			$settings_data = $prizes_data = array();
    			
    			$SettingModel = M('sdk_settings');
    			$settingsData = $SettingModel->where ( array('appid' => $id) )->select ();
    			foreach ($settingsData as $settingKey => &$setting) {
    			    if(in_array($setting['item_key'], array('pageview', 'userview', 'sharecount'))) {
    			        unset($settingsData[$settingKey]);
    			    } else {
    			        unset($setting['id']);
    			        $setting['create_time'] = $time;
    			        $setting['modify_time'] = $time;
    			        $setting['appid'] = $newId;
    			    }
    			}
    			$SettingModel->addAll($settingsData);
    			
    			$LottryPrizeModel = M('sdk_lottery_prize');
    			$prizesData = $LottryPrizeModel->where ( array('appid' => $id) )->select ();
    			foreach ($prizesData as &$prize) {
    				unset($prize['id']);
    				$prize['create_time'] = $time;
    				$prize['modify_time'] = $time;
    				$prize['appid'] = $newId;
    			}
    			$LottryPrizeModel->addAll($prizesData);
    		}
    		
    		$gamecreator_app_path = SITE_PATH . '/webroot/Public/gamecreator/app/';
    		mkdir($gamecreator_app_path . $newToken, 0755, true);
    		chmod($gamecreator_app_path . $newToken, 0755);
    		File::copy_dir($gamecreator_app_path . $token, $gamecreator_app_path . $newToken);
    		
    		$this->ajaxReturn(1);
    	}
    	
    	$this->ajaxReturn(0);
    }
    
    /**
	 * 列出目录
	 * @param $dir  目录名
	 * @return 目录数组。列出文件夹下内容，返回数组 $dirArray['dir']:存文件夹；$dirArray['file']：存文件
	 */
	private function get_dirs($dir, $filter = '') {
		$dir = rtrim($dir,'/').'/';
		//$dirArray [][] = NULL;
        $dirArray = array();
        $dirArray['dir'] = array();
        $dirArray['file'] = array();
		if (false != ($handle = opendir ( $dir ))) {
			$i = 0;
			$j = 0;
			while ( false !== ($file = readdir ( $handle )) ) {
                if ($file == '.' || $file == '..')  continue;
				if (is_dir ( $dir . $file )) { //判断是否文件夹
					$dirArray ['dir'] [$i] = $file;
					$i ++;
				} else {
                    if ($filter) {
                        $extension = pathinfo($file, PATHINFO_EXTENSION);
                        if ($extension != $filter) {
                            continue;
                        }
                    }
					
                    $dirArray ['file'] [$j] = $file;
					$j ++;
				}
			}
			closedir ($handle);
		}
		return $dirArray;
	}
}