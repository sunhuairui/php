<?php
/**
 * ppt模板类
 */
namespace Home\Controller;

class PagetemplateController extends HomeController {
    protected $_animations = array();

    public function _initialize(){
        $this->_animations = require_once(APP_PATH . 'Home/Conf/animations.php');
        parent::_initialize();
    }

    /**
     * 解析template.json文件，返回ppt模板识别的格式
     * $token 项目token
     */
    public function combinePagesData( $token ) {
        $this->token = $token;
        $pptData = array(
            'obj'=>array(),
            'list'=>array()
        );

        $templateArray = $this->_getTemplateData( $token );

        $pptData['obj'] = $this->_combinePageObject($pptData['obj'], $templateArray['share']);
        $pptData['list'] = $this->_combinePage($templateArray, $pptData['list']);

        $this->ajaxReturn(array('code'=>0, 'data'=>$pptData, 'msg'=>'success'));
    }

    protected function _getTemplateData( $token ) {
        is_dir(SITE_PATH.'/webroot/Public/gamecreator/app/' . $token) ? $gamecreator_app_path = SITE_PATH.'/webroot/Public/gamecreator/app/' . $token : $gamecreator_app_path = SITE_PATH.'/webroot/Public/gamecreator/templates/' . $token;

        if( is_dir( $gamecreator_app_path ) ) {
            if( file_exists($gamecreator_app_path . '/template.json') ){
                return json_decode(file_get_contents( $gamecreator_app_path . '/template.json'), true );
            }
        }
        return false;
    }



    /**
     * 模板对象属性拼装
     */
    protected function _combinePageObject($obj, $share){
        $obj = $share['setting'] ? $share['setting'] : array();
        $obj['name'] = $share['wechat']['title'];
        $obj['desc'] = $share['wechat']['desc'];
        $obj['imgUrl'] = $share['wechat']['imgUrl'];

        $obj['audiourl'] = '/play/' . $this->token . '/' . $obj['audiourl'];

        return $obj;
    }

    /**
     * 拼装页面
     */
    protected function _combinePage($templateArray,$pptdataList){
        if($templateArray['pages']){
            $pageSortNumber = 0;
            foreach ($templateArray['pages'] as $pageName => $pageElements) {
              $pptdataList[$pageSortNumber] = array(
                  'id'  =>$pageSortNumber + 1,
                  'name'=>$pageName,
                  'properties'=>isset($pageElements['properties']) ? $pageElements['properties'] : null
                );
                $pptdataList[$pageSortNumber] = $this->_combineElements($pptdataList[$pageSortNumber], $pageElements['elements'], $templateArray['templateVars']);
                $pageSortNumber ++ ;
            }
        }
        return $pptdataList;
    }

    /**
     * 模版对象页面元素拼装
     */
    protected function _combineElements($pageData, $pageElements, $templateVars){
        if(is_array($pageElements)){
          foreach ($pageElements as $elementName) {
            $pageData['elements'][] = $this->_combineElement($templateVars[$elementName]);
          }
        }
        return $pageData;
    }

    /**
     * 模版对象页面元素动画属性添加
     */
    protected function _combineElement($element){
        $animations = $this->_animations;
        $animationID = $element['id'] ? $element['id'] : 0;
        if($animationID){
        $animationArrayData = isset($animations[$animationID]) ? $animations[$animationID] : array();
        $animationType = isset($animationArrayData['type']) ? $animationArrayData['type'] : 0;
        if($animationType){
            switch ($animationType) {
              case 2:
                isset($element['value']) ? $animationArrayData['content'] = $element['value'] : NULL;
                isset($element['url'])   ? $animationArrayData['url'] = $element['url'] : NULL;
                break;
              case 3:
                $animationArrayData['properties']['bgColor'] = $element['value'];
                break;
              case 4:
                isset($element['originW']) ? $animationArrayData['properties']['width'] = $element['originW'] : NULL;
                isset($element['originH']) ? $animationArrayData['properties']['height'] = $element['originH']: NULL;
                $animationArrayData['properties']['src'] = preg_match("/^\/Public\//", $element['texUrl']) ? $element['texUrl'] : '/play/' . $this->token . '/' .$element['texUrl'];
                break;
              default:
                # code...
                break;
            }
        }
        return $animationArrayData;
        }
        return array();
    }

}