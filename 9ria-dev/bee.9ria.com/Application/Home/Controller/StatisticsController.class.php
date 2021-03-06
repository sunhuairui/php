<?php

namespace Home\Controller;

class StatisticsController extends HomeController {
    //初始化操作
    protected function _initialize() {
        parent::_initialize();
        if (!is_login()) {
            redirect(U('User/newlogin'));
        }
    } 
    
    // 我的数据
    public function index () {
        if (!is_login()) {
            redirect(U('User/newlogin'));
        }

        $settingModel = D('Settings');
        $userTotalData = $settingModel->getDataByUser($this->mid);
        $userTotalData['sharerate'] = intval($userTotalData['sharecount'] * 100 / $userTotalData['pageview']);
        
        $type || $type = I('type', 'pageview');
        $type = in_array($type, array('pageview', 'userview', 'sharecount')) ? $type : 'pageview';
        $typeS = $type == 'pageview' ? 'pv' : ($type == 'userview' ? 'uv' : 'share');
        
        $Model = D('Project');
        
        $page = I ( 'p', 1, 'intval' ); // 默认显示第一页数据
        $row = I('list_row', 10, 'intval');
        $appIds = $itemArr = $itemArrs = $items = array();
        
    	// 1表示正式环境，0表示测试环境
        $env = (APP_STATUS == 'production') ? $Model::PROJECT_ENV_PRODUCTION : $Model::PROJECT_ENV_TEST;
        $map = array('env' => $env, 'uid' => $this->mid);
        
        if ($env === $Model::PROJECT_ENV_PRODUCTION) {
            $map['status'] = $Model::PROJECT_STATUS_ONLINE;
        } else {
            $map['status'] = array('neq', $Model::PROJECT_STATUS_DELETE);
        }

        $games = $Model->where ( $map )->order('status DESC,id DESC')->select ();
        if($games) {
            foreach ($games as $val) {
                $appid = $val['id'];
                $appIds[] = $appid;
                $itemArr[$appid]['appid'] = $val['token'];
                $itemArr[$appid]['title'] = $val['title'];
            }        
            
            $redis = redis();
            $redis->sadd('uid:' . $this->mid . ':appid', $appIds);
            $appInfo = $redis->sort(
                    'uid:' . $this->mid . ':appid', 
                    array(
                        'sort'=>'desc', 
                        'by'=>'appid:*->'. $typeS .':total',
                        'get'=>array('#', 'appid:*->pv:total', 'appid:*->uv:total', 'appid:*->share:total'),
                        //'limit' => array(($page - 1) * $row, $row),

                    )
                );
            
            for ($i=0; $i<count($appInfo); ) {
                list($appid, $pv, $uv, $sc) = array_slice($appInfo, $i, 4);
                if(null !== $appid && in_array($appid, $appIds)) {
                    $itemArrs[] = array(
                            'appid' => $itemArr[$appid]['appid'],
                            'title' => $itemArr[$appid]['title'],
                            'pageview'  => (int) $pv,
                            'userview'  => (int) $uv,
                            'sharecount'=> (int) $sc,
                    );
                }
                
                $i += 4;
            }
            
            $items = array_slice($itemArrs, ($page - 1) * $row, $row);
        }
        
        // 分页
        $count = count($games);
        if ($count > $row) {
            $pageObj = new \Think\Page($count, $row);
            $pageObj->rollPage = $row;
            $pageObj->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
            $htmlPage = $pageObj->show();
            $this->assign('page', $htmlPage);
        }
         
        $this->assign('curType', $type);
        $this->assign('total', $userTotalData);
        $this->assign('items', $items);
        $this->display('Bee1/statistics');
    }
    
    public function statDetail($appid) {
        if(!is_login()) {
            redirect(U('User/newlogin'));
        }
        
        $period || $period = I('period', 'today');
        
        $Model = D('Project');
        
    	$env = (APP_STATUS == 'production') ? $Model::PROJECT_ENV_PRODUCTION : $Model::PROJECT_ENV_TEST;
    	//$map = array('token' => $appid, 'env' => $env, 'uid' => $this->mid);
    	$map = array('token' => $appid, 'env' => $env);
    	if ($env === $Model::PROJECT_ENV_PRODUCTION) {
    	   $map['status'] = $Model::PROJECT_STATUS_ONLINE;
    	} else {
    	   $map['status'] = array('neq', $Model::PROJECT_STATUS_DELETE);
    	}
    	
    	$project = $Model->where ( $map )->find ();
    	if (!$project) {
    	    $this->error('此项目不存在！');
    	}
    	
    	$data = array();
    	
		$id = $project['id'];
		 
		$settingModel = D('Settings');
	
		if (! IS_POST) {
// 		    $data['id'] = $id;
		    $data['appid'] = $project['token'];
		    $data['title']    = $project['title'];
		    $data['icon_url'] = 'Public/gamecreator/app/'. $project['token'] .'/icon.png';
		    
			$data['status_name'] = $Model->getNameByProjectStatus( $project['status'] );
			$appcount = $settingModel->getRedisDataByAppid($id);
			$appcount['pv'] = $appcount['pageview'];
			$appcount['uv'] = $appcount['userview'];
			$appcount['sc'] = $appcount['sharecount'];
			unset($appcount['pageview'], $appcount['userview'], $appcount['sharecount']);
			$appcount['fr'] = (number_format($appcount['sc'] / $appcount['pv'], 2) * 100) . '%';
			$data['appcount'] = $appcount;
			
			$raffleTypeArrs = $settingModel->where ( array('appid' => $id, 'item_key' => 'raffletype') )->find ();
			if($raffleTypeArrs) $raffleType = $raffleTypeArrs['item_value'];
			else {
			    $LotteryPrizeModel = D('LotteryPrize');
			    $prizeArrs = $LotteryPrizeModel->getAllPrize($id);
			    $raffleType = isset($prizeArrs[1]) ? (string) $prizeArrs[1]['lot_type'] : 0;
			}
		    $prizeType = 'none';
            switch ($raffleType) {
            	case "1":
            	    $prizeType = 'coupon';
            	    break;
            	case "2":
            	    $prizeType = 'rankdata';
            	    break;
            	case "4":
            	    $prizeType = 'baoming';
            	    break;
            	case "0":
            	    $prizeType = 'raffle';
            	case "3":
            	default:
            	    break;
            }
		}
		
		$xAxis = $curOption = array();
		$xAxisName = $yAxisName = '';
		
		switch ($period) {
			case 'yesterday':
				for($i=0; $i<24; $i++) $xAxis[] = $i;
				$xAxisName = '时';
				$yAxisName = '次/时';
				break;
			case 'week':
				for($i=6; $i>=0; $i--)  $xAxis[] = date('Y-m-d', strtotime((string)(-$i) ." days"));
				$xAxisName = '日';
				$yAxisName = '次/日';
				break;
			case 'month':
				for($i=29; $i>=0; $i--) $xAxis[] = date('Y-m-d', strtotime((string)(-$i) ." days"));
				$xAxisName = '日';
				$yAxisName = '次/日';
				break;
			case 'today':
			default:
                for($i=0; $i<24; $i++) $xAxis[] = $i;
                $xAxisName = '时';
                $yAxisName = '次/时';
				break;
		}
		
		$xCount['pv'] = $settingModel->getRedisDataByAppidTypePeriod($id, 'pv', $period);
		$xCount['uv'] = $settingModel->getRedisDataByAppidTypePeriod($id, 'uv', $period);
		$xCount['sc'] = $settingModel->getRedisDataByAppidTypePeriod($id, 'sc', $period);
		
		$xArr = $yArr = array();
		
		$xName = array('pv'=>'浏览量', 'uv'=>'访客数', 'sc'=>'转发数');
		foreach ($xName as $k => $v) {
		    $xArr[] = array(
		            'name' => $v,
		            'type' => 'line',
		            'data' => $xCount[$k]['v']
		    );
		    $xTotal[] = $xCount[$k]['c'];
		}
		$chartZx = array (
	        'xAxis'  => array('type'=> 'category', 'name' => '时间('. $xAxisName .')','data' => $xAxis),
		    'yAxis'  => array('type'=> 'value', 'name' => '数量('. $yAxisName .')'),
	        'series' => $xArr,
		    'total'  => $xTotal
        );
		$curOption['chartZx'] = $chartZx;
		
		$yName = array('pv'=>'浏览量', 'sc'=>'转发数'/*'uv'=>'转发数', 'sc'=>'转发率'*/);
		$yMax = $xCount['pv']['c'] > $xCount['sc']['c'] ? $xCount['pv']['c'] : $xCount['sc']['c'];
		foreach ($yName as $k => $v) {
		    $yArr[] = array(
		            'name'   => $v,
		            'value'  => $xCount[$k]['c']
		    );
		}
		$chartLd['title'] = array(
		        'text'       => '转发率为 '. (number_format($xCount['sc']['c'] / $xCount['pv']['c'], 2) * 100) .'%',
		        'subtext'    => '(转发率 = 转发数 / 浏览量)',
		 );
		$chartLd['series'] = array ('type' => 'funnel', 'width'=> '80%', 'min'=>0, /*'max'=>100,*/'max'=>$yMax, 'minSize'=>'0%', 'maxSize'=>'80%', 'data' => $yArr);
		$curOption['chartLd'] = $chartLd;
		
		if (! IS_POST) {
		    $this->assign('curMenuTab', 'statistics');
		    $this->assign('prizeType', $prizeType);
		    $this->assign('game', $data);
		    $this->assign('curOption', json_encode($curOption));
		    $this->display('Bee1/statDetail');
		} else {
		    $this->success ( $curOption );
		}

    }
    
    public function statLottery($appid) {
        
        $Model = D('Project');
        
        $env = (APP_STATUS == 'production') ? $Model::PROJECT_ENV_PRODUCTION : $Model::PROJECT_ENV_TEST;
        //$map = array('token' => $appid, 'env' => $env, 'uid' => $this->mid);
        $map = array('token' => $appid, 'env' => $env);
        if ($env === $Model::PROJECT_ENV_PRODUCTION) {
            $map['status'] = $Model::PROJECT_STATUS_ONLINE;
        } else {
            $map['status'] = array('neq', $Model::PROJECT_STATUS_DELETE);
        }
        
    	$project = $Model->where ( $map )->find ();
    	if (!$project) {
    	    $this->error('此项目不存在！');
    	}
    	
    	$page = I('p', 1, 'intval');
    	$row = I('list_row', 8, 'intval');
    	
		$id = $project['id'];
		$lotteryDatas = array();
		$htmlPage = '';
		
		//$SettingModel = D('Settings');
		$LotteryLogModel = D('LotteryLog');
		$raffleType = $LotteryLogModel::LOT_TYPE_RAFFLE;
		//$raffleType = $SettingModel->getConf($id, 'raffletype', $LotteryLogModel::LOT_TYPE_NONE);
		$lotterylogMap = array('appid' => $id, 'status' => 1, 'lot_type'=>$raffleType, 'lot_id'=>array('neq', 0));
		$lotterysArrs = $LotteryLogModel->where ( $lotterylogMap )->order('create_time DESC,id DESC') ->page($page, $row)->select ();
		
		if($lotterysArrs) {
		    $count = $LotteryLogModel->where($lotterylogMap)->count();
		    
		    // 分页
		    if ($count > $row) {
		        $pageObj = new \Think\Page ( $count, $row, array('appid' => $appid) );
		        $pageObj->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		        $htmlPage = $pageObj->show();
		    }
		    
		    $openIds = array();
		    foreach ($lotterysArrs as $val) {
		        $openIds[] = $val['openid'];
		    }
            $openIds = array_unique($openIds);
		    
		    $LotteryPrizeModel = D('LotteryPrize');
		    $prizeArrs = $LotteryPrizeModel->getAllPrize($id);
		    
		    $UserModel = D('User');
		    $nickNames = array();
		    $nicknameArr = $UserModel->field (array('openid', 'nickname'))->where ( array('openid' => array('in', $openIds)) )->select ();
		    foreach ($nicknameArr as $val) {
		        $nickNames[$val['openid']] = $val['nickname'];
		    }
		    
		    $GameDataModel = D('GameData');
		    $gamedataMap = array('appid' => $id, 'dtype' => 'exchange', 'openid' => array('in', $openIds));
		    $gamedataArr = $GameDataModel->where ( $gamedataMap )->order('id DESC') ->page($page, $row)->select ();
		    $gameDatas = array();
		    
		    foreach ($gamedataArr as $val) {
		        $dval = $val['dvalue'] ? json_decode($val['dvalue'], true) : array();
		        $gameDatas[$val['dkey']]['tel'] = $dval['tel'];
		    }
		    $lId = 0;
		    foreach ($lotterysArrs as $val) {
		        //$lId = $val['id'];
		        $lotteryDatas[$lId]['lot_name']   = $prizeArrs[$val['lot_id']]['lot_name'];
		        $lotteryDatas[$lId]['nickname']   = isset($nickNames[$val['openid']]) ? $nickNames[$val['openid']] : '未知';
		        $lotteryDatas[$lId]['tel']        = isset($gameDatas[$val['id']]['tel']) ?
		              $gameDatas[$val['id']]['tel'] : '';
		        $lotteryDatas[$lId]['create_time'] = date("y/m/d H:i:s", $val['create_time']);
		        $lId++;
		    }
		}
		
		$this->success ( array('lotterys' => $lotteryDatas, 'curPage' => $page, 'pages' => $htmlPage) );
    }
    
    public function statUserdata($appid) {
        $Model = D('Project');
        
    	$env = (APP_STATUS == 'production') ? $Model::PROJECT_ENV_PRODUCTION : $Model::PROJECT_ENV_TEST;
    	$map = array('token' => $appid, 'env' => $env/*, 'uid' => $this->mid*/);
    	
    	if ($env === $Model::PROJECT_ENV_PRODUCTION) {
    	   $map['status'] = $Model::PROJECT_STATUS_ONLINE;
    	} else {
    	   $map['status'] = array('neq', $Model::PROJECT_STATUS_DELETE);
    	}
    	
        $project = $Model->where ( $map )->find ();
        if (!$project) {
            $this->error('此项目不存在！');
        }
        
        $page = I('p', 1, 'intval');
        $row = I('list_row', 8, 'intval');
             
        $id = $project['id'];
        $gameDatas = array();
        $htmlPage = '';
        
        $GameDataModel = D('GameData');
        $gamedataMap = array('appid'=>$id, 'dtype'=>'exchange');
		$gamedataArr = $GameDataModel->where($gamedataMap)->order('create_time DESC,id DESC') ->page($page, $row)->select ();
		if ($gamedataArr) {
		    $count = $GameDataModel->where($gamedataMap)->count();
		    // 分页
		    if ($count > $row) {
		        $pageObj = new \Think\Page ( $count, $row, array('appid' => $appid) );
		        $pageObj->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		        $htmlPage = $pageObj->show();
		    }		  
		    
		    $gdId = 0;
		    foreach ($gamedataArr as $val) {
                $dval = $val['dvalue'] ? json_decode($val['dvalue'], true) : array();
                $gameDatas[$gdId]['nickname'] = isset($dval['name']) ? $dval['name'] : '';
                $gameDatas[$gdId]['tel'] = isset($dval['tel']) ? $dval['tel'] : '';
                $gameDatas[$gdId]['addr'] = isset($dval['address']) ? $dval['address'] : '';
		        $gdId++;
		    }
		}
    	
        $this->success ( array('gamedatas' => $gameDatas, 'curPage' => $page, 'pages' => $htmlPage) );
    }
    
    public function statCoupon($appid) {
        $type || $type = I('type', 'all');
        $code || $code = I('code', '');
        
        $Model = D('Project');
    
        $env = (APP_STATUS == 'production') ? $Model::PROJECT_ENV_PRODUCTION : $Model::PROJECT_ENV_TEST;
        $map = array('token' => $appid, 'env' => $env, 'uid' => $this->mid);
        
        if ($env === $Model::PROJECT_ENV_PRODUCTION) {
            $map['status'] = $Model::PROJECT_STATUS_ONLINE;
        } else {
            $map['status'] = array('neq', $Model::PROJECT_STATUS_DELETE);
        }
         
        $project = $Model->where ( $map )->find ();
        if (!$project) {
            $this->error('此项目不存在！');
        }
        
        $page = I('p', 1, 'intval');
        $row = I('list_row', 8, 'intval');
        
        $id = $project['id'];
        $couponDatas = array();
        $htmlPage = '';

        $GameCodeModel = D('GameCode');

        $gamecodeMap = array('appid' => $id);
        
        switch ($type) {
        	case 'unexchange':
                    //$gamecodeMap['openid'] = array('EQ', '');
					$gamecodeMap['status'] = 2;
					break;
        	case 'exchanged':
					$gamecodeMap['status'] = 1;
					break;
        	case 'receive':
                    //$gamecodeMap['openid'] = array('NEQ', '');
					//$gamecodeMap['status'] = 2;
                    $gamecodeMap['status'] = array('IN', array(1, 3));
					break;
        	case 'all':
        	default:
            		break;
        }
        
        if($code) $gamecodeMap['gamecode'] = array('LIKE', '%'. $code .'%');
        
        $gamecodeArr = $GameCodeModel->where($gamecodeMap)->order('id DESC')->page($page, $row)->select();
        if($gamecodeArr) {
            $count = $GameCodeModel->where($gamecodeMap)->count();

            // 分页
            if ($count > $row) {
                $pageObj = new \Think\Page ( $count, $row, array('appid' => $appid) );
                $pageObj->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
                $htmlPage = $pageObj->show();
            }

            $gameCodes = array();
            foreach ($gamecodeArr as $val) {
                $gameCodes[] = $val['gamecode'];
            }

            $UserModel = D('Lottery');
            $nickNames = $createTimes = array();
            if(count($gameCodes) > 0) {
                $nicknameArr = $UserModel->field (array('openid', 'nickname', 'create_time', 'gamecode'))->where ( array('appid'=> $id, 'gamecode' => array('in', $gameCodes)) )->select ();
                foreach ($nicknameArr as $val) {
                    $nickNames[$val['openid']] = $val['nickname'];
                    $createTimes[$val['gamecode']] = $val['create_time'];
                }
            }
            
            $LotteryPrizeModel = D('LotteryPrize');
            $prizeArrs = $LotteryPrizeModel->getAllPrize($id);
            
            foreach ($gamecodeArr as $val) {
                $gcId = $val['id'];
                $couponDatas[$gcId]['lot_name'] = $prizeArrs[$val['lot_id']]['lot_name'];
                
                $gcNickname = $gcCreatetime = '';
                $gcStatus = $val['status'];
                if($val['openid']) {
                    $gcNickname = isset($nickNames[$val['openid']]) ? $nickNames[$val['openid']] : '未知';
                    $gcCreatetime = date("y/m/d H:i:s", $createTimes[$val['gamecode']]);
                    //$gcStatus = $val['status'] == 2 ? 3 : 1;
                }
                
                $couponDatas[$gcId]['nickname']     = $gcNickname;
                $couponDatas[$gcId]['create_time']  = $gcCreatetime;
                $couponDatas[$gcId]['status']   = $gcStatus;
                $couponDatas[$gcId]['gamecode'] = $val['gamecode'];
            }
        }
        
        $this->success ( array('coupondatas' => $couponDatas, 'type' => $type, 'curPage' => $page, 'pages' => $htmlPage) );
    }
    
    public function changeCouponStatus($appid) {
        $code || $code = I('code', '');
        $Model = D('Project');
        
        $env = (APP_STATUS == 'production') ? $Model::PROJECT_ENV_PRODUCTION : $Model::PROJECT_ENV_TEST;
        $map = array('token' => $appid, 'env' => $env, 'uid' => $this->mid);
        
        if ($env === $Model::PROJECT_ENV_PRODUCTION) {
            $map['status'] = $Model::PROJECT_STATUS_ONLINE;
        } else {
            $map['status'] = array('neq', $Model::PROJECT_STATUS_DELETE);
        }
         
        $project = $Model->where ( $map )->find ();
        if (!$project) {
            $this->error('此项目不存在！');
        }
             
        $id = $project['id'];
    
        $GameCodeModel = D('GameCode');
        
        $gamecodeMap = array('appid' => $id, 'gamecode' => $code, 'openid' => array('NEQ', ''), 'status' => 3);
        $res = $GameCodeModel->where($gamecodeMap)->save(array('status' => 1));
        if($res) $this->success ();
        else $this->error ();
        
    }
    
    public function statRankdata($appid) {
        $Model = D('Project');
    
        $env = (APP_STATUS == 'production') ? $Model::PROJECT_ENV_PRODUCTION : $Model::PROJECT_ENV_TEST;
        $map = array('token' => $appid, 'env' => $env/*, 'uid' => $this->mid*/);
         
        if ($env === $Model::PROJECT_ENV_PRODUCTION) {
        	   $map['status'] = $Model::PROJECT_STATUS_ONLINE;
        } else {
        	   $map['status'] = array('neq', $Model::PROJECT_STATUS_DELETE);
        }
         
        $project = $Model->where ( $map )->find ();
        if (!$project) {
            $this->error('此项目不存在！');
        }
    
        $page = I('p', 1, 'intval');
        $row = I('list_row', 8, 'intval');
        $lot_id = I('lot_id', 0, 'intval');
        
        $id = $project['id'];
        $rankDatas = array();
        $htmlPage = '';
                
        $redis = redis();
        $rkey = 'rank:appid:'. $id .':lot_id:'. $lot_id;
        $count = $redis->zcard($rkey);
           echo $rkey."<hr>";
        echo $count."<hr>";
        $LotteryPrizeModel = D('LotteryPrize');
        $prizeArrs = $LotteryPrizeModel->getAllPrize($id);
                
        if($prizeArrs) {
            $prizeCount = $firstNum = $lastNum = $lotCount = 0;
            $prizeDescArrs = $prizeSortArrs = $prizeSort = array();
            foreach ($prizeArrs as $key => $val) {
                $lot_setting = json_decode($val['lot_code_setting'], true);
                $firstNum   = isset($lot_setting['firstnum']) ? $lot_setting['firstnum'] : 0;
                $lastNum    = isset($lot_setting['lastnum']) ? $lot_setting['lastnum'] : 0;
                $lotCount   = $lastNum - $firstNum + 1;
                
                $prizeSort[$val['id']]      = $firstNum;
                $prizeSortArrs[$val['id']]  = array(
                    'lot_count' => $lotCount,
                    'lot_desc'  => $val['lot_desc'],
                );
                
                $prizeCount += $lotCount;
            }
            asort($prizeSort);
            $prizeId = 1;
            foreach ($prizeSort as $key => $val) {
                $lotDesc    = isset($prizeSortArrs[$key]['lot_desc']) ? $prizeSortArrs[$key]['lot_desc'] : '';
                $lotCount   = isset($prizeSortArrs[$key]['lot_count']) ? $prizeSortArrs[$key]['lot_count'] : 0;
                for ($i=0; $i<$lotCount; $i++) {
                    $prizeDescArrs[$prizeId] = $lotDesc;
                    $prizeId ++;
                } 
            }
            
            if($prizeCount > 0) {
                $rankId = ($page - 1) * $row + 1;
                $count = $count > $prizeCount ? $prizeCount : $count;
                $rowStart   = ($page - 1) * $row;
                $rowEnd     = ceil($count / $row) == $page ? $count - 1 : ($page * $row - 1);
                
                // 分页
                if ($count > $row) {
                    $pageObj = new \Think\Page ( $count, $row, array('appid' => $appid) );
                    $pageObj->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
                    $htmlPage = $pageObj->show();
                }
echo $prizeCount."A<br>B".$count.'B<br>C'.$rowEnd."<hr>";
                $rankdataArr = $redis->zrevrange($rkey, $rowStart, $rowEnd, 'withscores');
                echo "<pre>";var_dump($rankdataArr);echo "</pre>";
                $openIds = array();
                foreach ($rankdataArr as $key => $val) {
                    $openIds[] = $key;
                }
                
                $UserModel = D('User');
                $nickNames = $nicknameArr = array();
                if(count($openIds) > 0) {
                    $nicknameArr = $UserModel->field (array('openid', 'nickname'))->where ( array('openid' => array('in', $openIds)) )->select ();
                    foreach ($nicknameArr as $val) {
                        $nickNames[$val['openid']] = $val['nickname'];
                    }
                }
                foreach ($rankdataArr as $key => $val) {
                    $rankDatas[$rankId]['nickname'] = isset($nickNames[$key]) ? $nickNames[$key] : '未知';
                    $rankDatas[$rankId]['rank_id']  = $rankId;
                    $rankDatas[$rankId]['lot_desc'] = $prizeDescArrs[$rankId];
                    $rankId++;
                }
            }
        } 
        //$this->success ( array('rankdatas' => $rankDatas, 'curPage' => $page, 'pages' => $htmlPage) );
    }
    
    public function statForm($appid) {
        $code || $code = I('code', '');
        
        $Model = D('Project');
        
        $env = (APP_STATUS == 'production') ? $Model::PROJECT_ENV_PRODUCTION : $Model::PROJECT_ENV_TEST;
        $map = array('token' => $appid, 'env' => $env, 'uid' => $this->mid);
         
        if ($env === $Model::PROJECT_ENV_PRODUCTION) {
            $map['status'] = $Model::PROJECT_STATUS_ONLINE;
        } else {
            $map['status'] = array('neq', $Model::PROJECT_STATUS_DELETE);
        }
         
        $project = $Model->where ( $map )->find ();
        if (!$project) {
            $this->error('此项目不存在！');
        }
        
        $page = I('p', 1, 'intval');
        $row = I('list_row', 8, 'intval');
        
        $id = $project['id'];
        $formDatas = array();
        $htmlPage = '';
        
        $settingModel = D('Settings');
        $formItems = $settingModel->getConf($id, 'formitems', '');
        $formItemIds = json_decode($formItems, true);
        
        $formModel = D('FormDict');
        $formItems = $formModel->getFormItemInfo($formItemIds);
        
        $GameDataModel = D('GameData');
	    $gamedataMap = array('appid' => $id, 'dtype' => 'baoming', 'status' => 1);
	    if($code) $gamedataMap['dvalue'] = array('LIKE', '%'. str_replace(array('"', '\\'), array('', '\\\\'), json_encode($code)) .'%');
	    
	    $gamedataArr = $GameDataModel->where ( $gamedataMap )->order('id DESC') ->page($page, $row)->select ();
	    $count = $GameDataModel->where($gamedataMap)->count();
	    // 分页
	    if ($count > $row) {
	        $pageObj = new \Think\Page ( $count, $row, array('appid' => $appid) );
	        $pageObj->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
	        $htmlPage = $pageObj->show();
	    }
	    
	    foreach ($gamedataArr as $key => $val) {
	        $dval = $val['dvalue'] ? json_decode($val['dvalue'], true) : array();
	        foreach ($formItems as $itemVal) {
	            $itemKey = $itemVal['name'];
	            $formDatas[$key][$itemKey] = isset($dval[$itemKey]) ? $dval[$itemKey] : '';
	        }
	        
	    }
	    
	    $this->success ( array('formTotal' => $count, 'formItems' => $formItems,'formDatas' => $formDatas, 'curPage'=>$page, 'pages' => $htmlPage) );
    }
}