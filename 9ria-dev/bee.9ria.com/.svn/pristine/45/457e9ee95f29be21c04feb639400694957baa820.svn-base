<?php
namespace Home\Model;
use Think\Model;

class TagModel extends Model {
	protected $tableName = 'sdk_tag';

	protected $_auto = array(
        array('status', 1, self::MODEL_INSERT),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('modify_time', NOW_TIME, self::MODEL_INSERT)
    );

    public function __construct() {
    	parent::__construct();
    }
}