<?php

namespace Home\Controller;

class CardController extends HomeController {
    // 卡片编辑页面
    public function editor() {
        // 编辑页面 
        $this->display('Bee1/cardeditor');
    }
    
    // 保存卡片设置
    public function saveSetting() {
        
    }
    
}