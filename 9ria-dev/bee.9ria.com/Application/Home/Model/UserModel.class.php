<?php

namespace Home\Model;
use Think\Model;

class UserModel extends Model {
	protected $tableName = 'sdk_user';

    public function __construct(){
    	parent::__construct();
    }
}