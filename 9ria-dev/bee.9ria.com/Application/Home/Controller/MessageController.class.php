<?php

namespace Home\Controller;

class MessageController extends HomeController {
    // 初始化操作
    protected function _initialize(){
        parent::_initialize();
        if(!is_login()){
            redirect(U('User/newlogin'));
        }
    }
 
    public function index(){
        $message = D('Message');
        $message_data = $message->get_message_data();
        echo $message->getLastSql()."<hr>"; 
        
        $page = I ( 'p', 1, 'intval' );
    	$row = I('list_row', 10, 'intval');
        
        // 分页
        $count = count($message_data);
        if ($count > $row) {
            $pageObj = new \Think\Page($count, $row);
            $pageObj->rollPage = $row;
            $pageObj->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
            $htmlPage = $pageObj->show();
            $this->assign('page', $htmlPage);
        }
        $items = array_slice($message_data, ($page - 1) * $row, $row);
        
        $this->assign('items', $items);
        $this->display("Bee1/message");
    }
    public function indexs(){
        $message = D('Message');
        $items = $message->get_latest_message();
        echo $message->getLastSql()."<hr>";
        echo "<pre>";var_dump($items);echo "</pre>";
        
        $this->display("Bee1/message");
    }
}