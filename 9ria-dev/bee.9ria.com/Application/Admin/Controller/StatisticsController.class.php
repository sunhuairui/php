<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
namespace Admin\Controller;

/**
 * 数据统计模型管理控制器
 */
class StatisticsController extends AdminController {
    
    public function index($page = 0) {
        $title || $title = I('title', '');
        // 1表示正式环境，0表示测试环境
        $Model = D('Home/Project');
        $env = (APP_STATUS == 'production') ? $Model::PROJECT_ENV_PRODUCTION : $Model::PROJECT_ENV_TEST;
         
        $page || $page = I ( 'p', 1, 'intval' ); // 默认显示第一页数据
        $row = empty ( $model ['list_row'] ) ? 20 : $model ['list_row'];
        
        $model = M('Model')->getByName('gcreator_project');
//         $model['search_key'] = is_numeric($title) ? 'id' : 'title';
        $this->assign('model', $model);
         
        // 解析列表规则
        $list_data = $this->_list_grid ( $model );
        array_pop($list_data ['list_grids']);
        $list_data ['list_grids'][] = array(
                'field' => array(0=>'id'),
                'title' => '操作',
                'href' => '/'. CONTROLLER_NAME .'/view?id=[id]|查看',
        );
        $fields = $list_data ['fields'];
 
        // 搜索条件
        if($title) $map[is_numeric($title) ? 'id' : 'title'] = array('like','%' . htmlspecialchars ($title) . '%');
        $map['env'] = $env;
        $order = 'create_time DESC,id DESC';
        
        if ($env === $Model::PROJECT_ENV_PRODUCTION) {
            $map['status'] = $Model::PROJECT_STATUS_ONLINE;
        } else {
            $map['status'] = array('neq', $Model::PROJECT_STATUS_DELETE);
        }
        // 读取模型数据列表
        empty ( $fields ) || in_array ( 'id', $fields ) || array_push ( $fields, 'id' );
        $data = $Model->field ( empty ( $fields ) ? true : $fields )->where ( $map )->order ( $order )->page ( $page, $row )->select ();
        
        /* 查询记录总数 */
        $count = $Model->where ( $map )->count ();
        $list_data ['list_data'] = $data;
        // 分页
        if ($count > $row) {
            $page = new \Think\Page ( $count, $row );
            $page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
            $list_data ['_page'] = $page->show ();
        }
         
        $this->assign($list_data);
         
        $this->meta_title = '项目列表';
        $this->display();
    }
    
    public function view($id = 0) {
        $code || $code = I('code', '');        
        $Model = D('Home/Project');
        
        $env = (APP_STATUS == 'production') ? $Model::PROJECT_ENV_PRODUCTION : $Model::PROJECT_ENV_TEST;
        $map = array('id' => $id, 'env' => $env);
        if ($env === $Model::PROJECT_ENV_PRODUCTION) {
            $map['status'] = $Model::PROJECT_STATUS_ONLINE;
        } else {
            $map['status'] = array('neq', $Model::PROJECT_STATUS_DELETE);
        }
        
        $project = $Model->where ( $map)->find ();
        if (!$project) {
            $this->error('此项目不存在！');
        }
        
        // 解析列表规则
        $list_data['list_grids'] = array(
        	array('field' => array('id'), 'title' => '序号'),
            array('field' => array('lot_name'), 'title' => '奖品名称'),
            array('field' => array('lot_desc'), 'title' => '奖品描述'),
            array('field' => array('nickname'), 'title' => '用户昵称'),
            array('field' => array('tel'), 'title' => '电话'),
            array('field' => array('addr'), 'title' => '地址'),
        );
        
        $list_data ['fields'] = array('id', 'lot_name', 'lot_desc', 'nickname', 'tel', 'addr');
        $page = I('p', 1, 'intval');
        $row = I('list_row', 20, 'intval');
        $gdId = ($page - 1) * $row + 1;
        
        $gameDatas = array();
        $htmlPage = '';

        $SettingModel = D('Home/Settings');
        $LotteryLogModel = D('Home/LotteryLog');
        $raffleType = $SettingModel->getConf($id, 'raffletype', $LotteryLogModel::LOT_TYPE_NONE);
        
        if($raffleType == $LotteryLogModel::LOT_TYPE_RAFFLE) {   
            $GameDataModel = D('Home/GameData');
            $gamedataMap = array('appid'=>$id, 'dtype'=>'exchange', 'status'=>1);
            if ($code) $gamedataMap['dvalue'] = array('LIKE', '%'. str_replace('"', '', json_encode($code)) .'%');
            $gamedataArr = $GameDataModel->where($gamedataMap)->order('create_time DESC,id DESC') ->page($page, $row)->select ();
            if ($gamedataArr) {
                $count = $GameDataModel->where($gamedataMap)->count();
                // 分页
                if ($count > $row) {
                    $page = new \Think\Page ( $count, $row );
                    $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
                    $list_data ['_page'] = $page->show ();
                }
            
                $logIds = $lotterysArrs = $lotterysLotIds = array();
                foreach ($gamedataArr as $val) {
                    if($val['dkey']) $logIds[] = $val['dkey'];
                }
                if(count($logIds) > 0) {
                    $lotterylogMap = array('appid' => $id, 'status' => 1, 'lot_type'=>$raffleType, 'lot_id'=>array('neq', 0), 'id'=>array('IN', $logIds));
                    $lotterysArrs = $LotteryLogModel->where ( $lotterylogMap )->select ();
                    foreach ($lotterysArrs as $val) {
                        $lotterysLotIds[$val['id']] = $val['lot_id'];
                    }
                }
            
                $LotteryPrizeModel = D('Home/LotteryPrize');
                $prizeArrs = $LotteryPrizeModel->getAllPrize($id);
            
                foreach ($gamedataArr as $val) {
                    $gameDatas[$gdId]['id'] = $gdId;
                    $lotName = $lotDesc = '';
                    if($val['dkey']) {
                        $lotId = isset($lotterysLotIds[$val['dkey']]) ? $lotterysLotIds[$val['dkey']] : 0;
                        $lotName = isset($prizeArrs[$lotId]) ? $prizeArrs[$lotId]['lot_name'] : '';
                        $lotDesc = isset($prizeArrs[$lotId]) ? $prizeArrs[$lotId]['lot_desc'] : '';
                    }
            
                    $gameDatas[$gdId]['lot_name'] = $lotName;
                    $gameDatas[$gdId]['lot_desc'] = $lotDesc;
                    $dval = $val['dvalue'] ? json_decode($val['dvalue'], true) : array();
                    $gameDatas[$gdId]['nickname'] = isset($dval['name']) ? $dval['name'] : '';
                    $gameDatas[$gdId]['tel'] = isset($dval['tel']) ? $dval['tel'] : '';
                    $gameDatas[$gdId]['addr'] = isset($dval['address']) ? $dval['address'] : '';
                    $gdId++;
                }
            } 
        }
        
        $list_data ['list_data'] = $gameDatas;
        $list_data ['errorHtml'] = $raffleType == $LotteryLogModel::LOT_TYPE_RAFFLE ? ' aOh! 暂时还没有内容! ' : ' aOh! 此项目抽奖类型为非一般抽奖，因此无兑奖数据! ';
        $this->assign('project', $project);
        $this->assign($list_data);
         
        $this->meta_title = '项目列表';
        $this->display();
    }
}