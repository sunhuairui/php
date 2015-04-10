<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2013 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace Common\Behavior;
use Think\Behavior;
use Think\Hook;
defined('THINK_PATH') or exit();

// 初始化钩子信息
class InitHookBehavior extends Behavior {
    
    // 获取修正后的pathinfo
    private function fixedAddonsUrl($info) {
        // 去除URL后缀
        $html_suffix = C('URL_HTML_SUFFIX');
        $suffix = $html_suffix ? trim($html_suffix, '.') : __EXT__;
        $result = preg_replace('/\.'.$suffix.'$/i', '', $info);
        // 判断判定url参数的模式
        $depr = C('URL_PATHINFO_DEPR');
        $result = trim($result, $depr);
        // 针对addon的url的进行修复
        if (substr($result, 0, 6) == 'addon'.$depr) {
            if (C('URL_PARAMS_BIND') && 1 == C('URL_PARAMS_BIND_TYPE')) {
                $result = str_replace('addon'.$depr, "Home{$depr}Addons{$depr}execute{$depr}", $result);
            } else {
                $paths = explode($depr, $result, 5);
                $result = "Home{$depr}Addons{$depr}execute{$depr}";
                
                $_addons = $paths[1];
                $_controller = empty($paths[2]) ? 'Index' : $paths[2];
                $_action = empty($paths[3]) ? 'Index' : $paths[3];
                $result .= implode($depr, array('_addons', $_addons, '_controller', $_controller, '_action', $_action));
                
                if (!empty($paths[4])) $result .= $depr.$paths[4];
            }
        }
        
        return $result.'.'.$suffix;
    }

    // 行为扩展的执行入口必须是run
    public function run(&$content) {
        // 定义SITE_DOMAIN和SITE_URL常量
        define('SITE_DOMAIN', strip_tags($_SERVER['HTTP_HOST']));
        define('SITE_URL', 'http://'.SITE_DOMAIN.__ROOT__);
        
        if(defined('BIND_MODULE') && BIND_MODULE === 'Install') return;
        
        //===== 修改 支持 index.php/addon/Vote/Vote/lists 这样的插件短地址（特殊的插件支持开发）
        $varPath  = C('VAR_PATHINFO');
        if (isset($_GET[$varPath])) { // 判断URL里面是否有兼容模式参数
            $_GET[$varPath] = $this->fixedAddonsUrl($_GET[$varPath]);
        } else {
            $_SERVER['PATH_INFO'] = $this->fixedAddonsUrl($_SERVER['PATH_INFO']);
        }

        $data = S('hooks');
        if(!$data){
            $hooks = M('Hooks')->getField('name,addons');
            foreach ($hooks as $key => $value) {
                if($value){
                    $map['status']  =   1;
                    $names          =   explode(',',$value);
                    $map['name']    =   array('IN',$names);
                    $data = M('Addons')->where($map)->getField('id,name');
                    if($data){
                        $addons = array_intersect($names, $data);
                        Hook::add($key,array_map('get_addon_class',$addons));
                    }
                }
            }
            S('hooks',Hook::get());
        }else{
            Hook::import($data,false);
        }
    }
}