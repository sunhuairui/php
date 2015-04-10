<?php

namespace Home\Controller;

class EditorController extends HomeController {    
    // 设置游戏配置
    public function setting($appid) {
        $addprizes = array(); //定义奖品数组

        //获取抽奖类型
        $raffletype = (int)I('post.raffletype');
        if($raffletype >= 0 && $raffletype <=4){        
            $this->_updateSetting($appid, 'raffletype', $raffletype);
            if(in_array($raffletype, array(0, 1))){
                //update settings
                $isallowrepeatwin = I('post.isallowrepeatwin');
                $nowinmsg = I('post.nowinmsg');
                $winrepeattimes = I('post.winrepeattimes');

                $prizes = $_POST['prizes'];
                $this->_updateSetting($appid, 'isallowrepeatwin', $isallowrepeatwin);
                $this->_updateSetting($appid, 'nowinmsg', $nowinmsg);
                $this->_updateSetting($appid, 'winrepeattimes', $winrepeattimes);
                if($raffletype == 0){
                    //抽奖
                    $lot_id = 0;
                    foreach ($prizes as $item) {
                        $addprizes[] = array(
                                "lot_id"=>++$lot_id,
                                "appid"=>$appid,
                                "lot_name"=>$item['lot_name'],
                                "lot_count"=>$item['lot_count'],
                                "probability"=>$item['probability'],
                                "lot_desc"=>$item['lot_desc'],
                                "lot_winning_tips"=>$item['lot_winning_tips'],
                                "lot_url"=>$item['lot_url'],
                                "lot_type"=>$item['lot_type'],
                                "lot_code_setting"=>'',
                                "status"=>1,
                                "create_time"=>time(),
                                "modify_time"=>0
                            );
                    }
                }else{
                    //奖券
                    $lot_id = 0;
                    foreach ($prizes as $item) {
                        $addprizes[] = array(
                                "lot_id"=>++$lot_id,
                                "appid"=>$appid,
                                "lot_name"=>$item['lot_name'],
                                "lot_count"=>$item['lot_count'],
                                "probability"=>$item['probability'],
                                "lot_desc"=>'',
                                "lot_winning_tips"=>$item['lot_winning_tips'],
                                "lot_url"=>'',
                                "lot_type"=>$item['lot_type'],
                                "lot_code_setting"=>json_encode($item['lot_code_setting']),
                                "status"=>1,
                                "create_time"=>time(),
                                "modify_time"=>0
                            );
                        //此处需要插入到gamecode 表中
                        $this->importgamecode($appid, $lot_id, $item['lot_code_setting'], $item['lot_count']);
                    }
                }
            }else if($raffletype == 2){
                $prizes = $_POST['prizes'];
                //update settings
                $starttime = I('post.starttime');
                $endtime = I('post.endtime');
                $prizeruledesc = I('post.prizeruledesc');

                $this->_updateSetting($appid, 'starttime', strtotime($starttime));
                $this->_updateSetting($appid, 'endtime', strtotime($endtime)+86400-1);
                $this->_updateSetting($appid, 'prizeruledesc', $prizeruledesc);

                $lot_id = 0;
                foreach ($prizes as $item) {
                    $addprizes[] = array(
                            "lot_id"=>++$lot_id,
                            "appid"=>$appid,
                            "lot_name"=>$item['lot_name'],
                            "lot_count"=>$item['lot_count'],
                            "probability"=>0,
                            "lot_desc"=>$item['lot_desc'],
                            "lot_winning_tips"=>'',
                            "lot_url"=>$item['lot_url'],
                            "lot_type"=>$item['lot_type'],
                            "lot_code_setting"=>json_encode($item['lot_code_setting']),
                            "status"=>1,
                            "create_time"=>time(),
                            "modify_time"=>0
                        );
                }

            }else if($raffletype == 4){
                $formItems = I('resultformitems');
                //update settings
                $formRuleDesc = I('formruledesc');
                
                $this->_updateSetting($appid, 'formitems', json_encode($formItems));
                $this->_updateSetting($appid, 'formruledesc', $formRuleDesc);

            }else{

            }
            //删除之前的奖项，插入新的奖项
            if(!empty($addprizes)){
                $prizetable = D('sdk_lottery_prize');

                //有可能删除的数据不存在，所以不判断返回值
                $res = $prizetable->where(array('appid'=>$appid,'status'=>1,'lot_type'=>$raffletype))->delete();

                $res = $prizetable->addAll($addprizes);
                if(!$res){
                    $this->ajaxReturn(array(
                        "code"=>1,
                        "msg"=>"插入数据错误",
                        "data"=>array()
                    ));
                }else{
                    $this->ajaxReturn(array(
                        "code"=>0,
                        "msg"=>"提交成功",
                        "data"=>array()
                    ));
                }
            }

        }
        $this->ajaxReturn(array('code'=>0,"msg"=>'',"data"=>array()));
    }

    // 如果setting表中appid, item_key数据存在，则更新item_value,反之 则插入新的数据
    private function _updateSetting($appid, $item_key, $item_value){
        $settings = D('sdk_settings');
        // update raffletype
        $settings->where(array('appid'=>$appid, 'item_key'=>$item_key, 'status'=>1))->find();
        if ($settings->id) {
            $settings->item_value = $item_value;
            $settings->modify_time = time();
            $res = $settings->save();
        } else {
            $res = $settings->add(array(
                "appid" => $appid,
                "item_key" => $item_key,
                "item_value" => $item_value,
                "status" => 1,
                "create_time" => time(),
                "modify_time" => 0
            ));
        }

        if (!res) {
            $this->ajaxReturn(array(
                    "code"=>1,
                    "msg"=>"操作数据库错误",
                    "data"=>array()
                ));
        }
    }


    // 删除设置项
    public function delsetting($id){
        $project = D('sdk_lottery_prize');
        $row = $project->where(array('id'=>$id))->find();

        if(!empty($row)){
            $gamecodetable = D('sdk_gamecode');
            $gamecodetable->where(array('appid'=>$row['appid'],'status'=>2,'lot_id'=>$row['lot_id']))->delete();
        }
        $project->where(array('id'=>$id))->delete();
        $this->ajaxReturn($row);
    }

    // 导入gamecode
    public function importgamecode($appid, $lot_id, $lot_code_setting, $lot_count){
        $data = array();
        if (is_array($lot_code_setting) && $appid && $lot_id) {
            if(isset($lot_code_setting['type']) && $lot_code_setting['type'] == 1 && !empty($lot_code_setting['prefix'])){
                //系统自动生成
                // @todo 临时对$lot_count做一个限制，限制在10000以内
                if ($lot_count > 10000) $lot_count = 10000;
                for ($i=0; $i < $lot_count; $i++) { 
                    $data[] = $lot_code_setting['prefix'] . generate_nonce_str(10);
                }
            }else if(isset($lot_code_setting['type']) && $lot_code_setting['type'] == 2 && !empty($lot_code_setting['key'])){
                //用户导入
                $data = $this->getGamecodeToRedis($lot_code_setting['key']);
            } else {

            }
        }
        
        if (!empty($data)) {
            $gamecodetable = D('sdk_gamecode');
            $gamecodetable->where(array('appid'=>$appid,'status'=>2,'lot_id'=>$lot_id))->delete();
            $rows = array();
            foreach ($data as $code) {
                $rows[] = array('appid'=>$appid, 'openid'=>'', 'lot_id'=>$lot_id, 'gamecode'=>$code, 'status'=>2);
            }

            $gamecodetable->addAll($rows);
        }
    }

    
    
   

    
    // 编辑
	public function editor($appid) {
        if (!is_login()) {
            redirect(U('User/newlogin'));
        }
        
        $time = time();
        $this->assign('t', $time);
        $this->assign('app_id', $appid);
        
        $project = D('Project');
        $map = array();
        $map['token'] = $appid;
        $env = (APP_STATUS == 'production') ? 1 : 0;
        $map['env'] = $env;
        $map['status'] = array('neq', 0);
        $projectinfo = $project->where($map)->find();

        if($this->mid != $projectinfo['uid'] && $this->mid != 1) {
            $this->error('项目('.$appid.')不属于你！');
        }
        
        $this->assign('token', $appid);
        $appid = $projectinfo['id'];
        $template = D('Template');
        $template->where(array('id'=>$project->template_id))->find();

        //获取raffletypes
        $raffletypes = '3';
        $projectSetting = '';
        $projectSettingArr = array();
        if($project->setting) {
            $projectSetting = $project->setting;
        } elseif($template->setting) {
            $projectSetting = $template->setting;
        }
        
        $projectSettingArr = json_decode($projectSetting, true);
        if(isset($projectSettingArr['RAFFLE_TYPES'])) {
            $raffletypes = $projectSettingArr['RAFFLE_TYPES'];
        }

        $raffletypeArrs = explode(',', $raffletypes);
        
        $this->assign("raffletypes", $raffletypes);

        $this->assign('mode', $template->mode);
        $sdk_settings = D('sdk_settings');
        $rows = $sdk_settings->where(array('appid'=>$appid))->select();
        if(empty($rows)){
            $setting = array();
        }else{
            foreach ($rows as $row) {
                $item_key = $row['item_key'];
                if($item_key == "starttime" || $item_key == "endtime"){
                    $row['item_value'] = date("m/d/Y",$row['item_value']);
                }

                $setting[$item_key] = $row['item_value'];

            }
            if(in_array(4, $raffletypeArrs)) {
                $formDictModel = D('FormDict');
                $defaultFormItems = $formDictModel->getFormItemByDefault();
                $setting['default_formitems'] = $defaultFormItems;
                
                $customFormItems = $formDictModel->getFormItemByUid($this->mid);
                $setting['custom_formitems'] = $customFormItems;
                
                $settingModel = D('Settings');
                $formItems = $settingModel->getConf($appid, 'formitems', '');
                $formItemIds = json_decode($formItems, true);
                
                $setting['formitems']       = $formItemIds;
                $setting['formruledesc']    = $settingModel->getConf($appid, 'formruledesc', '');
            }
        }

        $sdk_lottery_prize = D('sdk_lottery_prize');
        $prizes = $sdk_lottery_prize->where(array('appid'=>$appid))->select();
        foreach ($prizes as &$row) {
            if(!empty($row['lot_code_setting'])){
                $row['lot_code_setting'] = json_decode($row['lot_code_setting'], true);
            }else{
                $row['lot_code_setting'] = "";
            }
        }

        if(empty($prizes)) $prizes = array();
        $this->assign('setting', json_encode($setting));
        $this->assign('prizes', json_encode($prizes));
        $this->assign('appid', $projectinfo['id']);
        $this->assign('type', $template->type);
        if($template->type == 1){
            $this->display('Bee1/ppteditor');
        }else{
            $this->display('Bee1/editor');
        }
	}
    
    // 游戏设置信息
    public function gamesetting($appid) {
        $gamecreator_app_path = SITE_PATH.'/webroot/Public/gamecreator/app/';
        header('Content-Type: application/json');
        echo file_get_contents($gamecreator_app_path.$appid.'/template.json');
    }
	
    // 更新数据
	public function write($appid, $filename) {
		$filedata = isset($_POST['filedata']) ? $_POST['filedata'] : '';
		$basepath = SITE_PATH.'/webroot/Public/gamecreator/app/'.$appid.'/';
		if (is_dir($basepath)) {
			file_put_contents($basepath . $filename, $filedata);
			$this->ajaxReturn(array('success'=>1));
		} else {
			$this->ajaxReturn(array('error'=>'app目录不存在'));
		}
	}
	
    // 替换资源
	public function replace($appid) {
        $res = I('res');
        $web = I('web');
		$basepath = SITE_PATH.'/webroot/Public/gamecreator/app/'.$appid.'/';
		if (is_dir($basepath)) {
			$imageInfo= @getimagesize($basepath . $res);
			file_put_contents($basepath . $res, file_get_contents($web));
		   //执行压缩类
			$image = new ImageFile($basepath . $res, $imageInfo[0], $imageInfo[1], '0',$basepath . $res);
			// 执行打包命令
			$picture=new PictureModel();
			$picture->packPicture($basepath);
			
			$this->ajaxReturn(array('success'=>1));
		}
        
		$this->ajaxReturn(array('error'=>'app目录不存在'));
	}
	
    // 发布游戏
	public function publish($appid) {
        if (!is_login()) {
            redirect(U('User/newlogin'));
        }
        
        // 发布
        $env = (APP_STATUS == 'production') ? 1 : 0;
        $map = array('token'=>$appid, 'status'=>array('gt',0), 'env'=>$env);
        $project = D('Project');
        $row = $project->where($map)->find();
        if (!$project) $this->error('项目('.$appid.')不存在');
        
        $project->status = 2;
        $project->save();
        $template = D('Template');
        $templateInfo = $template->where(array('id'=>$row['template_id']))->find();
        $publish_url = "http://".SITE_DOMAIN.'/play/'.$appid;
        //$qr_svg = "http://". SITE_DOMAIN ."/index.php?s=/Home/Bee1/publishQRCode/appid/{$appid}";
        $qr_svg = U('publishQRCode', array('appid'=>$appid));
        $this->assign('appid', $appid);
        $this->assign('template_name', $row['name']);
        $this->assign('mode', $templateInfo['mode']);
        $this->assign('url', $publish_url);
        $this->assign('pc_url', $publish_url.'/?openid=otuWJjvQKhb9nn1xL8v-IRrgxct8');
        $this->assign('qr_svg', $qr_svg);

        $categorys = D('CategoryBee')->where(array('status'=>1))
            ->order('sort desc, id desc')
            ->select();
        
        $this->assign('categorys', $categorys);
        
        $view_file = 'Bee1/demo';
        if ($templateInfo['mode'] == 1) {
            $view_file = 'Bee1/demo2';
        }
        
		$this->display($view_file);
	}

    public function upload($appid) {
        $filename = $_GET['filename'];
        $basepath = SITE_PATH.'/webroot/Public/gamecreator/app/'.$appid.'/';
        if ($_FILES['files']['name'][0] != '') {
            // var_dump($_FILES['files']['error'][0]);exit;
            if ($_FILES['files']['error'][0]) {
                $this->ajaxReturn(array('code'=>'1','msg'=>uploadErr($_FILES['files']['error'][0]),'data'=>array()));
            } else {

                if(!in_array(strtolower(substr(strrchr($_FILES['files']['name'][0], '.'), 1)), array('jpg','jpeg','png'))){
                    $this->ajaxReturn(array('code'=>'1','msg'=>'上传文件格式错误','data'=>array()));
                }

            	$file_size = $_FILES['files']['size'][0];
            	$imageInfotmp = @getimagesize($_FILES['files']['tmp_name'][0]);
            	$imageInfo= @getimagesize($basepath . $filename);
            	if($file_size>800*1024){
                    $this->ajaxReturn(array('code'=>'1','msg'=>'上传图片不能超出800KB','data'=>array()));
            	 
            	//}elseif(($imageInfotmp[0]!=$imageInfo[0])||($imageInfotmp[1]!=$imageInfo[1])){
                  //$res = array('error'=>'尺寸不正确!');
            		
            	}else{
                	$result= move_uploaded_file($_FILES['files']['tmp_name'][0] , $basepath . $filename);
                    if($result){
                        //执行压缩类
                        $image = new \Org\Util\ImageFile($basepath . $filename, $imageInfo[0], $imageInfo[1], '0',$basepath . $filename);
                         // 执行打包命令
                        D('Picture')->packPicture($basepath);
                    }
                    $res = array('success'=>1);
            	}
            }
        } else {
            $this->ajaxReturn(array('code'=>'1','msg'=>'请上传文件！','data'=>array()));
        }
        
        $this->ajaxReturn($res);
    }

    public function settingUpload($appid){
        $filename =  $_GET['filename'];
        if(empty($filename)){
            $filename = time() . '.png';
        }

        $data = $_POST['data'];
        $basepath = SITE_PATH.'/webroot/Public/gamecreator/app/'.$appid.'/';

        if ($_FILES['files']['name'][0] != '') {
            if ($_FILES['files']['error'][0]) {
                $this->ajaxReturn(array('code'=>'1','msg'=>'上传文件出错','data'=>array()));
            } else {

                if(!in_array(strtolower(substr(strrchr($_FILES['files']['name'][0], '.'), 1)), array('jpg','jpeg','png'))){
                    $this->ajaxReturn(array('code'=>'1','msg'=>'上传文件格式错误','data'=>array()));
                }

                $file_size = $_FILES['files']['size'][0];
                $imageInfotmp = @getimagesize($_FILES['files']['tmp_name'][0]);
                $imageInfo= @getimagesize($basepath . $filename);
                if($file_size>800*1024){
                    $this->ajaxReturn(array('code'=>'1','msg'=>'上传图片不能超出800KB','data'=>array()));
                }else{
                    $result= move_uploaded_file($_FILES['files']['tmp_name'][0] , $basepath . $filename);
                    if($result){
                        $image = new \Org\Util\ImageFile($basepath . $filename, 300, 300, '0',$basepath . $filename);
                        $res = array('success'=>1,'filename'=>$filename);
                    }
                }
            }
        } else {
            $this->ajaxReturn(array('code'=>'1','msg'=>'请上传文件！','data'=>array()));
        }

        $this->ajaxReturn($res);
    }

    public function deletefile($appid){
        $filename =  $_GET['filename'];
        if(empty($filename)){
            $this->ajaxReturn(array('success'=>0,'msg'=>''));
        }
        $basepath = SITE_PATH.'/webroot/Public/gamecreator/app/'.$appid.'/';
        if(file_exists($basepath . $filename)){
            unlink($basepath . $filename );
            $this->ajaxReturn(array('success'=>1));
        }
        $this->ajaxReturn(array('success'=>0,'msg'=>'文件不存在'));
    }

    public function publishQRCode($appid) {
        vendor('phpqrcode.phpqrcode');
        $publish_url = "http://" . SITE_DOMAIN . '/play/'.$appid;
		header("content-disposition: attachment; filename=qrcode.png");
       \QRcode::png($publish_url,$outfile = false, $level = QR_ECLEVEL_L,$size = 8);
    }
    
    public function editScene($appid){
    	$time = time();
    	$this->assign('t', $time);
    	$this->assign('app_id', $appid);
    	
    	$project = D('Project');
    	$env = (APP_STATUS == 'production') ? 1 : 0;
    	$projectinfo = $project->where(array('token'=>$appid, 'env'=>$env))->find();
    	if($this->mid != $projectinfo['uid'] && $this->mid != 1) {
    		$this->error('项目('.$appid.')不属于你！');
    	}
    	
    	$template = D('Template');
    	$template->where(array('id'=>$project->template_id))->find();
    	$name=$template->name;
    	$url = "http://".SITE_DOMAIN.'/Public/gamecreator/templates/'.$name.'/?appid='.$appid;
    	$this->assign('url', $url);
    	$this->assign('mode', $template->mode);
    	// $setting=$project->setting;
    	
    	// $setarr=!empty($setting)?json_decode($setting):null;
    	// $endtitle=isset($setarr->endtitle)?$setarr['endtitle']:'';
        $setting = D('sdk_settings');
        $row = $setting->where(array('appid'=>$projectinfo['id'], 'item_key'=>'endtitle'))->find();
        $endtitle = empty($row) ? '活动已结束，敬请关注更多精彩！' : $row['item_value'];
    	$this->assign('endtitle',$endtitle);
    	$this->display('Bee1/editScene');
    }

    public function editshare($appid){
        $project = D('Project');
        $env = (APP_STATUS == 'production') ? 1 : 0;
        $projectinfo = $project->where(array('token'=>$appid, 'env'=>$env))->find();
        if($this->mid != $projectinfo['uid']) {
            $this->error('项目('.$appid.')不属于你！');
        }

        // 下线提示入sdk_setting库
        $endtitle = isset($_POST['endtitle']) ? $_POST['endtitle'] : '';
        if(!empty($endtitle)){
            $project = D('sdk_settings');
            $project->where(array('appid'=>$projectinfo['id'], 'item_key'=>'endtitle'))->delete();
            $time = time();
            $project->add(array(
                'appid'=>$projectinfo['id'],
                'item_key'=>'endtitle',
                'item_value'=>$endtitle,
                'status'=>1,
                'create_time'=>$time,
                'modify_time'=>$time
            ));
        }

        //分享图片覆盖icon.png
        $data = isset($_POST['imgdata']) ? $_POST['imgdata'] : '';
        $filename = 'icon.png';
        if(!empty($data)){
            $basepath = SITE_PATH.'/webroot/Public/gamecreator/app/'.$appid.'/';
            if(!empty($data) && is_dir($basepath)){
                file_put_contents($basepath . $filename, file_get_contents($data));
                $image = new \Org\Util\ImageFile($basepath . $filename, 300, 300, '0',$basepath . $filename);
                $res = array('success'=>1,'filename'=>$filename);
            } else {
                $this->ajaxReturn(array('error'=>1,'msg'=>'请上传文件！'));
            }
        }

        // 写入template.json文件
        $filedata = isset($_POST['filedata']) ? $_POST['filedata'] : '';
        if(!empty($filedata)){
            $this->write($appid, 'template.json');
        }
    }
    
    // 修改链接描述
    public function setinglink($id) {
    	$app = D('Project');
    	$appdata = $app->field(true)->where(array('id'=>$id) )->select();
    	if (empty($appdata)) {
    		$this->ajaxReturn(array('error'=>'项目不存在！'));
    	}
    	
        $time = time();
        $settingModel = D('Settings');
        $settingData = array('appid'=>$id,'status'=>1,'create_time'=>$time,'modify_time'=>0);
        if (isset($_POST['linkname'])) {
            if (empty($_POST['linkname'])) {
                $this->ajaxReturn(array('error'=>'链接描述不能为空！'));
            } else {
                $res = $settingModel->where(array('appid'=>$id, 'status'=>1, 'item_key'=>'linkname'))->find();
                if ($res) {
                    $settingModel->item_value = $_POST['linkname'];
                    $settingModel->modify_time = $time;
                    $res = $settingModel->save();
                } else {
                    $settingData['item_key'] = 'linkname';
                    $settingData['item_value'] = $_POST['linkname'];
                    $res = $settingModel->add($settingData);
                }
            }
        }

        if (isset($_POST['linkpath'])) {
            if (empty($_POST['linkpath'])) {
                $this->ajaxReturn(array('error'=>'链接地址不能为空！'));
            } else {
                $ss = preg_match_all('/(http|https|ftp|file){1}(:\/\/)?([\da-z-\.]+)\.([a-z]{2,6})([\/\w \.-?&%-=]*)*\/?/', $_POST['linkpath'], $urlall);
                if (empty($ss)) {
                    $this->ajaxReturn(array('error'=>'链接地址有误！！'));	
                }
                
                $res = $settingModel->where(array('appid'=>$id, 'status'=>1, 'item_key'=>'linkpath'))->find();
                if ($res) {
                    $settingModel->item_value = $_POST['linkpath'];
                    $settingModel->modify_time = $time;
                    $res = $settingModel->save();
                } else {
                    $settingData['item_key'] = 'linkpath';
                    $settingData['item_value'] = $_POST['linkpath'];
                    $res = $settingModel->add($settingData);
                }
            }
        }
        
        if (isset($_POST['islinkdesc'])) {
            $res = $settingModel->where(array('appid'=>$id, 'status'=>1, 'item_key'=>'islinkdesc'))->find();
            if ($res) {
                $settingModel->item_value = $_POST['islinkdesc'];
                $settingModel->modify_time = $time;
                $res = $settingModel->save();
            } else {
                $settingData['item_key'] = 'islinkdesc';
                $settingData['item_value'] = $_POST['islinkdesc'];
                $res = $settingModel->add($settingData);
            }
        }

        if ($res) {
            $this->ajaxReturn('设置成功');
        } else {
            $this->ajaxReturn(array('error'=>$settingModel->getError()));
        }
    }

    public function uploadcoupon(){
        // 解析文本 返回奖券
        if ($_FILES['files']['name'][0] != '') {
            if(strrchr($_FILES['files']['name'][0],'.') != '.txt'){
                $this->ajaxReturn(array('code'=>1, 'msg'=>'请导入txt格式的文本文件', 'data'=>''));
            }
            if (!$_FILES['files']['error'][0]) {
                $filecont = file_get_contents($_FILES['files']['tmp_name'][0]);
                $arr = explode("\n", $filecont);
                $data = array();
                foreach ($arr as $v) {
                    // 兑换长度截取20
                    $v = substr(trim($v), 0, 20);
                    if(preg_match("/^[a-zA-Z0-9\s]+$/",$v)) {
                        $data[] = $v;
                    }
                }
                
                if(empty($data)) {
                    $this->ajaxReturn(array('code'=>1, 'msg'=>'系统无法获取券号！', 'data'=>''));
                }
                
                $key = generate_nonce_str();
                //此处需要插入redis
                $records_count = $this->setGamecodeToRedis($key, $data);
                if ($records_count) {
                    $this->ajaxReturn(array("code"=>0, "msg"=>'', "data"=>array(
                        "key"=>$key,
                        "num"=>$records_count
                    )));
                } else {
                    $this->ajaxReturn(array('code'=>1,'msg'=>'存入redis错误','data'=>''));
                }
            }
        }
        
        $this->ajaxReturn(array('error'=>'解析奖券文件失败，请选择自动生成。'));
    }

    // 将键值对存入redis中
    private function setGamecodeToRedis($key, array $members) {
        $key = 'gamecode:'.$key;
        // 设置过期时间为2个小时，防止垃圾数据堆积
        $redis = redis();
        $redis->expire($key, 2*3600);
        return $redis->sadd($key, $members);
    }

    // 通过key 获取存入的数据，并删除之
    private function getGamecodeToRedis($key) {
        $key = 'gamecode:'.$key;
        $redis = redis();
        $result = $redis->smembers($key);
        // 为了节省存储空间，删除相关数据
        $redis->del($key);
        return $result;
    }
    
    /**
     * 背景音乐上传 
     * auth@changzhengfei at 2015/03/27 11:16
     * **/
       public function uploadMusic($appid){
        $filename = $_GET['filename'];
        $basepath = SITE_PATH.'/webroot/Public/gamecreator/app/'.$appid.'/';
        if ($_FILES['music']['name'] != '') {
            if ($_FILES['music']['error']) {
                $this->ajaxReturn(array('code'=>'1','msg'=>uploadErr($_FILES['music']['error']),'data'=>array()));
            } else {
                if(!in_array(strtolower(substr(strrchr($_FILES['music']['name'], '.'), 1)), array('mp3'))){
                    $this->ajaxReturn(array('code'=>'1','msg'=>'上传文件格式错误','data'=>array()));
                }

            	$file_size = $_FILES['music']['size'];
            	if($file_size>1*1024*1024){
                    $this->ajaxReturn(array('code'=>'1','msg'=>'上传文件不能超出1M','data'=>array()));
            	}else{
                    $result= move_uploaded_file($_FILES['music']['tmp_name'] , $basepath . $filename);
                    $res = array('success'=>1);
            	}
            }
        } else {
            $this->ajaxReturn(array('code'=>'1','msg'=>'请上传文件！','data'=>array()));
        }
        $this->ajaxReturn($res);
    }
    
    // 增加表单项
    public function addFormDictItem($label) {
        $FormDictModel = D('FormDict');
        $countLen = 10;
        $count = $FormDictModel->where (array('uid'=>$this->mid, 'is_default'=>array('neq', 1), 'status'=>1))->count ();
        if($count >= $countLen) $this->error('自定义表单项已达上限'. $countLen .'个，请删除原自定义表单项再执行添加操作！');
        
        $row = $FormDictModel->where(array('label'=>$label, 'uid'=>$this->mid, 'is_default'=>array('neq', 1), 'status'=>1))->find();
        if($row) $this->error('表单项('.$label.')已存在，请勿重复添加！');
        $row = $FormDictModel->where(array('label'=>$label, 'is_default'=>1, 'status'=>1))->find();
        if($row) $this->error('表单项('.$label.')已存在，请勿重复添加！');
        
        $time = time();
        $res = $FormDictModel->add(array(
            "label" => $label,
            "uid"   => $this->mid,
            "type"  => 'string',
            'rule'  => '',
            "status" => 1,
            "create_time" => $time,
            "modify_time" => 0
        ));
        
        if ($res) {
            $id = $res;
            $name = 'item_' . $id;
            $data['name'] = $name;
            $data['modify_time'] = $time;
            $res = $FormDictModel->where(array('id'=> $res))->save($data);
            if($res) {
                $this->success(array('msg'=>'添加表单项成功', 'data' => array('id'=>$id, 'label'=> $label, 'name'=> $name, 'type'=>'string', 'rule'=>'')));
            } else {
                $res = $FormDictModel->where(array('id'=> $res))->save(array('status'=>0));
                $this->error('修改表单项失败');
            }
        } else {
            $this->error('添加表单项失败');
        }
    }
    
    // 删除表单项
    public function delFormDictItem($id){
        $FormDictModel = D('FormDict');
        $row = $FormDictModel->where(array('id'=>$id, 'uid'=>$this->mid, 'is_default'=>array('neq', 1), 'status'=>1))->find();
        if(!$row) $this->error('此表单项不存在！');
        
        $res = $FormDictModel->where(array('id'=> $id))->save(array('status'=>0));
        if($res) {
            $this->success('删除表单项成功');
        } else {
            $this->error('删除表单项失败');
        }
    }
}