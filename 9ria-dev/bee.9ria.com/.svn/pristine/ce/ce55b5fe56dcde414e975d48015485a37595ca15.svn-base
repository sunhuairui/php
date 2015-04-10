<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
namespace Home\Model;
use Think\Model;

class StatLogMapModel extends Model {
	
	/* 自动验证规则 */
	protected $_validate = array(
			array('name', 'require', '名称不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_INSERT),
			array('name', '/^[a-zA-Z]\w{0,39}$/', '名称不合法', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
			array('title', 'require', '中文名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
			array('title', '1,40', '中文名称长度不能超过40个字符', self::VALUE_VALIDATE, 'length', self::MODEL_BOTH),
			
	);
	
	/* 自动完成规则 */
	protected $_auto = array(
			array('status', 1, self::MODEL_INSERT),
			array('create_time', 'time', self::MODEL_INSERT, 'function'),
			array('modify_time', 'time', self::MODEL_BOTH, 'function'),
	);
	
	protected $tableName = 'sdk_stat_log_map';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function checkName($name){
		$row = $this->where(array('name'=>$name))->find();
		if(!$row){
			return false;
		}
        
		return true;
	}

}