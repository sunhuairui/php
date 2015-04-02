<?php
namespace Home\Controller\Index;
use Think\Controller;

class  index extends Controller{
	public function _before_run(){
		echo "before_".ACTION_NAME."<br>";
	}
	
	public function run(){
		echo "执行".CONTROLLER_NAME."控制器的".ACTION_NAME."操作"."<br>";
	}
	
   public function _after_run(){
   	  echo "aftre_".ACTION_NAME."<br>";
   }
   
}
