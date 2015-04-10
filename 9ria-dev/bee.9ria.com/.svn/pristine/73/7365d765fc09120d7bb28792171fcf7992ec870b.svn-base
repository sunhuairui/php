<?php
namespace Home\Model;
use Think\Model;

class SettingsModel extends Model {
	protected $tableName = 'sdk_settings';
    protected $cache_time = 10;

    protected $_auto = array(
        array('status', 1, self::MODEL_INSERT),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('modify_time', NOW_TIME, self::MODEL_INSERT)
    );

    public function __construct() {
    	parent::__construct();
    }
    
    // 获取某人的总场景数，浏览量，访客数和转发量
    public function getDataByUser($uid) {
        $projectModel = D('Project');
        $map = array();
        // 1表示正式环境，0表示测试环境
    	$map['env'] = (APP_STATUS == 'production') ? 1 : 0;
    	$map['uid'] = $uid;
        $map['status'] = array('neq', 0);
        $appids = array();
        $projects = $projectModel->where($map)->select();
        foreach ($projects as $project) {
    		$appids[] = $project['id'];
    	}
        
        $result = array();
        $result['appcount'] = count($appids);
        $result['pageview'] = 0;
        $result['userview'] = 0;
        $result['sharecount'] = 0;
        
        $items = $this->getTotalData($appids);
        foreach ($items as $item) {
            $result['pageview'] += $item['pageview'];
            $result['userview'] += $item['userview'];
            $result['sharecount'] += $item['sharecount'];
        }
        
        return $result;
    }
    
    // 获取某项目的浏览量，访客数和转发量
    public function getDataByAppid($appid) {
        $time = time();
        $map = array();
        $map['status'] = array('neq', 0);
        $map['appid'] = $appid;
        
        $map['item_key'] = 'pageview';
        $item = $this->where($map)->find();
        $pageView = isset($item['item_value']) ? $item['item_value'] : 0;
        
        $map['item_key'] = 'userview';
        $item = $this->where($map)->find();
        $userView = isset($item['item_value']) ? $item['item_value'] : 0;

        $map['item_key'] = 'sharecount';
        $item = $this->where($map)->find();
        $shareCount = isset($item['item_value']) ? $item['item_value'] : 0;
        return array('pageview'=>$pageView, 'userview'=>$userView, 'sharecount'=>$shareCount);
    }
    
    // 获取某项目的浏览量，访客数和转发量
    public function getRedisDataByAppid($appid) {
        $client = redis();
        $pageView   = (int) $client->hget('appid:' . $appid, 'pv:total');
        $userView   = (int) $client->hget('appid:' . $appid, 'uv:total');
        $shareCount = (int) $client->hget('appid:' . $appid, 'share:total');
        return array('pageview'=>$pageView, 'userview'=>$userView, 'sharecount'=>$shareCount);
    }

    // 获取项目的总数据（包括pv,uv,和share）
    public function getTotalData($appids) {
        // 如果数据为空，则返回空数据
        if(empty($appids)) return array();
        // 初始化数据
        $ret = array();
        if (!is_array($appids)) {
            $appids = array($appids);
        }

        foreach ($appids as $appid) {
            $ret[$appid] = $this->getRedisDataByAppid($appid);
//             $ret[$appid] = $this->getDataByAppid($appid);
        }
        
    	return $ret;        
    }

    // 获取pageview
    public function getPageViews($appids) {
        $map = array();
        if (is_array($appids)) {
            $map['appid'] = array('in', $appids);
        } else {
            $map['appid'] = $appids;
        }
    	
    	$map['item_key'] = 'pageview';
        $map['status'] = 1;
    	$list = $this->where($map)->select();
    	$ret = array();
        $time = time();
    	foreach ($list as $row) {
    		$appid = $row['appid'];
    		$pageview = $row['item_value'];
    		$ret[$appid] = $pageview;
    	}
    	return $ret;
    }
    
    // 获取userview
    public function getUserViews($appids) {
        $map = array();
    	$map['appid'] = array('in', $appids);
    	$map['item_key'] = 'userview';
        $map['status'] = 1;
        
    	$list = $this->where($map)->select();
    	$ret = array();
    	foreach ($list as $row) {
    		$appid = $row['appid'];
    		$pageview = $row['item_value'];
    		$ret[$appid] = $pageview;
    	}
        
    	return $ret;
    }
    
    // 获取转发数
    public function getShareCount($appids) {
        $map = array();
        if (is_array($appids)) {
            $map['appid'] = array('in', $appids);
        } else {
            $map['appid'] = $appids;
        }
        
        $map['item_key'] = 'sharecount';
        $map['status'] = 1;
    	$list = $this->where($map)->select();
    	$ret = array();
    	foreach ($list as $row) {
    		$appid = $row['appid'];
    		$pageview = $row['item_value'];
    		$ret[$appid] = $pageview;
    	}
        
    	return $ret;        
    }
    
    // 获取某项目的浏览量，访客数和转发量
    public function getRedisDataByAppidTypePeriod($appid, $type = 'pv', $period = '') {
        
        $type = in_array($type, array('pv', 'uv', 'sc')) ? $type: 'pv';
        $period = in_array($period, array('today', 'yesterday', 'week', 'month')) ? $period : 'today';
        $itemKey = ($type == 'sc' ? 'share' : strtolower($type)) . ':';

        switch ($period) {
        	case 'yesterday':
        	    $day = date('Ymd', strtotime("-1 day"));
        	    for($i=0; $i<24; $i++) $xAxis[] = $day . ($i<10 ? '0' . $i : $i);
        	    break;
        	case 'week':
        	    for($i=6; $i>=0; $i--)  $xAxis[] = date('Ymd', strtotime((string)(-$i) ." days"));
        	    break;
        	case 'month':
        	    for($i=29; $i>=0; $i--) $xAxis[] = date('Ymd', strtotime((string)(-$i) ." days"));
        	    break;
        	case 'today':
        	    $day = date('Ymd');
        	    for($i=0; $i<24; $i++) $xAxis[] = $day . ($i<10 ? '0' . $i : $i);
        	default:
        	    break;
        }
        
        $client = redis();
        $countArrs = array();
        $countTol = 0;
        foreach ($xAxis as $xkey) {
//             $client->hincrby('appid:' . $appid, $itemKey . $xkey, ceil(rand(1, 100)));
            $countLen = (int) $client->hget('appid:' . $appid, $itemKey . $xkey);
            $countArrs[] = $countLen;
            $countTol += $countLen;
        }
        
        $itemValue = array('v' => $countArrs, 'c' => $countTol);      
        return $itemValue;
    }
    
    // 获取某项目的浏览量，访客数和转发量
    public function getDataByAppidTypePeriod($appid, $time = false, $type = 'PageView', $period = '') {
        $type = in_array($type, array('PageView', 'UserView', 'ShareCount')) ? $type : 'PageView';
        $period = in_array($period, array('today', 'yesterday', 'week', 'month')) ? $period : '';
        
        $itemKey = strtolower($type) . ($period ? '_' . $period : '');
        
        $map['appid'] = $appid;
        $map['status'] = 1;
        $map['item_key'] = $itemKey;
        
        $now = time();
        
        $item = $this->where ( $map )->find ();
        if($item) {
            if ($now - $item['modify_time'] > $this->cache_time) {
                $itemValue = $this->getLogDataByAppidAndPeriod($appid, $time, $type, $period);
                $itemValueJson = json_encode($itemValue);
                $this->where (array('id' => $item['id']))->save (array('modify_time' => $now, 'item_value' => $itemValueJson));
            } else {
                $itemValue = is_numeric($item['item_value']) ? $item['item_value'] : json_decode($item['item_value'], true);
            }
        } else {
            $itemValue = $this->getLogDataByAppidAndPeriod($appid, $time, $type, $period);
            $itemValueJson = json_encode($itemValue);
            $addData = array(
                    'appid'     => $appid,
                    'item_key'  => $itemKey,
                    'item_value'=> $itemValueJson,
                    'status'    => 1,
                    'create_time'   => $now,
                    'modify_time'   => $now
            );
            $this->add ( $addData );
        }
        
        return $itemValue;
    }
    
    private function getLogDataByAppidAndPeriod($appid, $time = false, $type, $period) {
        
        $xAxis = $countArr = $countArrs = $itemValue = array();
        $countTol = 0;
        
        $options['num'] = false;
        $options['where'] = array();
        $options['group'] = '';
        
        switch ($period) {
        	case 'yesterday':
        	    $options['where'] = array(
            	    'create_time' => array(
                	    'BETWEEN',
                	    array(strtotime(date('Y-m-d', strtotime("-1 day"))), strtotime(date('Y-m-d')))
            	    )
        	    );
        
        	    $options['group'] = "DATE_FORMAT(FROM_UNIXTIME(create_time), '%k')";
        	    $options['field'] = "DATE_FORMAT(FROM_UNIXTIME(create_time), '%k') AS ranges";
        	    for($i=0; $i<24; $i++) $xAxis[] = $i;
        	    break;
        	case 'week':
        	    $options['where'] = array('create_time' => array('EGT', strtotime(date('Y-m-d', strtotime("-6 day")))));
        	    $options['group'] = "DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d')";
        	    $options['field'] = "DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') AS ranges";
        	    for($i=6; $i>=0; $i--)  $xAxis[] = date('Y-m-d', strtotime((string)(-$i) ." days"));
        	    break;
        	case 'month':
        	    $options['where'] = array('create_time' => array('EGT', strtotime(date('Y-m-d', strtotime("-29 day")))));
        	    $options['group'] = "DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d')";
        	    $options['field'] = "DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') AS ranges";
        	    for($i=29; $i>=0; $i--) $xAxis[] = date('Y-m-d', strtotime((string)(-$i) ." days"));
        	    break;
        	case 'today':
        	    $options['where'] = array('create_time' => array('EGT', strtotime(date('Y-m-d'))));
        	    $options['group'] = "DATE_FORMAT(FROM_UNIXTIME(create_time), '%k')";
        	    $options['field'] = "DATE_FORMAT(FROM_UNIXTIME(create_time), '%k') AS ranges";
        	    for($i=0; $i<24; $i++) $xAxis[] = $i;
        	    break;
        	default:
        	    $options['num'] = true;
        	    break;
        }
        
        $fName = 'get'. $type;
        $statlogModel = D('StatLog');
        
        $data = $statlogModel->$fName($appid, $time, $options);
        
        if(is_array($data)) {
            foreach ($data as $val) {
                $countArr[$val['ranges']] = $val['count'];
            }
            
            foreach ($xAxis as $xkey) {
                $countLen = isset($countArr[$xkey]) ? $countArr[$xkey] : 0;
                $countArrs[] = $countLen;
                $countTol += $countLen;
            }
            
            $itemValue = array('v' => $countArrs, 'c' => $countTol);
        } else {
            $itemValue = (int) $data;
        }
        
        return $itemValue;
    }
    
    private function checkTimestamp($time) {
        if( strtotime(date("Y-m-d H:i:s", $time)) == $time ) return true;
        return false;
        
    }
    
    // 获取指定key的值
    public function getConf($appid, $key, $default = '') {
        $data = $this->where (array(
                'appid'     => $appid,
                'status'    => 1,
                'item_key'  => $key
        ))->find ();
        return $data ? (isset($data['item_value']) ? $data['item_value'] : $default) : $default;
    }
}