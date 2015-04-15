<?php
namespace Home\Model;
use Think\Model;

class CategoryBeeModel extends Model {
	protected $tableName = 'sdk_category';

    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 0;
    
	protected $_auto = array(
        array('status', 1, self::MODEL_INSERT),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('modify_time', NOW_TIME, self::MODEL_INSERT)
    );

    public function __construct(){
    	parent::__construct();
    }
    
    // 获取分类信息
    public function getCategories($field = true, $pageno = 1, $pagenum = 10, $order = '') {
        $map = array();
        $map['status'] = array('neq', self::STATUS_DELETE);
        if (empty($order)) {
            return $this->field($field)->where($map)->page($pageno, $pagenum)->select();
        } else {
            return $this->field($field)->where($map)->order($order)
                ->page($pageno, $pagenum)->select();
        }
    }
}