<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
namespace Home\Model;
use Think\Model;

class ProjectModel extends Model {
    // 操作状态
    const PROJECT_STATUS_ONLINE     =   2;      //  项目状态已上线
    const PROJECT_STATUS_OFFLINE    =   1;      //  更新模型数据
    const PROJECT_STATUS_DELETE     =   0;      //  包含上面两种方式
	
    private static $_projectStatus = array(
            self::PROJECT_STATUS_ONLINE     => '已上线',
            self::PROJECT_STATUS_OFFLINE    => '已下线',
            self::PROJECT_STATUS_DELETE     => '已删除',
    );
    
    // 生产环境
    const PROJECT_ENV_PRODUCTION    =   1;      //  正式线上环境
    const PROJECT_ENV_TEST          =   0;      //  开发环境
    
    private static $_projectEnv = array(
            self::PROJECT_ENV_TEST,
            self::PROJECT_ENV_PRODUCTION
    );
    
	/* 自动验证规则 */
	protected $_validate = array(
			array('name', 'require', '名称不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_INSERT),
			array('name', '/^[a-zA-Z]\w{0,39}$/', '名称不合法', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
			array('title', 'require', '中文名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
			array('title', '1,40', '中文名称长度不能超过40个字符', self::VALUE_VALIDATE, 'length', self::MODEL_BOTH),
			
	);
	
	/* 自动完成规则 */
	protected $_auto = array(
			array('status', 2, self::MODEL_INSERT),
			array('create_time', 'time', self::MODEL_INSERT, 'function'),
			array('modify_time', 'time', self::MODEL_BOTH, 'function'),
	);
	
	protected $tableName = 'gcreator_project';
	
	/* 项目设置自动验证规则 */
	protected $_setting_validate = array(
			array('FIRST_INIT_TIMES', 'require', '首次登录游戏抽奖初始值不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
			array('FIRST_INIT_TIMES', '/^(0|[1-9]\d*)$/', '首次登录游戏抽奖初始值必须为正整数', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
			array('DAY_OF_FREE_TIMES', 'require', '每天赠送次数值不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
			array('DAY_OF_FREE_TIMES', '/^(0|[1-9]\d*)$/', '每天赠送次数值必须为正整数', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
			array('TIMES_PER_SHARE_CLICK', 'require', '每次分享增加次数值不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
			array('TIMES_PER_SHARE_CLICK', '/^(0|[1-9]\d*)$/', '每次分享增加次数值必须为正整数', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
			array('DIFFCULT_PROBABILITY', 'require', '抽奖概率值不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
			array('DIFFCULT_PROBABILITY', '/^(0|[1-9]\d*)$/', '抽奖概率值必须为正整数', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
			array('MAX_POOL_SIZE', 'require', '奖池大小值不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
			array('MAX_POOL_SIZE', '/^(0|[1-9]\d*)$/', '奖池大小值必须为正整数', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
			array('NON_AWARD_ID_PROBABILITY', 'require', '非中奖ID概率值不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
			array('NON_AWARD_ID_PROBABILITY', '/^(0|[1-9]\d*)$/', '非中奖ID概率值必须为正整数', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
			array('ENABLE_FIRST_AWARD', '/^(0|1)$/', '中奖开关必须为布尔值', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
			array('ENABLE_APP', '/^(0|1)$/', '应用状态开关必须为布尔值', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
			array('CLOSE_EXCHANGE', '/^(0|1)$/', '关闭兑换开关必须为布尔值', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
			array('sort', '/^(min|max)$/', '排序规则必须为布尔值', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
			array('order', '/^(asc|desc)$/', '排列顺序必须为布尔值(asc|desc)', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
			array('RELATION_ACTION', 'require', '关联操作不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
			array('RELATION_ACTION', '/^[a-zA-Z]\w{0,39}$/', '关联操作必须为40位以内的字符串', self::VALUE_VALIDATE, 'regex', self::MODEL_BOTH),
	);
	
	/* 项目设置自动完成规则 */
	protected $_setting_auto = array(
			array('FIRST_INIT_TIMES', 1, self::MODEL_INSERT),
			array('DAY_OF_FREE_TIMES', 3, self::MODEL_INSERT),
			array('TIMES_PER_SHARE_CLICK', 1, self::MODEL_INSERT),
			array('DIFFCULT_PROBABILITY', 1, self::MODEL_INSERT),
			array('MAX_POOL_SIZE', 100, self::MODEL_INSERT),
			array('NON_AWARD_ID_PROBABILITY', 3000, self::MODEL_INSERT),
			array('ENABLE_FIRST_AWARD', 1, self::MODEL_INSERT),
			array('ENABLE_APP', 1, self::MODEL_INSERT),
			array('CLOSE_EXCHANGE', 0, self::MODEL_INSERT),
			array('sort', 'max', self::MODEL_INSERT),
			array('order', 'asc', self::MODEL_INSERT),
			array('RELATION_ACTION', 'addfriendscore', self::MODEL_INSERT),
	);
	
	/* 项目设置属性设置 */
	protected $_setting_attribute = array(
			array('FIRST_INIT_TIMES', '首次登录游戏抽奖初始值', '', 'num', '1', ''),
			array('DAY_OF_FREE_TIMES', '每天赠送次数值', '每天赠送抽奖次数值', 'num', '3', ''),
			array('TIMES_PER_SHARE_CLICK', '每次分享增加次数值', '点击一次分享链接增加的抽奖次数', 'num', '1', ''),
			array('DIFFCULT_PROBABILITY', '抽奖概率值', '', 'num', '1', ''),
			array('MAX_POOL_SIZE', '奖池大小值', '', 'num', '1000', ''),
			array('NON_AWARD_ID_PROBABILITY', '非中奖ID概率值', '获取非中奖ID的概率，相对于奖池', 'num', '3000', ''),
			array('ENABLE_FIRST_AWARD', '中奖开关', '是否保证第一次得中奖', 'bool', '1', '1:开启;0:关闭'),
			array('ENABLE_APP', '应用状态开关', '是否开启应用', 'bool', '1', '1:开启;0:关闭'),
			array('CLOSE_EXCHANGE', '关闭兑换开关', '是否关闭兑奖', 'bool', '1', '1:关闭;0:开启'),
			array('sort', '排序规则', '', 'radio', 'max', 'min:从小到大;max:从大到小'),
			array('order', '排列顺序', '', 'radio', 'asc', 'asc:正序;desc:倒序'),
			array('RELATION_ACTION', '关联操作', '', 'string', 'addfriendscore', ''),
	);
	
	/* 项目设置bool值特殊处理数组 */
	protected $_setting_bool = array('ENABLE_FIRST_AWARD', 'ENABLE_APP', 'CLOSE_EXCHANGE');
	
	/**
	 * 数据库连接
	 * @var string
	 */
	protected $connection = '';
	
	public function __construct() {
		if('production' !== APP_STATUS) {
			$mode = include CONF_PATH.'production.php';
			$this->connection = array(
					'db_type' 	=> $mode['DB_TYPE'],
					'db_user' 	=> $mode['DB_USER'],
					'db_pwd'  	=> $mode['DB_PWD'],
					'db_host' 	=> $mode['DB_HOST'],
					'db_port' 	=> $mode['DB_PORT'],
					'db_name' 	=> $mode['DB_NAME'],
			);
		}
		/* 执行构造方法 */
		parent::__construct();
	}
	
	public function checkName($name){
		$row = $this->where(array('name'=>$name))->find();
		if(!$row){
			return false;
		}
        
		return true;
	}

	public function getInfoByAppid($appid, $field = true) {
		$map['id'] = $appid;
		return $this->field($field)->where($map)->select();
	}
	
	public function updateStatus($appid, $status = 0){
		$data ['token'] 	= $appid;
		$save ['status'] = (int)$status;
		$res = $this->where($data)->save($save);
		
	}
	
	public function getInfoByToken($appid, $field = true) {
		$map['token'] = $appid;
		return $this->field($field)->where($map)->select();
	}
	
	public function getInfoByTemplateid($templateid, $field = true) {
		$map['template_id'] = $templateid;
		return $this->field($field)->where($map)->select();
	}
	
	public function getInfoByUid($uid, $field = true) {
		$map['uid'] = $uid;
		return $this->field($field)->where($map)->select();
	}
	
	public function checkProjectStatus($status) {
	    $projectStatus = self::$_projectStatus;
	    return array_key_exists($status, $projectStatus) ? $status : false;
	}
	
	public function getNameByProjectStatus($status) {
	    $projectStatus = self::$_projectStatus;
	    return array_key_exists($status, $projectStatus) ? $projectStatus[$status] : '';
	}
	
	public function getProjectEnv($env) {
	    $projectEnv = $this->_projectEnv;
	    return array_key_exists($env, $projectEnv) ? $projectEnv[$env] : self::PROJECT_ENV_TEST;
	}
	
	public function getSettingAttribute() {
		// 关闭数据库字段检测
		$this->autoCheckFields = false;
		$fields = array();
		if(!empty($this->_setting_attribute)) {
			$_attribute = $this->_setting_attribute;
            foreach($_attribute as $key => $attrval) {
            	$name 		= $attrval[0];
            	$fields[$name] = array(
					'name' 		=> $name,
					'title' 	=> isset($attrval[1]) ? $attrval[1] : '',
					'remark'	=> isset($attrval[2]) ? $attrval[2] : '',
					'type' 		=> isset($attrval[3]) ? $attrval[3] : '',
					'value'		=> isset($attrval[4]) ? $attrval[4] : '',
            		'extra'		=> isset($attrval[5]) ? $attrval[5] : '',
            		'is_show' 	=> '1'
            	);
            }
		}
		return $fields;
	}
	
	public function getSettingDefault(&$data) {
		$fields = $this->getSettingAttribute();
		foreach ($fields as $field){
			if(!isset($data[$field['name']])) {
				$data[$field['name']] = $field['value'];
			}
		}
		return $data;
	}
	
	public function getSettingBool() {
		return (!empty($this->_setting_bool)) ? $this->_setting_bool : array();
	}
	
	public function getSettingValidate() {
		return (!empty($this->_setting_validate)) ? $this->_setting_validate : array();
	}
	
	public function getSettingAuto() {
		return (!empty($this->_setting_auto)) ? $this->_setting_auto : array();
	}
	
	/*
	 * 布尔值转整型值
	*/
	public function bool2Num(&$data) {
		if($fields = $this->getSettingBool()) {
			foreach ($fields as $val) {
				if(isset($data[$val])) $data[$val] = intval($data[$val]);
			}
		}
		return $data;
	}
	
	/*
	 * 整型值转布尔值
	*/
	public function num2Bool(&$data) {
		if($fields = $this->getSettingBool()) {
			foreach ($fields as $val) {
				if(isset($data[$val])) $data[$val] = boolval($data[$val]);
			}
		}
		return $data;
	}
}