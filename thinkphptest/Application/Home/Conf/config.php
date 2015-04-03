<?php
return array(
	//'配置项'=>'配置值'
// 	'ACTION_BIND_CLASS' => true,
// 	'URL_PARAMS_BIND'            => true， //URL变量绑定到操作方法作为参数
	'URL_PARAMS_BIND_TYPE'   => 1,  //设置参数绑定按照变量顺序绑定
// 	'URL_PARAMS_BIND'       =>  false,  //关闭参数绑定功能
		'URL_HTML_SUFFIX'         => 'shtml|html|xml' ,//伪静态
		'URL_DENY_SUFFIX'         => 'pdf|ico|png|gif|jpg', // URL禁止访问的后缀设置
		'URL_CASE_INSENSITIVE' =>true,  //不区分URL大小写
		"DB_CONFIG1" => array(
				'DB_TYPE'                  =>  'mysql',           // 数据库类型
				'DB_HOST'                 =>  'localhost',           // 服务器地址
				'DB_NAME'                =>  'my_db',            // 数据库名
				'DB_USER'                  =>  'root',           // 用户名
				'DB_PWD'                  =>  '',           // 密码
				'DB_PORT'                 =>  '3306',           // 端口
				'DB_PREFIX'               =>  'think_',           // 数据库表前缀
				'DB_CHARSET'           =>  'utf8',				
		),		
		'DB_TYPE'                  =>  'mysql',           // 数据库类型
		'DB_HOST'                 =>  'localhost',           // 服务器地址
		'DB_NAME'                =>  'my_db',            // 数据库名
		'DB_USER'                  =>  'root',           // 用户名
		'DB_PWD'                  =>  '',                 // 密码
		'DB_PORT'                 =>  '3306',          // 端口
// 		'DB_PREFIX'               =>  'think_',           // 数据库表前缀
		'DB_CHARSET'           =>  'utf8',
    'ACTION_SUFFIX'      => 'Action',
// 	'URL_ROUTER_ON'    => true,
// 	'URL_ROUTER_TULES' =>array(
// 		"news/:year/:month/:day"  =>  array("News/archive","status=1"),
// 		"news/:id"                          =>  "News/read",
// 		"news/read/:id"                  => "/news/:1",
// 	),
		
    
);