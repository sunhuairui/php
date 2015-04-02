<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
	protected $tableName = 'user';
	protected $dbName    = 'my_db';
	protected $fields         = array("id","firstName","sex","age",
	                 "_type" => array("id"=>"int","firstName"=>"varchar","sex"=>"char","age"=>"int")
	);
	protected $pk             = "id";
}