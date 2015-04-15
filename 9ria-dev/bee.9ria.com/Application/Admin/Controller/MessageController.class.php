<?php
namespace Admin\Controller;

/**
 * 模型管理控制器
 */
class MessageController extends AdminController{
	
    /* 操作的表名 */
    protected $tableName = 'sdk_message';
    /* 操作的模型名 */
    protected $modelName = 'sdk_message';

    public function index($page = 0){
        // 1表示正式环境，0表示测试环境
    	$env =(APP_STATUS == 'production') ? 1 : 0; 
    	$page || $page = I( 'p', 1, 'intval' ); // 默认显示第一页数据
    	
    	$model = M('Model')->getByName($this->tableName);
    	$this->assign('model', $model);
                
    	// 解析列表规则
    	$list_data = $this->_list_grid( $model );
    	$grids = $list_data['list_grids'];
    	$fields = $list_data['fields']; 
    	 
        //下拉框状态搜索
        $status = I('get.status','','intval');
        if($status=="0" || $status){
            $map['status'] = $status;
        }
        $keyword = I('get.'.$model['search_key'],'','htmlspecialchars');//keyword
        if(trim($keyword)!==''){
            $map[$model['search_key']] = array('like','%' . htmlspecialchars(trim($keyword)) . '%');
            $map['contents'] = array('like','%' . htmlspecialchars(trim($keyword)) . '%');
            $map['_logic'] = 'OR';
        }
        
    	$row = empty( $model['list_row'] ) ? 20 : $model['list_row'];
    	$order = 'id DESC';
    	// 读取模型数据列表
    	empty( $fields ) || in_array( 'id', $fields ) || array_push( $fields, 'id' );
    	$Model = D( $this->modelName );
    	$data = $Model->field( empty( $fields ) ? true : $fields )->where( $map )->order( $order )->page( $page, $row )->select();
 
    	/* 查询记录总数 */
    	$count = $Model->where( $map )->count();
    	$list_data['list_data'] = $data;
    	
    	// 分页
    	if($count > $row){
    		$page = new \Think\Page( $count, $row );
    		$page->setConfig( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
    		$list_data['_page'] = $page->show();
    	}
    	
        //下拉状态选项查询
        $where=array("model_id"=>$model['id'],"name"=>"status","status"=>"1");
        $status_extra = M('Attribute')->field(array("title","extra"))->where($where)->find(); 
          
        $this->assign('status',$status);
        $this->assign('search_key',$select_search);
        $this->assign('statusExtra',$status_extra);//项目状态参数
    	$this->assign($list_data);
        $this->display();
    }

    /**
     * 新增页面初始化
     */
    public function add(){
    	$model = M('Model')->getByName($this->tableName);
    	$this->assign('model', $model);
        $data 	= I('post.');
    	if(IS_POST){
    		$Model 	= D( $this->modelName );  
    		  
    		$data['creator_id']      = UID;
                $data['creator_name']    = get_username(UID);
    		$data['status']       = trim($data['status']);
    		$data['create_times'] = trim($data['create_times']);
    		$data['type'] 	      = trim($data['type']);
    		$data['contents']     = trim($data['contents']);
    		$data['title'] 	      = trim($data['title']);

    		// 获取模型的字段信息
    		$Model 	= $this->checkAttr( $Model, $model['id'] );
    		if($Model->create($data) && $id = $Model->add()){
    			$this->success( '添加成功！', U('index') );
    		}else{
    			$this->error( $Model->getError() );
    		}
    	}else{
    		$fields = get_model_attribute( $model['id'] ); 
    		$this->assign( 'fields', $fields );
    		$this->meta_title = '新增' . $model['title'];
        	$this->display();
    	}
    }

    /**
     * 编辑页面初始化
     */
  public function edit($id = 0){
    	$id || $id = I( 'id' );
    	$model = M('Model')->getByName($this->tableName);
    	$this->assign('model', $model);
    	$data 	= I('post.');
    	$Model = D( $this->modelName );
  
    	if(IS_POST){
    		$data['status']          = trim($data['status']);
    		$data['type'] 	         = trim($data['type']);
    		$data['contents']        = trim($data['contents']);
    		$data['title'] 	         = trim($data['title']);
                $status=(string)$data['status'];
                if($status == '2' ){
                    $data['create_times']    = strtotime(date("Y-m-d H:i",time()));
                }
    		// 获取模型的字段信息
    		$Model = $this->checkAttr( $Model, $model['id'] );
               
    		if($Model->create($data) && $Model->save($data)){ 
                    $this->success( '保存' . $model['title'] . '成功！', U( 'index' ) );
    		}else{
                    $this->error( $Model->getError() );
    		}
    	}else{
    		// 获取数据
    		$data = $Model->find( $id ); 
    		$fields = get_model_attribute( $model['id'] );
    		$this->assign( 'fields', $fields );
    		$this->assign( 'data', $data );
    		$this->meta_title = '编辑' . $model['title'];
        	$this->display();
    	}
    }
 
    /**
     * 删除一条数据
     */
    public function del($ids = null){
    	! empty( $ids ) || $ids = I( 'id' );
    	! empty( $ids ) || $ids = array_unique(( array ) I( 'ids', 0 ) );
    	! empty( $ids ) || $this->error( '请选择要操作的数据!' );
    	
    	$Model = D( $this->modelName );
    	$map['id'] = array( 'in', $ids );
    	
    	if($Model->where( $map )->delete()){
    		$this->success( '删除成功' );
    	}else{
    		$this->error( '删除失败！' );
    	}
    }
}