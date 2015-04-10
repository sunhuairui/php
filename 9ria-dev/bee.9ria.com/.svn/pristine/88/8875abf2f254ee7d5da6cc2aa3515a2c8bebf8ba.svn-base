<?php

namespace Home\Model;
use Think\Model;

class StatLogModel extends Model {
	protected $tableName = 'sdk_stat_log';
    
	protected $_auto = array(
        array('status', 1, self::MODEL_INSERT),
        array('create_time', NOW_TIME, self::MODEL_INSERT)
    );

    public function __construct(){
    	parent::__construct();
    }
    
    public function getPageView($appid, $time = false, $options = array()) {
        if(false !== $time) $this->getTblName($time);
        
        $map = array();
        
        if (is_array($appid)) {
            $map['appid'] = array('in', $appid);
        } else {
            $map['appid'] = $appid;
        }
        
        $map['controller'] = 'sdk';
        $map['action'] = 'pageview';
        $map['status'] = 1;
        $group = '';
        $field = "COUNT(id) AS count";
        
        $returnNum = true;
        
        if(is_array($options)) {
        	$where = isset($options['where']) && $options['where'] && is_array($options['where']) ? $options['where'] : array();
        	$map = array_merge($map, $where);
        	$group = isset($options['group']) && $options['group'] && is_string($options['group']) ? $options['group'] : '';
        	$field .= isset($options['field']) && $options['field'] && is_string($options['field']) ? ','. $options['field'] : '';
        	$returnNum = isset($options['num']) && $options['num'] === false ? false : true;
        }
        
        $data = $this->field($field)->where($map)->group($group)->select();
        if(false === $returnNum) {
            return $data ? $data : array();
        } else {
            return $data[0]['count'] ? $data[0]['count'] : 0;
        }
    }
    
    public function getUserView($appid, $time = false, $options = array()) {
        if(false !== $time) $this->getTblName($time);
        
        $map = array();
        
        if (is_array($appid)) {
            $map['appid'] = array('in', $appid);
        } else {
            $map['appid'] = $appid;
        }
        
        $map['controller'] = 'sdk';
        $map['action'] = 'pageview';
        $map['status'] = 1;
        $group = '';
        $field = 'COUNT(DISTINCT openid) AS count';
        
        $returnNum = true;
        
        if(is_array($options)) {
        	$where = isset($options['where']) && $options['where'] && is_array($options['where']) ? $options['where'] : array();
        	$map = array_merge($map, $where);
        	$group = isset($options['group']) && $options['group'] && is_string($options['group']) ? $options['group'] : '';
        	$field .= isset($options['field']) && $options['field'] && is_string($options['field']) ? ','. $options['field'] : '';
        	$returnNum = isset($options['num']) && $options['num'] === false ? false : true;
        }
        
        $data = $this->field ($field)->where ($map)->group ($group)->select ();
        
        if(false === $returnNum) {
            return $data ? $data : array();
        } else {
            return $data[0]['count'] ? $data[0]['count'] : 0;
        }
        
    }
    
    public function getShareCount($appid, $time = false, $options = array()) {
        if(false !== $time) $this->getTblName($time);
        
        $map = array();
        
        if (is_array($appid)) {
            $map['appid'] = array('in', $appid);
        } else {
            $map['appid'] = $appid;
        }
        
        $map['status'] = 1;
        $map['controller'] = 'wxshare';
        $map['action'] = array('in', array('success_time_line', 'success_app_message', 'success_qq', 'success_weibo'));
        $group = '';
        $field = 'COUNT(id) AS count';
        
        $returnNum = true;
        
        if(is_array($options)){
        	$where = isset($options['where']) && $options['where'] ? $options['where'] : array();
        	$map = array_merge($map, $where);
        	$group = isset($options['group']) && $options['group'] && is_string($options['group']) ? $options['group'] : '';
        	$field .= isset($options['field']) && $options['field'] && is_string($options['field']) ? ','. $options['field'] : '';
        	$returnNum = isset($options['num']) && $options['num'] === false ? false : true;
        }
        
        $data = $this->field ($field)->where ($map)->group ($group)->select ();
        
        if(false === $returnNum) {
            return $data ? $data : array();
        } else {
            return $data[0]['count'] ? $data[0]['count'] : 0;
        }
    }
    
    
    private function getTblName($time = false) {
        if(false !== $time) $this->tableName .=  '_' . date("Ym", $time);
    }
}