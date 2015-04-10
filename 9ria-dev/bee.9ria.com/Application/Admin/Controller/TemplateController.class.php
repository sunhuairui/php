<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
namespace Admin\Controller;

/**
 * 模型管理控制器
 */
class TemplateController extends AdminController {
	
	/* 操作的表名 */
	protected $tableName = 'gcreator_template';
	/* 操作的模型名 */
	protected $modelName = 'Home/Template';
	
    /**
     * 模型管理首页
     */
    public function index($page = 0) {
    	// 1表示正式环境，0表示测试环境
    	$env = (APP_STATUS == 'production') ? 1 : 0;
    	
    	$page || $page = I ( 'p', 1, 'intval' ); // 默认显示第一页数据
    	
    	$model = M('Model')->getByName($this->tableName);
    	$this->assign('model', $model);
    	
    	// 解析列表规则
    	$list_data = $this->_list_grid ( $model );
    	$grids = $list_data ['list_grids'];
    	$fields = $list_data ['fields'];
    	
    	// 搜索条件
    	//$map = $this->_search_map($model, $fields);
    	$map['env'] = $env;
        
        //下拉框状态搜索 auth@changzhengfei
        $status = I('get.status','','intval');
        if($status=="0" || $status){
            $map['status'] = $status;
        }
        //下拉框选择搜索项进行模糊搜索
        $select_search = I('get.type','','htmlspecialchars');//type(名称/标题/作者)
        $keyword = I('get.name','','htmlspecialchars');//keyword
        if($keyword){
            if($select_search){//按照下拉选项搜索
                if($select_search=='token'){
                    $map[$select_search] =  htmlspecialchars($keyword);
                }else{
                    $map[$select_search] = array('like','%' . htmlspecialchars($keyword) . '%');
                }
            }else{//默认按照名称搜索
                $map['name'] = array('like','%' . htmlspecialchars($keyword) . '%');
            }
        }
        
        
        
    	$row = empty ( $model ['list_row'] ) ? 20 : $model ['list_row'];
    	
    	// 读取模型数据列表
    	empty ( $fields ) || in_array ( 'id', $fields ) || array_push ( $fields, 'id' );
    	$Model = D ( $this->modelName );
    	$data = $Model->field ( empty ( $fields ) ? true : $fields )->where ( $map )->order ( $order )->page ( $page, $row )->select ();
    			
    	/* 查询记录总数 */
    	$count = $Model->where ( $map )->count ();
    	$list_data ['list_data'] = $data;
    	
    	// 分页
    	if ($count > $row) {
    		$page = new \Think\Page ( $count, $row );
    		$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
    		$list_data ['_page'] = $page->show ();
    	}
    	//下拉状态选项查询 auth@changzhengfei
        $model_id = M('Model')->field('id')->getByName($this->tableName);
        $where=array("model_id"=>$model_id['id'],"name"=>"status","status"=>"1");
        $status_extra = M('Attribute')->field(array("title","extra"))->where($where)->find(); 
                
        $this->assign('statusExtra',$status_extra);//项目状态参数
    	$this->assign($list_data);
    	
    	$this->meta_title = '项目列表';
        $this->display();
    }

    /**
     * 新增页面初始化
     */
    public function add() {
    	$model = M('Model')->getByName($this->tableName);
    	$this->assign('model', $model);
    	
    	
    	if (IS_POST) {
    		$Model 	= D ( $this->modelName );
    		
    		$data 	= I('post.');
    		
    		$settings = array();
    		$settings = $Model->getSettingDefault($settings);
    		$settings = $Model->num2Bool($settings);
    		
    		$data['uid'] 		= UID;
    		$data['username'] 	= get_nickname(UID);
    		$data['token'] 		= generate_nonce_str(8);
    		$data['setting'] 	= json_encode($settings);
    		
    		// 获取模型的字段信息
    		$Model 	= $this->checkAttr ( $Model, $model ['id'] );
    		
    		if ($Model->create ($data) && $id = $Model->add ()) {
    			$this->success ( '添加' . $model ['title'] . '成功！', U ( 'index' ) );
    		} else {
    			$this->error ( $Model->getError () );
    		}
    	} else {
    		$fields = get_model_attribute ( $model ['id'] );
    			
    		$this->assign ( 'fields', $fields );
    		$this->meta_title = '新增' . $model ['title'];
        	$this->display();
    	}
    }

    /**
     * 编辑页面初始化
     */
    public function edit($id = 0) {
    	$id || $id = I ( 'id' );
    	
    	$model = M('Model')->getByName($this->tableName);
    	$this->assign('model', $model);
    	
    	$Model = D ( $this->modelName );
    	
    	if (IS_POST) {
    		// 获取模型的字段信息
    		$Model = $this->checkAttr ( $Model, $model ['id'] );
    		if ($Model->create () && $Model->save ()) {
    			$this->success ( '保存' . $model ['title'] . '成功！', U ( 'index' ) );
    		} else {
    			$this->error ( $Model->getError () );
    		}
    	} else {
    		// 获取数据
    		$data = $Model->find ( $id );
    		$data || $this->error ( '数据不存在！' );
    		
    		$fields = get_model_attribute ( $model ['id'] );
    			
    		$this->assign ( 'fields', $fields );
    		$this->assign ( 'data', $data );
    		$this->meta_title = '编辑' . $model ['title'];
        	$this->display();
    	}
    }

    /**
     * 设置一条或者多条数据的状态
    
     */
    public function setStatus($status, $ids = null){
    	
    	! empty ( $ids ) || $ids = I ( 'id' );
    	! empty ( $ids ) || $ids = array_unique ( ( array ) I ( 'ids', 0 ) );
    	! empty ( $ids ) || $this->error ( '请选择要操作的数据!' );
    	! empty ( $status ) || $status = I ( 'status' );
    	
    	$Model = D ( $this->modelName );
    	$map ['id'] = array (
    			'in',
    			$ids
    	);
    	
    	$action = '';
    	//生成属性数据
    	$data = array();
    	switch ($status){
    		case 0 :
    			$data	= array('status' => 0);
    			$action	= '下线';
    			break;
    		case 1 : //未发布
    			$data	= array('status' => 1);
    			$action	= '未发布';
    			break;
    		case 2 : //发布
    			$data	= array('status' => 2);
    			$action	= '发布';
    			break;
    		default :
    			$this->error('参数错误');
    			break;
    	}
    	
    	if ($Model->where ( $map )->save ( $data )) {
    		$this->success ( $action . '成功！');
    	} else {
    		$this->error ( $action . '失败！' );
    	}
    	
    }
    
    /**
     * 删除一条数据
     */
    public function del($ids = null){
    	
    	! empty ( $ids ) || $ids = I ( 'id' );
    	! empty ( $ids ) || $ids = array_unique ( ( array ) I ( 'ids', 0 ) );
    	! empty ( $ids ) || $this->error ( '请选择要操作的数据!' );
    	
    	$Model = D ( $this->modelName );
    	$map ['id'] = array (
    			'in',
    			$ids
    	);
    	
    	if ($Model->where ( $map )->delete ()) {
    		$this->success ( '删除成功' );
    	} else {
    		$this->error ( '删除失败！' );
    	}
    }
    
    /**
     * 访问游戏地址
     */
    public function show($id = 0) {
    	$id || $id = I ( 'id' );
    	
    	$Model = D ( $this->modelName );
    	// 获取数据
    	$data = $Model->find ( $id );
    	$data || $this->error ( '数据不存在！' );
    	
    	redirect('play/' . $data['token']);
    	
    }
}