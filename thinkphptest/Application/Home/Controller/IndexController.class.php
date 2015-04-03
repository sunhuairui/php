<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	
    public function indexAction(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
        echo "执行index控制器的index操作";
    }
    
    public function test(){
    	echo "test";
    }
    
    public function userAction(){
//     	$this->error('dfafdafda', 'http://www.baidu.com');
		//$connection = "DB_CONFIG1";
    	$User =D("User");
    	//$User -> where("id= 10 AND age = 20") ->select();
    	//预处理
//     	$id = 2;
//     	$age = 20;
//     	$User -> where("id = %d AND age = %s",array($id,$age)) ->select();
//     	$User -> where("id=%d AND age = %s",$id,$age) ->select();
//     	$map["id"] = 2;
//     	$map["age"] = 20;
//     	$User -> where($map) ->select();    	
//     	$User -> field("user.name,role.label")
//     	->table("think_user user,role role") -> select();
//   			$data['firstName'] = "王五";
//   			$data['sex'] = "男";
//   			$data['age']= "18";  			
//   			$User -> data($data) -> add();
//   			$User -> field("id,SUM(age)") -> select();
//   			$User -> field(array("id","firstName" => "nickname")) ->select();
//   			$User -> field(true) -> select();
//           $User -> field("id,sex",true)  ->select();
// 			 $User -> field("id,firstName,sex,age")->create();
			 //$User -> where("age=20") -> field("id,firstName") -> limit(5) -> select();
// 			 $User -> limit("0,3") -> select();			
// 				$User -> page(1,4)  -> select();
// 			 $User -> page(3,3) -> select();
// 			 $User -> field("id,firstName,sex") -> where("age = 20") -> group("firstName") -> select();
//group and having practice.
//           $User -> field("id,firstName") -> group("age") -> having("age > 20") -> select();
          // join  practice.
//           $User 
//           -> join("role on role.id = user.role_id") 
//           -> select();
          //right join
          //$User -> join("role on role.user_id = user.id","right") -> select();
          $user_data = $User -> field("*") -> select();
          dump($user_data);
    	    dump($User);
    	echo "user";
    }

	public function roleAction(){		
		$Role = M("Role");		
		dump($Role);
		echo 'role';
	}
}