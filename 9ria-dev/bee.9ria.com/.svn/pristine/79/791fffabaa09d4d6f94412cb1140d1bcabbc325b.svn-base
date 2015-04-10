<?php

namespace Home\Model;
use Think\Model;

class LotteryPrizeModel extends Model {
    // 操作状态
    const PRIZE_STATUS_ONLINE   =   1;      //  奖品状态正常
    const PRIZE_STATUS_OFFLINE  =   0;      //  奖品状态下架
    
    private static $_prizeStatus = array(
            self::PRIZE_STATUS_ONLINE   => '正常',
            self::PRIZE_STATUS_OFFLINE  => '下架'
    );
    
    //抽奖类型
    const LOT_TYPE_RAFFLE   = 0;    //  默认奖品
    const LOT_TYPE_EXCHANGE = 1;    //  绑定兑换码
    const LOT_TYPE_RANK     = 2;    //  排行榜
    const LOT_TYPE_NONE     = 3;	//  无
	const LOT_TYPE_FORM     = 4;	//  报名表单
    
	protected $tableName = 'sdk_lottery_prize';

    public function __construct(){
    	parent::__construct();
    }
    
    public function getAllPrize($appid, $status = self::PRIZE_STATUS_ONLINE, $type = false) {
    	$map = array(
    	        'appid' => $appid,
    	        'status' => ($status == self::PRIZE_STATUS_ONLINE ? self::PRIZE_STATUS_ONLINE : self::PRIZE_STATUS_OFFLINE)
    	);
    	
    	if(false !== $type) {
    	    $map['lot_type'] = $type == self::LOT_TYPE_EXCHANGE ? self::LOT_TYPE_EXCHANGE : self::LOT_TYPE_RAFFLE;
    	}
    	
    	$prizesArr = $this->where ( $map )->select ();
    	$prizes = array();
    	foreach ($prizesArr as $prize) {
    		$prizes[$prize['lot_id']] = $prize;
    	}
    	return $prizes;
    }
    
}