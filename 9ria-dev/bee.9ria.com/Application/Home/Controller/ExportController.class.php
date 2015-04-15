<?php

namespace Home\Controller;

class ExportController extends HomeController {
    // 初始化操作
    protected function _initialize(){
        parent::_initialize();
        if(!is_login()){
            redirect(U('User/newlogin'));
        }
    }

    /**
     * 数据导出到excel文件
     * auth@changzhengfei
     * 中奖信息
     */
    public function lotterys($appid) {
        $Model = D('Project');
        $env = (APP_STATUS == 'production') ? $Model::PROJECT_ENV_PRODUCTION : $Model::PROJECT_ENV_TEST;
        $map = array('token' => $appid, 'env' => $env);
        if($env === $Model::PROJECT_ENV_PRODUCTION){
            $map['status'] = $Model::PROJECT_STATUS_ONLINE;
        }else{
            $map['status'] = array('neq', $Model::PROJECT_STATUS_DELETE);
        }
        $project = $Model->where($map)->find();
        if(!$project){
            $this->error('此项目不存在！');
        }
        $id = $project['id'];
        $lotteryDatas = array(); 
        $LotteryLogModel = D('LotteryLog');
        $raffleType = $LotteryLogModel::LOT_TYPE_RAFFLE;
        $lotterylogMap = array('appid' => $id, 'status' => 1, 'lot_type' => $raffleType, 'lot_id' => array('neq', 0));
        $lotterysArrs = $LotteryLogModel->where($lotterylogMap)->order('create_time DESC,id DESC')->select();

        if($lotterysArrs){
            $count = $LotteryLogModel->where($lotterylogMap)->count();
            $openIds = array();
            foreach($lotterysArrs as $val){
                $openIds[] = $val['openid'];
            }

            $openIds = array_unique($openIds);
            $LotteryPrizeModel = D('LotteryPrize');
            $prizeArrs = $LotteryPrizeModel->getAllPrize($id);
            $UserModel = D('User');
            $nickNames = array();
            $nicknameArr = $UserModel->field(array('openid', 'nickname'))->where(array('openid' => array('in', $openIds)))->select();
            foreach($nicknameArr as $val){
                $nickNames[$val['openid']] = $val['nickname'];
            }
            $GameDataModel = D('GameData');
            $gamedataMap = array('appid' => $id, 'dtype' => 'exchange', 'openid' => array('in', $openIds));
            $gamedataArr = $GameDataModel->where($gamedataMap)->order('id DESC')->select();
            $gameDatas = array();
            foreach($gamedataArr as $val){
                $dval = $val['dvalue'] ? json_decode($val['dvalue'], true) : array();
                $gameDatas[$val['dkey']]['tel'] = $dval['tel'];
            }
            $lId = 0;
            foreach($lotterysArrs as $val){
                $lotteryDatas[$lId]['lot_name'] = $prizeArrs[$val['lot_id']]['lot_name'];
                $lotteryDatas[$lId]['nickname'] = isset($nickNames[$val['openid']]) ? $nickNames[$val['openid']] : '未知';
                $lotteryDatas[$lId]['tel'] = isset($gameDatas[$val['id']]['tel']) ? $gameDatas[$val['id']]['tel'] : '-';
                $lotteryDatas[$lId]['create_time'] = date("y/m/d H:i:s", $val['create_time']);
                $lId++;
            }
        }
        $headArr = array("奖项", "中奖用户昵称", "联系方式", "中奖时间"); //表头
        exportExcel($project['title'].'-中奖信息-'.date("Ymd", time()), $headArr, $lotteryDatas);
    }

    /* 礼券信息 */
    public function coupon($appid){
        $type || $type = I('type', 'all');
        $code || $code = I('code', '');
        
        $Model = D('Project');
        $env = (APP_STATUS == 'production') ? $Model::PROJECT_ENV_PRODUCTION : $Model::PROJECT_ENV_TEST;
        $map = array('token' => $appid, 'env' => $env, 'uid' => $this->mid);
        
        if($env === $Model::PROJECT_ENV_PRODUCTION){
            $map['status'] = $Model::PROJECT_STATUS_ONLINE;
        }else{
            $map['status'] = array('neq', $Model::PROJECT_STATUS_DELETE);
        }
         
        $project = $Model->where($map)->find();
        if(!$project){
            $this->error('此项目不存在！');
        }
        $id = $project['id'];
        $couponDatas = array(); 

        $GameCodeModel = D('GameCode');
        $gamecodeMap = array('appid' => $id);
        switch ($type){
        	case 'unexchange':
                        $gamecodeMap['status'] = 2;
                        break;
        	case 'exchanged':
                        $gamecodeMap['status'] = 1;
                        break;
                case 'receive':
                        $gamecodeMap['status'] = array('IN', array(1, 3));
                        break;
        	case 'all':
        	default:
            		break;
        }
        
        if($code) $gamecodeMap['gamecode'] = array('LIKE', '%'. $code .'%');
        $count = $GameCodeModel->where($gamecodeMap)->count();
        $gamecodeArr1 = $GameCodeModel->where($gamecodeMap)->order('id DESC')->select();
                
        //构造数据
        $gamecodeArr=array();//新数组
        $page=8;//每页显示数 
        $rows=ceil($count/$page);//总页数
        for($i=1;$i<=$rows;$i++){//页数
            $start=$i * $page -1;
            $end=($i-1) * $page ;
            if($i==$rows){ 
                $startKey=$count-1;//最后一页开始键位
                $num=$count % $page;//最后一页记录数
                $endKey=$count-$num;//最后一页结束键位
                for($startKey;$startKey>=$endKey;$startKey--){ 
		   $gamecodeArr[]=$gamecodeArr1[$startKey]; 
		 }
            }else{
                for($start;$start>=$end;$start--){ 
                    $gamecodeArr[]=$gamecodeArr1[$start]; 
                }
            }
        }
        
        if($gamecodeArr){
            $gameCodes = array();
            foreach($gamecodeArr as $val){
                $gameCodes[] = $val['gamecode'];
            }
            $UserModel = D('Lottery');
            $nickNames = $createTimes = array();
            if(count($gameCodes) > 0){
                $nicknameArr = $UserModel->field(array('openid', 'nickname', 'create_time', 'gamecode'))->where( array('appid'=> $id, 'gamecode' => array('in', $gameCodes)) )->select ();
                foreach($nicknameArr as $val){
                    $nickNames[$val['openid']] = $val['nickname'];
                    $createTimes[$val['gamecode']] = $val['create_time'];
                }
            }
            $LotteryPrizeModel = D('LotteryPrize');
            $prizeArrs = $LotteryPrizeModel->getAllPrize($id);
            
            foreach($gamecodeArr as $val){
                $gcId = $val['id'];
                $couponDatas[$gcId]['lot_name'] = $prizeArrs[$val['lot_id']]['lot_name'];

                $gcNickname = $gcCreatetime = '';
                $gcStatus = $val['status'];
                if($val['status'] == '3'){
                    $gcStatus = '已发出';
                }elseif($val['status'] == '1'){
                    $gcStatus = '已兑换';
                }else{
                    $gcStatus = '未发出';
                }
                if($val['openid']){
                    $gcNickname = isset($nickNames[$val['openid']]) ? $nickNames[$val['openid']] : '未知';
                    $gcCreatetime = date("y/m/d H:i:s", $createTimes[$val['gamecode']]);
                }
                $couponDatas[$gcId]['gamecode'] = $val['gamecode'];
                $couponDatas[$gcId]['nickname'] = $gcNickname ? $gcNickname : '-';
                $couponDatas[$gcId]['create_time'] = $gcCreatetime ? $gcCreatetime : '-';
                $couponDatas[$gcId]['status'] = $gcStatus;
            }
        }
        $headArr = array("礼券名称", "礼券券号", "中奖用户名称", "中奖时间", "礼券状态"); //表头 
        exportExcel($project['title'].'-礼券信息-' . date("Ymd", time()), $headArr, $couponDatas);
    }

    /*  排行榜信息 */
    public function rankdatas($appid){
        $Model = D('Project');
        $env = (APP_STATUS == 'production') ? $Model::PROJECT_ENV_PRODUCTION : $Model::PROJECT_ENV_TEST;
        $map = array('token' => $appid, 'env' => $env/* , 'uid' => $this->mid */);

        if($env === $Model::PROJECT_ENV_PRODUCTION){
            $map['status'] = $Model::PROJECT_STATUS_ONLINE;
        }else{
            $map['status'] = array('neq', $Model::PROJECT_STATUS_DELETE);
        }
        $project = $Model->where($map)->find();
        if(!$project){
            $this->error('此项目不存在！');
        }

        $lot_id = I('lot_id', 0, 'intval');
        $id = $project['id'];
        $rankDatas = array();

        $redis = redis();
        $rkey = 'rank:appid:' . $id . ':lot_id:' . $lot_id;
        $count = $redis->zcard($rkey);
        echo $rkey."<hr>";
echo $count."<hr>";
        $LotteryPrizeModel = D('LotteryPrize');
        $prizeArrs = $LotteryPrizeModel->getAllPrize($id);
        if($prizeArrs){
            $prizeCount = $firstNum = $lastNum = $lotCount = 0;
            $prizeDescArrs = $prizeSortArrs = $prizeSort = array();
            foreach($prizeArrs as $key => $val){
                $lot_setting = json_decode($val['lot_code_setting'], true);
                $firstNum = isset($lot_setting['firstnum']) ? $lot_setting['firstnum'] : 0;
                $lastNum = isset($lot_setting['lastnum']) ? $lot_setting['lastnum'] : 0;
                $lotCount = $lastNum - $firstNum + 1;

                $prizeSort[$val['id']] = $firstNum;
                $prizeSortArrs[$val['id']] = array(
                    'lot_count' => $lotCount,
                    'lot_desc' => $val['lot_desc'],
                );

                $prizeCount += $lotCount;
            }
            asort($prizeSort);
            $prizeId = 1;
            foreach($prizeSort as $key => $val){
                $lotDesc = isset($prizeSortArrs[$key]['lot_desc']) ? $prizeSortArrs[$key]['lot_desc'] : '';
                $lotCount = isset($prizeSortArrs[$key]['lot_count']) ? $prizeSortArrs[$key]['lot_count'] : 0;
                for ($i = 0; $i < $lotCount; $i++){
                    $prizeDescArrs[$prizeId] = $lotDesc;
                    $prizeId++;
                }
            }

            if($prizeCount > 0){
                $rankId = 1;
                $count = $count > $prizeCount ? $prizeCount : $count;
                
                echo $prizeCount."A<br>B".$count.'B<br>C'.$rowEnd."<hr>";
                $rankdataArr = $redis->zrevrange($rkey, 0, $count, 'withscores');
                echo "<pre>";var_dump($rankdataArr);echo "</pre>";
                $openIds = array();
                foreach($rankdataArr as $key => $val){
                    $openIds[] = $key;
                }

                $UserModel = D('User');
                $nickNames = $nicknameArr = array();
                if(count($openIds) > 0){
                    $nicknameArr = $UserModel->field(array('openid', 'nickname'))->where(array('openid' => array('in', $openIds)))->select();
                    foreach($nicknameArr as $val){
                        $nickNames[$val['openid']] = $val['nickname'];
                    }
                }
                foreach($rankdataArr as $key => $val){
                    $rankDatas[$rankId]['lot_desc'] = $prizeDescArrs[$rankId];
                    $rankDatas[$rankId]['rank_id'] = $rankId;
                    $rankDatas[$rankId]['nickname'] = isset($nickNames[$key]) ? $nickNames[$key] : '未知';
                    $rankId++;
                }
            }
        }
        $headArr = array("奖项", "排行", "用户昵称"); //表头
        //exportExcel($project['title'].'-排行榜信息-' . date("Ymd", time()), $headArr, $rankDatas);
    }

    /* 用户数据 */
    public function userinfo($appid){
        $Model = D('Project');
        $env = (APP_STATUS == 'production') ? $Model::PROJECT_ENV_PRODUCTION : $Model::PROJECT_ENV_TEST;
        $map = array('token' => $appid, 'env' => $env);

        if($env === $Model::PROJECT_ENV_PRODUCTION){
            $map['status'] = $Model::PROJECT_STATUS_ONLINE;
        }else{
            $map['status'] = array('neq', $Model::PROJECT_STATUS_DELETE);
        }
        $project = $Model->where($map)->find();
        if(!$project){
            $this->error('此项目不存在！');
        }
        $id = $project['id'];
        $gameDatas = array();

        $GameDataModel = D('GameData');
        $gamedataMap = array('appid' => $id, 'dtype' => 'exchange');
        $gamedataArr = $GameDataModel->where($gamedataMap)->order('create_time DESC,id DESC')->select();
        if($gamedataArr){
            $count = $GameDataModel->where($gamedataMap)->count();
            $gdId = 0;
            foreach($gamedataArr as $val){
                $dval = $val['dvalue'] ? json_decode($val['dvalue'], true) : array();
                $gameDatas[$gdId]['nickname'] = isset($dval['name']) ? $dval['name'] : '';
                $gameDatas[$gdId]['addr'] = isset($dval['address']) ? $dval['address'] : '-';
                $gameDatas[$gdId]['tel'] = isset($dval['tel']) ? $dval['tel'] : '-';
                $gdId++;
            }
        }
        $headArr = array("用户昵称", "通讯地址", "联系方式"); //表头  
        exportExcel($project['title'].'-用户数据-' . date("Ymd", time()), $headArr, $gameDatas);
    }

    /* 报名信息 */
    public function registerInfo($appid){
        $Model = D('Project');
        $env = (APP_STATUS == 'production') ? $Model::PROJECT_ENV_PRODUCTION : $Model::PROJECT_ENV_TEST;
        $map = array('token' => $appid, 'env' => $env, 'uid' => $this->mid);
        if($env === $Model::PROJECT_ENV_PRODUCTION){
            $map['status'] = $Model::PROJECT_STATUS_ONLINE;
        }else{
            $map['status'] = array('neq', $Model::PROJECT_STATUS_DELETE);
        }
        $project = $Model->where($map)->find();
        if(!$project){
            $this->error('此项目不存在！');
        }
        $id = $project['id'];
        $formDatas = array();
        $settingModel = D('Settings');
        $formItems = $settingModel->getConf($id, 'formitems', '');
        $formItemIds = json_decode($formItems, true);
                
        $formModel = D('FormDict');
        $formItems = $formModel->getFormItemInfo($formItemIds);

        $GameDataModel = D('GameData');
        $gamedataMap = array('appid' => $id, 'dtype' => 'baoming', 'status' => 1);
        $gamedataArr = $GameDataModel->where($gamedataMap)->order('id DESC')->select();
        foreach($gamedataArr as $key => $val){
            $dval = $val['dvalue'] ? json_decode($val['dvalue'], true) : array();
            foreach($formItems as $itemVal){
                $itemKey = $itemVal['name'];
                $formDatas[$key][$itemKey] = isset($dval[$itemKey]) ? $dval[$itemKey] : '';
            }
        }
        
        $headArr[] = '序号';
        foreach($formItems as $k1 => $headerName){
            $headArr[] = $headerName['label'];
            $nameKeys[] = $headerName['name'];
        }
        foreach($formDatas as $k => $d){
            $k++;
            foreach($nameKeys as $key){
                $nameKey['id'] = $k;
                if($key == 'sex'){
                    $kv=(string)$d[$key];
                    if($kv=='1'  OR $kv=='男'){
                        $nameKey[$key] = '男';
                    }else{
                        $nameKey[$key] = '女';
                    }
                }else{
                    $nameKey[$key] = $d[$key];
                }
            }
            $datas[] = $nameKey;
        }
        exportExcel($project['title'].'-报名信息-' . date("Ymd", time()), $headArr, $datas);
    }
}