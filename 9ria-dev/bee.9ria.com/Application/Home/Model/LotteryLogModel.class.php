<?php

namespace Home\Model;
use Think\Model;

class LotteryLogModel extends Model {
	protected $tableName = 'sdk_lottery_log';

	//抽奖类型
    const LOT_TYPE_RAFFLE   = 0;    //  默认奖品
    const LOT_TYPE_EXCHANGE = 1;    //  绑定兑换码
    const LOT_TYPE_RANK     = 2;    //  排行榜
    const LOT_TYPE_NONE     = 3;	//  无
	const LOT_TYPE_FORM     = 4;	//  报名表单
	
    public function __construct(){
    	parent::__construct();
    }
    
    
    public function statLotteryLogInfo ($appid) {
    	$map = array('appid' => $appid, 'status' => 1);
    	return $this->where ( $map )->select ();
    }
}