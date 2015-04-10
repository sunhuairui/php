<?php

namespace Home\Model;
use Think\Model;

class GameCodeModel extends Model {
    // 操作状态
    const GAMECODE_STATUS_UNEXCHANGE =   2;      //  奖品未发出
    const GAMECODE_STATUS_EXCHANGED  =   1;      //  奖品已兑换
    const GAMECODE_STATUS_RECEIVE  =   3;      //  奖品已发出
    
    private static $_gamecodeStatus = array(
            self::GAMECODE_STATUS_UNEXCHANGE    => '未发出',
            self::GAMECODE_STATUS_EXCHANGED     => '已兑换',
            self::GAMECODE_STATUS_RECEIVE     => '已发出'
    );
    
	protected $tableName = 'sdk_gamecode';

    public function __construct(){
    	parent::__construct();
    }
}