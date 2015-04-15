<?php
namespace  Home\Controller;
use Home\Controller\HomeController;
//============================================================
//<P>案例展示实现类</P>
//
//@class CaseController
//@author Sunhr
//@Date 2015.04.13
//@version 1.0.0
//============================================================
class CaseController extends HomeController{
	//每页数量
	const PAGESIZE = 20;
	//是否推荐
	const RECOMMEND_OK = 1;
	const RECOMMEND_NO = 0;
	
	// ============================================================
   // <T>用户案例查询</T>
   //
   // @return 要跳转页面
   // ============================================================
	public function index() {	
		$pageno = I('p', 1, 'intval');
		$row = I('list_row', self::PAGESIZE, 'intval');
		$project = D('Project');
      $cases = $project->getRecommendCases('*', $pageno, $row);
		$count = $project->getRecommendCasesCount();
// 		print_r($project->getLastSql());exit;
		foreach ($cases as $key=>$val) {
			if (empty($val['token'])) {
				$token = generate_nonce_str(8);
				$updatedata = array(
					'id' => $val["id"],
					'token'=> $token,
				);
				D('Project')->save($updatedata);
				$cases[$key]['codeurl'] = "http://".SITE_DOMAIN.'/Public/gamecreator/templates/'.$val['name'].'/?appid='.$token;
				
			}else{
				$cases[$key]['codeurl'] = "http://".SITE_DOMAIN.'/Public/gamecreator/templates/'.$val['name'].'/?appid='.$val['token'];
			}
		}

		$pagenum = ceil($count / $row);
		if ($pagenum > $pageno) {
			$this->assign('is_more', true);
		}
        
		$this->assign('cases', $cases);
		//跳转
		$this->display("Bee1/case");
	}
	
	// ============================================================
   // <T>用户案例分页</T>
   //
   // @return 要跳转页面
   // ============================================================
	public function case_ajax() {
		//'is_recommend'=>self::RECOMMEND_OK,
 		$map = array(
 				'status' => array('neq',0),
 		);
		
		$pageno = !empty($_POST['page']) ? $_POST['page'] : 1;
		$row = !empty($_POST['row']) ? $_POST['row'] : $this->pagesize;
		$template = D('Project');
		
		$cases = $template->where($map)
		->page($pageno, $row)
		->select();		
		foreach ($cases as $key=>$val) {
			//获取图片路径
			$cases[$key]['imgurl'] = get_production_cover_url($val['icon_url']);
			$cases[$key]['sw'] = U('case_info', 'projectid='.$val['id']);
			if (empty($val['token'])) {
				$token = generate_nonce_str(8);
				$updatedata = array(
						'id' => $val["id"],
						'token'=> $token,
				);
				D('Project')->save($updatedata);
				$cases[$key]['codeurl'] = "http://".SITE_DOMAIN.'/Public/gamecreator/templates/'.$val['name'].'/?appid='.$token;
			
			}else{
				$cases[$key]['codeurl'] = "http://".SITE_DOMAIN.'/Public/gamecreator/templates/'.$val['name'].'/?appid='.$val['token'];
			}
		}
		$count = $template->where($map)->count();
		$pagenum = ceil($count/$row);
		$is_page = $pagenum<=$pageno ? 1 : 0;
		$ret=array('page'=>$pageno, 'data'=>$cases, 'ispage'=>$is_page);
		$this->ajaxReturn($ret);
	}
	// ============================================================
	// <T>用户案例详情</T>
	//
	// @return 要跳转页面
	// ============================================================
	public function case_info(){
	  $token = I("id");	  
	  $project = D("Project");	  
	  $project = $project->where(array("token" => $token))->find();
	  $appid = $project['token'];
	  $name = $project['name'];
	  //游戏连接
	  $url = "http://".SITE_DOMAIN.'/play/'.$appid.'/';
	  $this->assign('pc_url', $url.'?openid=otuWJjvQKhb9nn1xL8v-IRrgxct8');
	  //二维码地址
	  $this->assign('url', $url);
	  //二维码下载地址
	  $qr_svg = U('demoSvg', array('appid'=>$appid, 'name'=>$name));
	  $this->assign('qr_svg', $qr_svg);
	  //场景
	  $categorys = D('CategoryBee')->where(array('status'=>1))
	  ->order('sort desc, id desc')
	  ->select();	  
	  $this->assign('categorys', $categorys);
	  //
	  $this->assign('project_name', $name);
	  
	  $this->assign('project', $project);
	  //跳转
	  $this->display("Bee1/caseinfo");
	}
	
	// ============================================================
	// <T>获取下载连接地址</T>
	//
	// @return 下载地址
	// ============================================================
	public function demoSvg($appid, $name) {
		vendor('phpqrcode.phpqrcode');
		$publish_url = "http://".SITE_DOMAIN.'/Public/gamecreator/templates/'.$name.'/?appid='.$appid;
		header("content-disposition: attachment; filename=qrcode.png");
		\QRcode::png($publish_url, false, QR_ECLEVEL_L, 8);
	}
	public function test(){
		$this->display("Bee1/test");
	}
	
}