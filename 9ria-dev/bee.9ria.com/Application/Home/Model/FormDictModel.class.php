<?php
namespace Home\Model;
use Think\Model;

class FormDictModel extends Model {
	protected $tableName = 'sdk_form_dict';
    protected $cache_time = 10;

    protected $_auto = array(
        array('status', 1, self::MODEL_INSERT),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('modify_time', NOW_TIME, self::MODEL_INSERT)
    );

    public function __construct() {
    	parent::__construct();
    }
    
    
    // 获取指定key的值
    public function getConf($appid, $key, $default = '') {
        $data = $this->where (array(
                'appid'     => $appid,
                'status'    => 1,
                'item_key'  => $key
        ))->find ();
        return $data ? (isset($data['item_value']) ? $data['item_value'] : $default) : $default;
    }
    
    
    public function getFormItem($ids) {
        
        $map = array();
        if (is_array($ids)) {
            $map['id'] = array('IN', $ids);
            $order = implode($ids, ',');
        } else {
            $map['id'] = $ids;
            $order = $ids;
        }
        
        $map['status'] = 1;
        $rows = $this->where ($map)->order ("FIELD(`id`,". $order .")")->select ();
        return $rows;
    }
    
    public function getFormItemInfo($ids) {
        $rows = $this->getFormItem($ids);
        $ret = array();
        if($rows) {
            foreach ($rows as $key => $row) {
                $ret[$key] = array(
                    'id'  => $row['id'],
                    'name'  => $row['name'],
                    'label' => $row['label'],
                    'type'  => $row['type'],
                    'rule'  => $row['rule']
                );
            }
        }
        return $ret;
    }
    
    public function getFormItemByDefault() {
        $map['is_default'] = 1;
        $map['status'] = 1;
        $rows = $this->where ($map)->order ("sort DESC,id ASC")->select ();
        $ret = array();
        if($rows) {
            foreach ($rows as $key => $row) {
                $ret[$key] = array(
                    'id'  => $row['id'],
                    'name'  => $row['name'],
                    'label' => $row['label'],
                    'type'  => $row['type'],
                    'rule'  => $row['rule']
                );
            }
        }
        return $ret;
    }
    
    public function getFormItemByUid($uid) {
        $map['uid'] = $uid;
        $map['status'] = 1;
        $map['is_default'] = array('neq', 1);
        $rows = $this->where ($map)->order ("sort DESC,id ASC")->select ();
        $ret = array();
        if($rows) {
            foreach ($rows as $key => $row) {
                $ret[$key] = array(
                    'id'  => $row['id'],
                    'name'  => $row['name'],
                    'label' => $row['label'],
                    'type'  => $row['type'],
                    'rule'  => $row['rule']
                );
            }
        }
        return $ret;
    }
}