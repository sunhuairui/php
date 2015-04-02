<?php
namespace Home\Controller;
use Think\Controller;
class BlogController extends Controller{
	public function read($id="2"){
		echo "id=".$id;
	}
	public function archive($year="2015",$month="01"){
		echo "year=".$year.",month=".$month;
	}
}