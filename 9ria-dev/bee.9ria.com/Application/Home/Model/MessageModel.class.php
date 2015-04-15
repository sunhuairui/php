<?php
namespace Home\Model;
use Think\Model;

class MessageModel extends Model {
    
    protected $tableName = 'sdk_message';
    
    public function __construct(){
    	parent::__construct();
    }
    /**
     * 获取当前用户最新的消息 type为系统广播 status为发布
     * **/
    public function get_latest_message(){
        $current_user = is_login();
        $order = " `create_times` DESC "; 
        $map  = array("creator_id"=>$current_user,"type"=>1,"status"=>2);
    	$data = $this->where( $map )->order( $order )->find();
        
        $message_id=$data['id'];
        $where = array('message_id'=>$message_id);
    	$message_log = M('sdk_message_log')->where( $where )->count();
    	
        if($message_log){
            return false;
        }else{
            return $data;
        }
    }
    
    //获取当前用户所有系统消息数据
    public function get_message_data($id=""){
        $current_user = is_login();
        $order = " `create_times` DESC "; 
        $map  = array("creator_id"=>$current_user,"type"=>1,"status"=>2);
        if($id){
            $map["id"]=$id;
        }
    	$data = $this->where( $map )->order( $order )->select();
    	
        if($data){
            return $data;
        }else{
            return false;
        }
    }
    //获取当前用户所有系统消息总数量
    public function get_message_data_count(){
        $current_user = is_login();
        $map  = array("creator_id"=>$current_user,"type"=>1,"status"=>2);
    	$count = $this->where( $map )->count();
        if($count){
            return $count;
        }else{
            return  0;
        }
    }
}